<?php
namespace Ond\AtelierCouturePoo\Model;
use Ond\AtelierCouturePoo\Core\Model;
use Ond\AtelierCouturePoo\Core\SESSION;
// require_once ("../Core/Model.php");
final class VenteModel extends Model
{

    public function __construct()
    {
        $this->ouvrirConnexion();
        $this->table = "vente";
    }

    public function save(PanierModel $panier): int
    {
        $date= new \DateTime();
        $date=$date->format('Y-m-d');
        $user=SESSION::get('userConnect')['id'];
        $this->executeUpdate("INSERT INTO `vente` (`date`, `montant`, `observation`, `userId`, `clientId`) VALUES ('$date', $panier->total,'$panier->observation', $user, $panier->client);");
        $venteId=$this->pdo->lastInsertId();
        foreach ($panier->articles as $article) {
            $qteVente=$article["qteVente"];
            $qteStock=$article["qteStock"];
            $montantAricle=$article["montantArticle"];
            $idArcle=$article["id"];
            $this->executeUpdate("INSERT INTO `detailvente` (`qteVente`, `articleId`, `venteId`, `montant`) VALUES ($qteVente, $idArcle,$venteId, $montantAricle);");
            $this->executeUpdate("UPDATE `article` SET `qteStock` = $qteStock-$qteVente WHERE `article`.`id` = $idArcle;");
          }

        return 1;
    }
    public function findAll(): array
    {
        return $this->executeSelect("SELECT * FROM $this->table v, client c WHERE v.clientId = c.idClient ");
    }
    public function findAllWithPagination(int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM vente",true);
        $data= $this->executeSelect("SELECT * FROM $this->table v, client c WHERE v.ClientId = c.idClient limit $page, $offset");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
    }

    public function findAllWithAllFilter(string $date, int $id, string $client, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM $this->table v, client c WHERE v.clientId = c.idClient and v.date = '$date' and c.nom = '$client'",true);
        $data= $this->executeSelect("SELECT * FROM $this->table v, client c,detailvente d,article ac WHERE v.clientId = c.idClient and v.date = '$date' and d.venteId =v.idVente and d.articleId=ac.id  AND d.articleId=$id and c.nom = '$client' limit $page, $offset");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        // return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f,detail d,article ac WHERE a.fournisseurId = f.idFour and a.date = '$date' and d.approId =a.idAppro and d.articleId=ac.id  AND d.articleId=$id and f.nomFour = '$fournisseur'");
    }
    public function findAllWithDtate(string $date, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM $this->table v, client c WHERE v.clientId =  c.idClient and v.date = '$date'",true);
        $data= $this->executeSelect("SELECT * FROM $this->table v, client c WHERE v.clientId = c.idClient and v.date = '$date' limit $page, $offset");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
    }
        // return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour and a.date = '$date'");

    public function findAllWithClient(string $client, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM $this->table v, client c WHERE v.ClientId = c.idClient and c.nom = '$client'",true);
        $data= $this->executeSelect("SELECT * FROM $this->table v, client c WHERE v.clientId = c.idClient and c.nom = '$client' limit $page, $offset");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        // return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f WHERE a.fournisseurId = f.idFour and f.nomFour = '$four'");
    }
    public function findAllWithFilterArticle(int $id, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM `vente` v, detailvente d, client c,article ac WHERE v.clientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id",true);
        $data= $this->executeSelect("SELECT * FROM `vente` v, detailvente d, client c,article ac WHERE v.ClientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id limit $page, $offset");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        //return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id");
    }
    public function findAllWithFilterArticleAndDate(int $id, string $date, int $page= 0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM `vente` v, detailvente d, client c,article ac WHERE v.ClientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id and v.date = '$date'",true);
        $data= $this->executeSelect("SELECT * FROM `vente` v, detailvente d, client c,article ac WHERE v.clientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id and v.date = '$date'");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        // return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id and a.date = '$date'");
    }
    public function findAllWithFilterArticleAndClient(int $id, string $client, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM `vente` v, detailvente d, client c,article ac WHERE v.clientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id and c.nom = '$client'",true);
        $data= $this->executeSelect("SELECT * FROM `vente` v, detailvente d, client c,article ac WHERE v.clientId=c.idClient and d.venteId =v.idVente AND d.articleId=ac.id AND d.articleId=$id and c.nom = '$client'");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        // return $this->executeSelect("SELECT * FROM `appro` a, detail d, fournisseur f,article ac WHERE a.fournisseurId=f.idFour and d.approId =a.idAppro AND d.articleId=ac.id AND d.articleId=$id and f.nomFour = '$fournisseur'");
    }
    public function findAllWithFilterDateAndClient(string $date, string $client, int $page=0, int $offset=OFFSET): array
    {
        $page*=$offset;
        $result=$this->executeSelect("SELECT count(*) as nbrVente FROM $this->table v, client c WHERE v.ClientId = c.idClient and v.date = '$date' and c.nom = '$client'",true);
        $data= $this->executeSelect("SELECT * FROM $this->table v, client c,detailvente d,article ac WHERE v.clientId = c.idClient and v.date = '$date' and d.venteId =v.idVente and d.articleId=ac.id and c.nom = '$client'");
        return[
            "totalElements"=>$result['nbrVente'],
            "data"=>$data,
            "pages"=>ceil($result['nbrVente']/$offset)
        ];
        //return $this->executeSelect("SELECT * FROM $this->table a, fournisseur f,detail d,article ac WHERE a.fournisseurId = f.idFour and a.date = '$date' and d.approId =a.idAppro and d.articleId=ac.id and f.nomFour = '$fournisseur'");
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