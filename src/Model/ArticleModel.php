<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
// require_once ("../Core/Model.php");
class ArticleModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "article";
    }
    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM article a,categorie c,type t WHERE a.typeId=t.idType and a.categorieId=c.idCategorie");
    }
    public function findAllVentes(): array
    {
        return $this->executeSelect("SELECT * FROM article a WHERE a.typeId=2 ");
    }
    public function findAllConnfectiones(): array
    {
        return $this->executeSelect("SELECT * FROM article a WHERE a.typeId=1 ");
    }
    public function findAllWithPagination(int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrArticle FROM article",true);
        $data= $this->executeSelect("SELECT * FROM article a,categorie c,type t WHERE a.typeId=t.idType and a.categorieId=c.idCategorie limit $page, $offset");
        return[
            "totalElements"=>$result['nbrArticle'],
            "data"=>$data,
            "pages"=>ceil($result['nbrArticle']/$offset)
        ];
    }
    public function findAllByID($id): array
    {
        return $this->executeSelect("SELECT * FROM article a,categorie c,type t WHERE a.typeId=t.idType and a.categorieId=c.idCategorie and a.id=$id");
    }
    public function findById(int $id): array
    {
        return $this->executeSelect("SELECT * FROM `article` WHERE `id`=$id",true);

    }
    


    public function save(array $article,): int
    {
        extract($article);
        return $this->executeUpdate("INSERT INTO `article` (`libelle`, `qteStock`, `prixAppro`, `typeId`, `categorieId`) VALUES ('$libelle', '$qteStock', '$prixAppro', '$typeId', '$categorieId')");

    }
    public function delete(int $id): int
    {
        return $this->executeUpdate("DELETE FROM `article` WHERE `id` = $id");
    }
    public function Update(array $article): int
    {
        extract($article);
        return $this->executeUpdate("UPDATE `article` SET `libelle`='$libelle', `prixAppro`='$prixAppro', `qteStock`='$qteStock', `categorieId`='$categorieId', `typeId`='$typeId' WHERE `article`.`id`='$id'");
    }
    public function findByName(string $nom): array|false
    {
        return $this->executeSelect("SELECT * FROM $this->table WHERE `libelle` like '$nom'",true);
    }
}

// SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=1 and d.approId =7 AND d.articleId=33
