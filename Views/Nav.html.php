<div
    class=" font-bold  w-full bg-purple-200  text-purple-950 text-center  dark:bg-gradient-to-b from-purple-400 from-30% to-purple-300">
    L'art de la couture, l'amour du détail! Votre style, notre savoir-faire.
</div>
<header
    class=" w-full lg:px-16 px-6 bg-white flex flex-wrap items-center lg:py-0 py-2 border-t-8 border-purple-100 shadow-md  dark:bg-gray-800 dark:border-purple-300">
    <div class="flex-1 flex justify-between items-center">
        <a href="#">
            <img class="-mb-6 w-36 -mt-6" src="img/1-removebg-preview.png" alt="">
            <!-- <img width="75" height="36" src="img/sewing-workshop.svg" alt="Atelier de couture"> -->
        </a>
    </div>

    <div class="hidden lg:flex lg:items-center lg:w-auto w-full h-20" id="menu">
        <nav>
            <ul class="lg:flex items-center justify-between text-base text-gray-700 pt-4 lg:pt-0 dark:text-gray-400">
                <li><a class="<?= add_classe_hidden_lien("Admin") ?> lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300"
                        href="<?= WEBROOT ?>/?controller=article&action=liste-article&page=0">Article</a></li>
                <li><a class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300"
                        href="<?= WEBROOT ?>/?controller=type&action=liste-type">Type</a></li>
                <li><a class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300"
                        href="<?= WEBROOT ?>/?controller=categorie&action=liste-categorie">Categorie</a></li>
                <li><a class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300 lg:mb-0 mb-2"
                        href="<?= WEBROOT ?>/?controller=appro&action=liste-appro&page=0">Approvisionnement</a></li>
                <li><a class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300 lg:mb-0 mb-2"
                        href="<?= WEBROOT ?>/?controller=production&action=liste-production&page=0">Production</a></li>
                <li><a class="lg:p-4 py-3 px-0 block border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-colors duration-300 lg:mb-0 mb-2"
                        href="<?= WEBROOT ?>/?controller=vente&action=liste-vente&page=0">Vente</a></li>
                <li><a class="rounded-md font-bold bg-purple-500 hover:bg-purple-600 focus:ring-4 ring-purple-300 shadow-lg px-4 py-2 text-white transition-transform transform"
                        href="<?= WEBROOT ?>/?controller=securite&action=logout">Déconnexion</a>
            </ul>
        </nav>

    </div>
</header>