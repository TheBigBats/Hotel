<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer tous les clients
$stmt = $conn->query("SELECT * FROM CLIENT");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="style5.css">
    <script>
        let selectedRowId = null;

        function selectRow(id) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.classList.remove('selected'); // Enlève la sélection des autres lignes
            });

            const selectedRow = document.getElementById(`row-${id}`);
            selectedRow.classList.add('selected'); // Surligne la ligne sélectionnée
            selectedRowId = id; // Enregistre l'ID de la ligne sélectionnée
        }

        function modifierClient() {
            if (selectedRowId) {
                window.location.href = `client.php?id=${selectedRowId}`; // Redirection vers client.php avec l'ID du client
            } else {
                alert('Veuillez sélectionner un client à modifier.');
            }
        }
    </script>
</head>

<body>
    <h1>Liste des Clients</h1>

    <table>
        <thead>
            <tr>
                <th>ID Client</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Civilité</th>
                <th>Mobile</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Pays</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['ID_CLIENT']) ?></td>
                    <td><?= htmlspecialchars($client['NOM']) ?></td>
                    <td><?= htmlspecialchars($client['PRENOM']) ?></td>
                    <td><?= htmlspecialchars($client['CIVILITE']) ?></td>
                    <td><?= htmlspecialchars($client['MOBILE']) ?></td>
                    <td><?= htmlspecialchars($client['ADRESSE']) ?></td>
                    <td><?= htmlspecialchars($client['EMAIL']) ?></td>
                    <td><?= htmlspecialchars($client['VILLE']) ?></td>
                    <td><?= htmlspecialchars($client['CODE_POSTAL']) ?></td>
                    <td><?= htmlspecialchars($client['PAYS']) ?></td>
                    <td>
                       <a href="client.php?id=<?= htmlspecialchars($client['ID_CLIENT']) ?>">Modifier</a>
                   </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="buttons">
        <a href="clients.php">
            <button class="consult-button">Nouveau</button>
        </a>
        
    </div>    
</body>
</html>
