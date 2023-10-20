<?php
namespace models;

use models\base\SQL;

class RessourceModel extends SQL
{
    public function __construct()
    {
        parent::__construct('ressource', 'idressource');
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie where estArchive != 1;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRandomRessource($limit = 3)
    {
        $sql = 'SELECT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie  ORDER BY RAND() LIMIT ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRecentRessource($limit = 3)
    {
        $sql = 'SELECT * FROM `ressource` inner join exemplaire on ressource.idressource=exemplaire.idressource inner join categorie on ressource.idcategorie=categorie.idcategorie order by dateentree desc limit ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRessourceByType(string $id):array
    {

        $sql = 'SELECT * FROM `ressource` inner join categorie on ressource.idcategorie=categorie.idcategorie where categorie.idcategorie in ('.$id.');';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }



    public function getAllType():array
    {
        $sql = 'SELECT idcategorie,libellecategorie FROM categorie';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getLivreById($id): ?string
    {
        try {
            $sql = 'SELECT titre from ressource where idressource = ?;';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result && isset($result['titre'])) {
                return $result['titre'];
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getCommentairesByid($id): array
    {
        $sql = 'SELECT * from commentaire where idressource = ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

}