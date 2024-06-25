<?php
namespace Ond\AtelierCouturePoo\Controllers;

use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\ArticleModel;
use Ond\AtelierCouturePoo\Model\CategorieModel;
use Ond\AtelierCouturePoo\Model\FournisseurModel;
use Ond\AtelierCouturePoo\Model\PanierModel;
use Ond\AtelierCouturePoo\Core\Autorisation;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;
use Ond\AtelierCouturePoo\Model\ProductionModel;

class ProductionController extends Controller
{
  private ArticleModel $articleModel;
  private ProductionModel $prodModel;
  private FournisseurModel $fournisseurModel;
  private CategorieModel $categorieModel;

  public function __construct()
  {
    parent::__construct();
    if (!Autorisation::isConnect()) {
      parent::redirectToRoute("controller=securite&action=show-form");
    }
    $this->articleModel = new ArticleModel();
    $this->prodModel = new ProductionModel();
    $this->fournisseurModel = new FournisseurModel();
    $this->categorieModel = new CategorieModel();
    $this->load();
  }
  public function load()
  {
    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == "liste-production") {
        $this->Lister($_REQUEST['page']);
      } elseif ($_REQUEST['action'] == "form-production") {
        $this->ChargerFormulaire();
      } elseif ($_REQUEST['action'] == "add-production") {
        $this->AjouterArticleDansProd($_POST);
      } elseif ($_REQUEST['action'] == "save-production") {
        $this->AjouterProd();
      }elseif ($_REQUEST['action'] == "vider-panier") {
        $this->viderPanier();
      }elseif ($_REQUEST['action'] == "filter-production") {
        $this->ListerWithFilter($_REQUEST['page']);
      }
    } else {
      $this->Lister();
    }

  }
  public function Lister($page = 0): void
  {
    $this->renderView("productions/liste", [
        "articles" => $this->articleModel->findAllVentes(),
      "productions" => $this->prodModel->findAll(),
      "reponse" => $this->prodModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);
  }

  public function ListerWithFilter($page=0): void
  {


    if ($_GET['date'] != "" && isset($_GET['articleId']) ) {
      $this->renderView("productions/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        "productions" => $this->prodModel->findAllWithAllFilter($_GET['date'], $_GET['articleId']),
        "reponse" => $this->prodModel->findAllWithAllFilter($_GET['date'], $_GET['articleId'],$page,OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId']) == false ) {
      $this->renderView("productions/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        "productions" => $this->prodModel->findAllWithDtate($_GET['date']),
        "reponse" => $this->prodModel->findAllWithDtate($_GET['date'],$page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] == "" && isset($_GET['articleId'])) {
      $this->renderView("productions/liste", [
        "articles" => $this->articleModel->findAllVentes(),
        "productions" => $this->prodModel->findAllWithFilterArticle($_GET['articleId']),
        "reponse" => $this->prodModel->findAllWithFilterArticle($_GET['articleId'],$page,OFFSET),
        "currentPage"=> $page
      ]);
    }
    $this->renderView("productions/liste", [
        "articles" => $this->articleModel->findAllVentes(),
      "productions" => $this->prodModel->findAll(),
      "reponse" => $this->prodModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
      
    ]);
  }

  public function AjouterArticleDansProd(array $data): void
  {
    Validator::isEmpty($data["observation"], "observation");
    if(!Validator::isEmpty($data["qteProd"], "qteProd")){
      Validator::isPossitive($data["qteProd"], "qteProd");
    }
    if (Validator::isValide()) {
      if (Session::get('panierProd')==false) {
        $panier= new PanierModel();
      }else{
        $panier= Session::get('panierProd');
      }
      $panier->addArticleProd($this->articleModel->findById($data["articleId"]),$data["qteProd"]);
      Session::add("panierProd", $panier);
      parent::redirectToRoute("controller=production&action=form-production");
    }else {
      Session::add("errors", Validator::$errors);
      parent::redirectToRoute("controller=production&action=form-production");
    }
    
  }

  public function AjouterProd(): void
  {
    $panier= Session::get('panierProd');
    if ($panier != false) {
    $this->prodModel->save($panier);
    // $panier->clear();
    Session::remove('panierProd');

    parent::redirectToRoute("controller=production&action=form-production");
  }else{
    parent::redirectToRoute("controller=production&action=form-production");
  }
}
public function viderPanier(): void{

  $panier= Session::get('panierProd');
  if ($panier != false) {
    $panier->clear();
    Session::remove('panierProd');
  }
  parent::redirectToRoute("controller=production&action=form-production");
    
}
  public function ChargerFormulaire(): void
  {
    parent::renderView("productions/form", [
      "articles" => $this->articleModel->findAllVentes()
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
    parent::redirectToRoute("controller=article&action=liste-article");
  }
}