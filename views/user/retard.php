



<div class="flex flex-wrap flex-col">

    <?php

    if (isset($_SESSION["NBRETARD"])) {
        \utils\SessionHelpers::NBRETARD(count($nbRetard));
    }
    if (count($retard) > 0) {
        for ($i = 1; $i < count($retard) + 1; $i++) {
            ?>
            <div class="">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold mb-2"><strong><?php echo $retard[$i - 1]->titre; ?></strong></h2>
                    <p class="text-gray-600">Date d'emprunt: <strong><?php echo $retard[$i - 1]->datedebutemprunt; ?></strong></p>
                    <p class="text-gray-600">Date de retour: <strong><?php echo $retard[$i - 1]->dateretour; ?></strong></p></br>

                    <p class="text-red-600">Frais encouru: <strong><?php echo $retard[$i - 1]->frais; ?>€</strong></p>

                </div>

            </div>
            <p class="text-red-600">( 1€ par jour non-rendu )</p>
            <br>
            <?php
        }
    } else {
        ?><p class="text-black font-semibold">Aucun retard à signaler</p><br>

        <?php
    }
    ?>

</div>