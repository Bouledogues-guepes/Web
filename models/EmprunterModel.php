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

            $titre="";
            $nomemprunteur="";
            $prenomemprunteur="";
            $email="";

            $data=$this->getTouteInfo($idemprunteur);

            $infolivre=$this->getLivreById($idRessource,$idemprunteur);





            foreach ($data as $row) {
                foreach ($row as $key => $value)
                {
                    if ($key == "emailemprunteur")
                    {
                        $email=$value;
                    }
                }
            }

            foreach ($infolivre as $ligne)
            {
                foreach ($ligne as $valeur)
                {

                    $titre=$valeur;
                }
            }


            $config = include("configs.php");

            EmailUtils::sendEmail($email, "Merci d'avoir d'emprunter", "aEmprunter",
                array(
                    "titre" => $titre
                )
            );

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
            $sql = 'SELECT * FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getTouteInfo($idemprunteur): bool|array
    {
        try {
            $sql = 'SELECT * FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie inner join emprunteur on emprunter.idemprunteur = emprunteur.idemprunteur WHERE emprunter.idemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getLivreById($id,$idemprunteur): bool|array
    {
        try {
            $sql = 'SELECT DISTINCT titre FROM emprunter LEFT JOIN ressource on emprunter.idressource=ressource.idressource where emprunter.idemprunteur =? and emprunter.idressource = ?;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id,$idemprunteur]);
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
}