<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<br>

<div class="flex flex-wrap w-full gap-4">

    <!-- Graphique principal -->
    <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">
        <div class="bg-white border-2 border-black rounded-lg p-4">
            <p class="text-center font-bold text-2xl">Nombre d'emprunt par ressource</p>
            <br>
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <!-- Div contenant les deux nouvelles divs -->
    <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">

        <!-- Première nouvelle div -->
        <div class="bg-white border-2 border-black rounded-lg p-4">
            <p class="text-center font-bold text-2xl">eachanzceaz</p>
        </div>

        <!-- Deuxième nouvelle div -->
        <div class="bg-white border-2 border-black rounded-lg p-4">
            <p class="text-center font-bold text-2xl">varzr"krvl"ara"v</p>
        </div>

    </div>

</div>

<script>
    // Supposons que $statistiques est votre tableau d'objets
    var statistiques = <?php echo json_encode($stat); ?>;

    // Extraire les titres, le nombre d'emprunts et les années dans des tableaux séparés
    var titres = statistiques.map(function (item) {
        return item.titre;
    });

    var nbEmprunts = statistiques.map(function (item) {
        return item.NbEmprunt;
    });

    var annees = statistiques.map(function (item) {
        return item.Annee;
    });

    // Créer un graphique à barres groupées
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: titres,
            datasets: [{
                label: 'Nombre d\'emprunts',
                data: nbEmprunts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<br>