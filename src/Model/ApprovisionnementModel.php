<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
use Ond\AtelierCouturePoo\Core\SESSION;
// require_once ("../Core/Model.php");
final class ApprovisionnementModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "appro";
    }

    public function save(PanierModel $panier): int
    {
        $date= new \DateTime();
        $date=$date->format('Y-m-d');
        $user=SESSION::get('userConnect')['id'];
        $this->executeUpdate("INSERT INTO `appro` (`date`, `montant`, `fournisseurId`, `userId`) VALUES ('$date', $panier->total, $panier->fournisseur, $user);");
        $approId=$this->pdo->lastInsertId();
        foreach ($panier->articles as $article) {
            $qteAppro=$article["qteAppro"];
            $qteStock=$article["qteStock"];
            $montantAricle=$article["montantArticle"];
            $idArcle=$article["id"];
            $this->executeUpdate("INSERT INTO `detail` (`qteAppr`, `articleId`, `approId`, `montant`) VALUES ($qteAppro, $idArcle,$approId, $montantAricle);");
            $this->executeUpdate("UPDATE `article` SET `qteStock` = $qteStock+$qteAppro WHERE `article`.`id` = $idArcle;");
          }

        return 1;
    }
    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour ");
    }
    public function findAllWithPagination(int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrAppro FROM appro",true);
        $data= $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour limit $page, $offset");
        return[
            "totalElements"=>$result['nbrAppro'],
            "data"=>$data,
            "pages"=>ceil($result['nbrAppro']/$offset)
        ];
    }

    public function findAllWithAllFilter(string $date, int $id, string $fournisseur): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f,detail d,article ac WHERE a.fournisseurId = f.idFour and a.date = '$date' and d.approId =a.idAppro and d.articleId=ac.id  AND d.articleId=$id and f.nomFour = '$fournisseur'");
    }
    public function findAllWithDtate(string $date): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour and a.date = '$date'");
    }
    public function findAllWithFournisseur(string $four): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour and f.nomFour = '$four'");
    }
    public function findAllWithFilterArticle(int $id): array
    {
        return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id");
    }
    public function findAllWithFilterArticleAndDate(int $id, string $date): array
    {
        return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id and a.date = '$date'");
    }
    public function findAllWithFilterArticleAndFournisseur(int $id, string $fournisseur): array
    {
        return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id and f.nomFour = '$fournisseur'");
    }
    public function findAllWithFilterDateAndFournisseur(string $date, string $fournisseur): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f,detail d,article ac WHERE a.fournisseurId = f.idFour and a.date = '$date' and d.approId =a.idAppro and d.articleId=ac.id and f.nomFour = '$fournisseur'");
    }

    
    // public function findById(int $id): array
    // {
    //     return $this->executeSelect("SELECT * FROM `type` WHERE `idType`=$id");
    // }
    // public function delete(int $id): int
    // {
    //     return $this->executeUpdate("DELETE FROM `type` WHERE `idType` = $id");
    // }
    // public function Update(array $type): int
    // {
    //     extract($type);
    //     return $this->executeUpdate("UPDATE `type` SET `nomType`='$nomType' WHERE `type`.`idType`=$id");
    // }

    
}