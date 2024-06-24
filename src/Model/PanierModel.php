<?php
namespace Ond\AtelierCouturePoo\Model;

use Ond\AtelierCouturePoo\Core\Model;

final class PanierModel
{
  public $fournisseur;
  public array $articles = [];
  public $total;
  public $observation;

  public function addArticle($article, $fournisseur, $qteAppro)
  {
    $montantArticle = $this->montantArticle($article["prixAppro"], $qteAppro);
    $key = $this->articleExist($article);
    if ($key != -1) {
      $this->articles[$key]["qteAppro"] += $qteAppro;
      $this->articles[$key]["montantArticle"] += $montantArticle;

    } else {
      $article["qteAppro"] = $qteAppro;
      $article["montantArticle"] = $montantArticle;
      $this->articles[] = $article;
    }
    
    $this->fournisseur = $fournisseur;
    $this->total += $montantArticle;
  }

  public function addArticleProd($article, $qteProd)
  {
    $montantArticle = $this->montantArticle($article["prixAppro"], $qteProd);
    $obs=$_POST["observation"];
    $key = $this->articleExist($article);
    if ($key != -1) {
      $this->articles[$key]["qteProd"] += $qteProd;
      $this->articles[$key]["montantArticle"] += $montantArticle;
      $this->articles[$key]["observation"] = $_POST["observation"];

    } else {
      $article["qteProd"] = $qteProd;
      $article["montantArticle"] = $montantArticle;
      // $article["observation"] = $_POST["observation"];
      $this->articles[] = $article;
    }
    $this->observation = $obs;
    $this->total += $montantArticle;
  }

  public function montantArticle($prix, $qteAppr)
  {
    return $prix * $qteAppr;
  }
  public function articleExist($article): int
  {
    foreach ($this->articles as $key => $value) {
      if ($value["id"] == $article["id"]) {
        return $key;
      }
    }
    return -1;
  }
  public function clear(): void
  {
    $this->articles = [];
    $this->total = 0;
    $this->fournisseur = null;
  }
}
