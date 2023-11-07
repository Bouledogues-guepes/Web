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

                <div class="hidden bg-red-400 text-white font-bold py-2 px-4 rounded-full mt-2" id="errorDivTaille">
                    Le commentaire n'est pas assez grand. Merci de le modifier
                </div>


                <input type="hidden" name="idRessource" value="<?=$_POST["idRessource"]?>">
            </div>


            <div class="mb-4">
                <label for="rating">Note (de 1 à 5 étoiles)</label>
                <div class="rating">
                    <span class="star text-2xl" data-value="1" data-selected="true">☆</span>
                    <span class="star text-2xl" data-value="2">☆</span>
                    <span class="star text-2xl" data-value="3">☆</span>
                    <span class="star text-2xl" data-value="4">☆</span>
                    <span class="star text-2xl" data-value="5">☆</span>
                </div>
                <input id="rating" name="rating" type="hidden" required>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-4 px-6 rounded-full">Soumettre</button>
            </div>
        </form>

    </div>
</div>

<style>
    .star {
        color: black; /*non sélectionnées*/
    }

    .selected {
        color: gold; /* sélectionnées */
    }
</style>


<script>
    const stars = document.querySelectorAll(".star");
    const ratingInput = document.getElementById("rating");

    stars.forEach(star => {
        star.addEventListener("click", () => {
            const value = star.getAttribute("data-value");
            ratingInput.value = value;
            updateStars(value);
        });
    });
    const selectedStar = document.querySelector(".star[data-selected='true']");
    if (selectedStar) {
        const value = selectedStar.getAttribute("data-value");
        updateStars(value);
    }

    function updateStars(value) {
        stars.forEach(star => {
            if (star.getAttribute("data-value") <= value) {
                star.textContent = "★";
                star.classList.add("selected");
            } else {
                star.textContent = "★";
                star.classList.remove("selected");
            }
        });
    }

    //Liste mots interdits
    const motInterdits = [/à chier/i, /à couilles rabattues/i, /à deux trois poils de cul/i, /à la con/i, /à la mords-moi/i, /à la mords-moi-le-nœud/i,
        /à la roule-moi les couilles dans la laitue/i, /à un poil de cul/i, /agacer le sous-préfet/i, /alibofi/i, /aller aux putes/i, /aller chier dans sa caisse/i,
        /aller libérer Mandela/i, /aller niquer sa mère/i, /aller se faire empapaouter/i, /aller se faire enculer/i, /aller se faire foutre/i, /aller se faire mettre/i,
        /aller voir la veuve poignet/i, /aller voir madame cinq doigts/i, /allez vous faire foutre/i, /archicon/i, /archifoutre/i, /arriver comme le marquis de Couille-Verte/i,
        /asphalteuse/i, /astiquer/i, /attaï/i, /avaleuse de sabre/i, /avoir de la chatte/i, /avoir de la merde dans les yeux/i, /avoir de la moule/i, /avoir des couilles/i,
        /avoir des couilles au cul/i, /avoir du cul/i, /avoir du poil au bon endroit/i, /avoir du poil au cul/i, /avoir l’air con/i, /avoir la gaule/i, /avoir la gueule dans le cul/i,
        /avoir la tête dans le cul/i, /avoir le cul bordé de médailles/i, /avoir le cul bordé de nouilles/i, /avoir le feu au cul/i, /avoir le papier qui colle aux bonbons/i,
        /avoir le trou du cul en chou-fleur/i, /avoir les couilles/i, /avoir les nerfs/i, /avoir les rideaux qui collent aux fenêtres/i, /avoir les yeux en couilles d’hirondelle/i,
        /avoir les yeux en trou de bite/i, /avoir les yeux en trou de pine/i, /avoir plein le cul/i, /avoir un balai dans le cul/i, /avoir une plume dans le cul/i, /BAB/i,
        /bagouse/i, /baisable/i, /baise/i, /baisé/i, /baiser/i, /baiser comme des lapins/i, /baiser comme un lapin/i, /baiser Fanny/i, /baiser le cul de la Fanny/i, /baiseur/i,
        /balancer la purée/i, /balancer la sauce/i, /balayette/i, /balek/i, /banane/i, /bande-mou/i, /bander/i, /bander comme un âne/i, /bander comme un cerf/i, /bander comme un taureau/i,
        /bander comme un Turc/i, /bangala/i, /baptême/i, /bar à putes/i, /bat/i, /bengala/i, /benzer/i, /berlingue/i, /beuteu/i, /biatch/i, /bibite/i, /biétaze/i,
        /biffle/i, /biffler/i, /bifle/i, /bifler/i, /bitch/i, /bite/i, /bite à cul/i, /bite au cirage/i, /bitembois/i, /Bitembois/i, /bivouaquer dans la crevasse/i, /blanc comme un cul/i,
        /blanc comme une merde de laitier/i, /BLC/i, /bombe atomique/i, /bon coup/i, /bon sang de merde/i, /bonnasse/i, /bonne/i, /bordel/i, /bordel à cul/i, /bordel à cul de pompe à merde/i,
        /bordel à cul pompe à merde/i, /bordel à culsbordel à queue/i, /bordel de merde/i, /bosnioule/i, /botte/i, /botter/i, /botter le cul/i, /boucaque/i, /bouche à pipe/i,
        /boucle-la/i, /boudiner/i, /bouègre/i, /bouffable/i, /bouffer la chatte/i, /bouffer le cul/i, /bougnoul/i, /bougnoule/i, /bougnoulisation/i, /bougnouliser/i, /boukak/i,
        /bouliche/i, /bouloir/i, /bounioul/i, /bounioule/i, /bourrer/i, /bourriquer/i, /boyau cullier/i, /branle-couille/i, /branlée/i, /branler/i, /branler le mammouth/i,
        /branlette/i, /branlette espagnole/i, /branlette intellectuelle/i, /branlette thaïlandaise/i, /branleur/i, /branleuse/i, /branlo/i, /branlotter/i, /brêle/i, /brise-burnes/i,
        /briser les couilles/i, /briser les noix/i, /broutage/i, /broute-minou/i, /brouter/i, /brouter le gazon/i, /brouter les couilles/i, /brouteur/i, /brouteuse/i, /burne/i,
        /bz/i, /ça m’en touche une sans faire bouger l’autre/i, /cagasse/i, /cagoince/i, /cahba/i, /câliboire/i, /calice/i, /câlice/i, /câlisse/i, /câlissement/i, /câlisser/i,
        /caner/i, /carrer dans l’oignon/i, /carrosserie/i, /carte de France/i, /cartouche/i, /casse-bonbon/i, /casse-couille/i, /casse-couilles/i, /casse-burette/i, /casser la gueule/i,
        /casser le pot/i, /casser les boules/i, /casser les burnes/i, /casser les couilles/i, /casser les noix/i, /cela m’en touche une sans faire bouger l’autre/i, /céoène/i,
        /cerise/i, /c’est de la couille de loup/i, /chacun sa merde/i, /chagasse/i, /chagatte/i, /changement d’huile/i, /charmouta/i, /chat/i, /chat-bite/i, /chatte/i, /chaude-pisse/i,
        /cheb/i, /cherche-merde/i, /chercher la merde/i, /chiabrena/i, /chiant/i, /chiant comme la Lune/i, /chiasse/i, /chiasser/i, /chiatique/i, /chibre/i,
        /chie dur, chie mou, mais chie dans le trou/i, /chiée/i, /chiennasse/i, /chienne/i, /chiennerie/i, /chier/i, /chier à la gueule/i, /chier comme tout le monde/i,
        /chier dans la tête/i, /chier dans le cassetin aux apostrophes/i, /hier dans le ventilo/i, /chier dans les bottes/i, /chier dans son froc/i, /chier pour la marine/i,
        /chier sur la gueule/i, /chier une pendule/i, /chier une pendule avec un ressort en bois/i, /chierie/i, /chieur/i, /chieuse/i, /chiotte/i, /chiottes/i, /chite/i, /chitte/i,
        /chocolat/i, /choper/i, /choune/i, /christ/i, /ciboire/i, /cirer le pingouin/i, /claque merde/i, /claque-merde/i, /clille/i, /comme papa dans maman/i,
        /comme un chien fout sa merde/i, /comme une envie de chier/i, /con/i, /con comme un balai/i, /con comme un gland/i, /con comme une bite/i, /conaud/i, /conchier/i,
        /connard/i, /connarde/i, /connasse/i, /connaud/i, /conne/i, /conneau/i, /connerie/i, /contrecrisser/i, /copain de baise/i, /copine de baise/i, /coquillard/i,
        /couille/i, /couille de loup/i, /couille de mammouth/i, /couille molle/i, /couillemollerie/i, /couilles au poteau/i, /couillu/i, /coup de pute/i, /couter la peau des couilles/i,
        /coûter la peau des couilles/i, /couter la peau du cul/i, /coûter la peau du cul/i, /coûter une couille/i, /cracher à la gueule/i, /cramouille/i, /craquer son slip/i,
        /craquer son string/i, /cravacher le pur-sang/i, /crisse/i, /crissement/i, /crosse/i, /crosser/i, /cruchasse/i, /cul/i, /culasse/i, /culbutage/i, /culbuter/i,
        /culer/i, /culeter/i, /culeur/i, /dans ton cul/i, /de la merde/i, /de marde/i, /de merde/i, /de mes couilles/i, /de mes deux/i, /de mes fesses/i, /de mon cul/i, /de mon vier/i,
        /débagouler/i, /débander/i, /déboiter/i, /débougnouliser/i, /débroussailler la tranchée/i, /décâcrisser/i, /décâlicer/i, /décalisser/i, /décâlisser/i, /décharge/i,
        /décharger/i, /décolisser/i, /déconnage/i, /déconner/i, /décrisser/i, /décrotter/i, /déculer/i, /défoncé/i, /défoncer/i, /défonceur/i, /défourailler/i, /dégager/i,
        /déglinguer/i, /dégorger le poireau/i, /dégueulassement/i, /démerde yourself/i, /demi-molle/i, /démonter/i, /dépucelable/i, /dépucelage/i, /dépuceler/i,
        /dérouler du câble/i, /des couilles/i, /descendre à la cave/i, /désengorger/i, /diarrhée/i, /Dieu me pignole/i, /Dieu me tripote/i, /dilater/i, /djoc/i, /DMC/i, /does/i,
        /doeser/i, /donne à manger à un cochon, il va chier sur ton perron/i, /drisser/i, /drouille/i, /DTC/i, /ducon/i, /duconnot/i, /dugland/i, /éburné/i, /écouillé/i, /emboîter/i,
        /emmanché/i, /emmancher/i, /emmerdé/i, /emmerder/i, /emmerder à pied et à cheval/i, /emmerder à pied, à cheval et en voiture/i, /emmerdeur/i, /emmerdeuse/i, /emmiellé/i,
        /empapaoutage/i, /en avoir à battre/i, /en avoir deux/i, /en avoir plein le cul/i, /en avoir plein les couilles/i, /en avoir ras les burnes/i, /en avoir une sacrée paire/i,
        /en chier/i, /en chier comme un Polonais/i, /en chier comme un Russe/i, /en foutre son billet/i, /en tabarnac/i, /en tabarnak/i, /enconnade/i, /enconner/i, /encuguler/i,
        /enculable/i, /enculade/i, /enculade de mouche/i, /enculagailler/i, /enculage/i, /enculage de mouche/i, /enculage de mouches/i, /enculailler/i, /enculailleur/i, /enculatoire/i,
        /enculé/i, /enculé de ta mère/i, /enculé de ta race/i, /enculement/i, /enculer/i, /enculer les mouches/i, /enculerie/i, /enculette/i, /enculeur/i, /enculeur de mouches/i,
        /enculeuse/i, /enculeuse de mouches/i, /enfant de chienne/i, /enfant de garce/i, /enfant de putain/i, /enfant de pute/i, /enfiler/i, /enfler/i, /enfoirage/i, /enfoiré/i,
        /enfoirée/i, /enfoirer/i, /enfourailler/i, /enfoutrer/i, /englander/i, /engrosser/i, /engueuler/i, /entre couilles/i, /entuber/i, /environ/i, /envoyer/i, /envoyer chier/i,
        /envoyer faire foutre/i, /envulver/i, /escalope/i, /esque/i, /estie/i, /et mon cul, c’est du poulet/i, /et ta connerie/i, /étrangler le borgne/i, /être chié/i,
        /être couillu/i, /être fini à la pisse/i, /être la fête/i, /être mou de la bite/i, /exploser/i, /exploser le terrier/i, /face de pet/i, /faciale/i, /faire chier/i,
        /faire chier la bite/i, /faire chier son monde/i, /faire chmir/i, /faire crapahuter le flemmard/i, /faire de la merde/i, /faire dégorger le poireau/i, /faire minette/i,
        /faire sa pute/i, /faire sprinter l’unijambiste/i, /fais du bien à Martin, il te chiera dans la main/i, /fan de putain/i, /fant de pute/i, /faux cul/i, /faux-cul/i,
        /fdp/i, /FDP/i, /ferme ta bouche/i, /ferme ta gueule/i, /fermer sa gueule/i, /fermer son claque merde/i, /fermer son claque-merde/i, /fesse/i, /fif/i, /fifi/i,
        /fille à pédés/i, /fille de pute/i, /film de boule/i, /film de boules/i, /fils de bâtard/i, /fils de chien/i, /fils de chienne/i, /fils de garce/i, /fils de putain/i,
        /fils de pute/i, /fils-de-puterie/i, /fils de ta race/i, /filsdeputerie/i, /fion/i, /fiotte/i, /fister/i, /foirade/i, /fouf/i, /foufoune/i, /foufounette/i,
        /fouille-merde/i, /fouille-au-train/i, /foune/i, /fourbir/i, /fourrer/i, /fout-la-merde/i, /foutage de gueule/i, /fouteur/i, /fouteur de merde/i, /fouteuse/i,
        /fouteuse de merde/i, /foutoir/i, /foutre/i, /foutre bas/i, /foutre en l’air/i, /foutre la merde/i, /foutre la paix/i, /foutre la pâtée/i, /foutre le bordel/i,
        /foutre le camp/i, /foutre son billet/i, /foutre sur la gueule/i, /foutriquer/i, /fuck/i, /fuck me boots/i, /fucker/i, /garage à bite/i, /garage à bites/i,
        /gauchiasse/i, /GCUM/i, /gicler/i, /gland/i, /glaoui/i, /gniouf/i, /gnoul/i, /gnoule/i, /gougnote/i, /gougnoter/i, /gougnotte/i, /gourdin/i, /gousse/i, /goût de chiottes/i,
        /grande gueule/i, /grosso merdo/i, /imbaisable/i, /imbitabilité/i, /imbitable/i, /joual vert/i, /journalope/i, /journapute/i, /karba/i, /keh/i, /ken/i, /kopfertami/i,
        /la mettre/i, /lâcher la touffe/i, /laisser pisser le mérinos/i, /langue de pute/i, /l’avoir dans le cul/i, /le con de sa mère/i, /le con de ta mère/i, /lèche-cul/i,
        /lèche-couilles/i, /lèchecul/i, /lécher le cul/i, /les briser grave/i, /les briser menu/i, /les briser sévère/i, /libérer Mandela/i, /limage/i, /limer/i, /lopette/i,
        /lunette de chiotte/i, /machine à baiser/i, /main au cul/i, /manche à couilles/i, /mange-merde/i, /manger comme un chancre/i, /manger de la marde/i,
        /manger ses morts/i, /maquerellage/i, /marde/i, /marlouf/i, /mazouter le pingouin/i, /mé cago/i, /mercon/i, /merdam/i, /merdasse/i, /merde/i, /merde en tube/i, /merder/i,
        /merderie/i, /merdeuse/i, /merdeux/i, /merdia/i, /merdicité/i, /merdier/i, /merdogène/i, /mes couilles/i, /mes couilles le temps se brouille/i, /mettre dans la sauce/i,
        /mettre dans l’os/i, /mettre la misère/i, /mettre la quenelle dans le shaker/i, /mettre le nez de quelqu’un dans sa merde/i, /mettre ses couilles sur la table/i,
        /mettre sur la gueule/i, /MILF/i, /minou/i, /Mirza/i, /mon cul/i, /mon vier/i, /mon vier, Madame Olivier/i, /monté comme un âne/i, /motocultable/i, /motoculter/i,
        /mouche à merde/i, /moule à merde/i, /moule-bite/i, /mouron/i, /musarder/i, /naaien/i, /ne plus se sentir pisser/i, /ne rien branler/i, /n’en avoir rien à battre/i,
        /n’en avoir rien à branler/i, /n’en avoir rien à foutre/i, /néo chatte/i, /néo-chatte/i, /nique/i, /nique sa mère/i, /nique ta mère/i, /niquer/i, /niquer sa mère/i,
        /niquez votre mère/i, /ntm/i, /NTM/i, /nul à chier/i, /nulach/i, /nulach’/i, /oh hisse, enculé/i, /on s’encule/i, /oui ou merde/i, /ouvrir sa grande gueule/i, /pachole/i,
        /pak pak/i, /pak-pak/i, /pakos/i, /panier/i, /papier-cul/i, /parachuter un congolais/i, /parachuter un Sénégalais/i, /pare-choc/i, /pare-chocs/i,
        /parle à mon cul, ma tête est malade/i, /partir en couille/i, /pays-bas/i, /PD/i, /peau d’hareng/i, /peau de couille/i, /peau de fesse/i, /peau de zob/i, /peau du cul/i,
        /peauduc/i, /pédale/i, /pédé/i, /pédé comme un Grec/i, /pédoque/i, /pédoule/i, /peler/i, /pelle à merde/i, /pélot/i, /penser avec sa bite/i,
        /penser avec sa queue/i, /pépom/i, /personal branling/i, /pet sauce/i, /péter à la gueule/i, /péter dans la soie/i, /péter le cul/i, /péter les couilles/i,
        /péter les pruneaux/i, /petit crisse/i, /pine/i, /piner/i, /pineur/i, /pinocumettable/i, /pinocumettre/i, /pipe/i, /pipeuse/i, /pisse-au-lit/i, /pisser/i,
        /pisser à la raie/i, /pisser au cul/i, /pisser de la copie/i, /pisser sa côtelette/i, /pisseur/i, /plan cul/i, /planter le javelot dans la moquette/i, /plotte à cash/i,
        /plume/i, /pogne-cul/i, /poil/i, /pomme à l’huile/i, /pompe à merde/i, /pomper/i, /pompeur/i, /pompeuse/i, /opaul/i, /orc/i, /porter le pet/i, /poser ses couilles sur la table/i,
        /poser une bugne/i, /pougner/i, /pour les couilles du pape/i, /pourrir/i, /pousser le repas de la veille/i, /pousser une gueulante/i, /poutrer/i, /PQ/i, /PQR/i,
        /prendre en sandwich/i, /putain/i, /putain con/i, /putain de/i, /putain de bordel de merde/i, /putain de merde/i, /putain de moine/i, /putain de sa mère/i, /putain de sa race/i,
        /putain de ta race/i, /putalike/i, /putassier/i, /pute/i, /pute borgne/i, /pute de luxe/i, /queue/i, /queutard/i, /queutarde/i, /qu’il aille se faire foutre/i,
        /qu’ils aillent se faire foutre/i, /qu’on l’encule/i, /RAB/i, /raccrocher à la gueule/i, /radasse/i, /ramasse-merde/i, /ramoner/i, /ramoner le trou de balle/i, /ras-la-moule/i,
        /ras la touffe/i, /ras-le-bonbon/i, /ras le cul/i, /ras-les-fesses/i, /rase-trou/i, /ratisser le bunker/i, /raton/i, /récurer la marmite/i, /réempaffer/i, /réenculer/i,
        /refucker/i, /remuer la merde/i, /résidu de capote/i, /résidu de fausse couche/i, /retourne aux asperges/i, /plote/i, /rien à enculer/i, /rien à foutre/i, /riflard/i,
        /ripalou/i, /Ripalou/i, /rond de chiotte/i, /rondelle/i, /roubignole/i, /roupette/i, /s’astiquer le chinois/i, /s’astiquer le manche/i, /s’effeuiller le baobab/i, /s’en balek/i,
        /s’en ballec/i, /s’en beurrer la raie/i, /sa mère/i, /sac à foutre/i, /sac à merde/i, /saint-chrême/i, /saint ciboire/i, /saint-ciboire/i, /saint-crême/i, /saint-sacrament/i,
        /saint-simonaque/i, /salaud/i, /salaude/i, /salle des fêtes/i, /salopard/i, /salope/i, /samater/i, /sans-couilles/i, /sarce/i, /s’archifoutre/i, /s’astiquer le poireau/i,
        /saute au paf/i, /saute-au-paf/i, /schleu/i, /schnek/i, /se barrer en couille/i, /se battre les couilles de/i, /se battre les couilles en neige/i, /se branler de/i,
        /se branler les couilles/i, /se câlisser/i, /se casser la gueule/i, /se casser le cul/i, /se casser le tronc/i, /se casser les couilles/i, /se cirer le manche/i, /se cogner/i,
        /se contrecrisser/i, /se contrefoutre/i, /se désenclaver la péninsule/i, /se doigter/i, /se faire enculer/i, /se faire la bite/i, /se faire pousser au cul/i, /se faire reluire/i,
        /se foutre comme de l’an quarante de/i, /se foutre de/i, /se foutre de la gueule de/i, /se geler le croupion/i, /se geler le fion/i, /se geler le tronc/i, /se geler les couilles/i,
        /se graisser le salami/i, /se les cailler/i, /se magner le cul/i, /se manger les couilles/i, /se polir le jonc/i, /se ronger le cul à la vinaigrette/i, /se saouler la gueule/i,
        /se sortir les doigts/i, /se sortir les doigts du cul/i, /se soulager les couilles/i, /se taper/i, /se taper une queue/i, /se tirer sur la nouille/i, /se tirer sur la tige/i,
        /se traîner la bite/i, /se vider les couilles/i, /s’en badigeonner les testicules avec le pinceau de l’indifférence/i, /s’en battre lec/i, /s’en battre/i, /s’en branler/i,
        /se branler comme de l’an quarante de/i, /s’en câlisser/i, /s’en cogner/i, /sent-la-pisse/i, /shitpost/i, /souchien/i, /souchienne/i, /sous-merde/i, /sphincter/i, /suce-médailles/i,
        /suce-boules/i, /sucer/i, /suceuse/i, /ta bouche/i, /ta bouche, bébé/i, /ta gueule/i, /ta mère/i, /ta mère la pute/i, /tabarnac/i, /tabarnak/i, /taboune/i, /tafiole/i, /tanquer/i,
        /tantouze/i, /taper/i, /taper dans la motte/i, /tapette/i, /tapettitude/i, /tapiole/i, /tarlouze/i, /tartissure/i, /taspé/i, /tassepé/i, /TBM/i, /tcholle/i, /techa/i,
        /téléphoner aux Congolais/i, /tepu/i, /tête de gland/i, /tête de nœud/i, /teub/i, /teube/i, /teuch/i, /teucha/i, /tg/i, /TG/i, /tirage/i, /tire-au-cul/i, /tirer/i,
        /tirer son coup/i, /tirer un coup/i, /touche à ton cul t’auras des verrues/i, /tournedos/i, /tourniquette/i, /tout de la gueule/i, /tranny/i, /tremper son biscuit/i,
        /treuf/i, /tringler/i, /troncher/i, /trou à bites/i, /trou de balle/i, /trou de cul/i, /trou du cul/i, /trou du cul du monde/i, /trouduc/i, /trouducune/i, /trouer le cul/i,
        /troufignoler/i, /troufignolerie/i, /troufignoliser/i, /troufignon/i, /trous à bites/i, /truie/i, /turluchon/i, /va chier/i, /va te faire enculer/i, /va te faire fiche/i,
        /va te faire foutre/i, /va te faire une soupe d’esques/i, /valseuse/i, /VDM/i, /vendre du piment/i, /vérole/i, /viarge/i, /vier/i, /vier d’âne/i, /vtff/i,
        /y avoir une couille dans le pâté/i, /y avoir une couille dans le potage/i, /y’a bon/i, /yeule/i, /youp/i, /youpin/i, /youpine/i, /youpiniser/i, /zapper sur manuel/i,
        /zboob/i, /zboube/i, /zemel/i, /zguègue/i];



document.querySelector("form").addEventListener("submit", function(event) {
    const comment = document.getElementById("comment").value.toLowerCase();

    const ContenirMotInterdits = motInterdits.some(regex => regex.test(comment));

    if (ContenirMotInterdits) {
        event.preventDefault();
        document.getElementById("errorDiv").classList.remove("hidden");
    }
    if (comment.length<20)
    {
        event.preventDefault();
        document.getElementById("errorDivTaille").classList.remove("hidden");
    }
});
</script>



























