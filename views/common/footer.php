<!-- Pied de page -->
<footer class="bg-[#15171A] text-center py-4">
    <p class="text-white">
        © 2023 Médiathèque. Tous droits réservés.

        <?php

        if(\utils\SessionHelpers::isAdmin())
            {
                ?>-<a href="/api" class="text-white hover:underline">Accès développeur</a><?php
            }?>


    </p>
</footer>
</body>

</html>