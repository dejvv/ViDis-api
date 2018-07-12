<?php
define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
function emptyStr($str) {
    return is_string($str) && strlen($str) === 0;
} 
class App{

    protected $controller = 'documentation';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){

        // parse url
        $url = $this->parseURL();

        // if url is empty just show documentation
        if($url === null || emptyStr($url[0])){
            // clear url from get so that on other api-branches you can check whether get is empty
            unset($_GET["url"]);
            require_once '../api/' . $this->controller . '/index.php';
            exit();
        } 
        
        // if api exists display it
        if(file_exists('../api/' . join("/",$url) . '/index.php')){
            $this->controller = join("/",$url);
            unset($_GET["url"]);
            require_once '../api/' . $this->controller . '/index.php';
            exit();
        }
        else{
            // TODO DISPLAY 404
            echo "Ya little bastard cant go here! because you on wrong url";
            exit();
        }
    }

    // parse url
    public function parseURL(){
        if(isset($_GET['url'])){
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}