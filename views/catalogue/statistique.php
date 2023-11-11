<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

<?php
if(isset($_GET["graphique"])) {
    $numero = $_GET["graphique"];
}
else
{
    $numero=1;
}

    if($numero==1)

    {
        ?>
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

                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <!-- Utiliser un autre identifiant pour le deuxième graphique -->
                    <canvas id="myChart2" onclick="redirectToGraph(2)"></canvas>
                </div>

                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <!-- Utiliser un autre identifiant pour le troisième graphique -->
                    <canvas id="myChart3" onclick="redirectToGraph(3)"></canvas>
                </div>

            </div>

        </div>
        <?php
    }
    if($numero==2)
    {
    ?>

    <div class="flex flex-wrap w-full gap-4">

        <!-- Graphique principal -->
        <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">

            <div class="bg-white border-2 border-black rounded-lg p-4">
                <p class="text-center font-bold text-2xl">Nombre d'emprunt par annee</p>
                <br>
                <!-- Utiliser un autre identifiant pour le deuxième graphique -->
                <canvas id="myChart2"></canvas>
            </div>


        </div>

        <!-- Div contenant les deux nouvelles divs -->
        <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">

            <div class="bg-white border-2 border-black rounded-lg p-4">
                <!-- Utiliser un autre identifiant pour le troisième graphique -->
                <canvas id="myChart3" onclick="redirectToGraph(3)"></canvas>
            </div>

            <div class="bg-white border-2 border-black rounded-lg p-4">
                <canvas id="myChart" onclick="redirectToGraph(1)"></canvas>
            </div>



        </div>

    </div>
    <?php
    }

    if($numero==3) {

    ?>

        <div class="flex flex-wrap w-full gap-4">

            <!-- Graphique principal -->
            <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">
                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <p class="text-center font-bold text-2xl">Nombre de commentaire par ressource</p>
                    <br>
                    <canvas id="myChart3"></canvas>
                </div>
            </div>

            <!-- Div contenant les deux nouvelles divs -->
            <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">

                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <!-- Utiliser un autre identifiant pour le deuxième graphique -->
                    <canvas id="myChart" onclick="redirectToGraph(1)"></canvas>
                </div>

                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <!-- Utiliser un autre identifiant pour le troisième graphique -->
                    <canvas id="myChart2" onclick="redirectToGraph(2)"></canvas>
                </div>

            </div>

        </div>
    <?php
    }

    ?>

<script>
    function redirectToGraph(graphNumber) {
        window.location.href = "/statistique?graphique=" + graphNumber;
    }

    // Supposons que $StatistiqueParLivre est votre tableau d'objets principal
    var StatistiqueParLivre = <?php echo json_encode($StatistiqueParLivre); ?>;

    var $StatistiqueParAnnee = <?php echo json_encode($StatistiqueParAnnee); ?>;

    var StatistiqueParCom = <?php echo json_encode($StatistiqueParCom); ?>;

    var titres1 = StatistiqueParLivre.map(function (item) {
        return item.titre;
    });

    var nbEmprunts1 = StatistiqueParLivre.map(function (item) {
        return item.NbEmprunt;
    });

    var titres2 = $StatistiqueParAnnee.map(function (item) {
        return item.ANNEE;
    });

    var nbEmprunts2 = $StatistiqueParAnnee.map(function (item) {
        return item.NbEmprunt;
    });

    var titres3 = StatistiqueParCom.map(function (item) {
        return item.titre;
    });

    var nbEmprunts3 = StatistiqueParCom.map(function (item) {
        return item.NbCom;
    });

    var ctx1 = document.getElementById('myChart').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: titres1,
            datasets: [{
                label: 'Nombre d\'emprunts',
                data: nbEmprunts1,
                backgroundColor: 'rgb(37,128,199,0.2)',
                borderColor: 'rgb(37,128,199,0.2)',
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

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: titres2,
            datasets: [{
                label: 'Nombre d\'emprunts',
                data: nbEmprunts2,
                backgroundColor: 'rgba(236,8,8,0.2)',
                borderColor: 'rgba(114,6,6,0.2)',
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

    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: titres3,
            datasets: [{
                label: 'Nombre de commentaires',
                data: nbEmprunts3,
                backgroundColor: 'rgba(9,215,36,0.2)',
                borderColor: 'rgba(27,103,37,0.2)',
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
