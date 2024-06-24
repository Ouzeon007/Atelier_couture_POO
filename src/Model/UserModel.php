<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
// require_once ("../Core/Model.php");

class UserModel extends Model
{
    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "user";
    }
    public function findByLoginAndPassword(string $login,string $password): array|false
    {
        return $this->executeSelect("SELECT * FROM $this->table u,role r WHERE u.roleId=r.idRole AND u.login like'$login' AND u.password like'$password'",true);
    }
}



