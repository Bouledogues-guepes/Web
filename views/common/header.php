
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/style/main.css">
    <script src="/public/js/sweetalert2.all.min.js"></script>
    <script src="/public/js/vue.global.prod.js"></script>
</head>

<body class="bg-[#F2F4F7]">

<!-- En-tête -->
<header class="bg-white">
    <nav class="container mx-auto px-4 py-6 flex items-center justify-between">

        <a href="/" class="text-2xl font-semibold text-gray-800 ">
        <img src="/public/images/mediatout.png" alt="Image d'illustration" class="w-1/4 mb-4 ml-0 mx-auto shadow-lg bg-white rounded-lg ">
        </a>

        <ul class="space-x-4 flex">

            <li><a href="/catalogue/all" class="text-gray-600 hover:text-gray-800">Parcourir les ressources</a></li>
            <li><a href="/horaires" class="text-gray-600 hover:text-gray-800">Horaires</a></li>
            <li><a href="/apropos" class="text-gray-600 hover:text-gray-800">À propos</a></li>
            <li>
                <?php
                //$user->prenomemprunteur
                if (\utils\SessionHelpers::isLogin())  { ?>
                    <a href="/me" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100">
                        Mon Compte
                    </a>
                <?php } else { ?>
                    <a href="/login" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                        Se connecter
                    </a>
                <?php } ?>
            </li>
            <li>

                <script>
                    fetch('/me/retard')
                </script>


                <?php

                    $nbRetard=$_SESSION["NBRETARD"]??0;


                    if (\utils\SessionHelpers::isLogin() && $nbRetard > 0 )  {

                        ?>

                    <button id="boutonAfficherMasquer" class=" hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded mt-1">
                        <img src="../../../public/images/clocheNotif.png" class="w-8"/>
                    </button>

                    <?php
                    }
                    else
                    {
                        if (\utils\SessionHelpers::isLogin() && ($nbRetard = 0 || $nbRetard = -1 ))
                        {
                        ?>
                        <button id="boutonAfficherMasquer" class=" hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded mt-1">
                            <img src="../../../public/images/clochePasNotif.png" class="w-8"/>
                        </button>
                        <?php

                        }
                    }
                    ?>
            </li>

            <div id="maDiv" class="hidden absolute z-50 bg-indigo-600 p-4 mt-16 rounded shadow-lg w-auto h-auto right-16" >
            </div>

            <script>

                const boutonAfficherMasquer = document.getElementById("boutonAfficherMasquer");
                const maDiv = document.getElementById("maDiv");

                boutonAfficherMasquer.addEventListener("click", function() {
                    if (maDiv.classList.contains("hidden")) {
                        fetch('/me/retard').then(result => result.text()).then(data =>document.getElementById("maDiv").innerHTML = data)
                        maDiv.classList.remove("hidden");
                    } else {
                        maDiv.classList.add("hidden");
                    }
                });
            </script>


        </ul>
    </nav>
</header>