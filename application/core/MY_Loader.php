<?php
class MY_Loader extends CI_Loader {
    private $path = 'cabinet';

    public function template($template_name, $vars = array(), $return = FALSE, $empty_page = FALSE)
    {
        if($empty_page) {
            if($return):
                $content = $this->view($template_name, $vars, $return);
                return $content;
            else:
                $this->view($template_name, $vars);
            endif;
        }else {
            if($return):
                $content  = $this->view($this->path . '/header', $vars, $return);
                $content .= $this->view($template_name, $vars, $return);
                $content .= $this->view($this->path . '/footer', $vars, $return);

                return $content;
            else:
                $this->view($this->path . '/header', $vars);
                $this->view($template_name, $vars);
                $this->view($this->path . '/footer', $vars);
            endif;
        }
    }

    public function setPath($path) {
        $this->path = $path;
    }
}