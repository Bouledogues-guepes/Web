<?php

namespace controllers;

use controllers\base\WebController;
use models\EmprunterModel;
use models\ExemplaireModel;
use models\RessourceModel;
use models\CategorieModel;
use utils\SessionHelpers;
use utils\Template;

class CatalogueController extends WebController
{

    private RessourceModel $ressourceModel;
    private ExemplaireModel $exemplaireModel;

    private CategorieModel $categorieModel;
    private EmprunterModel $emprunterModel;

    function __construct()
    {
        $this->ressourceModel = new RessourceModel();
        $this->exemplaireModel = new ExemplaireModel();
        $this->categorieModel = new CategorieModel();
        $this->emprunterModel = new EmprunterModel();
    }




    function verifierFormat($url)
    {

        $path = parse_url($url, PHP_URL_PATH);


        $pattern = '~\d+(&\d+)*$~';

        return preg_match($pattern, $path) === 1;
    }



    /**
     * Affiche la liste des ressources.
     * @param string $type
     * @return string
     */
    function liste(string $type,$mot=""): string
    {

        $listtype= $this->categorieModel->getAllType();



        if ($type == "all") {

            $catalogue = $this->ressourceModel->getAllRessource();


            return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue", "listtype"=>$listtype,"type" => $type,"catalogue" => $catalogue ));
        }

        else
        {
                if($this->verifierFormat($type))
                {
                    $casser = explode('&amp;', $type);
                    $casser = implode(',', $casser);
                    $catalogue = $this->ressourceModel->getRessourceByType($casser);
                    return Template::render("views/catalogue/liste.php", ["titre" => "Ensemble du catalogue", "listtype" => $listtype, "type" => $type, "catalogue" => $catalogue]);
                }
                else
                {
                    $mot=strip_tags($mot);


                    $listtype= $this->categorieModel->getAllType();

                    $catalogue = $this->ressourceModel->recherche($mot);

                    return Template::render("views/catalogue/liste.php", ["titre" => "Recherche à partir de : ".$mot, "listtype" => $listtype, "catalogue" => $catalogue]);
                }




        }
    }




    /**
     * Affiche le détail d'une ressource.
     * @param int $id
     * @return string
     */
    function detail(int $id): string
    {
        // Récupération de la ressource
        $ressource = $this->ressourceModel->getOne($id);

        $commentaires=$this->ressourceModel->getCommentairesByid($id);



        if ($ressource == null) {
            $this->redirect("/");
        }

        // Récupération des exemplaires de la ressource
        $exemplaires = $this->exemplaireModel->getByRessource($id);
        $exemplaire = null;

        $auteur=$this->ressourceModel->getAuteurById($id);

        // Pour l'instant, on ne gère qu'un exemplaire par ressource.
        // Si on en trouve plusieurs, on prend le premier.
        if ($exemplaires && sizeof($exemplaires) > 0) {
            $exemplaire = $exemplaires[0];
        }

        if (SessionHelpers::isConnected())
        {
            $user = SessionHelpers::getConnected();

            $dejaLu=$this->emprunterModel->ressourceDejaLu($user->idemprunteur,$id);

            $nbEmprunt=$this->emprunterModel->nombreEmprunt($user->idemprunteur);

            $listeIdDejaLu=$this->emprunterModel->IdRessourceDejaLu($user->idemprunteur);


            return Template::render("views/catalogue/detail.php", array("ressource" => $ressource,
                "exemplaire" => $exemplaire,"commentaires"=> $commentaires,"dejaLu"=>$dejaLu,
                "auteurs"=>$auteur,"nbEmprunt"=>$nbEmprunt,"listeIdDejaLu"=>$listeIdDejaLu));


        }
        return Template::render("views/catalogue/detail.php", array("ressource" => $ressource, "exemplaire" => $exemplaire,
            "commentaires"=> $commentaires,"dejaLu"=>"false","auteurs"=>$auteur));
    }

    function apropos(): string
    {
        return Template::render("views/apropos/apropos.php");
    }


    function ajoutCom():string
    {
        return Template::render("views/catalogue/addCom.php");
    }

    function addCom():bool
    {
        $com=$_POST["comment"];
        $note=$_POST["rating"];


        // Filtrage pour eviter les failles XSS
        $cleanText = strip_tags(htmlspecialchars($com));


        $user = SessionHelpers::getConnected();
        $idemprunteur=$user->idemprunteur;

        $idRessourceLu=$this->emprunterModel->ressourceDejaLu($idemprunteur);

        $idressource=$_POST["idRessource"];


        foreach ($idRessourceLu as $id)
        {
            if ( $id->idressource == $idressource)
            {
                $this->ressourceModel->addCommentaireOnId($cleanText,$note,$idemprunteur,$idressource);
                header("Location: /catalogue/detail/$idressource?commentAdded=true");
                return true;
            }
        }
        header("Location: /catalogue/detail/$idressource?commentAdded=false");
        return false;

    }


    function statistique():string
    {
        $StatistiqueParLivre=$this->ressourceModel->getStatistiqueParLivre();
        $StatistiqueParAnnee=$this->ressourceModel->getStatistiqueParAnnee();
        $StatistiqueParCom=$this->ressourceModel->getStatistiqueParCom();
        $StatistiqueParMoyenne=$this->ressourceModel->getStatistiqueParMoyenne();

        return Template::render("views/catalogue/statistique.php",["StatistiqueParLivre"=>$StatistiqueParLivre,"StatistiqueParAnnee"=>$StatistiqueParAnnee,"StatistiqueParCom"=>$StatistiqueParCom,"StatistiqueParMoyenne"=>$StatistiqueParMoyenne]);
    }


}