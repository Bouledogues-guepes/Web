<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Remerciements pour l'emprunt</title>
        <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body class="bg-gray-100 font-sans">
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-bold mb-4">Merci de nous faire confiance <?= $nom." ".$prenom ?></h1>

            <p class="text-lg">Nous tenons à vous remercier pour avoir emprunter <strong><?= $titre ?></strong> via notre médiathèque.<br></p>
            <p class="text-lg"><br> Date d'emprunt:  <strong><?= $debutemprunt ?></strong> </p>
            <p class="text-lg"> Date de retour:  <strong><?= $retouremprunt ?></strong> </p>

            <p class="mt-4"><br>Nous espérons que vous apprécierez et que vous reviendrez bientôt.<br> Pour toutes questions, veuillez nous contactez au numéro suivant : <br> <strong>01 23 45 67 89</strong><br></p>
            <p class="mt-4">À bientôt !</p>
        </div>
    </body>
</html>






