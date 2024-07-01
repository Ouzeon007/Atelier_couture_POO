<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
// require_once ("../Core/Model.php");
final class ClientModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "client";
    }

    // public function save(array $type): int
    // {
    //     extract($type);
    //     return $this->executeUpdate("INSERT INTO `type` (`nomType`) VALUES ('$nomType')");
    // }
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