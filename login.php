<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso</title>
    <!-- Link al Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Accesso</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="server.php" method="post">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Numero di telefono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <input type="hidden" name="action" value="accesso"> <!-- Campo nascosto per l'azione, tendenzialmente non usato ma fatto velocemente -->
                    <button type="submit" class="btn btn-primary">Accedi</button>
                </form>
                <div class="mt-3">
                    <p>Non hai un account? <a href="registrazione.php">Registrati qui</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Link al Bootstrap JavaScript via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>




<script>
    $(document).ready(function() {
        $('#login-form').submit(function(event) {     // Gestisco il modulo di login quando l'utente fa clic su "Accedi"
            event.preventDefault();                   // evito il comportamento predefinito del modulo

            var formData = $(this).serialize();       // Raccolgo i dati del modulo

            //chiamata HTTP per eseguire login
            $.ajax({
                type: 'POST',
                url: 'server.php',
                data: formData,
                success: function(response) {
                    // Visualizza la risposta del server
                    alert(response);

                    // In caso di accesso riuscito reindirizzo l'utente alla pagina principale
                    // lo faccio gia da backend però meglio esserne sicuri
                    if (response.indexOf("Accesso riuscito!") !== -1) {
                        window.location.href = 'index.php';
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); //stampo gli eventuali errori
                    alert("Si è verificato un errore durante l'accesso.");
                }
            });
        });
    });
</script>
