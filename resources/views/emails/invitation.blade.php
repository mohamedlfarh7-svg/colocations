<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; background-color: #050505; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #050505; padding-bottom: 40px; }
        .main { background-color: #0f0f0f; width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #1e1e1e; border-radius: 24px; overflow: hidden; margin-top: 20px; }
        .header-image { width: 100%; height: 200px; object-fit: cover; border-bottom: 2px solid #2563eb; }
        .content { padding: 40px 30px; text-align: center; }
        .badge { background: rgba(37, 99, 235, 0.1); border: 1px solid rgba(37, 99, 235, 0.2); color: #3b82f6; padding: 6px 15px; border-radius: 10px; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; display: inline-block; margin-bottom: 20px; }
        .title { color: #ffffff; font-size: 28px; font-weight: 900; margin: 0; text-transform: uppercase; font-style: italic; letter-spacing: -1px; }
        .subtitle { color: #9ca3af; font-size: 14px; margin-top: 10px; line-height: 1.6; }
        
        .coloc-card { background-color: #161616; border: 1px solid #262626; border-radius: 16px; padding: 25px; margin: 30px 0; text-align: left; }
        .info-row { margin-bottom: 10px; color: #d1d5db; font-size: 13px; }
        .info-label { color: #4b5563; font-weight: bold; text-transform: uppercase; font-size: 10px; letter-spacing: 1px; width: 80px; display: inline-block; }
        
        .btn { display: inline-block; background-color: #2563eb; color: #ffffff !important; padding: 16px 32px; border-radius: 14px; text-decoration: none; font-weight: 900; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }
        .footer { text-align: center; padding: 20px; color: #4b5563; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&h=200&q=80" alt="SpaceColoc" class="header-image">
            
            <div class="content">
                <div class="badge">Invitation Exclusive</div>
                <h1 class="title">Rejoins l'équipage</h1>
                <p class="subtitle">Une place s'est libérée dans une nouvelle colocation. Voici les détails de ton futur chez-toi :</p>

                <div class="coloc-card">
                    <div class="info-row">
                        <span class="info-label">Nom :</span> 
                        <strong style="color: #3b82f6;">{{ $invitation->colocation->name }}</strong>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Adresse :</span> 
                        <span>{{ $invitation->colocation->address ?? 'Adresse non spécifiée' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Budget :</span> 
                        <span style="color: #10b981;">{{ number_format($invitation->colocation->price, 2) }} DH / mois</span>
                    </div>
                </div>

                <a href="{{ route('invitations.accept', $invitation) }}" class="btn">
                    Accepter l'accès
                </a>

                <p style="color: #4b5563; font-size: 11px; margin-top: 30px; font-style: italic;">
                    Si tu n'as pas encore de compte, l'accès sera créé automatiquement après validation.
                </p>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SpaceColoc Architecture. All rights reserved.
        </div>
    </div>
</body>
</html>