<?php
namespace Ond\AtelierCouturePoo\Core;

use Ond\AtelierCouturePoo\Controllers\ApprovisionnementController;
use Ond\AtelierCouturePoo\Controllers\ProductionController;
use Ond\AtelierCouturePoo\Controllers\SecurityController;
use Ond\AtelierCouturePoo\Controllers\ArticleController;
use Ond\AtelierCouturePoo\Controllers\CategorieController;
use Ond\AtelierCouturePoo\Api\CategorieController as ApiCategorieController;
use Ond\AtelierCouturePoo\Controllers\TypeController;
use Ond\AtelierCouturePoo\Controllers\VenteController;

class Router
{

  public static function run()
  {
    if (isset($_REQUEST["controller"])) {
      if ($_REQUEST["controller"] == "article") {
        // require_once ("../src/Controllers/ArticleController.php");
        $controller = new ArticleController;
      } elseif ($_REQUEST["controller"] == "categorie") {


        // require_once ("../src/Controllers/CategorieController.php");
        $controller = new CategorieController;
      } elseif ($_REQUEST["controller"] == "type") {
        // require_once ("../src/Controllers/TypeController.php");
        $controller = new TypeController;
      } elseif ($_REQUEST["controller"] == "securite") {
        // require_once ("../src/Controllers/SecurityController.php");
        $controller = new SecurityController;
      } elseif ($_REQUEST["controller"] == "api-categorie") {
        $controller = new ApiCategorieController();

      } elseif ($_REQUEST["controller"] == "appro") {
        $controller = new ApprovisionnementController();
      }elseif ($_REQUEST["controller"] == "production") {
        $controller = new ProductionController();
      }elseif ($_REQUEST["controller"] == "vente") {
        $controller = new VenteController();
      }
    } else {
      // require_once ("../src/Controllers/SecurityController.php");
      $controller = new SecurityController;

    }

  }

}