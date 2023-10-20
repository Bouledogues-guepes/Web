<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">

                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Modifier les informations personnelles</h2>
                    <!-- Ajoutez ici les champs d'édition pour les informations personnelles -->
                    <!-- Par exemple : -->
                    <input type="text" placeholder="Nouveau nom" class="w-full mt-2 border p-2 rounded-lg">
                    <input type="text" placeholder="Nouveau prénom" class="w-full mt-2 border p-2 rounded-lg">
                    <input type="text" placeholder="Nouvelle date de naissance" class="w-full mt-2 border p-2 rounded-lg">
                    <input type="text" placeholder="Nouvelle email" class="w-full mt-2 border p-2 rounded-lg">
                    <input type="text" placeholder="Nouveau téléphone" class="w-full mt-2 border p-2 rounded-lg">
                </div>

                <div class="p-5 text-center">
                    <a class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2" href="/logout">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Colonne du milieu -->
        <form method="post" action="/me/edit/password">

            <div class="w-full md:w-1/3 px-4">
                <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">

                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Modifier le mots de passe</h2>
                        <!-- Ajoutez ici les champs d'édition pour les informations personnelles -->
                        <!-- Par exemple : -->
                        <input type="text" placeholder="Ancien mots de passe" class="w-full mt-2 border p-2 rounded-lg" name="currentPassword">
                        <br>
                        <input type="text" placeholder="Nouveau mot de passe" class="w-full mt-2 border p-2 rounded-lg" name="newPassword">
                        <input type="text" placeholder="Confirmation mot de passe" class="w-full mt-2 border p-2 rounded-lg" name="confirmNewPassword">

                    </div>

                    <div class="p-5 text-center">
                        <a class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2" href="/logout">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <!-- Colonne de droite -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Préférences</h2>
                    <div class="mt-2">
                        <label class="block text-gray-700">Affichez le téléphone</label>
                        <input type="radio" name="acceptConditions" value="oui" class="mr-1"> Oui
                        <input type="radio" name="acceptConditions" value="non" class="ml-4 mr-1"> Non
                    </div>
                </div>

                <div class="p-5 text-center">
                    <a class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2" href="/logout">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>