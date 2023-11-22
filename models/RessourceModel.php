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
        $sql = 'SELECT titre,MAX(ressource.idressource) AS idressource,MAX(ressource.idcategorie) AS idcategorie,MAX(description) AS description,MAX(image) AS image, MAX(anneesortie) AS anneesortie,MAX(isbn) AS isbn,MAX(langue) AS langue,MAX(estArchive) AS estArchive,MAX(idexemplaire) AS idexemplaire,MAX(idetat) AS idetat, MAX(dateentree) AS dateentree,MAX(libellecategorie) AS libellecategorie , nomVille FROM `ressource` INNER JOIN exemplaire ON ressource.idressource = exemplaire.idressource INNER JOIN categorie ON ressource.idcategorie = categorie.idcategorie inner join `ville` on exemplaire.idVille=ville.idVille WHERE estArchive != 1 GROUP BY titre ORDER BY MAX(dateentree) DESC LIMIT ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRessourceByType(string $id, $ville = ""): array
    {
        $idsArray = explode(',', $id);
        $idsArray = array_map('intval', $idsArray);
        $placeholders = rtrim(str_repeat('?,', count($idsArray)), ',');

        $sql = 'SELECT DISTINCT ressource.idressource, ressource.idcategorie, ressource.titre, ressource.description, ressource.image, ressource.anneesortie, isbn, langue, estArchive, libellecategorie, nomville
            FROM ressource
            INNER JOIN categorie ON ressource.idcategorie = categorie.idcategorie
            INNER JOIN exemplaire ON ressource.idressource = exemplaire.idressource
            INNER JOIN ville ON exemplaire.idVille = ville.idVille
            WHERE categorie.idcategorie IN (' . $placeholders . ')
            AND nomville = ?';

        $params = array_merge($idsArray, [$ville]);

        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function getAllByVille(string $ville):array
    {

        $sql='select distinct ressource.idressource,ressource.idcategorie,ressource.titre,ressource.description ,ressource.image ,ressource.anneesortie,isbn,langue,estArchive,libellecategorie,nomville from ressource 

inner join categorie on ressource.idcategorie=categorie.idcategorie 
inner join exemplaire on ressource.idressource = exemplaire.idressource 
inner join ville on exemplaire.idVille = ville.idVille 


where nomVille=? and estArchive=0;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$ville]);
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
            $sql = 'SELECT titre from ressource  where idressource = ? ';
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
group by emprunter.idressource order by NbEmprunt desc limit 10;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getStatistiqueParAnnee():array
    {
        $sql = 'SELECT year(datedebutemprunt) AS ANNEE,count(*) as NbEmprunt   
FROM emprunter inner join ressource on ressource.idressource=emprunter.idressource 
group by year(datedebutemprunt) order by ANNEE asc;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getStatistiqueParCom():array
    {
        $sql = 'SELECT titre ,count(com) as NbCom   
FROM emprunter inner join ressource on ressource.idressource=emprunter.idressource INNER join commentaire on ressource.idressource=commentaire.idressource
group by titre order by NbCom desc limit 6;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getStatistiqueParMoyenne():array
    {
        $sql = 'SELECT round(sum(noteCom)/ count(noteCom),1) as moyenne,titre 
from commentaire inner join ressource on ressource.idressource=commentaire.idressource 
group by commentaire.idressource order by moyenne desc ';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function recherche($mot=""):array
    {
        $sql = 'select distinct ressource.idressource,ressource.idcategorie,ressource.titre,ressource.description ,ressource.image ,ressource.anneesortie,isbn,langue,estArchive,libellecategorie,nomville FROM ressource 
                INNER JOIN categorie ON ressource.idcategorie = categorie.idcategorie 
                INNER JOIN exemplaire on ressource.idressource=exemplaire.idressource
                INNER JOIN ville on exemplaire.idVille = ville.idVille
                WHERE titre LIKE ? AND estArchive = 0';

        $motRecherche = '%' . $mot . '%';

        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$motRecherche]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAllVille(): array
    {
        $sql = 'SELECT * FROM ville';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }








}