<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlm {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('Tree_model', 'tree');
    }
    
    public function findLatestPlace($sponsor_id = -1, &$latest_child_place, $level = 1) {
        
        if($sponsor_id == -1) {
            $sponsor_id = 1;
        }

        $latest_child_place = $this->ci->tree->getUsersPlace($sponsor_id, $level);
        $new_place = 0;
        if($this->userHasChildren($latest_child_place, $level)) {
            //$latest_child_place - после какого места мы должны поставить нового пользователя
            $latest_child_place = $this->findLatestChildPlace($latest_child_place, $level);
            if(!$this->userHasChildren($latest_child_place, $level))
                //$new_place - место, на которое мы ставим пользователя
                $new_place = $latest_child_place * 2;
            else if($this->getChild($latest_child_place, true, $level) == false)
                $new_place = $latest_child_place * 2 + 1;
        } else {
            $new_place = $latest_child_place * 2;
        }

        return $new_place;
    }
    
    public function addTreeNode($new_user_id, $sponsor_id = -1, $level = 1, $bought = 0) {
        $latest = 0;
        $new_place = $this->findLatestPlace($sponsor_id, $latest, $level);

        $this->ci->tree->insertIntoMatrix($new_user_id, $new_place, $latest, $level, $bought);
        $this->update_weight($new_place, $level);

        return $new_place;
    }

    private function userHasChildren($place, $level = 1) {
        $query = $this->ci->tree->getUserByPlace($place, $level);
        if($query[0]['has_children'] == 1)
            return true;
        return false;
    }

    private function findLatestChildPlace($place, $level = 1) {
        $child = $this->getChild($place, true, $level);
        if($child == false)
            return $place; //если потомки есть, но правой ветки нет - становимся в правую ветку

        //другое же значит, что правая ветка существует, соответственно, берем потомка слева
        $child = $this->getChild($place, false, $level);
        $place = $child[0]['place'];
        $has_children = $child[0]['has_children'];
        //если у левого потомка нет веток или нет правой ветки, то становимся под ним
        if(!$has_children || $this->getChild($place, true, $level) == false) {
            return $place;
        }

        //и продолжаем ходить по дереву
        return $this->checkRow($place, 0, 0, 1, $level);
    }


    private function checkRow($start_place, $current_place = 0, $end_place = 0, $level = 1, $matrix_level = 1) {
        if($current_place == 0)
            $current_place = $start_place;
        $uinfo = $this->ci->tree->getUserByPlace($current_place, $matrix_level);
        if($uinfo == false) // такого места не существует
            return (int)($current_place / 2);
        $userplace = $uinfo[0]['place'];
        $has_children = $uinfo[0]['has_children'];
        if(!$has_children) {
            return $userplace;
        }
        if($this->getChild($userplace, true, $matrix_level) == false) {
            return $userplace;
        }
        $end_place = pow(2,$level) + $start_place - 1;
        if($current_place >= $end_place) {
            $level += 1;
            $uinfo = $this->ci->tree->getUserByPlace($start_place, $matrix_level);
            $child = $this->getChild($uinfo[0]['place'], false, $matrix_level);
            $start_place = $child[0]['place'];
            $current_place = 0;
        }
        else
            $current_place += 1;
        return $this->checkRow($start_place, $current_place, $end_place, $level, $matrix_level);
    }

    //если right == true, нужно смотреть правую ветку
    private function getChild($place, $right = false, $level = 1) {
        $seek_for = $place * 2;
        if($right)
            $seek_for += 1;
        return $this->ci->tree->getUserByPlace($seek_for, $level);
    }

    public function check_struct_closure($place, $level) {
        $count = 1;
        $left_child = $this->getChild($place, false, $level); //левая ветка
        $right_child = $this->getChild($place, true, $level); //правая ветка

        if($left_child != false)
            $count += 1;
        if($right_child != false)
            $count += 1;

        if($left_child ) {
            if ($this->getChild($left_child[0]['place'], true, $level) != false)
                $count += 2;
            else if ($left_child[0]['has_children'] == 1)
                $count += 1;
        }
        if($right_child) {
            if ($this->getChild($right_child[0]['place'], true, $level) != false)
                $count += 2;
            else if ($right_child[0]['has_children'] == 1)
                $count += 1;
        }

        return $count;
    }

    public function get_nodes($matrix_level = 1, $start_place, $max_level=3) {
        $user = $this->ci->tree->getUserByPlace($start_place, $matrix_level);
        $user = $this->ci->users->getUserById($user[0]['iduser']);
        $this->ci->load->model('users_model', 'users');
        $results = array(array('parent' => '', 'name' => $user['login'], 'place' => $start_place)); //в конце вернем этот массив

        $cur_level = 1; //всегда начниаем с людей под нами, т.е. сначала всегда 2 места (2^1 == 2)
        $start_place = $start_place * 2; //вычисляем ближайшего предполагаемого потомка

        while($cur_level <= $max_level) { //и идем по уровням
            $current_place = $start_place; //определяем начальное место в каждом уровне
            $places_to_check = pow(2, $cur_level); //и выясняем, сколько всего мест под спонсором на этом уровне
            for($i = 0; $i < $places_to_check; $i++, $current_place++) { //и идем по всем этим местам
                $child = $this->ci->tree->getUserByPlace($current_place, $matrix_level);
                if($child != false) {
                    $user = $this->ci->users->getUserById($child[0]['iduser']);
                    $results[] = array('parent' => (int) ($child[0]['place'] / 2),
                                        'name' => $user['login'],
                                        'place' => $child[0]['place'],
                                        'ico' => 'user');
                } else {
                    $results[] = array('parent' => (int) ($current_place / 2),
                        'name' => $this->ci->lang->line('place_empty'),
                        'place' => $current_place,
                        'ico' => 'times');
                }
            }

            //дошли до конца ряда, прыгаем на следующий уровень, выясняем, с какого места начинать проверку
            $cur_level++;
            $start_place = $start_place * 2;
        }

        return $results;
    }

    /* функция смотрит, есть ли наш спонсор в матрицах уровней 2, 3 и т.д.
     * если он есть - становимся его рефами, если мы приходим на уровень раньше
     * нашего спонсора, то функция ищет и возвращает спонсора спонсора (и т.д., пока не
     * дойдет до админа)
     */
    private function find_current_sponsor($uid, $level) {
        $old_sponsor = $this->ci->users->get_sponsor_by_id($uid);
        if(is_null($old_sponsor) || $old_sponsor == false) {
            return null;
        }
        if($this->ci->tree->getUsersPlace($old_sponsor, $level) == null) { //если нашего спонсора нет на нужном уровне
            return $this->find_current_sponsor($old_sponsor, $level); //ищем дальше
        }
        return $old_sponsor; //а иначе вернем спонсора
    }

    public function close_matrix($uid, $level) {
        $this->ci->load->model('finances_model', 'finances');
        if(!is_numeric($level) || ($level < 1 && $level > 6)) {
            return false;
        }

        $reward = array('1' => array('backmoney' => 0.06,
                                        'sponsor' => 0.03),
                        '2' => array('backmoney' => 0.1,
                                        'sponsor' => 0.05),
                        '3' => array('backmoney' => 0.2,
                                        'sponsor' => 0.1),
                        '4' => array('backmoney' => 0.7,
                                        'sponsor' => 0.3),
                        '5' => array('backmoney' => 4,
                                        'sponsor' => 1),
                        '6' => array('backmoney' => 60,
                            'sponsor' => 0),
                        );

        $options = $reward[$level];
        $this->ci->finances->addTransaction(null, $uid, $options['backmoney'], 5, 1);
        $this->ci->users->addFunds($uid, $options['backmoney']);

        $sponsor_id = $this->ci->users->getUserById($uid);
        $sponsor_id = $sponsor_id['idsponsor'];
        $this->ci->finances->addTransaction($uid, $sponsor_id, $options['sponsor'], 6, 1);
        $this->ci->users->addFunds($sponsor_id, $options['sponsor']);
    }

    private function change_weight($place, $matrix_level = 1) {
        if($place < 1)
          return;
        $row = $this->ci->tree->get_weight($place, $matrix_level); //получим его "вес"
        if($row['matrix_weight'] < 6)
            $this->ci->tree->update_weight($place, $row['matrix_weight'] + 1, $matrix_level );
        if($row['matrix_weight'] + 1 >= 6 && $place >= 2) {
            $user = $this->ci->tree->getUserByPlace($place, $matrix_level);
            $user = $this->ci->users->getUserById($user[0]['iduser']);
            $this->close_matrix($user['id'], $matrix_level);

            $uid = $user['id'];
            $level = $user['current_level'];
            if($user['current_level'] < 6) {
                if($level <= $matrix_level) {
                    $level = $user['current_level'] + 1;
                    $this->ci->users->update_level($uid, $level);
                } else {
                    $level = $matrix_level + 1;
                }
            }

            if($this->ci->tree->user_has_place($uid, $level))
                $new_sponsor = $uid;
            else
                $new_sponsor = $this->find_current_sponsor($uid, $level);
            if(!is_null($new_sponsor)) {
                $this->addTreeNode($uid, $new_sponsor, $level);
            }
        }
    }
    
    public function update_weight($place, $matrix_level = 1) {
        //апдейтим нашего родителя
        $place = (int) ($place / 2); //получим место, под которое мы встали
        $this->change_weight($place, $matrix_level);
//        if($place > 3) {
            //и родителя родителя
            $place = (int)($place / 2);
            $this->change_weight($place, $matrix_level);
//        }
    }

    
}