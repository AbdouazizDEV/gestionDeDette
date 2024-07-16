<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <style>
        body {
            background-color: #4B2E1A;
            color: white;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #D3D3D3;
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #8B4513;
        }
        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .input-group label {
            flex-basis: 30%;
        }
        .input-group input {
            flex-basis: 70%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="input-group">
            <label>Client: </label>
            <input type="text" value="<?php echo htmlspecialchars($client['nom']); ?>" disabled>
            <label>Montant versé: </label>
            <input type="text" value="<?php echo htmlspecialchars($dette['montant_verser']); ?>" disabled>
            <label>Montant restant: </label>
            <input type="text" value="<?php echo htmlspecialchars($dette['montant_restant']); ?>" disabled>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paiements as $paiement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paiement['date_paiement']); ?></td>
                        <td><?php echo htmlspecialchars($paiement['montant_paye']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="input-group">
            <label>Mr: </label>
            <input type="text" value="<?php echo htmlspecialchars($client['nom']); ?>" disabled>
        </div>
    </div>
</body>
</html>
