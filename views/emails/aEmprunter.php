<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remerciements pour l'emprunt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #3498db;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        strong {
            color: #3a68ce;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }

        .contact-info {
            color: #3498db;
            font-weight: bold;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .text-gray {
            color: #777;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Merci de nous faire confiance <?= $nom . " " . $prenom ?></h1>

    <p>Nous tenons à vous remercier pour avoir emprunté <strong><?= $titre ?></strong> via notre médiathèque.</p>
    <p>Date d'emprunt: <strong><?= $debutemprunt ?></strong></p>
    <p>Date de retour: <strong><?= $retouremprunt ?></strong></p>

    <p class="mt-8">Nous espérons que vous apprécierez et que vous reviendrez bientôt.</p>
    <p>Pour toutes questions, veuillez nous contacter au numéro suivant : <span class="contact-info">01 23 45 67 89</span></p>

    <p class="mt-8 text-gray">À bientôt !</p>
</div>
</body>

</html>






