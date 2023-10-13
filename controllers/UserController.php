<?php

namespace controllers;

use controllers\base\WebController;
use Exception;
use models\EmprunterModel;
use models\EmprunteurModel;
use models\RessourceModel;
use utils\EmailUtils;
use utils\SessionHelpers;
use utils\Template;

class UserController extends WebController
{
    // On déclare les modèles utilisés par le contrôleur.
    private EmprunteurModel $emprunteur; // Modèle permettant d'interagir avec la table emprunteur

    private EmprunterModel $emprunter; // Modèle permettant l'emprunt

    private RessourceModel $ressource;

    function __construct()
    {
        $this->emprunteur = new EmprunteurModel();
        $this->emprunter = new EmprunterModel();
        $this->ressource = new RessourceModel();
    }

    /**
     * Déconnecte l'utilisateur.
     * @return string
     */
    function logout(): string
    {
        SessionHelpers::logout();
        return $this->redirect("/");
    }

    /**
     * Affiche la page de connexion.
     * Si l'utilisateur est déjà connecté, il est redirigé vers sa page de profil.
     * Si la connexion échoue, un message d'erreur est affiché.
     * @return string
     */

    function VerifEmail($email) {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

        if (preg_match($pattern, $email)) {
            return true; // L'email est valide
        } else {
            return false; // L'email est invalide
        }
    }


    function login(): string
    {
        $data = array();

        // Si l'utilisateur est déjà connecté, on le redirige vers sa page de profil



        // Gestion de la connexion
        if (isset($_POST["email"]) && isset($_POST["password"]))
        {

            $result = $this->emprunteur->connexion($_POST["email"], $_POST["password"]);
            $validationcompte=$this->emprunteur->getValidation($_POST["email"]);

            // Si la connexion est réussie, on redirige l'utilisateur vers sa page de profil

            if ($result && ($validationcompte==1 || $validationcompte==2)) {
                $this->redirect("/me");
            }
            else {
                if (!$result)
                {
                    $data["error"] = "Email ou mot de passe incorrect";
                }
                elseif ($validationcompte == 0) {
                    $data["error"] = "Compte non-validé";
                    SessionHelpers::logout();

                }
                elseif ($validationcompte == 5) {
                    $data["error"] = "Email ou mot de passe incorrect";
                    SessionHelpers::logout();

                }
                elseif ($validationcompte == 3) {
                    $data["error"] = "Compte banni";
                    SessionHelpers::logout();

                } elseif ($validationcompte == 4) {
                    $data["error"] = "Compte supprimé";
                    SessionHelpers::logout();
                }


            }
        }

        // Affichage de la page de connexion
        return Template::render("views/user/login.php", $data);
    }

    /**
     * Affiche la page d'inscription.
     * Si l'utilisateur est déjà connecté, il est redirigé vers sa page de profil.
     * Si l'inscription échoue, un message d'erreur est affiché.
     * @return string
     */
    function signup(): string
    {
        $data = array();
        // Si l'utilisateur est déjà connecté, on le redirige vers sa page de profil
        if (SessionHelpers::isConnected()) {
            return $this->redirect("/me");
        }

        if (isset($_POST["boutonInscrire"])) {
            try {
                // Vérification des champs requis et des contraintes a l'aide de diffèrentes exception
                if (!isset($_POST["tel"]) || empty($_POST["tel"]) || strlen($_POST["tel"])<10 )
                {
                    throw new Exception("Le téléphone est mal renseigné.");
                }
                if (strlen($_POST["password"]) <= 8)
                {
                    throw new Exception("Le mot de passe doit faire plus de 8 caractères");
                }
                if (!isset($_POST["password"]) || empty($_POST["password"]))
                {
                    throw new Exception("Erreur dans le mots de passe");
                }
                if ( !isset($_POST["email"]) || empty($_POST["email"]) || !$this->VerifEmail($_POST["email"]) || strlen($_POST["email"]) > 64)
                {
                    throw new Exception("Erreur dans l'email");
                }
                if (!isset($_POST["nom"]) ||  empty($_POST["nom"]) || strlen($_POST["nom"])<1)
                {
                    throw new Exception("Erreur dans le nom");
                }
                if ( !isset($_POST["prenom"]) || empty($_POST["prenom"]) || strlen($_POST["prenom"])<1)
                {
                    throw new Exception("Erreur dans le prenom");
                }

                $_POST["tel"] = str_replace(' ', '', $_POST["tel"]);

                $result = $this->emprunteur->creerEmprenteur($_POST["tel"], $_POST["email"], $_POST["password"], $_POST["nom"], $_POST["prenom"]);

                // Si l'inscription est réussie, on affiche un message de succès
                if ($result) {
                    return Template::render("views/user/signup-success.php");
                } else {
                    throw new Exception("La création du compte a échoué.");
                }
            } catch (Exception $e) {
                $data["error"] = $e->getMessage();
            }
        }
        // Affichage de la page d'inscription
        return Template::render("views/user/signup.php", $data);
    }

