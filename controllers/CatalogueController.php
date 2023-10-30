<?php

namespace controllers;

use controllers\base\WebController;
use models\ExemplaireModel;
use models\RessourceModel;
use models\CategorieModel;
use utils\Template;

class CatalogueController extends WebController
{

    private RessourceModel $ressourceModel;
    private ExemplaireModel $exemplaireModel;

    private CategorieModel $categorieModel;

    function __construct()
    {
        $this->ressourceModel = new RessourceModel();
        $this->exemplaireModel = new ExemplaireModel();
        $this->categorieModel = new CategorieModel();
    }

    /**
     * Affiche la liste des ressources.
     * @param string $type
     * @return string
     */
    function liste(string $type): string
    {

        $listtype= $this->categorieModel->getAllType();

        if ($type == "all") {
            // Récupération de l'ensemble du catalogue
            $catalogue = $this->ressourceModel->getAll();

            // Affichage de la page à l'utilisateur
            return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue", "listtype"=>$listtype,"type" => $type,"catalogue" => $catalogue ));
        }

        else
        {

            $casser=explode('&amp;',$type);
            $casser=implode(',',$casser);
            $catalogue = $this->ressourceModel->getRessourceByType($casser);

            return Template::render("views/catalogue/liste.php", ["titre" => "Ensemble du catalogue", "listtype"=>$listtype,"type" => $type,"catalogue" => $catalogue]);

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

        //$users=$this->EmprunteurModel->


        if ($ressource == null) {
            $this->redirect("/");
        }

        // Récupération des exemplaires de la ressource
        $exemplaires = $this->exemplaireModel->getByRessource($id);
        $exemplaire = null;



        // Pour l'instant, on ne gère qu'un exemplaire par ressource.
        // Si on en trouve plusieurs, on prend le premier.
        if ($exemplaires && sizeof($exemplaires) > 0) {
            $exemplaire = $exemplaires[0];
        }


        return Template::render("views/catalogue/detail.php", array("ressource" => $ressource, "exemplaire" => $exemplaire,"commentaires"=> $commentaires));
    }

    function apropos(): string
    {
        return Template::render("views/apropos/apropos.php");
    }
}