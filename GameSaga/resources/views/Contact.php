
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nouveau message de contact</h1>
    </div>

    <div class="content">
        <h2>Détails du message :</h2>
        <p><strong>Objet :</strong> {{ $data['objet'] }}</p>
        <p><strong>Message :</strong></p>
        <p style="white-space: pre-line;">{{ $data['contenu'] }}</p>
    </div>

    <div class="footer">
        <p>Envoyé depuis le formulaire de contact de GameSaga</p>
    </div>
</body>
</html>