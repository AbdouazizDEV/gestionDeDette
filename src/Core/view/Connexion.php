<?php
    namespace Core\view;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-brown': '#6b5639',
                        'custom-gray': '#e0e0e0',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-custom-brown flex justify-center items-center h-screen">
    <div class="bg-custom-gray p-8 rounded-lg w-80">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-custom-brown rounded-full"></div>
        </div>
        <form action="/index.php?action=login" method="POST">
            <div class="mb-4">
                <label class="block text-custom-brown mb-2" for="username">Username :</label>
                <div class="bg-custom-brown p-2 rounded flex items-center">
                    <input type="text" id="username" name="username" placeholder="Saisissez votre nom d'utilisateur" class="bg-custom-gray flex-grow pl-2">
                    <svg class="w-6 h-6 text-custom-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-custom-brown mb-2" for="password">Password :</label>
                <div class="bg-custom-brown p-2 rounded flex items-center">
                    <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe" class="bg-custom-gray flex-grow pl-2">
                    <svg class="w-6 h-6 text-custom-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <button type="submit" class="w-full bg-custom-brown text-white py-2 rounded">Connexion</button>
        </form>


        <div class="flex justify-center space-x-4 mt-6">
            <img src="path_to_whatsapp_icon.png" alt="WhatsApp" class="w-6 h-6">
            <img src="path_to_facebook_icon.png" alt="Facebook" class="w-6 h-6">
            <img src="path_to_instagram_icon.png" alt="Instagram" class="w-6 h-6">
            <img src="path_to_linkedin_icon.png" alt="LinkedIn" class="w-6 h-6">
            <img src="path_to_twitter_icon.png" alt="Twitter" class="w-6 h-6">
        </div>
    </div>
</body>
</html>