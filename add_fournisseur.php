<?php 
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données en sécurité
    $nom = $conn->real_escape_string(trim($_POST['nom']));
    $telephone = $conn->real_escape_string(trim($_POST['telephone']));
    $adresse = $conn->real_escape_string(trim($_POST['adresse']));
    $type_produit = $conn->real_escape_string(trim($_POST['type_produit']));
    $contact_nom = $conn->real_escape_string(trim($_POST['contact_nom']));
    $contact_fonction = $conn->real_escape_string(trim($_POST['contact_fonction']));
    $rib = $conn->real_escape_string(trim($_POST['rib']));
    $numero_fiscal = $conn->real_escape_string(trim($_POST['numero_fiscal']));

    // Vérification si le fournisseur existe déjà
    $check_sql = "SELECT * FROM fournisseur WHERE TRIM(nom) = '$nom' OR TRIM(telephone) = '$telephone'";
    $result = $conn->query($check_sql);

    if (!$result) {
        echo "Erreur dans la requête SQL : " . $conn->error;
    } else if ($result->num_rows > 0) {
        // Si le fournisseur existe déjà
        echo "<script>
                alert('Le fournisseur existe déjà dans la base de données.');
                window.location.href = 'add_fournisseur.php';
              </script>";
    } else {
        // Si le fournisseur n'existe pas, insérez les données
        $sql = "INSERT INTO `fournisseur` 
                (nom, telephone, adresse, type_produit, contact_nom, contact_fonction, rib, numero_fiscal) 
                VALUES 
                ('$nom', '$telephone', '$adresse', '$type_produit', '$contact_nom', '$contact_fonction', '$rib', '$numero_fiscal')";

        if ($conn->query($sql) === TRUE) {
            header("Location: suppliers.php?msg=Fournisseur ajouté avec succès");
            exit;
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un Nouveau Fournisseur</title>
  <link rel="stylesheet" href="add.css">
</head>
<body>
  <div class="form-container">
    <h2 class="form-title">Ajouter un Nouveau Fournisseur</h2>
    <form action="add_fournisseur.php" method="POST">

      <div class="form-section">
        <div class="half-width">
          <label for="nom">Nom du Fournisseur</label>
          <input type="text" name="nom" placeholder="Entrez le nom du fournisseur" required>
        </div>

        <div class="half-width">
          <label for="adresse">Adresse</label>
          <input type="text" name="adresse"placeholder="Entrez l'adresse complète" required>
        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="telephone">Numéro de téléphone</label>
          <input type="tel" name="telephone" placeholder="(+213)" required>
        </div>

        <div class="half-width">
          <label for="type_produit">Type de Produit/Service</label>
          <select name="type_produit" required>
            <option value="" disabled selected>Choisissez le Type de Produit/Service</option>
            <option value="Produits électroniques">Produits électroniques</option>
            <option value="Matériel médical">Matériel médical</option>
            <option value="Vêtements">Vêtements</option>
            <option value="Alimentaire">Alimentaire</option>
            <option value="Services divers">Services divers</option>
          </select>
        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="contact_nom">Nom de la Personne de Contact</label>
          <input type="text" name="contact_nom" placeholder="Entrez le nom du contact" >
        </div>

        <div class="half-width">
          <label for="contact_fonction">Fonction de la Personne</label>
          <input type="text" name="contact_fonction" placeholder="Entrez la fonction du contact">
        </div>
      </div>

      <div class="form-section">
        <div class="half-width">
          <label for="rib">RIB/IBAN</label>
          <input type="text" name="rib" placeholder="Entrez le RIB/IBAN" >
        </div>

        <div class="half-width">
          <label for="numero_fiscal">Numéro Fiscal</label>
          <input type="text" name="numero_fiscal" placeholder="Entrez le numéro fiscal">
        </div>
      </div>

      <button type="submit" class="btn-primary">Ajouter Fournisseur</button>
    </form>
  </div>
</body>
</html>
