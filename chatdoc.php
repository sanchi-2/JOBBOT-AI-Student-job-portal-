<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatDoc | JobBot AI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>

    <style>
        /* --- NAVBAR --- */
        .navbar { background: linear-gradient(90deg, #f3f8ff 0%, #fdf5ff 100%) !important; border-bottom: 1px solid #e0e0e0; padding: 12px 0; }
        .navbar-brand { color: #4a148c !important; font-weight: 700; }
        .btn-logout { background-color: #dc3545 !important; color: white !important; border-radius: 8px; padding: 6px 20px; text-decoration: none; font-weight: 600; margin-right: 15px; }

        body { background: #f8f9fa; min-height: 100vh; overflow: hidden; }

        /* --- UPLOAD VIEW --- */
        #uploadView { padding: 60px 20px; text-align: center; }
        .upload-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px dashed #c3b1e1;
            border-radius: 30px;
            padding: 80px 20px;
            margin: 40px auto;
            max-width: 800px;
            transition: 0.3s;
            cursor: pointer;
        }
        .upload-section:hover { border-color: #6a1b9a; background: white; }
        .btn-browse { background: linear-gradient(90deg, #a020f0, #6a1b9a); color: white; border: none; padding: 12px 50px; border-radius: 12px; font-weight: bold; }

        /* --- CHAT INTERFACE --- */
        #chatView { display: none; height: calc(100vh - 72px); }
        .sidebar { width: 260px; background: white; border-right: 1px solid #e0e0e0; padding: 20px; }
        .doc-viewer-container { flex: 1; background: #525659; display: flex; flex-direction: column; }
        .doc-toolbar { background: #323639; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .ai-panel { width: 350px; background: white; border-left: 1px solid #e0e0e0; display: flex; flex-direction: column; }
        
        #docFrame { width: 100%; height: 100%; border: none; background: white; }

        /* --- CHAT MESSAGES --- */
        .chat-messages { flex-grow: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; background: #fdfdfd; }
        .msg-ai { align-self: flex-start; background: #e9ecef; color: #333; padding: 10px 15px; border-radius: 15px 15px 15px 0; margin-bottom: 15px; max-width: 85%; }
        .msg-user { align-self: flex-end; background: #007bff; color: white; padding: 10px 15px; border-radius: 15px 15px 0 15px; margin-bottom: 15px; max-width: 85%; }

        .chat-input-container { padding: 15px; border-top: 1px solid #eee; }
        .chat-input-box { border: 1px solid #dee2e6; border-radius: 12px; padding: 10px; background: white; }
        .chat-input-box textarea { border: none; width: 100%; outline: none; resize: none; font-size: 0.9rem; }

        /* LOADING */
        #loadingOverlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255,255,255,0.9);
            z-index: 9999;
            justify-content: center; align-items: center; flex-direction: column;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php">JobBot AI</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>
</nav>

<div id="loadingOverlay">
    <div class="spinner-border text-primary"></div>
    <h5 class="mt-3">Analyzing Document...</h5>
</div>

<div id="uploadView" class="container">
    <h1 class="fw-bold mt-5"><span style="color: #007bff;">ChatDoc:</span> Chat with Word & PDF</h1>
    <p class="text-muted">Upload any document to start the AI analysis</p>

    <div class="upload-section shadow-sm" onclick="document.getElementById('fileInput').click()">
        <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" width="80">
        <div class="mt-3">
            <button class="btn btn-browse shadow mb-3">Browse File</button>
            <input type="file" id="fileInput" hidden accept=".pdf,.docx">
            <h5 class="fw-bold">Drag & Drop or click to upload</h5>
            <p class="text-secondary small">Supports .pdf and .docx</p>
        </div>
    </div>
</div>

<div id="chatView" class="d-flex">
    <div class="sidebar d-flex flex-column">
        <button class="btn btn-primary w-100 mb-3" onclick="location.reload()">+ New Chat</button>
        <div class="p-2 border rounded bg-light small text-truncate">
            <i class="bi bi-file-earmark-text me-2"></i>
            <span id="fileNameDisplay">document.docx</span>
        </div>
    </div>

    <div class="doc-viewer-container">
        <div class="doc-toolbar">
            <div id="docTitle">Document Preview</div>
            <div class="d-flex gap-3">
                <i class="bi bi-download" style="cursor:pointer"></i>
            </div>
        </div>
        <iframe id="docFrame"></iframe>
    </div>

    <div class="ai-panel">
        <div class="p-3 border-bottom text-center fw-bold text-secondary">AI ASSISTANT</div>
        <div class="chat-messages" id="chatMessages">
            <div class="msg-ai">Hello! I've processed your document. Ask me anything about it!</div>
        </div>
        <div class="chat-input-container">
            <div class="chat-input-box">
                <textarea rows="2" placeholder="Ask ChatDoc..." id="aiInput"></textarea>
                <div class="text-end mt-2">
                    <button class="btn btn-primary btn-sm rounded-circle" id="sendMsgBtn">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const uploadView = document.getElementById('uploadView');
    const chatView = document.getElementById('chatView');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const docFrame = document.getElementById('docFrame');
    const aiInput = document.getElementById('aiInput');
    const msgBox = document.getElementById('chatMessages');

    fileInput.onchange = function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            loadingOverlay.style.display = 'flex';
            document.getElementById('fileNameDisplay').innerText = file.name;

            const reader = new FileReader();

            if (file.name.endsWith('.docx')) {
                reader.onload = function(event) {
                    const arrayBuffer = event.target.result;
                    mammoth.convertToHtml({arrayBuffer: arrayBuffer})
                        .then(function(result) {
                            const doc = docFrame.contentWindow.document;
                            doc.open();
                            doc.write(`
                                <body style="font-family: Arial, sans-serif; padding: 40px; line-height: 1.6; color: #333;">
                                    ${result.value}
                                </body>
                            `);
                            doc.close();
                            showInterface();
                        });
                };
                reader.readAsArrayBuffer(file);
            } 
            else if (file.name.endsWith('.pdf')) {
                const fileURL = URL.createObjectURL(file);
                docFrame.src = fileURL;
                showInterface();
            }
        }
    };

    function showInterface() {
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
            uploadView.style.display = 'none';
            chatView.style.display = 'flex';
        }, 1200);
    }

    function sendMessage() {
        const text = aiInput.value.trim();
        if(text !== "") {
            msgBox.innerHTML += `<div class='msg-user'>${text}</div>`;
            aiInput.value = "";
            msgBox.scrollTop = msgBox.scrollHeight;

            setTimeout(() => {
                msgBox.innerHTML += `<div class='msg-ai'>Analyzing the document... Based on your file, I found relevant information regarding: "${text}".</div>`;
                msgBox.scrollTop = msgBox.scrollHeight;
            }, 800);
        }
    }

    document.getElementById('sendMsgBtn').onclick = sendMessage;

    // Support for Enter key
    aiInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });
</script>

</body>
</html>