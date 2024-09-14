<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buddhi Babu</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">

    <!-- Google Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Estilos del chat -->
    <link rel="stylesheet" href="/assets/css/contchat.css">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="/assets/js/contenidogpt.min.js"></script>
</head>

<body>
    <!-- Chat Container -->
    <div class="chat-container"></div>

    <!-- User Input Container -->
    <div class="user-input-container">
        <div class="user-input-content">
            <div class="user-input-textarea">
                <input type="text" id="chat-input" placeholder="Escriba su consulta" required>
                <span id="send-btn" class="material-symbols-rounded">send</span>
            </div>
            <div class="typing-controls">
                <span id="theme-btn" class="material-symbols-rounded">light_mode</span>
                <span id="delete-btn" class="material-symbols-rounded">delete</span>
            </div>
        </div>
    </div>
</body>

</html>
