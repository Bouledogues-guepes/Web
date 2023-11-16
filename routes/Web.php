<?php

namespace routes;

use controllers\ApiDocController;
use controllers\CatalogueController;
use controllers\MainController;
use controllers\UserController;
use routes\base\Route;
use utils\SessionHelpers;
use utils\Template;

class Web
{
    function __construct()
    {
        $main = new MainController();
        $apidoc = new ApiDocController();
        $user = new UserController();
        $catalogue = new CatalogueController();

        // Appel la méthode « home » dans le contrôleur $main.
        Route::Add('/', [$main, 'home']);

        Route::Add('/horaires', fn() => Template::render('views/global/horaires.php'));

        // Routes permettant l'accès à la documentation de l'API.


        // Routes permettant la gestion de l'authentification.
        Route::Add('/login', [$user, 'login']);
        Route::Add('/signup', [$user, 'signup']);


        // Validation de l'inscription.
        Route::Add('/valider-compte/{uuid}', [$user, 'signupValidate']);

        if (SessionHelpers::isLogin()) {
            // Page de profil utilisateur.
            Route::Add('/me', [$user, 'me']);

            // Action de déconnexion.
            Route::Add('/logout', [$user, 'logout']);

            Route::Add('/delete', [$user, 'delCompte']);

            // Action d'emprunt d'une ressource.
            Route::Add('/catalogue/emprunter', [$user, 'emprunter']);

            Route::Add('/me/retard',[$user,'getRetard']);
            Route::Add('/me/download',[$user,'infoUser']);
            Route::Add('/me/edit',[$user,'editUser']);
            Route::Add('/me/edit/info',[$user,'editUserInfo']);
            Route::Add('/me/edit/password',[$user,'editUserPassword']);
            Route::Add('/catalogue/detail/commentaire/{id}',[$catalogue,'ajoutCom']);
            Route::Add('/catalogue/detail/add/{id}',[$catalogue,'addCom']);

        }

        if ( SessionHelpers::isAdmin())
        {
            Route::Add('/api', [$apidoc, 'liste']);
            Route::Add("/statistique",[$catalogue,'statistique']);
        }
        // Route permettant l'accès au catalogue.

        Route::Add('/catalogue/ville',[$catalogue,'liste']);
        Route::Add('/catalogue/detail/{id}', [$catalogue, 'detail']);


        Route::Add('/catalogue/{type}', [$catalogue, 'liste']);

        Route::Add('/catalogue/recherche',[$catalogue, 'liste']);

        Route::Add('/apropos',[$catalogue,'apropos']);



    }
}

