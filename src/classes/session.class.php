<?php

class Session {
    private $vars;
    public $smarty;
    function __construct() {
        $this->vars = array();
        
        $this->smarty = new Smarty;
        $this->smarty->template_dir = BASE_DIR."/src/templates";
        $this->smarty->compile_dir =  BASE_DIR."/src/templates_c";
        #$this->smarty->cache_dir = "cache";
        #$this->smarty->config_dir = "configs";
        #$this->smarty->debug = true;
    }
    
    public function get($varname) {
        if (isset($this->vars[$varname]))
            return $this->vars[$varname];
        elseif (isset($_SESSION[$varname]))
            return $_SESSION[$varname];
        return false;
    }
    
    public function set($varname, $value, $sess=true) {
        $this->vars[$varname] = $value;
        if ($sess)
            $_SESSION[$varname] = $value;
    }
    
    public function save() {
        $_SESSION['SESSION'] = serialize($this);
    }
    
    public function user() {
        if (isset($_SESSION['USER']))
            $user = unserialize($_SESSION['USER']);
        else
            $user = new User();
        return $user;
    }
    
    public function log($text) {
        if (is_object($text))
            error_log(var_export($text, true));
        elseif (is_array($text))
            error_log(var_export($text, true));
        else
            error_log($text);
    }
    
    public function checkLogin() {
        if (isset($_SESSION['USER']))
            return true;
        return false;
    }
    
    public function assertLogin($url=null) {
        if (!$this->checkLogin()) {
            if ($url)
                $this->set("REDIRECT_URL_AFTER_LOGIN", $url, true);
            $this->redirect(APP_BASE_URL."/login");
        }
    }
    public function redirect($url) {
        if (strlen($url) > 0) {
            $this->log("Redirect: {$url}");
            header("Location:{$url}");
            exit();
        }
    }
   
}
?>