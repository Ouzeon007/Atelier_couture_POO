<?php
namespace Ond\AtelierCouturePoo\Controllers;

use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\ArticleModel;
use Ond\AtelierCouturePoo\Model\CategorieModel;
use Ond\AtelierCouturePoo\Model\TypeModel;
use Ond\AtelierCouturePoo\Core\Autorisation;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;

// require_once ("../Model/ArticleModel.php");
// require_once ("../Model/CategorieModel.php");
// require_once ("../Model/TypeModel.php");
// require_once ("../Core/Controller.php");
class ArticleController extends Controller
{
  private ArticleModel $articleModel;
  private TypeModel $typeModel;
  private CategorieModel $categorieModel;

  public function __construct()
  {
    parent::__construct();
    if (!Autorisation::isConnect()) {
      parent::redirectToRoute("controller=securite&action=show-form");
    }
    $this->articleModel = new ArticleModel;
    $this->typeModel = new TypeModel;
    $this->categorieModel = new CategorieModel;
    $this->load();
  }
  public function load()
  {
    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == "liste-article") {

        $this->Lister($_REQUEST['page']);
      } elseif ($_REQUEST['action'] == "form-article") {
        $this->ChargerFormulaire();
      } elseif ($_REQUEST['action'] == "save-article") {
        unset($_REQUEST["action"]);
        unset($_REQUEST["btnSave"]);
        $this->store($_REQUEST);
      } elseif ($_REQUEST['action'] == "delete-article") {
        $this->Supprimer($_REQUEST["id"]);


      } elseif ($_REQUEST['action'] == "update-article") {
        $this->ChargerUpdateFormulaire();
      } elseif ($_REQUEST['action'] == "edit-article") {
        unset($_REQUEST["action"]);
        unset($_REQUEST["btnSave"]);
        $this->Modifier($_REQUEST);

      }
    } else {
      $this->Lister();
    }

  }
  public function Lister(int $page=0): void
  {
    $this->renderView("articles/liste", [
      "reponse" => $this->articleModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);

  }
  public function ChargerFormulaire(): void
  {
    parent::renderView("articles/form", [
      "categories" => $this->categorieModel->findAll(),
      "types" => $this->typeModel->findAll()
    ]);
  }
  public function store(array $article): void
  {
    Validator::isEmpty($article["libelle"], "libelle");
    if (!Validator::isEmpty($article["qteStock"], "qteStock")) {
      Validator::isPossitive($article["qteStock"], "qteStock");
    }
    if (!Validator::isEmpty($article["prixAppro"], "prixAppro")) {
      Validator::isPossitive($article["prixAppro"], "prixAppro");
    }
    if (Validator::isValide()) {
      $articleT = $this->articleModel->findByName($article["libelle"]);

      if ($articleT) {
        Validator::add("libelle", "L'article existe déja");
        Session::add("errors", Validator::$errors);
        $this->ChargerFormulaire();
      } else {

        $this->articleModel->save($article);
      }

    } else {
      Session::add("errors", Validator::$errors);
      parent::redirectToRoute("controller=article&action=form-article");
    }
    parent::redirectToRoute("controller=article&action=liste-article&page=0");
  }
  public function ChargerUpdateFormulaire(): void
  {
    parent::renderView("articles/form.update", [
      "article" => $this->articleModel->findAllByID($_REQUEST['id']),
      "catArticle" => $this->categorieModel->findById($this->articleModel->findAllByID($_REQUEST['id'])[0]['categorieId']),
      "typeArticle" => $this->typeModel->findById($this->articleModel->findAllByID($_REQUEST['id'])[0]['typeId']),
      "categories" => $this->categorieModel->findAll(),
      "types" => $this->typeModel->findAll()

    ]);
  }
  public function Supprimer(int $id): void
  {
    $this->articleModel->delete($id);
    parent::redirectToRoute("controller=article&action=liste-article");
  }
  public function Modifier(array $article): void
  {
    Validator::isEmpty($article["libelle"], "libelle");
    if (!Validator::isEmpty($article["qteStock"], "qteStock")) {
      Validator::isPossitive($article["qteStock"], "qteStock");
    }
    if (!Validator::isEmpty($article["prixAppro"], "prixAppro")) {
      Validator::isPossitive($article["prixAppro"], "prixAppro");
    }
    if (Validator::isValide()) {
      $articleT = $this->articleModel->findByName($article["libelle"]);
      if ($articleT) {
        Validator::add("libelle", "L'article existe déja");
        Session::add("errors", Validator::$errors);
        parent::redirectToRoute("controller=article&action=update-article&id=" . $article['id']);
      } else {
        $this->articleModel->Update($article);
      }
    } else {
      Session::add("errors", Validator::$errors);
      parent::redirectToRoute("controller=article&action=update-article&id=" . $article['id']);
    }
    parent::redirectToRoute("controller=article&action=liste-article");
  }


}


