<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - DinoChat</title>
    <!-- bootstrap Autorisée possibilité de le personnalisée -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- Carte de connexion -->
                <h3 class="text-center">Connexion</h3>
                <!-- Champ pour l'adresse e-mail -->
                <input type="email" class="form-control" placeholder="Entrez votre e-mail" required>
                <!-- Champ pour le mot de passe -->
                <input type="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                <!-- Bouton pour soumettre les informations de connexion -->
                <button class="btn btn-primary w-100">Se connecter</button>
                <!-- Lien pour s'inscrire -->
                <a href="/register" class="text-decoration-none">Pas encore inscrit ? Créez un compte</a>
            </div>
        </div>
    </div>
</body>
</html>
