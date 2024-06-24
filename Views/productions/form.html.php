<?php
use ond\AtelierCouturePoo\Core\Session;

if (Session::get('errors')) {
  $errors = Session::get('errors');
  // dd($errors);
}
?>

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md mb-10 dark:bg-gray-800">
  <h2 class="text-2xl font-bold mb-6 text-purple-900 dark:text-purple-400">Nouvelle Production</h2>

  <form action="<?= WEBROOT ?>" method="post">
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Observation:</label>
          <textarea name="observation" id="observation"
          
      class="w-full px-3 py-2 border-b border-gray-800 rounded-lg focus:outline-none shadow-md shadow-purple-500/50 focus:border-purple-500 dark:bg-gray-800 text-gray-400 mt-4"
      placeholder="Observation"><?php if(Session::get('panierProd')!=false) echo Session::get('panierProd')->observation;else echo ""?> </textarea>
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
        <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Qte Production:</label>
        <input id="prix" type="text" name="qteProd"
          class="<?= add_classe_invalid('prixAppro') ?> w-full px-3 py-2 border-b border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400"
          placeholder="Prix">
        <div class="text-red-700 rounded relative" role="alert">
          <strong class="font-bold"><?= $errors['prixAppro'] ?? "" ?></strong>
        </div>
      </div>
      <div class="flex items-end">
      <input type="hidden" name="controller" value="production">
      <input type="hidden" name="action" value="add-production">
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
      if (Session::get("panierProd")!=false):
       foreach (Session::get('panierProd')->articles as $article): ?>
      <div class="min-w-max bg-white p-7 rounded-lg shadow-md shadow-purple-500/50 dark:bg-gray-800">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?= $article["libelle"] ?></h3>
        <p class="text-gray-500 dark:text-gray-300">Qte Production: <?= $article["qteProd"] ?></p>
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
        class="text-purple-900 dark:text-purple-400 font-bold"><?php if(Session::get('panierProd')!=false) echo Session::get('panierProd')->total;else echo 0?> FCFA</span></p>
        
  </div>
  <div class="text-center mt-4">

      <a href="<?= WEBROOT ?>/?controller=production&action=save-production" id="btn" type="submit"
        class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300">Soumettre</a>
    </div>
    
</div>
<?php
Session::remove('errors');
?>