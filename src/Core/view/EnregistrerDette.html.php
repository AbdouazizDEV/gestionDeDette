<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Commande</title>
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
<body class="bg-custom-bg flex justify-center items-center h-screen">
    <div class="bg-custom-gray p-6 rounded-lg w-[600px]" style="width: 53%;">
        <div class="space-y-4 mb-4">
            <div class="flex items-center bg-custom-brown rounded p-2">
                <label class="text-white w-16">Client :</label>
                <input type="text" class="flex-grow bg-white rounded px-2 py-1">
            </div>
            <div class="flex items-center bg-custom-brown rounded p-2">
                <label class="text-white w-16">Tel :</label>
                <input type="text" class="flex-grow bg-white rounded px-2 py-1">
            </div>
        </div>
        
        <div class="bg-custom-brown p-4 rounded-lg">
            <div class="flex items-center mb-4">
                <label class="text-white mr-2">Référence :</label>
                <input type="text" class="flex-grow bg-white rounded px-2 py-1 mr-2">
                <button class="bg-white px-4 py-1 rounded">OK</button>
            </div>
            
            <div class="flex space-x-2 mb-4">
                <input type="text" placeholder="Libellé" class="flex-grow bg-white rounded px-2 py-1">
                <input type="text" placeholder="Prix" class="flex-grow bg-white rounded px-2 py-1">
                <input type="text" placeholder="Quantité" class="flex-grow bg-white rounded px-2 py-1">
                <button class="bg-white px-4 py-1 rounded">Ajouter</button>
            </div>
            
            <table class="w-full bg-white">
                <thead>
                    <tr>
                        <th class="border p-2">Article</th>
                        <th class="border p-2">Prix</th>
                        <th class="border p-2">Quantité</th>
                        <th class="border p-2">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
