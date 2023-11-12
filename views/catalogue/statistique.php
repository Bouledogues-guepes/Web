<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

<?php
$tabNumero=[1,2,3,4];

if(isset($_GET["graphique"])) {

    $numero=strip_tags(htmlspecialchars($_GET["graphique"]));


    if(in_array($_GET["graphique"], $tabNumero))
    {
        $numero = $_GET["graphique"];

    }
    else
    {
        $numero=1;
    }
}
else
{
    $numero=1;
}

function plusmoins($numero)
{
    if($numero==1)
        {
            echo '<div class="flex justify-between mb-5">
              <button disabled class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100 opacity-50" title="Graphique précedent">➖</button>
              <a href="/statistique?graphique=' . ($numero + 1) . '" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100" title="Graphique suivant">➕</a>
          </div>';

        }
    elseif($numero==max($tabNumero=[1,2,3,4]))
    {
                    echo '<div class="flex justify-between mb-5">
              <a href="/statistique?graphique=' . ($numero - 1) . '" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100 "title="Graphique précedent" >➖ </a>
              <button disabled class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100 opacity-50" title="Graphique suivant" >➕</button>
          </div>';
    }
    else
    {
                            echo '<div class="flex justify-between mb-5">
               
              <a href="/statistique?graphique=' . ($numero - 1) . '" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100" title="Graphique précedent">➖ </a>
              
              <a href="/statistique?graphique=' . ($numero + 1) . '" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full w-100 h-100" title="Graphique suivant">➕</a>
          </div>';
    }
}
function div($nb)
{
    echo '            <div class="bg-white border-2 border-black rounded-lg p-4">
                <canvas id="myChart'.$nb.'" onclick="redirectToGraph('.$nb.')"></canvas>
            </div>';
}

    if($numero==1)

    {
        ?>
        <div class="flex flex-wrap w-full gap-4 mt-5">

            <!-- Graphique principal -->
            <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">
                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <p class="text-center font-bold text-2xl">Les 10 Ressources les plus empruntés</p>
                    <br>
                    <canvas id="myChart1"></canvas>
                </div>
            </div>

            <!-- Div contenant les deux nouvelles divs -->
            <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">

            <?php

            echo div(2).div(3).div(4);

            plusmoins($numero)?>


            </div>

        </div>
        <?php
    }
    if($numero==2)
    {
    ?>

        <div class="flex flex-wrap w-full gap-4 mt-5">

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

            <?php

            echo div(3).div(4).div(1);

            plusmoins($numero)?>
        </div>

    </div>
    <?php
    }

    if($numero==3) {

    ?>

        <div class="flex flex-wrap w-full gap-4 mt-5">

            <!-- Graphique principal -->
            <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">
                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <p class="text-center font-bold text-2xl">Les 6 Ressources avec le plus de commentaires</p>
                    <br>
                    <canvas id="myChart3"></canvas>
                </div>
            </div>

            <!-- Div contenant les deux nouvelles divs -->
            <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">

                <?php

                echo div(4).div(1).div(2);

                plusmoins($numero)?>
            </div>

        </div>
    <?php
    }
if($numero==4) {

    ?>

    <div class="flex flex-wrap w-full gap-4 mt-5">

        <!-- Graphique principal -->
        <div class="w-full md:w-4/5 lg:w-3/4 xl:w-2/3 relative">
            <div class="bg-white border-2 border-black rounded-lg p-4">
                <p class="text-center font-bold text-2xl">Les ressources les mieux notés</p>
                <br>
                <canvas id="myChart4"></canvas>
            </div>
        </div>

        <!-- Div contenant les deux nouvelles divs -->
        <div class="w-full md:w-1/5 lg:w-1/4 xl:w-1/5 flex flex-col gap-4">
            <?php

            echo div(1).div(2).div(3);

            plusmoins($numero)?>
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

    var StatistiqueParMoyenne= <?php echo json_encode($StatistiqueParMoyenne); ?>;


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

    var titres4 = StatistiqueParMoyenne.map(function (item) {
        return item.titre;
    });

    var nbEmprunts4 = StatistiqueParMoyenne.map(function (item) {
        return item.moyenne;
    });


    var ctx1 = document.getElementById('myChart1').getContext('2d');
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

    var ctx4 = document.getElementById('myChart4').getContext('2d');
    var myChart4 = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: titres4,
            datasets: [{
                label: 'Note moyenne',
                data: nbEmprunts4,
                backgroundColor: 'rgba(246,212,4,0.2)',
                borderColor: 'rgba(161,142,16,0.2)',
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

    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth' // Ajoute une animation de défilement fluide
        });
    }

    // Appeler la fonction au chargement de la page
    window.onload = function() {
        scrollToBottom();
    };
</script>

<?php



//$dataStatistiqueParLivre = json_decode(json_encode($StatistiqueParLivre), true);
//print_r($dataStatistiqueParLivre);
//
//
//$dataStatistiqueParAnnee = json_decode(json_encode($StatistiqueParAnnee), true);
//print_r($dataStatistiqueParAnnee);
//
//
//$dataStatistiqueParCom = json_decode(json_encode($StatistiqueParCom), true);
//print_r($dataStatistiqueParCom);
//
//
//$dataStatistiqueParMoyenne = json_decode(json_encode($StatistiqueParMoyenne), true);
//print_r($dataStatistiqueParMoyenne);

?>
