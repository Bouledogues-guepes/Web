<?php

use utils\SessionHelpers;

?>



<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/2 px-4">
            <img src="/public/assets/<?= $ressource->image ?>"
                 alt="Image du livre"
                 class="mb-4 rounded-lg object-cover m-auto h-[70vh]">
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">

            <div class="bg-white shadow-lg rounded-lg px-6 py-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= $ressource->titre ?></h1>
                <p class="text-gray-600 mb-2">Année de publication: <span
                            class="font-semibold"><?= $ressource->anneesortie ?></span></p>
                <p class="text-gray-600 mb-2">Langue : <span class="font-semibold"><?= $ressource->langue ?></span></p>
                <p class="text-gray-600 mb-2">ISBN : <span class="font-semibold"><?= $ressource->isbn ?></span></p>
                <p class="text-gray-600 mb-2">Description: <span class="font-semibold">
                        <?= $ressource->description ?>
                </p>

                <!-- Bouton pour emprunter un exemplaire -->
                <?php if ($exemplaire) { ?>
                    <form id="exemplaire" method="post" class="text-center pt-5 pb-3" action="/catalogue/emprunter">
                        <input type="hidden" name="idRessource" value="<?= $ressource->idressource ?>">
                        <input type="hidden" name="idExemplaire" value="<?= $exemplaire->idexemplaire ?>">
                        <?php
                        if (SessionHelpers::isConnected()) {
                            ?>
                            <button type="submit"
                                    class="bg-indigo-600 text-white hover-bg-indigo-900 font-bold py-3 px-6 rounded-full">
                                Emprunter
                            </button><br><br>
                        <?php } ?>
                    </form>
                <?php } ?>
                <div class="bg-gray-200 p-4 mb-2 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold text-gray-900">Commentaires</h1>
                        <?php if (SessionHelpers::isConnected()) {?>

                                <form id="addCom" method="post" action ="/catalogue/detail/commentaire/<?=$ressource->idressource?>">

                                    <button type="submit" class="bg-indigo-600 text-white hover-bg-indigo-900 px-4 py-2 rounded">+</button>
                                    <input type="hidden" name="idRessource" value="<?= $ressource->idressource ?>">

                                </form>
                        <?php } ?>
                    </div>
                    <?php
                    if ($commentaires==null)
                    {
                        ?> <p class="text-gray-600 mb-2"><span class="font-semibold">Aucun commentaires n'a été déposé</span></p> <?php
                    }
                    else
                    {
                    foreach($commentaires as $value) { ?>


                        <div class="bg-white p-4 mb-2 rounded-lg">
                            <img src="<?= \utils\Gravatar::get_gravatar($value->emailemprunteur) ?>" alt="Photo de profil" class="rounded-full h-14 w-14">
                            <p class="text-gray-600 mb-2"><span class="font-semibold"><?= $value->nomemprunteur." ".$value->prenomemprunteur ?></span></p>
                            <?php
                            $noteCom = $value->noteCom;
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $noteCom) {
                                    echo '<span class="text-yellow-500">&#9733;</span>';
                                } else {
                                    echo '<span class="text-gray-500">&#9733;</span>';
                                }
                            }
                            ?>


                            <br>

                            <p class="text-gray-600 mb-2 text-xs"><span class="font-semibold"><?= $value->datecom ?></span></p>

                            <p class="text-gray-600 mb-2"><span class="font-semibold"><i><?= $value->com ?></i></span></p>

                        </div>

                    <?php }} ?>


                </div>
            </div>
        </div>
    </div>
</div>

<script>

    document.querySelector("#exemplaire").addEventListener("submit", async (e) => {
        e.preventDefault()
        const result = await Swal.fire({
            title: 'Confirmer l\'emprunt ?',
            text: "Souhaitez-vous emprunter cette ressource ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'
        })
        if (result.isConfirmed) {
            e.target.submit()
        }
    });

</script>