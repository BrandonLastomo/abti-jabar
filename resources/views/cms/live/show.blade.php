<!DOCTYPE html>
<html>

<head>
    <title>YouTube Live</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 30px;
        }

        /* container utama */
        .container {
            max-width: 1200px;
            margin: auto;
        }

        /* layout video + chat */
        .wrapper {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        /* card */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }

        /* video section */
        .video-box {
            flex: 2;
        }

        .video-box iframe {
            width: 100%;
            height: 450px;
            border-radius: 10px;
        }

        /* chat section */
        .chat-box-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #chat-box {
            height: 420px;
            overflow: auto;
            border-radius: 10px;
            background: #fafafa;
            padding: 15px;
        }

        /* chat message */
        .message {
            margin-bottom: 10px;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }

        .username {
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>🔴 YouTube Live Stream - {{$live->title}}</h2>

        <div class="wrapper">

            <!-- VIDEO -->
            <div class="card video-box">
                <iframe
                    id="ytplayer"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- CHAT -->
            <div class="card chat-box-container">

                <div class="chat-title">💬 Live Chat</div>

                <div id="chat-box"></div>

            </div>

        </div>
    </div>

    <script>
        const VIDEO_ID = "{{ $videoId }}";

        document.getElementById("ytplayer").src =
            `https://www.youtube.com/embed/${VIDEO_ID}?autoplay=1`;

        let liveChatId = "";
        let nextPageToken = "";

        // ambil liveChatId
        async function fetchLiveChatId() {
            const res = await fetch(`/youtube/livechat/${VIDEO_ID}`);
            const data = await res.json();
            liveChatId = data.liveChatId;
            startChatPolling();
        }

        // polling chat
        async function startChatPolling() {

            setInterval(async () => {

                const res = await fetch(`/youtube/chat/messages?liveChatId=${liveChatId}&pageToken=${nextPageToken}`);
                const data = await res.json();

                nextPageToken = data.nextPageToken;

                data.items.forEach(msg => {

                    const name = msg.authorDetails.displayName;
                    const text = msg.snippet.displayMessage;

                    const div = document.createElement("div");
                    div.classList.add("message");

                    div.innerHTML = `
<span class="username">${name}</span><br>
<span>${text}</span>
`;

                    document.getElementById("chat-box").appendChild(div);

                });

                let chatBox = document.getElementById("chat-box");
                chatBox.scrollTop = chatBox.scrollHeight;

            }, 2000);

        }

        fetchLiveChatId();
    </script>

</body>

</html>