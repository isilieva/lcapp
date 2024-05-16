<div class="sidebar">
    <div>
        <img src="../Public/logo.jpg" alt="Logo">
        <br>
        <a href="dashboard.php">ACCUEILLE</a>
        <br>
        <a href="listeEmp.php">Liste des Employés</a>
    </div>
    <button class="logout-btn" onclick="logout()">LOG OUT</button>
</div>
<script>
    function logout() {
        window.location.href = '../Component/backlogin.php?logout=true';
    }
</script>
