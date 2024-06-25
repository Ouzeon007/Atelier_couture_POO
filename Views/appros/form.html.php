<?php
use ond\AtelierCouturePoo\Core\Session;

if (Session::get('errors')) {
  $errors = Session::get('errors');
  // dd($errors);
}
?>

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md mb-10 dark:bg-gray-800">
  <h2 class="text-2xl font-bold mb-6 text-purple-900 dark:text-purple-400">Nouvelle Approvisionnement</h2>
  <a href="<?= WEBROOT ?>/?controller=appro&action=vider-panier"
      class="float-end -mt-14 inline-flex items-center px-4 py-2 bg-red-600 transition ease-in-out delay-75 hover:bg-red-700 text-white text-sm font-medium rounded-md hover:-translate-y-1 hover:scale-110">
      <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" class="h-5 w-5 mr-2"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
          stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>
      Vider
    </a>
  <form action="<?= WEBROOT ?>" method="post">
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Fournisseur:</label>
      <select id="select" name="fournisseurId"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400">
        <option value="" disabled selected class="dark:text-gray-300">Choisissez un type</option>
        <?php foreach ($fournisseurs as $fournisseur): ?>
          <option <?php if(Session::get('panier')!=false && Session::get('panier')->fournisseur==$fournisseur["idFour"]) echo "selected" ?> value="<?= $fournisseur["idFour"] ?>" class="dark:text-gray-300"><?= $fournisseur["nomFour"] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>

    <div class="mb-4 flex space-x-6">
      <div class="w-4/5">
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

      <div class="w-2/4">
        <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Qte Appro:</label>
        <input id="prix" type="text" name="qteAppro"
          class="<?= add_classe_invalid('prixAppro') ?> w-full px-3 py-2 border-b border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400"
          placeholder="Prix">
        <div class="text-red-700 rounded relative" role="alert">
          <strong class="font-bold"><?= $errors['prixAppro'] ?? "" ?></strong>
        </div>
      </div>
      <div class="flex items-end">
      <input type="hidden" name="controller" value="appro">
      <input type="hidden" name="action" value="add-appro">
        <button type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
          Add
        </button>
      </div>
    </div>
  </form>

  <div
    class="overflow-x-auto whitespace-nowrap py-4 scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-purple-300">
    <div class="flex space-x-4">
      <!-- Example item -->
      <?php
      if (Session::get("panier")!=false):
       foreach (Session::get('panier')->articles as $article): ?>
      <div class="min-w-max bg-white p-7 rounded-lg shadow-md shadow-purple-500/50 dark:bg-gray-800">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?= $article["libelle"] ?></h3>
        <p class="text-gray-500 dark:text-gray-300">Qte Appro: <?= $article["qteAppro"] ?></p>
        <p class="text-gray-500 dark:text-gray-300">Prix: <?= $article["prixAppro"] ?></p>
        <p class="text-gray-500 dark:text-gray-300">Montant: <?= $article["montantArticle"] ?></p>
      </div>
      <?php endforeach ?>
      <?php endif ?>
      <!-- Add more items as needed -->
    </div>
  </div>

  <!-- Section for displaying total -->
  <div class="mt-6 text-right">
    <p class="text-gray-700 dark:text-gray-300 font-medium">Total du panier: <span
        class="text-purple-900 dark:text-purple-400 font-bold"><?php if(Session::get('panier')!=false) echo Session::get('panier')->total;else echo 0?> FCFA</span></p>
  </div>
  <div class="text-center mt-4">

      <a href="<?= WEBROOT ?>/?controller=appro&action=save-appro" id="btn" type="submit"
        class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300">Soumettre</a>
    </div>
    
</div>
<?php
Session::remove('errors');
?>