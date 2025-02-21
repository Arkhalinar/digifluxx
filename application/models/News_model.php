<?php
class News_model extends CI_Model {

    private $table_name = "news";

    public $title_russian;
    public $title_english;
    public $title_german;
    public $title_hungar;
    public $body_text_russian;
    public $body_text_english;
    public $body_text_german;
    public $body_text_hungar;

    public function __construct() {
        parent::__construct();
    }

    public function add_news() {
        $body_russian = $this->input->post('text_body_russian');
        $body_english = $this->input->post('text_body_english');
        $body_german = $this->input->post('text_body_german');
        $body_hungar = $this->input->post('text_body_hungar');
        $body_russian = str_replace('../', '', $body_russian);
        $body_english = str_replace('../', '', $body_english);
        $body_german = str_replace('../', '', $body_german);
        $body_hungar = str_replace('../', '', $body_hungar);
        $this->title_russian = $this->input->post('title_russian');
        $this->title_english = $this->input->post('title_english');
        $this->title_german = $this->input->post('title_german');
        $this->title_hungar = $this->input->post('title_hungar');
        $this->body_text_russian = $body_russian;
        $this->body_text_english = $body_english;
        $this->body_text_german = $body_german;
        $this->body_text_hungar = $body_hungar;
        $this->db->set('date_add', 'NOW()', false);
        $this->db->insert($this->table_name, $this);
    }

    public function edit_news($id) {
        $data['body_text_russian'] = $this->input->post('text_body_russian');
        $data['body_text_english'] = $this->input->post('text_body_english');
        $data['body_text_german'] = $this->input->post('text_body_german');
        $data['body_text_hungar'] = $this->input->post('text_body_hungar');
        $data['title_russian'] = $this->input->post('title_russian');
        $data['title_english'] = $this->input->post('title_english');
        $data['title_german'] = $this->input->post('title_german');
        $data['title_hungar'] = $this->input->post('title_hungar');
        $this->db->where('id', $id)->update($this->table_name, $data);
    }

    public function get_news($limit, $offset) {
        return $this->db->limit($limit, $offset)
            ->order_by('date_add', 'DESC')
            ->get($this->table_name)->result_array();
    }

    public function get_total_news(){

        return $this->db->count_all_results($this->table_name);

    }

    public function get_news_by_id($id) {

        return $this->db->get_where($this->table_name, array('id' => $id))->row_array();

    }




    public function add_news2() {
        $body_russian = $this->input->post('text_body_russian');
        $body_english = $this->input->post('text_body_english');
        $body_german = $this->input->post('text_body_german');
        $body_hungar = $this->input->post('text_body_hungar');
        $body_russian = str_replace('../', '', $body_russian);
        $body_english = str_replace('../', '', $body_english);
        $body_german = str_replace('../', '', $body_german);
        $body_hungar = str_replace('../', '', $body_hungar);
        $this->title_russian = $this->input->post('title_russian');
        $this->title_english = $this->input->post('title_english');
        $this->title_german = $this->input->post('title_german');
        $this->title_hungar = $this->input->post('title_hungar');
        $this->body_text_russian = $body_russian;
        $this->body_text_english = $body_english;
        $this->body_text_german = $body_german;
        $this->body_text_hungar = $body_hungar;
        $this->db->set('date_add', 'NOW()', false);
        $this->db->insert('mess_1', $this);
        $this->db->query("UPDATE users SET is_looked_news=0");
    }
    public function edit_news2($id) {
        $data['body_text_russian'] = $this->input->post('text_body_russian');
        $data['body_text_english'] = $this->input->post('text_body_english');
        $data['body_text_german'] = $this->input->post('text_body_german');
        $data['body_text_hungar'] = $this->input->post('text_body_hungar');
        $data['title_russian'] = $this->input->post('title_russian');
        $data['title_english'] = $this->input->post('title_english');
        $data['title_german'] = $this->input->post('title_german');
        $data['title_hungar'] = $this->input->post('title_hungar');
        $this->db->where('id', $id)->update('mess_1', $data);
    }
    public function get_news2($limit, $offset) {
        return $this->db->limit($limit, $offset)
            ->order_by('date_add', 'DESC')
            ->get('mess_1')->result_array();
    }
    public function get_total_news2(){

        return $this->db->count_all_results('mess_1');

    }
    public function get_news_by_id2($id) {

        return $this->db->get_where('mess_1', array('id' => $id))->row_array();
        
    }




    public function add_news3() {
        $body_russian = $this->input->post('text_body_russian');
        $body_english = $this->input->post('text_body_english');
        $body_german = $this->input->post('text_body_german');
        $body_hungar = $this->input->post('text_body_hungar');
        $body_russian = str_replace('../', '', $body_russian);
        $body_english = str_replace('../', '', $body_english);
        $body_german = str_replace('../', '', $body_german);
        $body_hungar = str_replace('../', '', $body_hungar);
        $this->title_russian = $this->input->post('title_russian');
        $this->title_english = $this->input->post('title_english');
        $this->title_german = $this->input->post('title_german');
        $this->title_hungar = $this->input->post('title_hungar');
        $this->body_text_russian = $body_russian;
        $this->body_text_english = $body_english;
        $this->body_text_german = $body_german;
        $this->body_text_hungar = $body_hungar;
        $this->db->set('date_add', 'NOW()', false);
        $this->db->insert('mess_2', $this);
        $this->db->query("UPDATE users SET is_looked_news_2=0");
    }
    public function edit_news3($id) {
        $data['body_text_russian'] = $this->input->post('text_body_russian');
        $data['body_text_english'] = $this->input->post('text_body_english');
        $data['body_text_german'] = $this->input->post('text_body_german');
        $data['body_text_hungar'] = $this->input->post('text_body_hungar');
        $data['title_russian'] = $this->input->post('title_russian');
        $data['title_english'] = $this->input->post('title_english');
        $data['title_german'] = $this->input->post('title_german');
        $data['title_hungar'] = $this->input->post('title_hungar');
        $this->db->where('id', $id)->update('mess_2', $data);
    }
    public function get_news3($limit, $offset) {
        return $this->db->limit($limit, $offset)
            ->order_by('date_add', 'DESC')
            ->get('mess_2')->result_array();
    }
    public function get_total_news3(){

        return $this->db->count_all_results('mess_2');

    }
    public function get_news_by_id3($id) {

        return $this->db->get_where('mess_2', array('id' => $id))->row_array();
        
    }










    public function read_news($uid, $news_id) {
        return $this->db->where(array('iduser' => $uid, 'idnews' => $news_id))->count_all_results('news_read');
    }

    public function mark_as_read($uid, $news_id) {
        $data['iduser'] = $uid;
        $data['idnews'] = $news_id;

        $this->db->insert('news_read', $data);
    }
}
