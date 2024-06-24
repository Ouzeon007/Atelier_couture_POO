<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
// require_once ("../Core/Model.php");
final class CategorieModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "categorie";
    }

    public function findById(int $id): array
    {
        return $this->executeSelect("SELECT * FROM `categorie` WHERE `idCategorie`=$id");

    }
    public function save(array $categorie): int
    {
        extract($categorie);
        return $this->executeUpdate("INSERT INTO `categorie` (`nomCategorie`) VALUES ('$nomCategorie')");
    }
    public function delete(int $id): int
    {

        return $this->executeUpdate("DELETE FROM `categorie` WHERE `idCategorie` = $id");
    }
    public function Update(array $type): int
    {
        extract($type);
        return $this->executeUpdate("UPDATE `categorie` SET `nomCategorie`='$nomCategorie' WHERE `categorie`.`idCategorie`=$id");
    }
}


