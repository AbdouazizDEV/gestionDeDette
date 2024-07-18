<?php
use App\Controller\ProductController;

$productController = new ProductController();
$produits = $productController->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Ajouter une Dette</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-brown': '#6b5639',
                        'custom-gray': '#e0e0e0',
                        'custom-bg': '#4a5043',
                        'custom-button': '#7e6e5c',
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Couleurs personnalisées */
        .bg-brown-500 {
            background-color: #7e6e5c;
        }
        .bg-brown-600 {
            background-color: #8B4513;  
        }

        /* Menu dropdown */
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body>
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="flex justify-center items-center bg-black bg-opacity-75 min-h-screen">
        <div class="relative bg-brown-500 rounded-lg shadow-lg w-[80%] h-[80%] p-5">
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-white">Ajouter une Dette</h3>
                <button type="button" class="text-white hover:text-gray-300" id="closeModal">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            
            <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="client" class="text-white">Client:</label>
                    <input type="text" id="client" value="<?= isset($client) ? htmlspecialchars($client['nom'] . ' ' . $client['prenom'], ENT_QUOTES) : '' ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full" readonly>
                </div>
                <div>
                    <label for="tel" class="text-white">Tel:</label>
                    <input type="text" id="tel" value="<?= isset($client) ? htmlspecialchars($client['telephone'], ENT_QUOTES) : '' ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full" readonly>
                </div>
            </div>


    <div class="mt-4 p-4 bg-brown-600 rounded-lg">
        <form method="POST" action="/dette/save" id="debtForm">
            <input type="hidden" name="id_client" value="<?= htmlspecialchars($client['id'], ENT_QUOTES) ?>">

            <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <button type="button" id="mega-menu-dropdown-button" class="bg-gray-300 text-black px-4 py-2 rounded-lg">
                    Produit <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="mega-menu-dropdown" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                    <?php foreach ($produits as $produit): ?>
                        <label class="p-4 text-gray-900 dark:text-white">
                            <input type="checkbox" name="product_ids[]" value="<?= htmlspecialchars($produit['id_produit'], ENT_QUOTES) ?>" data-nom="<?= htmlspecialchars($produit['nom'], ENT_QUOTES) ?>" data-description="<?= htmlspecialchars($produit['description'] ?? '', ENT_QUOTES) ?>" data-prix="<?= htmlspecialchars($produit['prix'] ?? '', ENT_QUOTES) ?>" data-quantite="<?= htmlspecialchars($produit['quantite_en_stock'] ?? '', ENT_QUOTES) ?>" class="product-checkbox">
                            <?= htmlspecialchars($produit['nom'], ENT_QUOTES) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="montant" class="text-white">Montant total:</label>
                        <input type="number" id="montant" name="montant" value="<?= htmlspecialchars($_POST['montant'] ?? '') ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full" readonly>
                        <span class="text-red-500"><?= $errors['montant'] ?? '' ?></span>
                    </div>
                    <div>
                        <label for="montant_verser" class="text-white">Montant Versé :</label>
                        <input type="text" id="montant_verser" name="montant_verser" value="<?= htmlspecialchars($_POST['montant_verser'] ?? '') ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full">
                        <span class="text-red-500"><?= $errors['montant_verser'] ?? '' ?></span>
                    </div>
                    <div>
                        <label for="montant_restant" class="text-white">Montant restant:</label>
                        <input type="number" id="montant_restant" name="montant_restant" value="<?= htmlspecialchars($_POST['montant_restant'] ?? '') ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="date_emprunt" class="text-white">Date d'emprunt:</label>
                        <input type="date" id="date_emprunt" name="date_emprunt" value="<?= htmlspecialchars($_POST['date_emprunt'] ?? date('Y-m-d')) ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full" readonly>
                        <span class="text-red-500"><?= $errors['date_emprunt'] ?? '' ?></span>
                    </div>
                    <div>
                        <label for="date_remboursement" class="text-white">Date de Remboursement :</label>
                        <input type="date" id="date_remboursement" name="date_remboursement" value="<?= htmlspecialchars($_POST['date_remboursement'] ?? '') ?>" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 w-full">
                        <span class="text-red-500"><?= $errors['date_remboursement'] ?? '' ?></span>
                    </div>
                </div>

                <table id="productTable" class="w-full bg-gray-100 text-black mt-4">
                    <thead>
                        <tr>
                            <th class="border p-2">Nom</th>
                            <th class="border p-2">Description</th>
                            <th class="border p-2">Prix</th>
                            <th class="border p-2">Quantité</th>
                            <th class="border p-2">nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les produits ajoutés seront affichés ici -->
                    </tbody>
                </table>
                <br>
                <div class="flex justify-end">
                    <button type="submit" id="addProductBtn" class="bg-gray-300 text-black px-4 py-2 rounded-lg">Ajouter Dette</button>
                </div>
            </div>
        </form>
    </div>
