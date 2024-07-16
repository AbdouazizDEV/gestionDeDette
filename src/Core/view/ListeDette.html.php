<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Dettes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-bg {
            background-color: #6b4226; /* Couleur marron */
        }
        .custom-input, .custom-select, .custom-table th, .custom-table td {
            background-color: #d4c4b7; /* Couleur beige */
            border-color: #6b4226; /* Bordure marron */
        }
    </style>
</head>
<body class="custom-bg text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="clientName" class="block text-sm font-medium text-gray-700">Prénom et Nom:</label>
                    <input type="text" id="clientName" class="mt-1 block w-full custom-input border rounded-md" readonly value="<?= htmlspecialchars($client['nom'] ?? '' . ' ' . $client['prenom'] ?? '', ENT_QUOTES) ?>">
                </div>
                <div>
                    <label for="clientPhone" class="block text-sm font-medium text-gray-700">TEL :</label>
                    <input type="text" id="clientPhone" class="mt-1 block w-full custom-input border rounded-md" readonly value="<?= htmlspecialchars($client['telephone'] ?? '', ENT_QUOTES) ?>">
                </div>
                <div>
                    <label for="filter" class="block text-sm font-medium text-gray-700">Sélecte :</label>
                    <select id="filter" class="mt-1 block w-full custom-select border rounded-md" onchange="filterDettes()">
                        <option value="oui">Dettes Solder</option>
                        <option value="non">Dettes non Solder</option>
                    </select>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200 custom-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant versé</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant restant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Liste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dettes)): ?>
                        <?php foreach ($dettes as $dette): ?>
                            <tr data-id-dette="<?= htmlspecialchars($dette['id_dette'], ENT_QUOTES) ?>">
                                <td class="px-6 py-4 whitespace-nowrap" data-client-name="<?= htmlspecialchars($client['nom'] ?? '' . ' ' . $client['prenom'] ?? '', ENT_QUOTES) ?>"><?= htmlspecialchars($dette['date_emprunt'], ENT_QUOTES) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap" data-montant="<?= htmlspecialchars($dette['montant'], ENT_QUOTES) ?>"><?= htmlspecialchars($dette['montant'], ENT_QUOTES) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap" data-montant-verser="<?= htmlspecialchars($dette['montant_verser'], ENT_QUOTES) ?>"><?= htmlspecialchars($dette['montant_verser'], ENT_QUOTES) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap" data-montant-restant="<?= htmlspecialchars($dette['montant_restant'], ENT_QUOTES) ?>"><?= htmlspecialchars($dette['montant_restant'], ENT_QUOTES) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="/dette/produit">
                                        <input type="hidden" name="id_dette" value="<?= htmlspecialchars($dette['id_dette'], ENT_QUOTES) ?>">
                                        <button type="submit" class="productButton">Produits</button>
                                    </form>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="paymentButton" onclick="openModal('<?= htmlspecialchars($dette['id_dette'], ENT_QUOTES) ?>', '<?= htmlspecialchars($client['nom'] ?? '' . ' ' . $client['prenom'] ?? '', ENT_QUOTES) ?>', '<?= htmlspecialchars($dette['montant'], ENT_QUOTES) ?>', '<?= htmlspecialchars($dette['montant_verser'], ENT_QUOTES) ?>', '<?= htmlspecialchars($dette['montant_restant'], ENT_QUOTES) ?>')">Paiement</button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="window.location.href='/dette/paiements/<?= htmlspecialchars($dette['id_dette'], ENT_QUOTES) ?>'">Liste</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Aucune dette trouvée pour ce client.</td>
                        </tr>
                    <?php endif; ?> 
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4 flex justify-center">
                <?php if ($page > 1): ?>
                    <a href="/dette/list/<?= $page - 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-800 rounded mr-2">Précédent</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                    <a href="/dette/list/<?= $i ?>" class="px-4 py-2 bg-gray-300 text-gray-800 rounded mr-2 <?= $i == $page ? 'bg-gray-500 text-white' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($page < ($totalPages ?? 1)): ?>
                    <a href="/dette/list/<?= $page + 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-800 rounded">Suivant</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

   <!-- Product Modal -->
    <!-- Product Modal -->
