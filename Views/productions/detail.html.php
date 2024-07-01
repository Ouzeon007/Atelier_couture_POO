<div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Détails de la Production</h1>
        
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Informations de la Production</h2>
            <p><strong>Date:</strong> <?= htmlspecialchars($productionDetails[0]['date']) ?></p>
            <p><strong>Montant:</strong> <?= htmlspecialchars($productionDetails[0]['montant']) ?></p>
            <p><strong>Observation:</strong> <?= htmlspecialchars($productionDetails[0]['observation']) ?></p>
        </div>
        
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Articles de la Production</h2>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/3 px-4 py-2">Libellé</th>
                        <th class="w-1/3 px-4 py-2">Quantité</th>
                        <th class="w-1/3 px-4 py-2">Prix</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($productionDetails as $detail): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($detail['libelle']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($detail['qteProd']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($detail['prixAppro']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="?controller=production&action=liste-production&page=0" class="mt-4 inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Retour</a>
    </div>