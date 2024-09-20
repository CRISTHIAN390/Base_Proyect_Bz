<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistente Virtual</title>

    <!-- Estilos del chat -->
    <link rel="stylesheet" href="/assets/css/styleschat.css">

    <!-- FavIcon Added Here -->

    <!-- Link For Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500&display=swap"
        rel="stylesheet">

    <!-- Link For Google Icons  -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</head>

<body>
    <!-- chat-container for outgoing and outgoing chat-->
    <div class="chat-container"></div>


    <!-- User Pormpt Input Container Starts Here -->

    <div class="user-input-container">
        <div class="user-input-content">
            <div class="user-input-textarea">
                <textarea id="chat-input" placeholder="Enter para enviar tu mensaje" required></textarea>
                <span id="send-btn" class="material-symbols-rounded">send</span>
            </div>
            <div class="typing-controls">
                <span id="theme-btn" class="material-symbols-rounded">light_mode</span>
                <span id="delete-btn" class="material-symbols-rounded">delete</span>
                <span id="logout-btn" class="material-symbols-rounded">logout</span>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const PromptInput = $("#chat-input");
            const SendBtn = $("#send-btn");
            const ChatContainer = $(".chat-container");
            const ThemeBtn = $("#theme-btn");
            const DeleteBtn = $("#delete-btn");
            const LagoutBtn = $("#logout-btn");

            let UserPrompt = null;
            //diferenciar stilos mmsj entrada y saliente
            const CreateElement = (html, ClassName) => {
                const ChatDiv = $("<div></div>").addClass("chat " + ClassName).html(html);
                return ChatDiv;
            };


            const DataFromLocalStorage = () => {
                let ThemeSwitcher = localStorage.getItem("Theme-Switcher");
                $("body").toggleClass("light-mode", ThemeSwitcher === "light_mode");
                ThemeBtn.text(ThemeSwitcher || "light_mode");

                let AllChats = localStorage.getItem("All-Chats");
                if (AllChats) {
                    ChatContainer.html(AllChats);
                } else {
                    ChatContainer.html(`
                            <div class="Default-Text">
                                <h1>Tefi AI</h1>
                                <p>Consulta tus dudas ☺ !</p>
                            </div>
                        `);
                }
                ChatContainer.scrollTop(ChatContainer.prop("scrollHeight"));
            };

            DataFromLocalStorage();

            const GetGeminiResponses = async (IncominChatDiv) => {
                let PElement = $("<p></p>");
                try {
                    SendBtn.prop("disabled", true);
                    const Responses = await $.post('/chat-fetch', {
                        prompt: UserPrompt,
                        _token: "{{ csrf_token() }}"
                    });
                    PElement.html(Responses.result.trim());
                    PromptInput.val("");
                } catch (error) {

                    const errorMessage = error.responseJSON && error.responseJSON.message;
                    if (errorMessage && errorMessage.includes("LANGUAGE")) {
                        PElement.addClass("error");
                        PElement.text(
                            "Oops! I can only speak English. Please try again with different input.");
                    } else {
                        PElement.addClass("error");
                        PElement.text("Oops something went wrong while getting responses please try again");
                    }
                }
                IncominChatDiv.find(".loading-dots-animation").remove();
                IncominChatDiv.find(".chat-details").append(PElement);
                ChatContainer.scrollTop(ChatContainer.prop("scrollHeight"));
                localStorage.setItem("All-Chats", ChatContainer.html());
            };

            const CopyResponses = (CopyBtn) => {
                let ResponseText = $(CopyBtn).parent().find("p");
                navigator.clipboard.writeText(ResponseText.text());
                $(CopyBtn).text("done");
                setTimeout(() => $(CopyBtn).text("content_copy"), 1000);
            };

            const TypyingAnimation = () => {
                const html = `<div class="chat-content-box">
                                    <div class="chat-details">
                                        <img src="https://i.ibb.co/crKsfZc/blue-modern-robotic-logo.png" alt="chatbot-image">
                                        <div class="loading-dots-animation">
                                            <div class="loading-dot" style="--delay:0.2s;" ></div>
                                            <div class="loading-dot" style="--delay:0.3s;" ></div>
                                            <div class="loading-dot" style="--delay:0.4s;" ></div>
                                        </div>
                                    </div>
                                    <span class="material-symbols-rounded">content_copy</span>
                                </div>`;
                const IncominChatDiv = CreateElement(html, "incoming");
                ChatContainer.append(IncominChatDiv);
                ChatContainer.scrollTop(ChatContainer.prop("scrollHeight"));
                GetGeminiResponses(IncominChatDiv); // Getting Generated Responses
            };

            const OutgoinChat = () => {
                UserPrompt = PromptInput.val().trim();
                if (!UserPrompt) return;
                const html = `<div class="chat-content-box">
                                        <div class="chat-details">
                                       
                                            <img src="/assets/img/profiles/avator1.jpg" alt="user-image">
                                            <p></p>
                                        </div>
                                    </div>`;
                const OutgoinChatDiv = CreateElement(html, "outgoing");
                ChatContainer.append(OutgoinChatDiv);
                OutgoinChatDiv.find("p").text(UserPrompt);
                $(".Default-Text").remove();
                ChatContainer.scrollTop(ChatContainer.prop("scrollHeight"));
                setTimeout(TypyingAnimation, 500);
            };

            //botones chat
            ThemeBtn.on("click", () => {
                $("body").toggleClass("light-mode");
                localStorage.setItem("Theme-Switcher", ThemeBtn.text());
                ThemeBtn.text($("body").hasClass("light-mode") ? "dark_mode" : "light_mode");
            });

            DeleteBtn.on("click", () => {
                if (confirm("Estás seguro de que quieres eliminar todos los chats?")) {
                    localStorage.removeItem("All-Chats");
                }
                DataFromLocalStorage();
            });

            LagoutBtn.on("click", () => {
                if (confirm("Regresar al panel?")) {
                    localStorage.removeItem("All-Chats");
                    //volver a la vista dasboard
                    window.location.href = "/dashboard";
                }
                DataFromLocalStorage();
            });

            //Eventos en teclas y text
            let InitialHeight = PromptInput.prop("scrollHeight");

            PromptInput.on("input", () => {
                PromptInput.height(InitialHeight).height(PromptInput.prop("scrollHeight"));
            });

            PromptInput.on("keydown", (e) => {
                if (e.key === "Enter" && !e.shiftKey && $(window).width() > 800) {
                    e.preventDefault();
                    OutgoinChat();
                }
            });
            SendBtn.on("click", OutgoinChat);
        });
    </script>
</body>

</html>
