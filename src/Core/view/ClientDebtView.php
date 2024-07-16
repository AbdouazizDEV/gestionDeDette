<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Dette</title>
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
</head>
<body class="bg-custom-bg text-gray-800">
    <main class="h-full overflow-y-auto" style="width: 83%; position: absolute; top: 86px; left: 15%; height: 89%;">
        <div class="container mx-auto p-4">
            <div class="flex space-x-4">
                <!-- Formulaire Nouveau Client -->
                <div class="flex space-x-4">
                <!-- Formulaire Nouveau -->
                <div class="bg-gray-200 p-6 rounded-lg">
                    <h2 class="text-lg font-bold mb-4">Nouveau Client</h2>
                    <form class="space-y-4" action="/clients/create" method="post" enctype="multipart/form-data">
                        <input type="text" name="nom" placeholder="Nom" class="w-full p-2 border border-gray-300 rounded">
                        <input type="text" name="prenom" placeholder="Prenom" class="w-full p-2 border border-gray-300 rounded">
                        <input type="email" name="email" placeholder="E-mail" class="w-full p-2 border border-gray-300 rounded">
                        <input type="text" name="adresse" placeholder="Adresse" class="w-full p-2 border border-gray-300 rounded">
                        <input type="number" name="tel" placeholder="TEL" class="w-full p-2 border border-gray-300 rounded">
                        <input type="file" name="photo" placeholder="Photo" class="w-full p-2 border border-gray-300 rounded">
                        <button type="submit" class="w-full bg-custom-button text-white p-2 rounded">Enregistrer</button>
                    </form>
                </div>

                <!-- Modal -->
                <div id="successModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-lg font-bold mb-4">Client ajouté avec succès</h2>
                            <button onclick="closeModal()" class="bg-custom-button text-white p-2 rounded">Fermer</button>
                        </div>
                    </div>
                </div>

                <script>
                function closeModal() {
                    document.getElementById('successModal').classList.add('hidden');
                }

                function showModal() {
                    document.getElementById('successModal').classList.remove('hidden');
                }
                </script>


                <!-- Formulaire Suivre une Dette -->
                <div class="bg-gray-200 p-6 rounded-lg shadow-md w-1/2">
                    <h2 class="text-lg font-bold mb-4">Suivre une Dette</h2>
                    <form class="space-y-4" action="/clients/search-debt" method="post">
                        <div class="flex mb-4">
                            <input type="tel" name="tel" placeholder="Tel:" class="flex-grow p-2 border border-gray-300 rounded-l">
                            <button type="submit" class="bg-custom-button text-white px-4 rounded-r">OK</button>
                        </div>
                    </form>
                    <div class="flex space-x-2 mb-4">
                        <button class="bg-custom-button text-white px-4 py-2 rounded">Client</button>
                        <button class="bg-custom-button text-white px-4 py-2 rounded">Nouvelle Dette</button>
                        <button class="bg-custom-button text-white px-4 py-2 rounded">Dette</button>
                    </div>
                    <div class="bg-white p-4 rounded shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-gray-500 rounded-full mr-4"></div>
                            <div>
                                <p>Nom : <?php echo htmlspecialchars($client['nom']); ?></p>
                                <p>Prenom : <?php echo htmlspecialchars($client['prenom']); ?></p>
                                <p>E-mail : <?php echo htmlspecialchars($client['email']); ?></p>
                            </div>
                        </div>
                        <?php if (!empty($dettes)): ?>
                            <?php foreach ($dettes as $dette): ?>
                                <p>Total Dette : <?php echo htmlspecialchars($dette['montant']); ?></p>
                                <p>Montant versé : <?php echo htmlspecialchars($dette['montant_verser']); ?></p>
                                <p>Montant restant : <?php echo htmlspecialchars($dette['montant_restant']); ?></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune dette trouvée pour ce client.</p>
                        <?php endif; ?>
                    </div>
                </div>  

            </div>
        </div>
    </main>
</body>
</html>
