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
                        <option value="<?= $article["id"] ?>" class="dark:text-gray-300"><?= $article["libelle"] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mt-8">
                <input type="hidden" name="controller" value="appro">
                <input type="hidden" name="action" value="filter-appro">
                <button type="submit"
                    class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Filtrer</button>
            </div>
        </div>
    </form>

    <table
        class=" bg-opacity-0 w-full max-w-4xl mx-auto overflow-x-auto shadow-xl sm:rounded-lg text-sm text-left rtl:text-right text-gray-500 mt-20 dark:text-gray-400 border-b-8 border-purple-500 ">
        <caption
            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800 rounded-t-lg">
            Tableau Articles
            <a class="rounded-md font-bold bg-purple-500 hover:bg-purple-600 focus:ring-4 ring-purple-300 shadow-sm px-2 py-2 text-white focus:outline-2 outline-transparent outline-offset-4 float-end active:bg-purple-600/90 ml-3"
                href="<?= WEBROOT ?>/?controller=production&action=form-production"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg> Production</a>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Date</th>
                <th scope="col" class="px-6 py-3">Montant</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productions as $production):
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
                            href="<?= WEBROOT ?>/?controller=pr$production&action=update-article&id=<?= $production['id'] ?>">Modifier</a>
                        <a class="text-red-400 hover:text-red-900 ml-4"
                            href="<?= WEBROOT ?>/?controller=pr$production&action=delete-article&id=<?= $production['id'] ?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>