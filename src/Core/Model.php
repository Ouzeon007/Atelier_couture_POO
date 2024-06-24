<?php
namespace Ond\AtelierCouturePoo\Core;
use PDO;
use PDOException;
class Model
{
    protected string $dsn = 'mysql:host=localhost:3306;dbname=Atelier_Couture';
    protected $username = 'root';
    protected $password = '';
    protected PDO|null $pdo = null;
    protected string $table;

    public function ouvrirConnexion(): void
    {
        try {
            if ($this->pdo == null) {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion:" . $e->getMessage();
        }
    }
    public function fermerConnexion(): void
    {
        if ($this->pdo != null) {
            $this->pdo == null;
        }
    }

    protected function executeSelect(string $sql, bool $fetch = false): array|false
    {
        try {
            $stm = $this->pdo->query($sql);
            return $fetch ? $stm->fetch(PDO::FETCH_ASSOC) : $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de connexion:" . $e->getMessage();
            return false;
        }
    }

    protected function executeUpdate(string $sql): int|false
    {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException $e) {
            echo "Erreur de connection :" . $e->getMessage();
            return false;
        }
    }

    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM $this->table");
    }

    public function eviteDoublon(int $id): array
    {
        return $this->executeSelect("SELECT * FROM $this->table WHERE 'idCategorie'!=$id");
    }
    public function findByName(string $nom): array|false
    {
        return $this->executeSelect("SELECT * FROM $this->table WHERE `nom$this->table` like '$nom'",true);
    }


}

