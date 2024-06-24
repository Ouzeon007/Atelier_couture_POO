<?php
namespace Ond\AtelierCouturePoo\Api;
use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\CategorieModel;
use Ond\AtelierCouturePoo\Core\Autorisation;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;
// require_once ("../Model/CategorieModel.php");
// require_once ("../Core/Controller.php");
class CategorieController extends Controller
{

    private CategorieModel $categorieModel;
    public function __construct()
    {
        parent::__construct();
        if(!Autorisation::isConnect()){
            parent::redirectToRoute("controller=securite&action=show-form");
        }
        $this->categorieModel = new CategorieModel;
        $this->load();
    }

    public function load()
    {

        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == "api-liste-categorie") {
                $this->Lister();
            } elseif ($_REQUEST['action'] == "apisave-categorie") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["btnSave"]);
                $this->add($_REQUEST);

            } elseif ($_REQUEST['action'] == "api-delete-categorie") {
                ;
                $this->Supprimer($_REQUEST["id"]);
            } elseif ($_REQUEST['action'] == "update-categorie") {
                $this->ChargerUpdateFormulaire();
            } elseif ($_REQUEST['action'] == "edit-categorie") {
                unset($_REQUEST["action"]);
                unset($_REQUEST["btnSave"]);
                $this->Modifier($_REQUEST);
            }
        }

    }
    public function Lister(): void
    {
        parent::renderJson([
            "categories" => $this->categorieModel->findAll()
        ]);


    }

    public function add(array $categorie): void
    {
        Validator::isEmpty($categorie["nomCategorie"], "nomCategorie");
        if (Validator::isValide()) {
            $categorieT = $this->categorieModel->findByName($categorie["nomCategorie"]);
            if ($categorieT) {
                Validator::add("nomCategorie", "La catégorie existe déja");
                Session::add('errors', Validator::$errors);
            } else {
                $this->categorieModel->save($categorie);
            }
        } else {
            Session::add('errors', Validator::$errors);
        }
        parent::redirectToRoute("controller=categorie&action=liste-categorie");
    }
    public function Supprimer(int $id): void
    {
        $this->categorieModel->delete($id);
        parent::redirectToRoute("controller=categorie&action=liste-categorie");
    }
    public function Modifier(array $categorie): void
    {
        Validator::isEmpty($categorie["nomCategorie"], "nomCategorie");
        if (Validator::isValide()) {
            $categorieT = $this->categorieModel->findByName($categorie["nomCategorie"]);
            if ($categorieT) {
                Validator::add("nomCategorie", "La catégorie existe déja");
                Session::add('errors', Validator::$errors);
                $this->ChargerUpdateFormulaire();
            } else {
                $this->categorieModel->Update($categorie);
                parent::redirectToRoute("controller=categorie&action=liste-categorie");
            }


        } else {
            Session::add('errors', Validator::$errors);
            $this->ChargerUpdateFormulaire();
        }

    }
    public function ChargerUpdateFormulaire(): void
    {
        parent::renderView("Categorie/liste.update", [
            "categories" => $this->categorieModel->findAll(),
            "catSelect" => $this->categorieModel->findById($_REQUEST['id'])
        ]);
    }
}



