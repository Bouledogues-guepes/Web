<?php
namespace models;

use models\base\SQL;
use utils\SessionHelpers;

class RessourceModel extends SQL
{
    public function __construct()
    {
        parent::__construct('ressource', 'idressource');
    }

    public function getAuteurById(int $id): array
    {
        $sql = 'SELECT nomauteur,ressource.titre FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie 
    inner join ecrire on ressource.idressource=ecrire.idRessource inner join auteur on auteur.idAuteur=ecrire.idAuteur where ressource.idressource = ?;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$id]);
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
        $sql = 'SELECT idcom,com,noteCom,datecom,idressource, nomemprunteur,prenomemprunteur,emailemprunteur from commentaire inner join emprunteur on commentaire.idemprunteur=emprunteur.idemprunteur where idressource = ? ORDER BY datecom DESC';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function addCommentaireOnId($commentaire,$note,$user,$ressource) : bool
    {
        try {
            $sql = "INSERT INTO `commentaire` (`idcom`, `com`, `noteCom`, `idemprunteur`, `datecom`, `idressource`) VALUES (NULL, ?, ?, ?, CURRENT_DATE(),?)";
            $stmt = parent::getPdo()->prepare($sql);

            return $stmt->execute([ $commentaire,$note,$user,$ressource]);
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function getStatistiqueParLivre():array
    {
        $sql = 'SELECT titre,count(*)as NbEmprunt   
FROM emprunter inner join ressource on ressource.idressource=emprunter.idressource 
group by emprunter.idressource ;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }



}