<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<br>
<div style="width: 80%; margin: auto; position: relative;">
    <div style="background-color: white; border: 2px solid black; border-radius: 8px; padding: 16px;">
        <canvas id="myChart"></canvas>
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