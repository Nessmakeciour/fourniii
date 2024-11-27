<?php 
include "db_connection.php";

$id = $_GET['id'];
if (filter_var($id, FILTER_VALIDATE_INT)) {
    $sql = "DELETE FROM `fournisseur` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: suppliers.php?msg=Enregistrement supprimé avec succès");
        exit();
    } else {
        echo "Échec : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID invalide.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