</div>

        </div>
    </div>

    <script>
    document.getElementById('mega-menu-dropdown-button').addEventListener('click', function() {
        var dropdown = document.getElementById('mega-menu-dropdown');
        dropdown.classList.toggle('hidden');
    });

    var productCheckboxes = document.querySelectorAll('.product-checkbox');
    var productTableBody = document.querySelector('#productTable tbody');

    productCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var row = document.createElement('tr');
            if (checkbox.checked) {
                row.innerHTML = '<td class="border p-2">' + checkbox.getAttribute('data-nom') + '</td>' +
                                '<td class="border p-2">' + (checkbox.getAttribute('data-description') || 'N/A') + '</td>' +
                                '<td class="border p-2">' + (checkbox.getAttribute('data-prix') || 'N/A') + '</td>' +
                                '<td class="border p-2">' + (checkbox.getAttribute('data-quantite') || 'N/A') + '</td>'+
                                '<td class="border p-2"><input type="number" class="nombre bg-gray-200 border border-gray-300 rounded-lg text-black p-1" required></td>';
                productTableBody.appendChild(row);

                // Ajouter un écouteur d'événements pour le champ "nombre"
                row.querySelector('.nombre').addEventListener('input', updateMontant);
            } else {
                var rows = productTableBody.querySelectorAll('tr');
                rows.forEach(function(existingRow) {
                    if (existingRow.querySelector('td').textContent === checkbox.getAttribute('data-nom')) {
                        existingRow.remove();
                    }
                });
            }
            updateMontant(); // Mise à jour du montant total après changement de sélection
        });
    });

    function updateMontant() {
        var montant = 0;
        var rows = productTableBody.querySelectorAll('tr');
        rows.forEach(function(row) {
            var prix = parseFloat(row.querySelector('td:nth-child(3)').textContent) || 0;
            var nombre = parseFloat(row.querySelector('.nombre').value) || 0;
            montant += prix * nombre;
        });

        document.getElementById('montant').value = montant.toFixed(2);
        updateMontantRestant();
    }

    document.getElementById('montant_verser').addEventListener('input', function() {
        updateMontantRestant();
        validateMontantVerser();
    });

    function updateMontantRestant() {
        var montant = parseFloat(document.getElementById('montant').value) || 0;
        var montantVerser = parseFloat(document.getElementById('montant_verser').value) || 0;
        var montantRestant = montant - montantVerser;
        document.getElementById('montant_restant').value = montantRestant.toFixed(2);
    }

    function validateMontantVerser() {
        var montant = parseFloat(document.getElementById('montant').value) || 0;
        var montantVerser = parseFloat(document.getElementById('montant_verser').value) || 0;
        var montantError = document.getElementById('montantError');

        if (montantVerser > montant) {
            montantError.classList.remove('hidden');
            document.getElementById('montant_verser').classList.add('border-red-500');
        } else {
            montantError.classList.add('hidden');
            document.getElementById('montant_verser').classList.remove('border-red-500');
        }
    }

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('default-modal').style.display = 'none';
    });
</script>

</body>
</html>

