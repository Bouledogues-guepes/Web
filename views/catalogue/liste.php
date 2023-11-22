
<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">

    <h2 class="text-3xl font-bold text-gray-800 mb-4"><?= $titre ?></h2>


    <div class="bg-gray-200 rounded-lg shadow-md p-4 inline-block">

        <form action="/catalogue/<?= $type ?>" method="POST" class="bg-gray-200 rounded-lg shadow-md p-4">

            <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                Faire une sélection
                <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700 mt-2 absolute">
                <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
                    <?php
                    foreach ($listtype as $row) {
                        ?>
                        <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="<?= $row->idcategorie ?>" type="checkbox" name="selectedCategories[]" value="<?= $row->idcategorie ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="<?= $row->idcategorie ?>" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?php echo $row->libellecategorie; ?></label>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <button type="submit" class="inline-block rounded bg-indigo-600 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                Rechercher
            </button>

            <a href="/catalogue/all" class="text-indigo-600 hover:text-red-600 ml-2" title="Réinitialiser la recherche"> ❌️</a>

            <!-- Other buttons -->
            <div class="mt-4">
                <select name="selectedVille" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <?php
                    foreach ($nomVilles as $ville) {

                        if (isset($_SESSION["retenirVille"]))
                        {
                            if ($ville==$_SESSION["retenirVille"])
                            {
                                echo '<option value="'.$ville.'" selected>'.$ville.'</option>';
                            }
                            else
                            {
                                echo '<option value="'.$ville.'">'.$ville.'</option>';
                            }
                        }
                        else
                        {
                            echo '<option value="'.$ville.'">'.$ville.'</option>';
                        }

                    }
                    ?>
                </select>
            </div>

        </form>


        <form action="/catalogue/recherche" method="POST" class="flex items-center mt-2">

            <input type="text" name="mot" placeholder="Recherche..." class="border p-2 rounded-md focus:outline-none focus:ring focus:border-blue-300">

            <button type="submit" class="ml-2" aria-label="Rechercher">
                🔍
            </button>

        </form>
    </div>


    <br>
    <br>

    <script src="../../public/js/triCategorie.js"></script>
    <?php
    if ($catalogue == null)
    {
    ?>
    <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate">Aucun ressource n'est associé votre recherche</h3>
    <?php
        }
    ?>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 container mx-auto">
        <?php foreach ($catalogue as $ressource) { ?>
            <a href="/catalogue/detail/<?= $ressource->idressource ?>" class="bg-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                <img loading="lazy" src="/public/assets/<?= $ressource->image ?>" alt="<?= htmlspecialchars($ressource->titre) ?>" class="w-full h-64 object-cover object-center rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate"><?= $ressource->titre ?></h3>

                    <div class="flex items-center">
                        <div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300">
                            <div class="text-xs font-normal leading-none max-w-full flex-initial">
                                <?= $ressource->libellecategorie ?>
                            </div>
                        </div>

                        <div class="ml-2 w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-green-700 bg-green-100 border border-green-300">
                            <div class="text-xs font-normal leading-none max-w-full flex-initial">
                                <?= $ressource->nomville ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
</div>