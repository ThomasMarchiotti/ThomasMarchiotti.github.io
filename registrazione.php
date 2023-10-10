<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <!-- Link al Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrazione</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="registrazione-form" action="server.php" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome:</label>
                        <input type="text" id="cognome" name="cognome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Numero di telefono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="consenso1" name="consenso1" required>
                        <label class="form-check-label" for="consenso1">Accetto i Termini e condizioni</label>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="consenso2" name="consenso2">
                        <label class="form-check-label" for="consenso2">Accetto il Marketing e la profilazione</label>
                    </div>
                    <button type="submit" class="btn btn-success">Registrati</button>

                    <!-- Campo nascosto per l'azione, come in login.php -->
                    <input type="hidden" name="action" value="registrazione" />
                </form>
            </div>
        </div>
    </div>
    <div id="registrazione-success-banner" class="alert alert-success mt-3" style="display: none;">
        Registrazione completata con successo! Puoi effettuare il login.
    </div>

    <!-- Link al Bootstrap JavaScript via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<script>
    $(document).ready(function() {
        $('#registrazione-form').submit(function(event) {   // Gestisco il modulo di login quando l'utente fa clic su "Registrati"
            event.preventDefault();                         // evito il comportamento predefinito del modulo

            var formData = $(this).serialize();             // Raccolgo i dati del modulo
    
            //chiamata HTTP per fare registrazione
            $.ajax({
                type: 'POST',
                url: 'server.php',
                data: formData,
                success: function(response) {
                    $('#risultato-registrazione').html(response);
                    $('#registrazione-success-banner').show(); // mostro banner di successo

                    setTimeout(function() { //dopo 2 secondi nascondo banner e faccio redirect
                        $('#registrazione-form').hide();
                        
                        window.location.href = 'login.php';
                    }, 2000); //fine
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); //stampo gli errori
                    $('#risultato-registrazione').html("Si è verificato un errore durante la registrazione.");
                }
            });
        });
    });
    </script>    