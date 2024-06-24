<?php
namespace Ond\AtelierCouturePoo\Core;
use Ond\AtelierCouturePoo\Core\Session;
    class Controller{
        protected string $layout;
        public function redirectToRoute(string $path){
            header("location:".WEBROOT."?$path");
            exit;
        }

        public function __construct() {
            Session::ouvrir();
            $this->layout = "base";
        }
        
        public function renderView(string $view,array $data=[]){
            ob_start();
            extract($data);
            require_once("../Views/$view.html.php");
            $contentView= ob_get_clean();
            require_once("../Views/Layout/$this->layout.layout.php");
        }

        public function renderJson(array $data=[]){
           echo json_encode($data);
        }

    }
    
