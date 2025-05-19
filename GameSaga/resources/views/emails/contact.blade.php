
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact GameSaga</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f8f9fa;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #dc3545; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 24px;">GameSaga</h1>
        </div>

        <div style="background-color: white; padding: 30px; border-radius: 0 0 8px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2 style="color: #dc3545; margin-top: 0;">Nouveau message de contact</h2>
            
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <p style="margin: 0 0 10px 0;"><strong style="color: #343a40;">Objet:</strong></p>
                <p style="margin: 0 0 20px 0; color: #495057;">{{ $objet }}</p>
                
                <p style="margin: 0 0 10px 0;"><strong style="color: #343a40;">Message:</strong></p>
                <div style="white-space: pre-line; color: #495057; background-color: white; padding: 15px; border-radius: 4px; border: 1px solid #dee2e6;">
                    {{ $content }}
                </div>
            </div>
        </div>

        <div style="text-align: center; padding: 20px; color: #6c757d; font-size: 14px;">
            <p style="margin: 0;">Envoyé depuis le formulaire de contact de GameSaga</p>
            <p style="margin: 5px 0 0 0;">© {{ date('Y') }} GameSaga. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>