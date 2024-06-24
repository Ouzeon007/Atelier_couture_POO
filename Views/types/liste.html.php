<?php
use ond\AtelierCouturePoo\Core\Session;
if (Session::get('errors')) {
  $errors = Session::get('errors');

}

?>
<div class="flex flex-col md:flex-row justify-center  md:space-y-0  mt-20">

  <div class="w-full max-w-4xl mx-6">
    <table
      class=" w-full  overflow-x-auto shadow-xl sm:rounded-lg text-sm text-left rtl:text-right text-gray-500  dark:text-gray-400 border-b-8 border-purple-500 ">
      <caption
        class="p-8 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        Tableau Types

      </caption>
      <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">ID</th>
          <th scope="col" class="px-6 py-3">Type</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($types as $type): ?>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              <?= $type['nomType'] ?>
            </th>
            <td class="px-6 py-4">
              <a class="text-purple-600  dark:text-purple-400 hover:text-purple-800 "
                href="<?= WEBROOT ?>/?controller=type&action=update-type&id=<?= $type['idType'] ?>">Modifier</a>
              <a class="text-red-400 hover:text-red-900 ml-4"
                href="<?= WEBROOT ?>/?controller=type&action=delete-type&id=<?= $type['idType'] ?>"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
            </td>

          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>


  <div class="w-full mr-4 md:w-1/3   bg-gray-200 p-6 rounded-lg dark:bg-gray-600 ">
    <h2 class="text-2xl font-bold mb-6 mt-5 text-purple-900  dark:text-purple-400">Nouveaux Type</h2>

    <form action="<?= WEBROOT ?>" method="post">
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2  dark:text-gray-200">Nom:</label>
        <input type="text" id="libelle" name="nomType"
          class="<?= add_classe_invalid('nomType') ?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 dark:text-gray-400"
          placeholder="nom du type">

        <div class=" text-red-700 rounded relative " role="alert">
          <strong class="font-bold "><?= $errors['nomType'] ?? "" ?></strong>
        </div>
      </div>

      <div class="text-center">
        <input type="hidden" name="action" value="save-type">
        <input type="hidden" name="controller" value="type">
        <button id="btn" type="submit"
          class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300">AJOUTER</button>
      </div>

    </form>
  </div>

</div>
<?php
Session::remove('errors');
?>