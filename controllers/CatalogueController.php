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

        if($path[0]=="%")
        {
            return 0;
        }

        return preg_match($pattern, $path) === 1;
    }



    /**
     * Affiche la liste des ressources.
     * @param string $type
     * @return string
     */
    function liste(string $type="null",$mot=""): string
    {

        $listtype= $this->categorieModel->getAllType();
        $villes=$this->ressourceModel->getAllVille();

        $nomvilles = array_column($villes, 'nomville');

        if(isset($_POST["selectedVille"]))
        {
            $_SESSION["retenirVille"]=$_POST["selectedVille"];
        }


        if(isset($_POST["selectedVille"]) and $type=="all")
        {

            $ville=$_POST["selectedVille"];

            $catalogue = $this->ressourceModel->getAllByVille($ville);
            return Template::render("views/catalogue/liste.php", ["titre" => "Ensemble du catalogue de ".$ville, "listtype" => $listtype, "type" => $type, "catalogue" => $catalogue,"nomVilles"=>$nomvilles]);
        }


        if ($type == "all") {

            $catalogue = $this->ressourceModel->recherche("");
            return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue", "listtype"=>$listtype,"type" => $type,"catalogue" => $catalogue,"nomVilles"=>$nomvilles ));
        }

        else
        {

                if($this->verifierFormat($type))
                {
                    $ville=$_POST["selectedVille"];
                    $casser = explode('&amp;', $type);
                    $casser = implode(',', $casser);
                    $catalogue = $this->ressourceModel->getRessourceByType($casser,$ville);
                    return Template::render("views/catalogue/liste.php", ["titre" => "Selection du catalogue de ".$ville, "listtype" => $listtype, "type" => $type, "catalogue" => $catalogue,"nomVilles"=>$nomvilles]);
                }
                else
                {
                    $mot=strip_tags($mot);

                    $listtype= $this->categorieModel->getAllType();

                    $catalogue = $this->ressourceModel->recherche($mot);

                    return Template::render("views/catalogue/liste.php", ["titre" => "Recherche à partir de : '".$mot."' sur toutes les bibliothèques", "listtype" => $listtype, "catalogue" => $catalogue,"type" => $type,"nomVilles"=>$nomvilles]);
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

        if ($exemplaires && sizeof($exemplaires) > 0) {
            $exemplaire = $exemplaires[0];
        }
        else{
            $exemplaire=0;
        }


        $restant=$this->exemplaireModel->getNbExemplaire($id)-$this->exemplaireModel->getNbEmprunt($id);

        if ($restant<0){$restant=0;}

        if (SessionHelpers::isConnected())
        {
            $user = SessionHelpers::getConnected();

            $dejaLu=$this->emprunterModel->ressourceDejaLu($user->idemprunteur,$id);

            $nbEmprunt=$this->emprunterModel->nombreEmprunt($user->idemprunteur);

            $listeIdDejaLu=$this->emprunterModel->IdRessourceDejaLu($user->idemprunteur);


            return Template::render("views/catalogue/detail.php", array("ressource" => $ressource,
                "exemplaire" => $exemplaire,"commentaires"=> $commentaires,"dejaLu"=>$dejaLu,
                "auteurs"=>$auteur,"nbEmprunt"=>$nbEmprunt,"listeIdDejaLu"=>$listeIdDejaLu,"examplaireRestant"=>$restant));


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
        $idressource=$_POST["idRessource"];


        $idRessourceLu=$this->emprunterModel->ressourceDejaLu($idemprunteur,$idressource);

        if ($idRessourceLu)
        {
            $this->ressourceModel->addCommentaireOnId($cleanText,$note,$idemprunteur,$idressource);
            header("Location: /catalogue/detail/$idressource?commentAdded=true");
            return true;
        }
        else
        {
            header("Location: /catalogue/detail/$idressource?commentAdded=false");
            return false;
        }


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