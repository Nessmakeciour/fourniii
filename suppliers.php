<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulter Fournisseurs</title>
  <link rel="stylesheet" href="suppliers.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
  <h1 style="text-align: center; color: #007bff;">Liste des Fournisseurs</h1>

  <table>
    <thead>
      <tr>
        <th>id</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Téléphone</th>
        <th>Type de Produits</th>
        <th>Contact</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="suppliersTable">
    <?php
    include "db_connection.php"; 
    $sql = "SELECT * FROM fournisseur";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['adresse']); ?></td>
                    <td><?php echo htmlspecialchars($row['telephone']); ?></td>
                    <td><?php echo htmlspecialchars($row['type_produit']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_nom'] . " (" . $row['contact_fonction'] . ")"); ?></td>
                    <td>
                      <div class="actions">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                          <i class="fa-solid fa-pen-to-square"></i> Modifier
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?');">
                          <i class="fa-solid fa-trash"></i> Supprimer
                        </a>
                      </div>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='10'>Aucun fournisseur trouvé.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='10'>Erreur de la requête : " . htmlspecialchars(mysqli_error($conn)) . "</td></tr>";
    }
    mysqli_close($conn);
    ?>
</tbody>
</table>
</body>
</html>
