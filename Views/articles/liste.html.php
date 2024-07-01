<div>
    <table
        class=" bg-opacity-0 w-full max-w-6xl mx-auto overflow-x-auto shadow-xl sm:rounded-lg text-sm text-left rtl:text-right text-gray-500 mt-20 dark:text-gray-400 border-b-8 border-purple-500 ">
        <caption
            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800 rounded-t-lg">
            Tableau Articles
            <a class="rounded-md font-bold bg-purple-500 hover:bg-purple-600 focus:ring-4 ring-purple-300 shadow-sm px-2 py-2 text-white focus:outline-2 outline-transparent outline-offset-4 float-end active:bg-purple-600/90 ml-3"
                href="<?= WEBROOT ?>/?controller=article&action=form-article">
                <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg> Article </div>
            </a>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Libelle</th>
                <th scope="col" class="px-6 py-3">Qte Stock</th>
                <th scope="col" class="px-6 py-3">Prix</th>
                <th scope="col" class="px-6 py-3">Categorie</th>
                <th scope="col" class="px-6 py-3">Type</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reponse["data"] as $article): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $article['libelle'] ?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $article['qteStock'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $article['prixAppro'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $article['nomCategorie'] ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= $article['nomType'] ?>
                    </td>
                    <td class="px-6 py-4">

                        <a class="text-purple-600 dark:text-purple-400 hover:text-purple-800 "
                            href="<?= WEBROOT ?>/?controller=article&action=update-article&id=<?= $article['id'] ?>">Modifier</a>
                        <a class="text-red-400 hover:text-red-900 ml-4"
                            href="<?= WEBROOT ?>/?controller=article&action=delete-article&id=<?= $article['id'] ?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>


    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-10 text-base mt-5  justify-center">
            <li>
                <a href="#"
                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                </a>
            </li>
            <?php for ($page = 0; $page < $reponse["pages"]; $page++): ?>
                <li>
                    <a href="<?= WEBROOT ?>/?controller=article&action=liste-article&page=<?= $page ?>"
                        class=" <?php if ($page == $currentPage)
                            echo "bg-red-500 text-purple-900 dark:text-white dark:bg-purple-500" ?> <?= ($page == $reponse["pages"]) ?> flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $page + 1 ?></a>
                </li>
            <?php endfor; ?>
            <li>
                <a href="#"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            </li>
        </ul>
    </nav>

</div>