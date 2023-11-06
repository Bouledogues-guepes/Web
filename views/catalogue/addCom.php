<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Ajouter un commentaire</h2>

        <form action="/catalogue/detail/add/<?=$_POST["idRessource"]?>" method="POST">
            <div class="mb-4">
                <label for="comment">Commentaire</label>
                <textarea id="comment" name="comment" class="w-full p-2 border rounded" rows="4" required></textarea>


                <div class="hidden bg-red-400 text-white font-bold py-2 px-4 rounded-full mt-2" id="errorDiv">
                    Le commentaire n'est pas valide. Merci de le modifier
                </div>


                <input type="hidden" name="idRessource" value="<?=$_POST["idRessource"]?>">
            </div>

            <div class="mb-4">
                <label for="rating">Note (de 0 à 5 étoiles)</label>
                <select id="rating" name "rating" class="w-full p-2 border rounded" required>
                <option value="0">☆☆☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="3">★★★☆☆</option>
                <option value="4">★★★★☆</option>
                <option value="5">★★★★★</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full">Soumettre</button>
            </div>
        </form>

    </div>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
        const comment = document.getElementById("comment").value;

        const specificWord = "con";

        if (comment.toLowerCase().includes(specificWord) === false ) {
            event.preventDefault();
            document.getElementById("errorDiv").classList.remove("hidden");
        }
    });
</script>