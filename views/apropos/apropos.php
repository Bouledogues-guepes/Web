
<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="max-w-2xl mx-auto">

        <div id="default-carousel" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <span class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800">First Slide</span>
                    <img src="../../public/images/quisommesnous2.png" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="../../public/images/notrehistoire.png" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="../../public/images/nosservices.png" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            </div>
            <!-- Slider controls -->
            <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 white:bg-white-800/30 group-hover:bg-black/50 dark:group-hover:bg-black-800/60 group-focus:ring-4 group-focus:ring-white white:group-focus:ring-white-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-black-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
            </button>
            <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 white:bg-white-800/30 group-hover:bg-black/50 dark:group-hover:bg-black-800/60 group-focus:ring-4 group-focus:ring-white white:group-focus:ring-white-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-black-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
            </button>
        </div>

        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    </div>

    <!-- tab -->



    <div class="mb-4 border-b border-gray-200 dark:border-gray-700 content-center">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center justify-evenly" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">À propos de nous</button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Notre équipe</button>
            </li>
            <!--
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Contacts</button>
            </li>
            -->
        </ul>
    </div>
    <div id="myTabContent" class="content-center">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">Notre médiathèque a été fondée par <strong>deux frères passionnés</strong> par la <strong>, la culture et le partage des connaissances</strong> : Carl Benoit et Roger Benoit. <br> Depuis son ouverture, notre médiathèque est devenue <strong>Un lieu incontournable pour les amateurs de livres, de films, de musique et d'arts visuels</strong>.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <strong>Carl Benoit - Président et Cofondateur</strong><br>Carl Benoit est un homme de lettres passionné et visionnaire.<br> Né pour être un bibliophile, il a consacré sa vie à la promotion de la culture et de la littérature. Sa soif de connaissances l'a conduit à voyager à travers le monde, à explorer les bibliothèques les plus reculées et à dénicher des trésors littéraires.<br> Son engagement envers la préservation du patrimoine culturel est inébranlable, et il a su transformer sa passion en une institution qui enrichit la vie de la communauté.<br> Carl est connu pour sa sagesse, son sens de l'humour et sa capacité à inspirer les autres par sa profonde compréhension des mots et des idées.<br><br>
                <strong>Roger Benoit - Cofondateur</strong><br> Roger Benoit, le frère de Carl, est l'âme chaleureuse et bienveillante de la médiathèque.<br> Sa passion réside dans la création d'un espace accueillant et inclusif où chacun se sent chez lui. Il est un raconteur d'histoires né, capable de captiver les visiteurs de tous âges avec des contes et des anecdotes fascinants.<br> Roger est également un artiste talentueux, et ses œuvres d'art originales ornent les murs de la médiathèque, ajoutant une touche unique à l'atmosphère du lieu.<br> Sa gentillesse et son désir de partager sa passion pour la culture et l'art sont contagieux, ce qui fait de lui une figure appréciée au sein de la communauté.
            </p>
        </div>
        <!--
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
        </div>
        -->
    </div>

</div>