<?php if (isset($products)): ?>
<div id="productModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg" style="width: 50%;">
        <h2 class="text-xl font-bold mb-4">Liste des Produits</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($product['nom'], ENT_QUOTES) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($product['description'], ENT_QUOTES) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($product['prix'], ENT_QUOTES) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($product['quantite'], ENT_QUOTES) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='<?= htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES) ?>'" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded">Fermer</button>
    </div>
</div>
<?php endif; ?>


  <!-- Modal Paiement -->
<div id="paymentModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg" style="width: 50%;">
        <h2 class="text-xl font-bold mb-4">Effectuer un Paiement</h2>
        <form id="paymentForm" method="POST">
            <div class="mb-4">
                <label for="paymentClientName" class="block text-sm font-medium text-gray-700">Client:</label>
                <input type="text" id="paymentClientName" class="mt-1 block w-full custom-input border rounded-md" readonly>
            </div>
            <div class="mb-4">
                <label for="paymentMontant" class="block text-sm font-medium text-gray-700">Montant Total:</label>
                <input type="text" id="paymentMontant" class="mt-1 block w-full custom-input border rounded-md" readonly>
            </div>
            <div class="mb-4">
                <label for="paymentMontantVerser" class="block text-sm font-medium text-gray-700">Montant Versé:</label>
                <input type="text" id="paymentMontantVerser" class="mt-1 block w-full custom-input border rounded-md" readonly>
            </div>
            <div class="mb-4">
                <label for="paymentMontantRestant" class="block text-sm font-medium text-gray-700">Montant Restant:</label>
                <input type="text" id="paymentMontantRestant" class="mt-1 block w-full custom-input border rounded-md" readonly>
            </div>
            <div class="mb-4">
                <label for="paymentAmount" class="block text-sm font-medium text-gray-700">Montant à Payer:</label>
                <input type="number" name="paymentAmount" id="paymentAmount" class="mt-1 block w-full custom-input border rounded-md">
            </div>
            <div id="paymentErrors" class="mb-4 text-red-500"></div>
            
            <input type="hidden" name="id_dette" id="id_dette">
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Payer</button>
                <button type="button" class="mr-2 px-4 py-2 bg-gray-300 rounded" onclick="closeModal()">Annuler</button>
            </div>
        </form>
    </div>
</div>
<script>
    function filterDettes() {
        const filter = document.getElementById('filter').value;
        window.location.href = '?filter=' + filter;
    }

    // Sélectionner la bonne option de filtre lors du chargement de la page
    document.getElementById('filter').value = new URLSearchParams(window.location.search).get('filter') || 'non';
</script>

<script>
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        let formData = new FormData(this);
        let errorsContainer = document.getElementById('paymentErrors');
        errorsContainer.innerHTML = ''; // Effacer les erreurs précédentes

        fetch('/dette/handlePayment', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                // Afficher les erreurs
                for (let error in data.errors) {
                    errorsContainer.innerHTML += '<p>' + data.errors[error] + '</p>';
                }
            } else if (data.success) {
                // Rediriger ou actualiser la liste des dettes
                window.location.href = '/dette/list';
            }
        })
        .catch(error => console.error('Erreur:', error));
    });

    function openModal(id_dette, clientName, montant, montantVerser, montantRestant) {
        document.getElementById('id_dette').value = id_dette;
        document.getElementById('paymentClientName').value = clientName;
        document.getElementById('paymentMontant').value = montant;
        document.getElementById('paymentMontantVerser').value = montantVerser;
        document.getElementById('paymentMontantRestant').value = montantRestant;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.getElementById('paymentErrors').innerHTML = ''; // Effacer les erreurs à la fermeture
    }
    
</script>
</body>
</html>

