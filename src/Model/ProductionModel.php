<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
use Ond\AtelierCouturePoo\Core\SESSION;
// require_once ("../Core/Model.php");
final class ProductionModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "production";
    }

    public function save(PanierModel $panier): int
    {
        $date= new \DateTime();
        $date=$date->format('Y-m-d');
        $user=SESSION::get('userConnect')['id'];
        $this->executeUpdate("INSERT INTO `production` (`date`, `montant`,`observation`,`userId`) VALUES ('$date', $panier->total, '$panier->observation', $user);");
        $approId=$this->pdo->lastInsertId();
        foreach ($panier->articles as $article) {
            $qteProd=$article["qteProd"];
            $qteStock=$article["qteStock"];
            $montantAricle=$article["montantArticle"];
            $idArcle=$article["id"];
            $this->executeUpdate("INSERT INTO `detailprod` (`qteProd`, `articleId`, `productionId`, `montant`) VALUES ($qteProd, $idArcle,$approId, $montantAricle);");
            $this->executeUpdate("UPDATE `article` SET `qteStock` = $qteStock-$qteProd WHERE `article`.`id` = $idArcle;");
          }

        return 1;
    }
    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM $this->table a ");
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