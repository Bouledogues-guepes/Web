<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <form method="post" action="/me/edit/info">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Modifier les informations personnelles</h2>
                    <!-- Ajoutez ici les champs d'édition pour les informations personnelles -->
                    <!-- Par exemple : -->
                    <input type="text" placeholder="Nouveau nom" class="w-full mt-2 border p-2 rounded-lg" name="newName">
                    <input type="text" placeholder="Nouveau prénom" class="w-full mt-2 border p-2 rounded-lg" name="newPname">
                    <input type="date" placeholder="Nouvelle date de naissance" class="w-full mt-2 border p-2 rounded-lg" name="newDateN">
                    <input type="email" placeholder="Nouvel email" class="w-full mt-2 border p-2 rounded-lg" name="newEmail">
                    <input type="number" placeholder="Nouveau téléphone" class="w-full mt-2 border p-2 rounded-lg" name="newTel">
                </div>


                <div class="p-5 text-center">
                    <input type="submit" value="Modifier" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2" >
                </div>
                </form>
            </div>
        </div>

        <!-- Colonne du milieu -->


        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <form method="post" action="/me/edit/password">
                <div class="mb-4">

                    <h2 class="text-xl font-semibold text-gray-800 mb-2 ">Modifier le mots de passe</h2>
                    <!-- Ajoutez ici les champs d'édition pour les informations personnelles -->
                    <!-- Par exemple : -->
                    <input type="password" placeholder="Ancien mots de passe" class="w-full mt-2 border p-2 rounded-lg" name="currentPassword">
                    <br>
                    <input type="password" placeholder="Nouveau mot de passe" class="w-full mt-2 border p-2 rounded-lg" name="newPassword">
                    <input type="password" placeholder="Confirmation mot de passe" class="w-full mt-2 border p-2 rounded-lg" name="confirmNewPassword">

                </div>

                <div class="p-5 text-center">
                    <input type="submit" value="Modifier" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2" >

                </div>
                </form>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Préférences</h2>
                    <div class="mt-2">
                        <form method="post" action="/me">


                            <div class="border p-4 rounded-lg">
                                <label class="block text-gray-700">Affichez le téléphone</label>
                                <input type="radio" name="acceptConditions" value="oui" class="mr-1" required > Oui
                                <input type="radio" name="acceptConditions" value="non" class="ml-4 mr-1" required> Non
                            </div>





                            <div class="p-5 text-center">
                                <button type="submit" name="modification" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2">Modifier</button>
                            </div>
                        </form>

                        <a href="/delete" id="deleteLink">
                            <div class="border p-4 rounded-lg bg-red-500 text-white flex justify-center items-center">
                                <label class="block">🗑Supprimer le compte 🗑️</label>
                            </div>
                        </a>

                        <div id="confirmationBox" class="hidden">
                            <div class="border p-4 rounded-lg">
                                <p class="mb-4">Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                                <div class="flex justify-center">
                                    <button id="confirmDelete" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full mr-2">Confirmer</button>
                                    <button id="cancelDelete" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full">Annuler</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('deleteLink').addEventListener('click', function(e) {
                                e.preventDefault(); // Empêche le lien de naviguer immédiatement

                                // Afficher la boîte de confirmation
                                document.getElementById('confirmationBox').classList.remove('hidden');
                            });

                            document.getElementById('confirmDelete').addEventListener('click', function() {
                                // Placez ici le code pour supprimer le compte
                                // Vous pouvez ajouter la redirection vers /delete
                                window.location.href = '/delete';
                            });

                            document.getElementById('cancelDelete').addEventListener('click', function() {
                                // Si l'utilisateur annule la suppression, masquez la boîte de confirmation
                                document.getElementById('confirmationBox').classList.add('hidden');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

