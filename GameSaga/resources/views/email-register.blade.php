<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- insérer le style -->
</head>

<body>
    <p>Bienvenue {{ $user->pseudo }},</p>

    <p>Veuillez cliquer sur le lien ci-dessous pour valider votre adresse e-mail :</p>

    <button class="button">
        <a href="{{ $frontend_URL }}/verification?email={{ $user->email }}&token={{ $user->token }}">Vérifier mon
            e-mail</a>
    </button>

    <p>A bientôt !</p>
</body>