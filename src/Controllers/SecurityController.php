<?php
namespace Ond\AtelierCouturePoo\Controllers;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;
use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\UserModel;

// require_once ("../src/Model/UserModel.php");
// require_once ("../src/Core/Controller.php");

class SecurityController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->layout="connection";
        $this->userModel = new UserModel;
        $this->load();
    }
    public function load()
    {

        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == "connexion") {
                $this->connection($_REQUEST);
            } elseif ($_REQUEST['action'] == "show-form") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["btnSave"]);
                $this->showForm();
            }elseif ($_REQUEST['action'] == "logout") {
                $this->logout();
            }
        } else {
            $this->showForm();
        }
    }
    private function logout()
    {
        Session::fermer();
        parent::redirectToRoute("controller=securite&action=show-form");
    }
    private function showForm()
    {
        parent::renderView("Security/form");
    }
    private function connection(array $data)
    {
        if(!Validator::isEmpty($data["login"], "login")){
            Validator::isEmail($data["login"], "login");
        }
        Validator::isEmpty($data["password"], "password");
        if (Validator::isValide()) {
            $userConnect=$this->userModel->findByLoginAndPassword($data["login"],$data["password"]);
            if ($userConnect) {
                Session::add("userConnect", $userConnect);
                parent::redirectToRoute("controller=article&action=liste-article&page=0");
            }else {
                Validator::add("error_connexion", "Utilisateur introuvable");
                Session::add("errors", Validator::$errors);
            }
        }else {
            Session::add("errors", Validator::$errors);
        }
        parent::redirectToRoute("controller=securite&action=show-form");

    }
}



