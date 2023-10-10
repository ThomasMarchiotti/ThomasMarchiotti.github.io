<?php
//Avvio o ripresa della sessione
session_start();

//Verifico se ho fatto logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();                  //distruggo la sessione
    header('Location: login.php');     //reindirizzo l'utente alla pagina di login
    exit;
}

//controllo se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); //in caso negativo ritorno alla login
    exit;
}

//recupero dati in sessione
$nome = $_SESSION['user_name'];
$cognome = $_SESSION['user_cognome'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- Link al Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Benvenuto nella tua home page, <?php echo $nome . ' ' . $cognome; ?>!</h1>
        <p class="text-center">Benvenuto in PharmaCare.</p>
        <div class="text-center">
            <a href="index.php?logout=true" class="btn btn-danger">Esci</a>
        </div>
    </div>

    <!-- Link al Bootstrap JavaScript via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
