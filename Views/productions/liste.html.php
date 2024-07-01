<div>

    <form method="GET" action="<?= WEBROOT ?>" class="mb-4 mt-10">
        <div class="flex space-x-6 justify-center">
            <div class="w-1/5">
                <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Date:</label>
                <input type="date" name="date" value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>"
                    class="w-full px-3 py-2 border-b border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400">
            </div>
            <div class="w-1/5">
                <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Article:</label>
                <select id="select" name="articleId"
                    class="w-full px-3 py-2 border-b border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400">
                    <option value="" disabled selected class="dark:text-gray-300">Choisissez un type</option>
                    <?php foreach ($articles as $article): ?>
                        <option value="<?= $article["id"] ?>" <?= isset($_GET['articleId']) && $_GET['articleId'] == $article["id"] ? 'selected' : '' ?> class="dark:text-gray-300">
                            <?= $article["libelle"] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mt-8">
                <input type="hidden" name="controller" value="production">
                <input type="hidden" name="action" value="filter-production">
                <input type="hidden" name="page" value="0">

                <button type="submit"
                    class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Filtrer</button>
            </div>
        </div>
    </form>

    <table
        class=" bg-opacity-0 w-full max-w-4xl mx-auto overflow-x-auto shadow-xl sm:rounded-lg text-sm text-left rtl:text-right text-gray-500 mt-8 dark:text-gray-400 border-b-8 border-purple-500 ">
        <caption
            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800 rounded-t-lg">
            Tableau Articles
            <a class="rounded-md font-bold bg-purple-500 hover:bg-purple-600 focus:ring-4 ring-purple-300 shadow-sm px-2 py-2 text-white focus:outline-2 outline-transparent outline-offset-4 float-end active:bg-purple-600/90 ml-3"
                href="<?= WEBROOT ?>/?controller=production&action=form-production">
                <div class="flex"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg> Production </div>
            </a>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">Montant</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reponse["data"] as $production):
                $date = new \DateTime($production['date']);
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= $date->format('d-m-Y') ?>
                    </th>
                    <td class="px-6 py-4">
                        <?= $production['montant'] ?>
                    </td>

                    <td class="px-6 py-4">

                        <a class="text-purple-600 dark:text-purple-400 hover:text-purple-800 "
                            href="<?= WEBROOT ?>/?controller=production&action=detail-production&id=<?= $production['idProd'] ?>">Details</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="flex items-center -space-x-px h-10 text-base mt-5  justify-center">
            <li>
                <a href="<?= WEBROOT ?>/?date=<?php if (isset($_GET['date']))
                      echo $_GET['date'] ?><?php if (isset($_GET['articleId']))
                      echo "&articleId=" . $_GET['articleId'] ?>&controller=production&action=filter-production&page=<?php if ($currentPage > 0)
                      echo $currentPage - 1;
                  else
                      echo 0 ?>"
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
                    <a href="<?= WEBROOT ?>/?date=<?php if (isset($_GET['date']))
                          echo $_GET['date'] ?><?php if (isset($_GET['articleId']))
                          echo "&articleId=" . $_GET['articleId'] ?>&controller=production&action=filter-production&page=<?= $page ?>"
                        class=" <?php if ($page == $currentPage)
                            echo "bg-red-500 text-purple-900 dark:text-white dark:bg-purple-500" ?> <?= ($page == $reponse["pages"]) ?> flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $page + 1 ?></a>
                </li>
            <?php endfor; ?>
            <li>
                <a href="<?= WEBROOT ?>/?date=<?php if (isset($_GET['date']))
                      echo $_GET['date'] ?><?php if (isset($_GET['articleId']))
                      echo "&articleId=" . $_GET['articleId'] ?>&controller=production&action=filter-production&page=<?php if ($currentPage < $reponse["pages"] - 1)
                      echo $currentPage + 1;
                  else
                      echo $_GET["page"] ?>"
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