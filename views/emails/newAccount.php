


<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Bienvenue sur le site de la médiathèque</title>
        <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body class="bg-gray-100 font-sans">
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-bold mb-4">Bienvenue sur le site de la médiathèque</h1>
            <p>Votre compte a bien été créé. Voici vos identifiants de connexion :</p>
            <ul class="list-disc ml-8 mt-2">
                <li><strong>Identifiant :</strong> <?= $email ?></li>
                <li><strong>Mot de passe :</strong>*********</li>
            </ul>
            <p class="mt-4">Pour finaliser votre inscription, merci de cliquer sur le lien ci-dessous :</p>
            <p class="mt-2"><a href="http://192.168.103.2/<?= $url ?>" class="text-blue-500 hover:underline">Valider l'inscription</a></p>
            <p class="mt-4">A bientôt sur notre site !</p>
        </div>
    </body>

</html>

