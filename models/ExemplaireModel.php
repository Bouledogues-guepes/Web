<?php

namespace models;

use models\base\SQL;

class ExemplaireModel extends SQL
{
    public function __construct()
    {
        parent::__construct('exemplaire', 'idexemplaire');
    }

    public function getByRessource(int $id): bool|array
    {
        try {
            $sql = 'SELECT idressource, idexemplaire
FROM exemplaire
WHERE idressource = ? AND (idressource, idexemplaire) NOT IN (
    SELECT e.idressource, e.idexemplaire
    FROM emprunter em
    JOIN exemplaire e ON em.idressource = e.idressource AND em.idexemplaire = e.idexemplaire
    WHERE em.idressource = ? AND em.EST_RENDU = 0
);';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id,$id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function getNbExemplaire(int $id): int|false
    {
        try {
            $sql = 'SELECT COUNT(exemplaire.idressource) AS nbexemplaire FROM exemplaire WHERE exemplaire.idressource = ?;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);

            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }

    public function getNbEmprunt(int $id): int|false
    {
        try {
            $sql = 'select count(emprunter.idressource) as nbemprunter from emprunter where emprunter.idressource=?  and emprunter.est_rendu=0;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);

            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {

            error_log($e->getMessage());
            return false;
        }
    }





}