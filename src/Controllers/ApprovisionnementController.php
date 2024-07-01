<?php
namespace Ond\AtelierCouturePoo\Controllers;

use Ond\AtelierCouturePoo\Core\Controller;
use Ond\AtelierCouturePoo\Model\ApprovisionnementModel;
use Ond\AtelierCouturePoo\Model\ArticleModel;
use Ond\AtelierCouturePoo\Model\CategorieModel;
use Ond\AtelierCouturePoo\Model\FournisseurModel;
use Ond\AtelierCouturePoo\Model\PanierModel;
use Ond\AtelierCouturePoo\Core\Autorisation;
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Validator;

class ApprovisionnementController extends Controller
{
  private ArticleModel $articleModel;
  private ApprovisionnementModel $approModel;
  private FournisseurModel $fournisseurModel;
  private CategorieModel $categorieModel;

  public function __construct()
  {
    parent::__construct();
    if (!Autorisation::isConnect()) {
      parent::redirectToRoute("controller=securite&action=show-form");
    }
    $this->articleModel = new ArticleModel();
    $this->approModel = new ApprovisionnementModel();
    $this->fournisseurModel = new FournisseurModel();
    $this->categorieModel = new CategorieModel();
    $this->load();
  }
  public function load()
  {
    if (isset($_REQUEST['action'])) {
      if ($_REQUEST['action'] == "liste-appro") {
        $this->Lister($_REQUEST['page']);
      } elseif ($_REQUEST['action'] == "form-appro") {
        $this->ChargerFormulaire();
      } elseif ($_REQUEST['action'] == "add-appro") {
        $this->AjouterArticleDansAppro($_POST);
      } elseif ($_REQUEST['action'] == "save-appro") {
        $this->AjouterAppro();
      }elseif ($_REQUEST['action'] == "vider-panier") {
        $this->viderPanier();
      }elseif ($_REQUEST['action'] == "filter-appro") {
        $this->ListerWithFilter();
      }elseif ($_REQUEST['action'] == "detail-appro") {
        parent::renderView("appros/detail", [
          "approDetail" => $this->approModel->findAllDetails($_GET['id']),

        ]);
      }
    } else {
      $this->Lister();
    }

  }
  public function ListerWithFilter($page = 0): void
  {


    if ($_GET['date'] != "" && isset($_GET['articleId']) && $_GET['nomFour'] != "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithAllFilter($_GET['date'], $_GET['articleId'], $_GET['nomFour']),
        "reponse" => $this->approModel->findAllWithAllFilter($_GET['date'], $_GET['articleId'], $_GET['nomFour'],$page,OFFSET),
        "currentPage" => $page

      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId']) == false && $_GET['nomFour'] == "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithDtate($_GET['date']),
        "reponse" => $this->approModel->findAllWithDtate($_GET['date'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] == "" && isset($_GET['articleId']) == false && $_GET['nomFour'] != "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithFournisseur($_GET['nomFour']),
        'reponse' => $this->approModel->findAllWithFournisseur($_GET['nomFour'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] == "" && isset($_GET['articleId']) && $_GET['nomFour'] == "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithFilterArticle($_GET['articleId']),
        'reponse' => $this->approModel->findAllWithFilterArticle($_GET['articleId'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId']) && $_GET['nomFour'] == "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithFilterArticleAndDate($_GET['articleId'],$_GET['date']),
        'reponse' => $this->approModel->findAllWithFilterArticleAndDate($_GET['articleId'], $_GET['date'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }
    elseif ($_GET['date'] == "" && isset($_GET['articleId']) && $_GET['nomFour'] != "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithFilterArticleAndFournisseur($_GET['articleId'],$_GET['nomFour']),
        'reponse' => $this->approModel->findAllWithFilterArticleAndFournisseur($_GET['articleId'], $_GET['nomFour'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }elseif ($_GET['date'] != "" && isset($_GET['articleId'])==false && $_GET['nomFour'] != "") {
      $this->renderView("appros/liste", [
        "articles" => $this->articleModel->findAllConnfectiones(),
        "appros" => $this->approModel->findAllWithFilterArticleAndFournisseur($_GET['articleId'],$_GET['nomFour']),
        'reponse' => $this->approModel->findAllWithFilterArticleAndFournisseur($_GET['articleId'], $_GET['nomFour'], $page, OFFSET),
        "currentPage" => $page
      ]);
    }
    $this->renderView("appros/liste", [
      "articles" => $this->articleModel->findAllConnfectiones(),
      "appros" => $this->approModel->findAll(),
      'reponse' => $this->approModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);
  }

  public function Lister(int $page=0): void
  {
    $this->renderView("appros/liste", [
      "articles" => $this->articleModel->findAllConnfectiones(),
      "reponse" => $this->approModel->findAllWithPagination($page, OFFSET),
      "currentPage" => $page
    ]);
  }
  public function AjouterArticleDansAppro(array $data): void
  {
   if (!Validator::isEmpty($data["qteAppro"], "qteAppro")) {
    Validator::isPossitive($data["qteAppro"], "qteAppro");
   } 
   if (Validator::isValide()) {
    if (Session::get('panier')==false) {
      $panier= new PanierModel();
    }else{
      $panier= Session::get('panier');
    }

    $panier->addArticle($this->articleModel->findById($data["articleId"]),$data["fournisseurId"],$data["qteAppro"]);
    Session::add("panier", $panier);
    parent::redirectToRoute("controller=appro&action=form-appro");
   }else{
    Session::add("errors", Validator::$errors);
    parent::redirectToRoute("controller=appro&action=form-appro");
   }
    

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

  public function AjouterAppro(): void
  {
    $panier= Session::get('panier');
    $this->approModel->save($panier);
    // $panier->clear();
    Session::remove('panier');

    parent::redirectToRoute("controller=appro&action=form-appro");
  }
  public function ChargerFormulaire(): void
  {
    parent::renderView("appros/form", [
      "fournisseurs" => $this->fournisseurModel->findAll(),
      "articles" => $this->articleModel->findAllConnfectiones()
    ]);
  }
  public function viderPanier(): void{
    $panier= Session::get('panier');
    if ($panier != false) {
      $panier->clear();
      Session::remove('panierProd');
    }
    parent::redirectToRoute("controller=appro&action=form-appro");
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
  // public function ChargerUpdateFormulaire(): void
  // {
  //   parent::renderView("articles/form.update", [
  //     "article" => $this->articleModel->findAllByID($_REQUEST['id']),
  //     "catArticle" => $this->categorieModel->findById($this->articleModel->findAllByID($_REQUEST['id'])[0]['categorieId']),
  //     "typeArticle" => $this->typeModel->findById($this->articleModel->findAllByID($_REQUEST['id'])[0]['typeId']),
  //     "categories" => $this->categorieModel->findAll(),
  //     "types" => $this->typeModel->findAll()

  //   ]);
  // }
  // public function Supprimer(int $id): void
  // {
  //   $this->articleModel->delete($id);
  //   parent::redirectToRoute("controller=article&action=liste-article");
  // }
  // public function Modifier(array $article): void
  // {
  //   Validator::isEmpty($article["libelle"], "libelle");
  //   if (!Validator::isEmpty($article["qteStock"], "qteStock")) {
  //     Validator::isPossitive($article["qteStock"], "qteStock");
  //   }
  //   if (!Validator::isEmpty($article["prixAppro"], "prixAppro")) {
  //     Validator::isPossitive($article["prixAppro"], "prixAppro");
  //   }
  //   if (Validator::isValide()) {
  //     $articleT = $this->articleModel->findByName($article["libelle"]);
  //     if ($articleT) {
  //       Validator::add("libelle", "L'article existe déja");
  //       Session::add("errors", Validator::$errors);
  //       parent::redirectToRoute("controller=article&action=update-article&id=" . $article['id']);
  //     } else {
  //       $this->articleModel->Update($article);
  //     }
  //   } else {
  //     Session::add("errors", Validator::$errors);
  //     parent::redirectToRoute("controller=article&action=update-article&id=" . $article['id']);
  //   }
  //   parent::redirectToRoute("controller=article&action=liste-article");
  // }


}


