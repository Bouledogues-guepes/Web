<?php
$email=$user->emailemprunteur;
$prenom=$user->prenomemprunteur;
$nom=$user->nomemprunteur;
$tel=$user->telportable;
//echo $nombreEmprunt->nb;
?>



<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">

                <?php
                if (isset($_SESSION['chgmPassword'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?= htmlspecialchars($_SESSION['chgmPassword']) ?></span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        </span>
                    </div>
                    <?php unset($_SESSION['chgmPassword']); ?>
                <?php endif;


                if (isset($_SESSION['modifInfo'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= htmlspecialchars($_SESSION['modifInfo']) ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        </span>
                </div>
                <?php unset($_SESSION['modifInfo']); ?>
                <?php endif; ?>

                <div class="flex items-center justify-center mb-4">
                    <img src="<?= \utils\Gravatar::get_gravatar($user->emailemprunteur) ?>" alt="Photo de profil"
                         class="rounded-full h-32 w-32">
                </div>
                <div class="flex items-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">👋 <?= $user->prenomemprunteur ?></h1>
                    <a href="/me/edit" class="ml-auto">
                        <img src="../../public/images/editer.png" alt="Image" class="w-5 h-5">
                    </a>
                </div>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Informations personnelles </h2>


                    <p class="text-gray-600 mb-2"><span
                                class="font-bold">Email:</span> <?= $user->emailemprunteur ?></p>
                    <p class="text-gray-600 mb-2"><span class="font-bold">Nom:</span> <?= $user->nomemprunteur ?>
                    </p>
                    <p class="text-gray-600 mb-2"><span
                                class="font-bold">Prénom:</span> <?= $user->prenomemprunteur ?></p>

                    <?php
                    if (isset($_POST['acceptConditions'])) {
                        $valeurDuFormulaire = $_POST['acceptConditions'];
                        setcookie("masquerNumero", $valeurDuFormulaire, time() + 30 * 24 * 60 * 60, "/");


                        header("Location: " . $_SERVER['REQUEST_URI'] . "?cachebuster=" . time());
                        exit;
                    }

                    $valeurDuCookie = isset($_COOKIE['masquerNumero']) ? $_COOKIE['masquerNumero'] : "";

                    if ($valeurDuCookie === "non") {
                        echo '<div><p class="text-gray-600 mb-2" id="telAmasquer"><span class="font-bold">Téléphone:</span> **********</p></div>';
                    } else {
                        echo '<div><p class="text-gray-600 mb-2" id="telAmasquer"><span class="font-bold">Téléphone:</span> ' . $user->telportable . '</p></div>';
                    }
                    ?>
                    <script>
                        if (window.location.search.indexOf("cachebuster=") !== -1) {
                            const newURL = window.location.href.replace(/\?cachebuster=\d+/, '');
                            window.history.replaceState({}, document.title, newURL);
                        }
                    </script>


                </div>

                <div class="p-5 text-center">
                    <a class="bg-red-600 text-white hover:bg-red-900 font-bold py-4 px-6 rounded-full mr-2" href="/logout">
                        Déconnexion
                    </a>

                    <a href="/me/download">

                    <button id="downloadButton" class="bg-indigo-200 text-white hover:bg-indigo-600 font-bold py-4 px-6 rounded-full ">



                        <div>
                            <img src="../../public/images/download.png" class="object-cover h-4 w-4">
                        </div>


                    </button>
                    </a>

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
                    <?php foreach ($emprunts as $emprunt) { ?>
                        <a href="/catalogue/detail/<?=$emprunt->idressource?>">
                            <div class="bg-white shadow-lg rounded-lg flex p-4">

                                <img loading="lazy" src="/public/assets/<?= $emprunt->image ?>" alt="<?= htmlspecialchars($emprunt->titre) ?>" class="w-1/4 h-32 object-cover object-center">

                                <div class="ml-4">
                                    <h2 class="text-xl font-bold text-gray-800 mb-2"><?= $emprunt->titre ?></h2>

                                    <p class="text-gray-600 mb-2 font-bold">Type: <span class="font-semibold"><?= $emprunt->libellecategorie ?></span></p>
                                    <p class="text-gray-600 mb-2 font-bold">
                                        Date d'emprunt:
                                        <span class="font-semibold"><?= date_format(date_create($emprunt->datedebutemprunt), "d/m/Y") ?></span>
                                    </p>
                                    <p class="text-gray-600 mb-2 font-bold">
                                        Date de retour prévue:
                                        <?php
                                        if($emprunt->Retard >= $emprunt->dureeemprunt)
                                        {
                                            ?><span class="font-semibold"><?= date_format(date_create($emprunt->dateretour), "d/m/Y") ?>⚠️</span><?php
                                        }
                                        else
                                        {
                                            ?><span class="font-semibold "><?= date_format(date_create($emprunt->dateretour), "d/m/Y") ?></span><?php
                                        }
                                        ?>

                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="../../public/js/masquerLeTelephone.js"></script>
