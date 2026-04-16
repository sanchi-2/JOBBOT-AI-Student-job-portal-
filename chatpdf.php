<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ChatPDF | JobBot AI</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* --- NAVBAR SETTINGS --- */
    .navbar { background: linear-gradient(90deg, #f3f8ff 0%, #fdf5ff 100%) !important; border-bottom: 1px solid #e0e0e0; padding: 12px 0; }
    .navbar-brand { color: #4a148c !important; font-weight: 700; }
    .btn-logout { background-color: #dc3545 !important; color: white !important; border-radius: 8px; padding: 6px 20px; text-decoration: none; font-weight: 600; margin-right: 15px; }

    body { background: #f8f9fa; min-height: 100vh; overflow-x: hidden; }

    /* --- VIEW 1: UPLOAD BOX --- */
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

    /* --- VIEW 2: CHAT INTERFACE (image_24c09e style) --- */
    #chatView { display: none; height: calc(100vh - 72px); }
    .sidebar { width: 260px; background: white; border-right: 1px solid #e0e0e0; padding: 20px; }
    .pdf-viewer-container { flex: 1; background: #525659; display: flex; flex-direction: column; }
    .pdf-toolbar { background: #323639; color: white; padding: 8px 20px; display: flex; justify-content: space-between; align-items: center; }
    .ai-panel { width: 350px; background: white; border-left: 1px solid #e0e0e0; display: flex; flex-direction: column; }
    
    /* PDF Preview Frame */
    #pdfFrame { width: 100%; height: 100%; border: none; }

    /* AI Chat Input Area */
    .chat-input-container { padding: 20px; border-top: 1px solid #eee; }
    .chat-input-box { border: 1px solid #dee2e6; border-radius: 12px; padding: 10px; background: #fff; }
    .chat-input-box textarea { border: none; width: 100%; outline: none; resize: none; }

    /* LOADING OVERLAY */
    #loadingOverlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255,255,255,0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="index.php">JobBot AI</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="logout.php" class="btn btn-logout">Logout</a>
            <button class="btn fs-4">☰</button>
        </div>
    </div>
</nav>

<div id="loadingOverlay">
    <div class="spinner-border text-primary" role="status"></div>
    <h5 class="mt-3">Analyzing your PDF...</h5>
</div>

<div id="uploadView" class="container">
    <h1 class="fw-bold"><span style="color: #2d8a4e;">ChatPDF:</span> Chat with Any PDF & Summarize Free</h1>
    <p class="text-muted">Upload your document to start chatting with AI</p>

    <div class="upload-section shadow-sm" onclick="document.getElementById('fileInput').click()">
        <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" width="80" alt="PDF Icon">
        <div class="mt-3">
            <button class="btn btn-browse shadow mb-3">Browse File</button>
            <input type="file" id="fileInput" hidden accept=".pdf">
            <h5 class="fw-bold">Drag & Drop, or Choose PDF to upload</h5>
            <p class="text-secondary small">Your data is safe and secure.</p>
        </div>
    </div>
</div>

<div id="chatView" class="d-flex">
    <div class="sidebar d-flex flex-column">
        <div class="mb-4">
            <button class="btn btn-outline-primary w-100 mb-2"><i class="bi bi-plus-lg"></i> New Folder</button>
            <button class="btn btn-primary w-100"><i class="bi bi-file-earmark-plus"></i> New File</button>
        </div>
        <div class="flex-grow-1 overflow-auto">
            <div class="p-2 bg-light rounded d-flex align-items-center mb-2">
                <i class="bi bi-file-pdf text-danger fs-4 me-2"></i>
                <div class="small text-truncate">
                    <strong id="fileNameDisplay">document.pdf</strong><br>
                    <span class="text-muted" id="fileSizeDisplay">0 KB</span>
                </div>
            </div>
        </div>
    </div>

    <div class="pdf-viewer-container">
        <div class="pdf-toolbar">
            <div id="pdfTitle">Document Preview</div>
            <div class="d-flex gap-3">
                <i class="bi bi-zoom-in" style="cursor:pointer"></i>
                <i class="bi bi-download" style="cursor:pointer"></i>
            </div>
        </div>
        <iframe id="pdfFrame"></iframe>
    </div>

    <div class="ai-panel">
        <div class="p-3 border-bottom d-flex gap-2">
            <button class="btn btn-sm btn-primary px-3">AI Chat</button>
            <button class="btn btn-sm btn-light px-3">Notebook</button>
        </div>
        
        <div class="flex-grow-1 p-3 overflow-auto" id="chatMessages">
            <div class="alert alert-info small">
                <strong>AI:</strong> I've analyzed your document. What would you like to know?
            </div>
        </div>

        <div class="chat-input-container">
            <div class="chat-input-box">
                <textarea rows="2" placeholder="Ask me anything..." id="aiInput"></textarea>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="text-muted small">Shift + Enter for newline</span>
                    <button class="btn btn-primary btn-sm rounded-circle" id="sendMsgBtn">
                        <i class="bi bi-send"></i>
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
    const pdfFrame = document.getElementById('pdfFrame');

    fileInput.onchange = function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // 1. Show Loading
            loadingOverlay.style.display = 'flex';

            // 2. Simulate AI Processing
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
                uploadView.style.display = 'none';
                chatView.classList.add('d-flex'); // Show the chat UI
                
                // Set file info in sidebar
                document.getElementById('fileNameDisplay').innerText = file.name;
                document.getElementById('fileSizeDisplay').innerText = (file.size / 1024 / 1024).toFixed(2) + " MB";

                // Preview the PDF
                const fileURL = URL.createObjectURL(file);
                pdfFrame.src = fileURL;
            }, 2000); // 2 second delay for realism
        }
    };

    // Chat Message Logic
    document.getElementById('sendMsgBtn').onclick = function() {
        const input = document.getElementById('aiInput');
        if(input.value.trim() !== "") {
            const msgBox = document.getElementById('chatMessages');
            msgBox.innerHTML += `<div class='mb-2 text-end'><strong>You:</strong> ${input.value}</div>`;
            input.value = "";
            
            // Fake AI Response
            setTimeout(() => {
                msgBox.innerHTML += `<div class='alert alert-info small'><strong>AI:</strong> Based on the document, this section describes your experience...</div>`;
                msgBox.scrollTop = msgBox.scrollHeight;
            }, 1000);
        }
    };
</script>

</body>
</html>