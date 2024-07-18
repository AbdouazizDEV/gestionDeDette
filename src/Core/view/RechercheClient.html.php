
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
</style>
<style>
    /* Couleurs personnalisées */
    .bg-brown-500 {
        background-color: #7e6e5c;
    }
    .bg-brown-600 {
        background-color: #8B4513;  
    }
</style>

</head>
<body class="bg-custom-bg text-gray-800">
    <main class="h-full overflow-y-auto" style="width: 83%; position: absolute; top: 86px; left: 15%; height: 89%;">
        <div class="container mx-auto p-4">
            <div class="flex space-x-4">
                <!-- Formulaire Nouveau Client -->
                <div class="flex space-x-4 " style="width: 100%;">
                <!-- Formulaire Nouveau -->
                <div class="bg-gray-200 p-6 rounded-lg" style="width: -webkit-fill-available;">
                    <h2 class="text-lg font-bold mb-4">Nouveau Client</h2>
                    <form class="space-y-4" action="/clients/create" method="post" enctype="multipart/form-data">
                    <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES) ?>" class="w-full p-2 border border-gray-300 rounded">
                    <?php if (isset($errors['nom'])): ?>
                        <span class="text-red-500"><?= htmlspecialchars($errors['nom'], ENT_QUOTES) ?></span>
                    <?php endif; ?>

                    <input type="text" name="prenom" placeholder="Prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '', ENT_QUOTES) ?>" class="w-full p-2 border border-gray-300 rounded">
                    <?php if (isset($errors['prenom'])): ?>
                        <span class="text-red-500"><?= htmlspecialchars($errors['prenom'], ENT_QUOTES) ?></span>
                    <?php endif; ?>

                    <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>" class="w-full p-2 border border-gray-300 rounded">
                    <?php if (isset($errors['email'])): ?>
                        <span class="text-red-500"><?= htmlspecialchars($errors['email'], ENT_QUOTES) ?></span>
                    <?php endif; ?>

                    <input type="text" name="adresse" placeholder="Adresse" value="<?= htmlspecialchars($_POST['adresse'] ?? '', ENT_QUOTES) ?>" class="w-full p-2 border border-gray-300 rounded">
                    <?php if (isset($errors['adresse'])): ?>
                        <span class="text-red-500"><?= htmlspecialchars($errors['adresse'], ENT_QUOTES) ?></span>
                    <?php endif; ?>

                    <input type="tel" name="tel" placeholder="TEL" value="<?= htmlspecialchars($_POST['tel'] ?? '', ENT_QUOTES) ?>" class="w-full p-2 border border-gray-300 rounded">
                    <?php if (isset($errors['tel'])): ?>
                        <span class="text-red-500"><?= htmlspecialchars($errors['tel'], ENT_QUOTES) ?></span>
                    <?php endif; ?>

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
                    function showSuccessModal() {
                        const modal = document.getElementById('successModal');
                        modal.classList.remove('hidden');
                        modal.classList.add('fade-in');
                    }

                    function closeModal() {
                        const modal = document.getElementById('successModal');
                        modal.classList.add('hidden');
                        modal.classList.remove('fade-in');
                    }
                </script>

                <!-- Formulaire Suivre une Dette -->
                <div class="bg-gray-200 p-6 rounded-lg shadow-md w-1/2">
                    <h2 class="text-lg font-bold mb-4">Suivre une Dette</h2>
                    <div class="flex mb-4">
                        <input type="number" id="phone" placeholder="Tel:" class="flex-grow p-2 border border-gray-300 rounded-l">
                        <button id="searchBtn" class="bg-custom-button text-white px-4 rounded-r">OK</button>
                    </div>
                    <div class="flex space-x-2 mb-4">
                        <button class="bg-custom-button text-white px-4 py-2 rounded">Client</button>
                        <form action="/dette/create" method="post">
                            <button class="block text-white bg-custom-button hover:bg-custom-800 focus:ring-4 focus:outline-none focus:ring-custom-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-custom-600 dark:hover:bg-custom-700 dark:focus:ring-custom-800"> Nouvelle Dette</button>
                        </form>
                        <form action="/dette/list" method="post">
                            <button class="bg-custom-button text-white px-4 py-2 rounded">Dette</button>
                        </form>
                    </div>
                    <div id="clientDetails" class="bg-white p-4 rounded shadow-md hidden" style="height: 63%;">
                        <div class="flex items-center mb-4" style="height: 51%;">
                            <img id="clientPhoto" class="w-16 h-16 rounded-full mr-4" src="" alt="Photo du client" style="width: 39%;height: 93%;">
                            <div>
                                <p>Nom : <span id="clientName"></span></p>
                                <p>Prenom : <span id="clientSurname"></span></p>
                                <p>E-mail : <span id="clientEmail"></span></p>
                            </div>
                        </div>
                        <p>Total Dette : <span id="totalDebt"></span></p>
                        <p>Montant versé : <span id="amountPaid"></span></p>
                        <p>Montant restant : <span id="remainingAmount"></span></p>
                    </div>
                </div>

            </div>
        </div>


