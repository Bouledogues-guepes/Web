



<div class="flex flex-wrap flex-col">

    <?php
    //echo $nombreElements = count($retard);

    for ( $i=1; $i<count($retard)+1;$i++)
    {

    ?>
        <div class="">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2"><?php echo $retard[$i-1]->idressource; ?></h2>

                <p class="text-gray-600">Information sur la ressource: </p>
                <p class="text-gray-600">Date d'emprunt: <strong><?php echo $retard[$i-1]->datedebutemprunt; ?></strong> </p><br>
                <p class="text-gray-600">Date de retour: <strong><?php echo $retard[$i-1]->dateretour; ?></strong> </p>
            </div>
        </div><br>

    <?php
    }
    ?>
</div>