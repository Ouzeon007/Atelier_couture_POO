<?php
namespace Ond\AtelierCouturePoo\Controllers;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;
use Ond\AtelierCouturePoo\Model\TypeModel;
use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Core\Autorisation;
// require_once ("../Model/TypeModel.php");
// require_once ("../Core/Controller.php");

class TypeController extends Controller
{

  private TypeModel $typeModel;

  public function __construct()
  {
    parent::__construct();
    if (!Autorisation::isConnect()) {
      parent::redirectToRoute("controller=securite&action=show-form");
    }
    $this->typeModel = new TypeModel;
    $this->load();
  }



  public function load()
  {

    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == "liste-type") {
        $this->Lister();
      } elseif ($_REQUEST['action'] == "save-type") {
        unset($_REQUEST["action"]);
        unset($_REQUEST["btnSave"]);
        $this->add($_REQUEST);

      } elseif ($_REQUEST['action'] == "delete-type") {
        ;
        $this->Supprimer($_REQUEST["id"]);
      } elseif ($_REQUEST['action'] == "update-type") {
        $this->ChargerUpdateFormulaire();
      } elseif ($_REQUEST['action'] == "edit-type") {
        unset($_REQUEST["action"]);
        unset($_REQUEST["btnSave"]);
        $this->Modifier($_REQUEST);
      }
    }
  }
  public function Lister(): void
  {
    parent::renderView("types/liste", [
      "types" => $this->typeModel->findAll()
    ]);
  }
  public function add(array $type): void
  {

    Validator::isEmpty($type["nomType"], "nomType");
    if (Validator::isValide()) {
      $typeT = $this->typeModel->findByName($type["nomType"]);
      if ($typeT) {
        Validator::add("nomType", "Le type existe déja");
        Session::add("errors", Validator::$errors);
      } else {
        $this->typeModel->save($type);
      }

    } else {
      Session::add("errors", Validator::$errors);
    }
    parent::redirectToRoute("controller=type&action=liste-type");
  }
  public function Supprimer(int $id): void
  {
    $this->typeModel->delete($id);
    parent::redirectToRoute("controller=type&action=liste-type");
  }
  public function ChargerUpdateFormulaire(): void
  {
    parent::renderView("types/liste.update", [
      "typeSelect" => $this->typeModel->findById($_REQUEST['id']),
      "types" => $this->typeModel->findAll()

    ]);
  }
  public function Modifier(array $type): void
  {
    Validator::isEmpty($type["nomType"], "nomType");
    if (Validator::isValide()) {
      $typeT = $this->typeModel->findByName($type["nomType"]);
      if ($typeT) {
        Validator::add("nomType", "Le type existe déja");
        Session::add("errors", Validator::$errors);
        $this->ChargerUpdateFormulaire();
      } else {
        $this->typeModel->Update($type);
        parent::redirectToRoute("controller=type&action=liste-type");
      }
    } else {
      Session::add("errors", Validator::$errors);
      $this->ChargerUpdateFormulaire();
    }


  }
}


