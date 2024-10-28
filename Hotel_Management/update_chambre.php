<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $chambreId = $_POST['id'];
    $action = $_POST['action']; 
    
    // Connexion à la base de données Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Si l'action est de mise à jour
    if ($action === 'update') {
        $numero = $_POST['numero'];
        $categorie = $_POST['categorie'];
        $prix = $_POST['prix'];
        
        
        $disponible = isset($_POST['disponible']) ? 1 : 0;
        $enNettoyage = isset($_POST['en_nettoyage']) ? 1 : 0;
        $besoinMaintenance = isset($_POST['besoin_maintenance']) ? 1 : 0;

        // Préparer et exécuter la requête de mise à jour
        $stmt = $conn->prepare("UPDATE CHAMBRE SET NUMERO_CHAMBRE = :numero, CATEGORIE = :categorie, DISPONIBLE = :disponible, TARIF = :prix, EN_NETTOYAGE = :en_nettoyage, BESOIN_MAINTENANCE = :besoin_maintenance WHERE ID_CHAMBRE = :id");
        
        // Exécution de la requête avec des valeurs
        $stmt->execute([
            'numero' => $numero,
            'categorie' => $categorie,
            'disponible' => $disponible,
            'prix' => $prix,
            'en_nettoyage' => $enNettoyage,
            'besoin_maintenance' => $besoinMaintenance,
            'id' => $chambreId
        ]);

        // Rediriger vers afficher_chambres.php après la mise à jour
        header('Location: afficher_chambres.php?id=' . $chambreId);
        exit();
    }

    // Si l'action est de suppression
    elseif ($action === 'delete') {
        // Préparer et exécuter la requête de suppression
        $stmt = $conn->prepare("DELETE FROM CHAMBRE WHERE ID_CHAMBRE = :id");
        $stmt->execute(['id' => $chambreId]);

        // Rediriger vers la liste des chambres après la suppression
        header('Location: afficher_chambres.php');
        exit();
    }
} else {
    echo "Aucune donnée soumise.";
}
?>
