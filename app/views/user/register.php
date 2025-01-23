<?php
require_once __DIR__ . '/../../controllers/UserController.php';

use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['register_error'] ?? null;
$success = $_SESSION['success_message'] ?? null;
unset($_SESSION['register_error'], $_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DinoChat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Inscription</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/register" id="register-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre e-mail" required>
                        </div>
                        <div class="mb-3">
                            <label for="pseudo" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirmez le mot de passe</label>
                            <input type="password" class="form-control" id="confirm-password" placeholder="Confirmez votre mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Créer un compte</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/login" class="text-decoration-none">Déjà inscrit ? Connectez-vous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
document.getElementById('register-form').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        event.preventDefault();
        alert("Les mots de passe ne correspondent pas !");
        return;
    }

    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/;
    if (!passwordRegex.test(password)) {
        event.preventDefault();
        alert("Le mot de passe ne respecte pas les normes :\n- Au moins 12 caractères\n- Une majuscule\n- Une minuscule\n- Un chiffre\n- Un caractère spécial.");
    }
});
</script>
