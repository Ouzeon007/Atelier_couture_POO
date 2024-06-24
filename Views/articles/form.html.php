<?php
use ond\AtelierCouturePoo\Core\Session;
if (Session::get('errors')) {
  $errors = Session::get('errors');
  // dd($errors);
}
?>
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md mb-10 dark:bg-gray-800">
  <h2 class="text-2xl font-bold mb-6 text-purple-900 dark:text-purple-400"">Nouvelle Article</h2>

  <form action=" <?= WEBROOT ?>" method="post">
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Libelle:</label>
      <input type="text" id="libelle" name="libelle"
        class="<?= add_classe_invalid('libelle') ?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400"
        placeholder="nom de l'article">
        <div class=" text-red-700 rounded relative  " role="alert">
        <strong class="font-bold "><?= $errors['libelle'] ?? "" ?></strong>
      </div>

    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">QteStock:</label>
      <input id="qte" type="text" name="qteStock"
        class="<?= add_classe_invalid('qteStock')?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400  "
        placeholder="QteStock">
      <div class=" text-red-700 rounded relative" role="alert">
        <strong class="font-bold "><?= $errors['qteStock'] ?? "" ?></strong>
      </div>

    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Prix:</label>
      <input id="prix" type="text" name="prixAppro"
        class="<?= add_classe_invalid('prixAppro') ?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400 "
        placeholder="Prix">
        <div class=" text-red-700 rounded relative " role="alert">
        <strong class="font-bold "><?= $errors['prixAppro'] ?? "" ?></strong>
      </div>

    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Type:</label>
      <select id="select" name="typeId"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400" >
        <option value="" disabled selected class="dark:text-gray-300">Choisissez un type</option>
        <?php foreach ($types as $type): ?>
          <option value="<?= $type["idType"] ?>" class="dark:text-gray-300"><?= $type["nomType"] ?></option>
        <?php endforeach ?>
      </select>
    </div>


    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300 ">Categorie:</label>
      <select id="select2" name="categorieId"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400" >
        <option value="" disabled selected class="dark:text-gray-300">Choisissez une categorie</option>
        <?php foreach ($categories as $categorie): ?>
          <option value="<?= $categorie["idCategorie"] ?>" class="dark:text-gray-300"><?= $categorie["nomCategorie"] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="text-center">
      <input type="hidden" name="controller" value="article">
      <input type="hidden" name="action" value="save-article">

      <button id="btn" type="submit"
        class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300">Soumettre</button>
    </div>
    </form>
</div>
<?php
    Session::remove('errors');
?>