    function signupValidate($uuid){
        $result = $this->emprunteur->validateAccount($uuid);

        if($result){
            // Affichage de la page de finalisation de l'inscription
            return Template::render("views/user/signup-validate-success.php");
        }else{
            // Gestion d'erreur à améliorer
            return parent::redirect("/");
        }
    }

    /**
     * Affiche la page de profil de l'utilisateur connecté.
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
     * @return string
     */
    function me(): string
    {
        // Récupération de l'utilisateur connecté en SESSION.
        // La variable contient les informations de l'utilisateur présent en base de données.
        $user = SessionHelpers::getConnected();

        // Récupération des emprunts de l'utilisateur
        $emprunts = $this->emprunter->getEmprunts($user->idemprunteur);

        return Template::render("views/user/me.php", array("user" => $user, "emprunts" => $emprunts));
    }

    /**
     * Affiche la page de profil d'un utilisateur.
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
     * Pour accéder à la page il faut également l'id de la ressource et l'id de l'exemplaire.
     * @return string
     */
    function emprunter(): string
    {
        // Id à emprunter
        $idRessource = $_POST["idRessource"];
        $idExemplaire = $_POST["idExemplaire"];



        // Récupération de l'utilisateur connecté en SESSION.
        $user = SessionHelpers::getConnected();

        if (!$user || !$idRessource || !$idExemplaire) {
            // Gestion d'erreur à améliorer
            die ("Erreur: utilisateur non connecté ou ids non renseignés");
        }

        // On déclare l'emprunt, et on redirige l'utilisateur vers sa page de profil

        $nbEmprunt= $this->emprunter->nombreEmprunt( $user->idemprunteur);



        if ($nbEmprunt->nb <3)
        {
            $result = $this->emprunter->declarerEmprunt($idRessource, $idExemplaire, $user->idemprunteur);
            $titre = $this->ressource->getLivreById($idRessource);

            $emprunts = $this->emprunter->getLastEmpruntDuree($user->idemprunteur);

            EmailUtils::sendEmail($user->emailemprunteur, "Merci pour votre emprunt ! ", "aEmprunter",
                    array(
                        "titre" => $titre,
                        "nom" => $user->nomemprunteur,
                        "prenom" => $user->prenomemprunteur,
                        "debutemprunt" => $emprunts[0]->datedebutemprunt,
                        "retouremprunt" => $emprunts[0]->dateretour
                    )
                );

            if ($result) {
                $this->redirect("/me");
            } else {
                // Gestion d'erreur à améliorer
                die("Erreur lors de l'emprunt");
            }
        }
        else
        {
            $this->redirect("/me");
        }
    }


    function getRetard(): string
    {
        $user = SessionHelpers::getConnected();

        if (!$user) {
            die ("Erreur: utilisateur non connecté ou ids non renseignés");
        }

        $retard=$this->emprunter->infoRetard($user->idemprunteur);

        $nbRetard=$this->emprunter->getRetard($user->idemprunteur);

        return Template::render("views/user/retard.php", array("user" => $user, "retard" => $retard,"nbRetard"=>$nbRetard), false);

    }

    function infoUser():string
    {
        $user = SessionHelpers::getConnected();

        if (!$user) {
            die ("Erreur: utilisateur non connecté ou ids non renseignés");
        }

        $info=$this->emprunteur->getInfoEmprunteur($user->idemprunteur);

        Template::render("views/user/download.php", ["info" => $info]);
    }

}