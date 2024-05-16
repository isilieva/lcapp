<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}

// Connexion à la base de données
$host = 'your_host';
$db = 'your_db_name';
$user = 'your_db_user';
$pass = 'your_db_password';
$port = 'your_db_port';

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass port=$port");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Gestion des actions (ajout, suppression, modification)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $query = "INSERT INTO employees (nom, prenom) VALUES ($1, $2)";
        pg_query_params($conn, $query, array($nom, $prenom));
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM employees WHERE id = $1";
        pg_query_params($conn, $query, array($id));
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $query = "UPDATE employees SET nom = $1, prenom = $2 WHERE id = $3";
        pg_query_params($conn, $query, array($nom, $prenom, $id));
    }
}

// Récupération de la liste des employés
$query = "SELECT * FROM employees";
$result = pg_query($conn, $query);
$employees = pg_fetch_all($result);

pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #C47B7B;
            width: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar img {
            width: 100px;
            padding-bottom: 25px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .sidebar .logout-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .employee-form {
            margin-bottom: 20px;
        }
        .employee-form input {
            margin-right: 10px;
        }
        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-table th, .employee-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .employee-table th {
            background-color: #f4f4f4;
        }
        .employee-table td:last-child {
            text-align: center;
        }
        .button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .button.add {
            background-color: #28a745;
            color: white;
        }
        .button.edit {
            background-color: #007bff;
            color: white;
        }
        .button.delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <?php include '../Component/sidebar.php'; ?>
    <div class="content">
        <h1>Liste des Employés</h1>
        <form class="employee-form" method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <button type="submit" name="add" class="button add">Ajouter</button>
        </form>
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($employees): ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employee['nom']); ?></td>
                            <td><?php echo htmlspecialchars($employee['prenom']); ?></td>
                            <td>
                                <form style="display:inline-block;" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
                                    <button type="button" class="button edit" onclick="editEmployee(<?php echo $employee['id']; ?>, '<?php echo $employee['nom']; ?>', '<?php echo $employee['prenom']; ?>')">Modifier</button>
                                    <button type="submit" name="delete" class="button delete">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Aucun employé trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <form id="editForm" class="employee-form" method="POST" style="display:none;">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="nom" id="editNom" placeholder="Nom" required>
            <input type="text" name="prenom" id="editPrenom" placeholder="Prénom" required>
            <button type="submit" name="edit" class="button edit">Enregistrer</button>
        </form>

        <script>
            function editEmployee(id, nom, prenom) {
                document.getElementById('editId').value = id;
                document.getElementById('editNom').value = nom;
                document.getElementById('editPrenom').value = prenom;
                document.getElementById('editForm').style.display = 'block';
                window.scrollTo(0, 0);
            }
        </script>
    </div>
</body>
</html>