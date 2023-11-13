<?php

namespace models;

use models\base\SQL;
use utils\EmailUtils;

class EmprunterModel extends SQL
{
    public function __construct()
    {
        parent::__construct('emprunter', 'idemprunter');
    }

    /**
     * Déclare un emprunt dans la base de données.
     * @param $idRessource identifiant de la ressource empruntée (idressource)
     * @param $idExemplaire identifiant de l'exemplaire emprunté (idexemplaire)
     * @param $idemprunteur identifiant de l'emprunteur (lecteur)
     * @return bool true si l'emprunt a été déclaré, false sinon.
     */
    public function declarerEmprunt($idRessource, $idExemplaire, $idemprunteur): bool
    {
        try {
            $sql = 'INSERT INTO emprunter (idressource, idexemplaire, idemprunteur, datedebutemprunt, dureeemprunt, dateretour) VALUES (?, ?, ?, NOW(), 30, DATE_ADD(NOW(), INTERVAL 1 MONTH))';
            $stmt = parent::getPdo()->prepare($sql);

            return $stmt->execute([$idRessource, $idExemplaire, $idemprunteur]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Récupère les emprunts d'un emprunteur en fonction de son id (idemprunteur)
     * @param $idemprunteur
     * @return bool
     */
    public function getEmprunts($idemprunteur): bool|array
    {
        try {
            $sql = 'SELECT *,datediff(CURRENT_DATE,datedebutemprunt) as Retard FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ? and EST_RENDU =0';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getLastEmpruntDuree($idemprunteur): bool|array
    {
        try {
            $sql = 'SELECT datedebutemprunt,dateretour FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ? order by datedebutemprunt desc limit 1';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }



    /**
     * Retourne les 5 ressources les plus empruntées.
     * @return array|false
     */
    public function getTopEmprunts(): array
    {
        try {
            $sql = 'SELECT COUNT(emprunter.idressource) AS nbEmprunt, titre, emprunter.idressource FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource GROUP BY emprunter.idressource ORDER BY nbEmprunt DESC LIMIT 5';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }


    public function infoRetard($idemprunteur) : array|bool
    {
        try {
            $sql = 'SELECT titre,
                idemprunteur,
                emprunter.idressource,
                idexemplaire,
                LEFT(datedebutemprunt,10) as datedebutemprunt,
                dureeemprunt,
                LEFT(dateretour,10) as dateretour,
                datediff(CURRENT_DATE,datedebutemprunt) as frais
                
                FROM emprunter inner join ressource on ressource.idressource=emprunter.idressource 
                
                where datediff(CURRENT_DATE,datedebutemprunt) >= dureeemprunt and idemprunteur = ? and EST_RENDU=0;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getRetard($idemprunteur): int|array
    {
        try {
            $sql = 'SELECT EST_RENDU,titre
                
                FROM emprunter inner join ressource on ressource.idressource=emprunter.idressource 
                
                where datediff(CURRENT_DATE,datedebutemprunt) >= dureeemprunt and idemprunteur = ? and EST_RENDU =0 group by emprunter.idressource;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return -1;
        }
    }

    public function nombreEmprunt($idemprunteur): int|object
    {
        try {
            $sql = 'SELECT count(*) as nb from emprunter where idemprunteur=? and EST_RENDU=0;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return -1;
        }
    }

    public function ressourceDejaLu($idemprunteur,$idRessource): bool
    {
        try {
            $sql = 'SELECT count(*) as dejaLu from emprunter where idemprunteur = ? and idressource= ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur,$idRessource]);
            return $stmt->fetch(\PDO::FETCH_OBJ)->dejaLu>0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function IdRessourceDejaLu($idemprunteur): array
    {

        $sql = 'SELECT idressource from emprunter where idemprunteur=? and EST_RENDU=0;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$idemprunteur]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);

    }





}