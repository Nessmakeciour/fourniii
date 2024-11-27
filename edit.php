<?php
include "db_connection.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `fournisseur` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fournisseur = $result->fetch_assoc();
    } else {
        echo "Fournisseur introuvable.";
        exit;
    }
} else {
    echo "ID non fourni.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['telephone'], $_POST['type_produit'], $_POST['contact_nom'], $_POST['contact_fonction'], $_POST['rib'], $_POST['numero_fiscal'])) {
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $type_produit = mysqli_real_escape_string($conn, $_POST['type_produit']);
        $contact_nom = mysqli_real_escape_string($conn, $_POST['contact_nom']);
        $contact_fonction = mysqli_real_escape_string($conn, $_POST['contact_fonction']);
        $rib = mysqli_real_escape_string($conn, $_POST['rib']);
        $numero_fiscal = mysqli_real_escape_string($conn, $_POST['numero_fiscal']);
        $sql = "UPDATE `fournisseur` SET nom = ?, adresse = ?, telephone = ?, type_produit = ?, contact_nom = ?, contact_fonction = ?, rib = ?, numero_fiscal = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $nom, $adresse, $telephone, $type_produit, $contact_nom, $contact_fonction, $rib, $numero_fiscal, $id);

        if ($stmt->execute()) {
            header("Location: suppliers.php?msg=Fournisseur modifié avec succès");
            exit();
        } else {
            echo "Erreur lors de la mise à jour : " . $conn->error;
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le Fournisseur</title>
  <link rel="stylesheet" href="add.css">
</head>
<body>
  <div class="form-container">
    <h2 class="form-title">Modifier le Fournisseur</h2>
    <form action="" method="POST">
      <div class="form-section">
        <div class="half-width">
          <label for="nom">Nom du Fournisseur</label>
          <input type="text" name="nom" placeholder="Entrez le nom du fournisseur"  value="<?php echo htmlspecialchars($fournisseur['nom'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="half-width">
          <label for="adresse">Adresse</label>
          <input type="text" name="adresse" placeholder="Entrez l'adresse complète" value="<?php echo htmlspecialchars($fournisseur['adresse'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="telephone">Numéro de téléphone</label>
          <input type="tel" name="telephone" placeholder="(+213)" value="<?php echo htmlspecialchars($fournisseur['telephone'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="half-width">
          <label for="type_produit">Type de Produit/Service</label>
          <select name="type_produit" required>
  <option value="" disabled>Choisissez le Type de Produit/Service</option>
  <option value="Produits électroniques" <?php echo ($fournisseur['type_produit'] == 'Produits électroniques') ? 'selected' : ''; ?>>Produits électroniques</option>
  <option value="Matériel médical" <?php echo ($fournisseur['type_produit'] == 'Matériel médical') ? 'selected' : ''; ?>>Matériel médical</option>
  <option value="Vêtements" <?php echo ($fournisseur['type_produit'] == 'Vêtements') ? 'selected' : ''; ?>>Vêtements</option>
  <option value="Alimentaire" <?php echo ($fournisseur['type_produit'] == 'Alimentaire') ? 'selected' : ''; ?>>Alimentaire</option>
  <option value="Services divers" <?php echo ($fournisseur['type_produit'] == 'Services divers') ? 'selected' : ''; ?>>Services divers</option>
</select>

        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="contact_nom">Nom de la Personne de Contact</label>
          <input type="text" name="contact_nom" placeholder="Entrez le nom du contact" value="<?php echo htmlspecialchars($fournisseur['contact_nom'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="half-width">
          <label for="contact_fonction">Fonction de la Personne</label>
          <input type="text" name="contact_fonction" placeholder="Entrez la fonction du contact" value="<?php echo htmlspecialchars($fournisseur['contact_fonction'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="rib">RIB/IBAN</label>
          <input type="text" name="rib" placeholder="Entrez le RIB/IBAN"  value="<?php echo htmlspecialchars($fournisseur['rib'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="half-width">
          <label for="numero_fiscal">Numéro Fiscal</label>
          <input type="text" name="numero_fiscal"placeholder="Entrez le numéro fiscal" value="<?php echo htmlspecialchars($fournisseur['numero_fiscal'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
      </div>

      <button type="submit" class="btn-primary">Enregistrer les modifications</button>
    </form>
  </div>
</body>
</html>
