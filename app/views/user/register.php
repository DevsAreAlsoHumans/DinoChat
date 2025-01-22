<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DinoChat</title>
    <!-- bootstrap Autorisée possibilité de le personnalisée -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- Carte d'inscription -->
                <h3 class="text-center">Inscription</h3>
                <!-- Champ pour l'adresse e-mail -->
                <input type="email" class="form-control" placeholder="Entrez votre e-mail" required>
                <!-- Champ pour le nom d'utilisateur -->
                <input type="text" class="form-control" placeholder="Entrez votre pseudo" required>
                <!-- Champ pour le mot de passe -->
                <input type="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                <!-- Bouton pour soumettre les informations d'inscription -->
                <button class="btn btn-success w-100">Créer un compte</button>
                <!-- Lien pour se connecter -->
                <a href="/login" class="text-decoration-none">Déjà inscrit ? Connectez-vous</a>
            </div>
        </div>
    </div>
</body>
</html>