<!-- Modal principal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75">
    <div class="relative bg-brown-500 rounded-lg shadow-lg w-[80%] h-[80%] p-5">
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-white">
                Client Information
            </h3>
            <button type="button" class="text-white hover:text-gray-300" id="closeModal">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <!-- Corps du modal -->
        <div class="space-y-4">
            <div>
                <label for="client" class="text-white">Client:</label>
                <input type="text" id="client" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 ml-2">
            </div>
            <div>
                <label for="tel" class="text-white">Tel:</label>
                <input type="text" id="tel" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 ml-2">
            </div>
            <div class="mt-4 p-4 bg-brown-600 rounded-lg">
                <div class="flex items-center mb-2">
                    <label for="reference" class="text-white mr-2">Reference:</label>
                    <input type="text" id="reference" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1">
                    <!-- Créer une Selecte pour y lister tous les articles -->
                     <select id="reference" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1" name="select_article" >
                         <!-- Remplir la liste avec les articles -->
                         
                     </select>
                    <button class="bg-gray-300 text-black ml-2 px-2 rounded-lg">OK</button>
                </div>
                <div class="flex mb-2">
                    <label for="libelle" class="text-white mr-2">Libelle:</label>
                    <input type="text" id="libelle" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 mr-2">
                    <label for="montant" class="text-white mr-2">Montant:</label>
                    <input type="text" id="prix" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1 mr-2">
                    <label for="quantite" class="text-white mr-2">Quantite:</label>
                    <input type="text" id="quantite" class="bg-gray-200 border border-gray-300 rounded-lg text-black p-1">
                </div>
                <button class="bg-gray-300 text-black px-4 py-1 rounded-lg">Ajouter</button>
            </div>
            <table class="w-full bg-gray-100 text-black mt-4">
                <thead>
                    <tr>
                        <th class="border p-2">Article</th>
                        <th class="border p-2">Prix</th>
                        <th class="border p-2">Quantite</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Les lignes de la table seront ajoutées ici -->
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>
<!-- <script>
    document.getElementById('toggleModal').addEventListener('click', function() {
        document.getElementById('default-modal').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('default-modal').classList.add('hidden');
    });

    document.getElementById('acceptButton').addEventListener('click', function() {
        document.getElementById('default-modal').classList.add('hidden');
        // Ajoutez ici toute action à réaliser après avoir accepté les termes
    });

    document.getElementById('declineButton').addEventListener('click', function() {
        document.getElementById('default-modal').classList.add('hidden');
        // Ajoutez ici toute action à réaliser après avoir refusé les termes
    });
</script> -->
<script>
document.getElementById('searchBtn').addEventListener('click', function () {
    const phone = document.getElementById('phone').value;

    if (phone) {
        fetch(`/clients/phone?tel=${phone}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('clientDetails').classList.remove('hidden');
                    if (data.photo) {
                        document.getElementById('clientPhoto').src = data.photo.startsWith('/') ? data.photo : `/uploads/${data.photo}`;
                    } else {
                        document.getElementById('clientPhoto').src = '/uploads/boy_bambey.jpg'; // Mettre une image par défaut si nécessaire
                    }
                    document.getElementById('clientName').textContent = data.nom;
                    document.getElementById('clientSurname').textContent = data.prenom;
                    document.getElementById('clientEmail').textContent = data.email;

                    document.getElementById('totalDebt').textContent = data.totalDebt;
                    document.getElementById('amountPaid').textContent = data.amountPaid;
                    document.getElementById('remainingAmount').textContent = data.remainingAmount;
                }
            })
            .catch(error => console.error('Erreur:', error));
    } else {
        alert('Veuillez saisir un numéro de téléphone.');
    }
});
</script>

</body>
</html>