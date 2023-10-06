
<!DOCTYPE html>
<html>
<head>
    <title>Afficher/Masquer une Div au-dessus de Tout avec Tailwind CSS</title>
    <!-- Incluez les fichiers CSS de Tailwind CSS (vous devez les avoir téléchargés au préalable) -->
</head>
<body>
<button id="boutonAfficherMasquer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Afficher/Masquer la Div
</button>

<div id="maDiv" class="hidden absolute z-50 bg-gray-200 p-4 rounded shadow-lg w-auto h-auto">
    <p>Ceci est le contenu de la div.</p>
    <?php

    echo $retard[0]->idressource."<br>";
    echo $retard[1]->idressource;
    ?>
</div>

<script>
    // JavaScript pour afficher/masquer la div lorsque le bouton est cliqué
    const boutonAfficherMasquer = document.getElementById("boutonAfficherMasquer");
    const maDiv = document.getElementById("maDiv");

    boutonAfficherMasquer.addEventListener("click", function() {
        if (maDiv.classList.contains("hidden")) {
            maDiv.classList.remove("hidden");
        } else {
            maDiv.classList.add("hidden");
        }
    });
</script>
</body>
</html>