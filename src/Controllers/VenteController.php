<?php
namespace Ond\AtelierCouturePoo\Controllers;

use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\ArticleModel;
use Ond\AtelierCouturePoo\Model\CategorieModel;
use Ond\AtelierCouturePoo\Model\ClientModel;
use Ond\AtelierCouturePoo\Model\PanierModel;
use Ond\AtelierCouturePoo\Core\Autorisation;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;
use Ond\AtelierCouturePoo\Model\VenteModel;

class VenteController extends Controller
{
  private ArticleModel $articleModel;
  private VenteModel $venteModel;
  private ClientModel $clientModel;
  private CategorieModel $categorieModel;

  public function __construct()
  {
    parent::__construct();
    if (!Autorisation::isConnect()) {
      parent::redirectToRoute("controller=securite&action=show-form");
    }
    $this->articleModel = new ArticleModel();
    $this->venteModel = new VenteModel();
    $this->clientModel = new ClientModel();
    $this->categorieModel = new CategorieModel();
    $this->load();
  }
  public function load()
  {
    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == "liste-vente") {
        $this->Lister($_REQUEST['page']);
      } elseif ($_REQUEST['action'] == "form-vente") {
        $this->ChargerFormulaire();
      } elseif ($_REQUEST['action'] == "add-vente") {
        $this->AjouterArticleDansVente($_POST);
      } elseif ($_REQUEST['action'] == "save-vente") {
        $this->AjouterVente();
      }elseif ($_REQUEST['action'] == "vider-panier") {
        $this->viderPanier();
      }elseif ($_REQUEST['action'] == "filter-vente") {
        $this->ListerWithFilter();
      }
    } else {
      $this->Lister();
    }

  }

  public function ListerWithFilter($page = 0): void
  {


    if ($_GET['date'] != "" && isset($_GET['articleId']) && $_GET['nom'] != "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        "reponse" => $this->venteModel->findAllWithAllFilter($_GET['date'], $_GET['articleId'], $_GET['nom'],$page,OFFSET),
        "currentPage" => $page

      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId']) == false && $_GET['nom'] == "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        "reponse" => $this->venteModel->findAllWithDtate($_GET['date'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] == "" && isset($_GET['articleId']) == false && $_GET['nom'] != "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        'reponse' => $this->venteModel->findAllWithClient($_GET['nom'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] == "" && isset($_GET['articleId']) && $_GET['nom'] == "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        'reponse' => $this->venteModel->findAllWithFilterArticle($_GET['articleId'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId']) && $_GET['nom'] == "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        'reponse' => $this->venteModel->findAllWithFilterArticleAndDate($_GET['articleId'], $_GET['date'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }
    elseif ($_GET['date'] == "" && isset($_GET['articleId']) && $_GET['nom'] != "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        'reponse' => $this->venteModel->findAllWithFilterArticleAndClient($_GET['articleId'], $_GET['nom'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId'])==false && $_GET['nom'] != "") {
      $this->renderView("ventes/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        'reponse' => $this->venteModel->findAllWithFilterDateAndClient($_GET['date'], $_GET['nom'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }
    $this->renderView("ventes/liste", [
      "articles" => $this->articleModel->findAllVentes(),
      "appros" => $this->venteModel->findAll(),
      'reponse' => $this->venteModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);
  }

  public function Lister(int $page=0): void
  {
    $this->renderView("ventes/liste", [
      "articles" => $this->articleModel->findAllVentes(),
      "reponse" => $this->venteModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);
  }
  public function AjouterArticleDansVente(array $data): void
  {
   if (!Validator::isEmpty($data["qteVente"], "qteVente")) {
    Validator::isPossitive($data["qteVente"], "qteVente");
   } 
   if (Validator::isValide()) {
    if (Session::get('panierVente')==false) {
      $panier= new PanierModel();
    }else{
      $panier= Session::get('panierVente');
    }

    $panier->addArticleVente($this->articleModel->findById($data["articleId"]),$data["clientId"],$data["qteVente"]);
    Session::add("panierVente", $panier);
    parent::redirectToRoute("controller=vente&action=form-vente");
   }else{
    Session::add("errors", Validator::$errors);
    parent::redirectToRoute("controller=vente&action=form-vente");
   }
    

  }


  public function AjouterVente(): void
  {
    $panier= Session::get('panierVente');
    $this->venteModel->save($panier);
    // $panier->clear();
    Session::remove('panierVente');

    parent::redirectToRoute("controller=vente&action=form-vente");
  }
  public function ChargerFormulaire(): void
  {
    parent::renderView("ventes/form", [
      "clients" => $this->clientModel->findAll(),
      "articles" => $this->articleModel->findAllVentes()
    ]);
  }
  public function viderPanier(): void{
    $panier= Session::get('panierVente');
    if ($panier != false) {
      $panier->clear();
      Session::remove('panierVente');
    }
    parent::redirectToRoute("controller=vente&action=form-vente");
  }


}