<!DOCTYPE html>
<html>
<body>
    <h2>Bonjour !</h2>
    <p>Vous avez été invité à rejoindre la colocation : <strong>{{ $invitation->colocation->title }}</strong></p>
    <p>Pour accepter l'invitation et rejoindre vos colocataires, cliquez sur le bouton ci-dessous :</p>
    
    <a href="{{ route('invitations.accept', $invitation) }}" 
       style="display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #4f46e5; border-radius: 5px; text-decoration: none;">
       Accepter l'invitation
    </a>

    <p>Si vous n'avez pas de compte, vous pourrez en créer un après avoir cliqué sur le lien.</p>
</body>
</html>