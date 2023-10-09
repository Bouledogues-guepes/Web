<?php
$email=$user->emailemprunteur;
$prenom=$user->prenomemprunteur;
$nom=$user->nomemprunteur;
$tel=$user->telportable;
?>



<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <div class="flex items-center justify-center mb-4">
                    <img src="<?= \utils\Gravatar::get_gravatar($user->emailemprunteur) ?>" alt="Photo de profil"
                         class="rounded-full h-32 w-32">
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">👋 <?= $user->prenomemprunteur ?></h1>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Informations personnelles </h2>


                    <p class="text-gray-600 mb-2"><span
                                class="font-semibold">Email:</span> <?= $user->emailemprunteur ?></p>
                    <p class="text-gray-600 mb-2"><span class="font-semibold">Nom:</span> <?= $user->nomemprunteur ?>
                    </p>
                    <p class="text-gray-600 mb-2"><span
                                class="font-semibold">Prénom:</span> <?= $user->prenomemprunteur ?></p>

                    <div>
                        <p class="text-gray-600 mb-2" id="telAmasquer"><span
                                    class="font-semibold">Téléphone:</span> <?= $user->telportable ?></p>
                        <?php
                        $valeurDuCookie = isset($_COOKIE['masquerNumero']) ? $_COOKIE['masquerNumero'] : "";

                        // Génération du code HTML du formulaire
                        echo '<input type="checkbox" id="checkbox" name="Masquer"';

                        // Si le cookie a la valeur "masquer", cochez la case à cocher par défaut
                        if ($valeurDuCookie === "masquer") {
                            echo ' checked';
                        }

                        echo '>';?>
                        <label for="Masquer">Masquer le téléphone ?</label>


                    </div>


                </div>

                <div class="p-5 text-center">
                    <a class="bg-red-600 text-white hover:bg-red-900 font-bold py-4 px-6 rounded-full mr-2" href="/logout">
                        Déconnexion
                    </a>

                    <button id="downloadButton" class="bg-indigo-200 text-white hover:bg-indigo-600 font-bold py-4 px-6 rounded-full ">

                        <div>
                            <img src="../../public/images/download.png" class="object-cover h-4 w-4">
                        </div>
                    </button>

                    <script>
                        const downloadButton = document.getElementById("downloadButton");

                        // Créez un gestionnaire d'événements pour le clic sur le bouton
                        downloadButton.addEventListener("click", function () {
                        // Créez un objet JSON de données (remplacez cela par vos propres données)
                        const jsonData = {
                        nom: "John",
                        prenom: "Doe",
                        email: "john.doe@example.com",
                        // Ajoutez d'autres données ici...
                        };

                        // Convertissez l'objet JSON en une chaîne JSON
                        const jsonString = JSON.stringify(jsonData, null, 2);

                        // Créez un objet Blob à partir de la chaîne JSON
                        const blob = new Blob([jsonString], { type: "application/json" });

                        // Générez une URL d'objet Blob pour le téléchargement
                        const url = URL.createObjectURL(blob);

                        // Créez un lien de téléchargement
                        const a = document.createElement("a");
                        a.href = url;
                        a.download = "donnees.json"; // Nom du fichier de téléchargement
                        a.style.display = "none";

                        // Ajoutez le lien au DOM et déclenchez le clic
                        document.body.appendChild(a);
                        a.click();

                        // Supprimez le lien du DOM après le téléchargement
                        document.body.removeChild(a);
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-2/3 px-4 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes emprunts</h1>

            <?php if (!$emprunts) { ?>
                <!-- Message si aucun emprunt -->
                <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-5">
                    <p class="text-gray-600 mb-2">Vous n'avez aucun emprunt en cours.</p>
                </div>
            <?php } else { ?>
                <!-- Tableau des emprunts -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5">

                    <!-- Liste des emprunts -->
                    <?php foreach ($emprunts as $emprunt) { ?>
                        <div class="bg-white shadow-lg rounded-lg px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= $emprunt->titre ?></h2>
                            <p class="text-gray-600 mb-2">Type: <span
                                        class="font-semibold"><?= $emprunt->libellecategorie ?></span></p>
                            <p class="text-gray-600 mb-2">
                                Date d'emprunt:
                                <span class="font-semibold"><?= date_format(date_create($emprunt->datedebutemprunt), "d/m/Y") ?></span>
                            </p>
                            <p class="text-gray-600 mb-2">
                                Date de retour prévue:
                                <span class="font-semibold"><?= date_format(date_create($emprunt->dateretour), "d/m/Y") ?></span>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="../../public/js/masquerLeTelephone.js"></script>

<?php

if (isset($_POST['Masquer'])) {
    $valeurDuCookie = "masquer";
    $duree = time() + 30 * 24 * 60 * 60; // Expire dans 30 jours
    $chemin = "/"; // Le cookie est disponible dans tout le domaine
    setcookie("masquerNumero", $valeurDuCookie, $duree, $chemin);
}




?>