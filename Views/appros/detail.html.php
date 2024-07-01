<?php
dd($approDetail);
?>
<div class="container mx-auto max-w-4xl px-4 py-6">
  <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-500">Détails de la Production</h1>

    <div class="mb-6">
      <h2 class="text-2xl font-semibold mb-4 text-white">Informations de la Production</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
          <p class="font-medium text-white"><strong class="text-purple-300">Date:</strong> <?= htmlspecialchars($approDetail[0]['date']) ?>
          </p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
          <p class="font-medium text-white"><strong class="text-purple-300" >Montant:</strong>
            <?= htmlspecialchars($approDetail[0]['montant']) ?></p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm md:col-span-2">
          <p class="font-medium text-white"><strong class="text-purple-300">Observation:</strong>
            <?= htmlspecialchars($approDetail[0]['observation']) ?></p>
        </div>
      </div>
    </div>

    <div class="mb-6">
      <h2 class="text-2xl font-semibold mb-4 text-white">Articles de la Production</h2>


      <div
    class="overflow-x-auto whitespace-nowrap py-4 scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-purple-300">
    <div class="flex space-x-4">
      <?php foreach ($approDetail as $detail): ?>
          <div class="min-w-max bg-white p-9 w-1/4 rounded-lg shadow-md shadow-purple-500/50 dark:bg-gray-800 text-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white "><?= htmlspecialchars($detail['libelle']) ?></h3>
            <p class="text-gray-500 dark:text-gray-300">Quantité: <?= htmlspecialchars($detail['qteProd']) ?></p>
            <p class="text-gray-500 dark:text-gray-300">Prix: <?= htmlspecialchars($detail['prixAppro']) ?></p>
          </div>
        <?php endforeach ?>
    </div>
  </div>
    </div>

    <div class="text-center">
      <a href="?controller=production&action=liste-production&page=0"
        class="mt-4 inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-6 rounded-full transition duration-300 ease-in-out focus:ring-4 ring-purple-300">Retour</a>
    </div>
  </div>
</div>