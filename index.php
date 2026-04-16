<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>JobBot | Student Job Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* --- NAVBAR SETTINGS (IMAGE 2 STYLE) --- */
.navbar {
    background: linear-gradient(90deg, #f3f8ff 0%, #fdf5ff 100%) !important; 
    border-bottom: 1px solid #e0e0e0;
    padding: 12px 0;
}

.navbar-brand {
    color: #4a148c !important; 
    font-weight: 700;
    font-size: 1.4rem;
}

/* Updated Logout Button Styling */
.btn-logout {
    background-color: #dc3545 !important; /* Red for Logout */
    color: white !important;
    border-radius: 8px;
    padding: 6px 20px;
    font-weight: 600;
    border: none;
    margin-right: 15px;
    text-decoration: none;
    display: inline-block;
}

.btn-logout:hover {
    background-color: #a71d2a !important;
}

/* Hamburger Icon */
.nav-link.fs-4 {
    color: #333 !important;
}

/* Modern Dropdown */
.dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #eee;
    padding: 15px;
    min-width: 260px;
}

.my-library-btn {
    border: 1px solid #9c27b0;
    color: #9c27b0 !important;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 10px;
    font-weight: 500;
}

.menu-label {
    font-size: 0.7rem;
    color: #999;
    text-transform: uppercase;
    font-weight: 700;
    margin: 10px 0 5px 12px;
}

.upgrade-btn {
    background-color: #f06292 !important;
    color: white !important;
    border-radius: 20px;
    text-align: center;
    font-weight: 700;
    margin-top: 10px;
}

/* --- YOUR ORIGINAL WORKING CSS --- */
.active-menu {
    background-color: #f0f4ff !important;
    color: #007bff !important;
    border-radius: 5px;
}

.dropdown-submenu .dropdown-menu {
    display: none;
    margin-left: 10px;
}

/* CHATBOT SYMBOL UP */
#chatbot-btn {
    position: fixed;
    bottom: 100px; 
    right: 20px;
    font-size: 35px;
    cursor: pointer;
    z-index: 1000;
}

#chatbot-box {
    display: none; /* JS will change this to 'flex' */
    flex-direction: column; 
    position: fixed;
    bottom: 150px; 
    right: 20px;
    width: 320px;
    height: 400px; /* Set a height so flex works well */
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    z-index: 1000;
}

.chat-body {
    flex-grow: 1; /* Makes the body take up available space */
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
}

.typing {
    font-style: italic;
    color: #888;
    font-size: 0.8rem;
}
.chat-header { background: #007bff; color: white; padding: 10px; display: flex; justify-content: space-between; }
.chat-body { height: 200px; overflow-y: auto; padding: 10px; }
.bot-msg { background: #eee; padding: 5px; margin: 5px 0; border-radius: 5px; }
.user-msg { background: #007bff; color: white; padding: 5px; margin: 5px 0; border-radius: 5px; text-align: right; }
.chat-footer { display: flex; }
.chat-footer input { flex: 1; padding: 8px; border: none; }
.chat-footer button { background: #007bff; color: white; border: none; padding: 8px; }

.hero { background: linear-gradient(135deg, #007bff, #00c6ff); color: white; padding: 60px; }
.job-card:hover { transform: scale(1.05); transition: 0.3s; }

/* FOOTER 2026 LINE DOWN */
footer {
    background: #212529;
    color: white;
    padding: 30px 0; 
    margin-top: 20px;
}
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand" href="#">JobBot AI</a>

<div class="ms-auto d-flex align-items-center">
    <a href="logout.php" class="btn btn-logout">Logout</a>

    <div class="dropdown">
        <a class="nav-link fs-4" href="#" data-bs-toggle="dropdown">☰</a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item my-library-btn" href="#">📖 My Library</a></li>

            <div class="menu-label">Study and Work</div>
             <li><a class="dropdown-item" href="javascript:void(0);" id="navAiChat">💬 AI Chat</a></li>
            <li><a class="dropdown-item" href="chatpdf.php">📄 ChatPDF</a></li>
            
            <li><a class="dropdown-item" href="chatdoc.php">📁 AI Document</a></li>

            <div class="menu-label">Employment</div>
            <li class="dropdown-submenu">
                <a class="dropdown-item" href="#" onclick="toggleSubmenu(event)">💼 Jobs ▶</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Frontend Developer</a></li>
                    <li><a class="dropdown-item" href="#">Backend Developer</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>

<section class="hero text-center">
<div class="container">
<h1>Find Your Dream Job</h1>
<p>AI-powered student assistance & job guidance</p>
<a href="jobs.php" class="btn btn-light">Get Started</a>
</div>
</section>

<section class="container my-5">
<h3 class="mb-4">Latest Jobs</h3>
<div class="row">
    <div class="col-md-4">
        <div class="card job-card"><div class="card-body"><h5>Frontend Developer</h5><p>HTML, CSS, JS</p></div></div>
    </div>
    <div class="col-md-4">
        <div class="card job-card"><div class="card-body"><h5>Data Analyst</h5><p>Excel, SQL, Python</p></div></div>
    </div>
    <div class="col-md-4">
        <div class="card job-card"><div class="card-body"><h5>PHP Intern</h5><p>PHP, MySQL</p></div></div>
    </div>
</div>
</section>

<footer class="text-center">
<div class="container">
© 2026 JobBot | AI Student Assistant
</div>
</footer>

<div id="chatbot-btn">🤖</div>
<div id="chatbot-box">
    <div class="chat-header">
        <span>JobBot Assistant</span>
        <span id="closeChat" style="cursor:pointer">✖</span>
    </div>
    <div class="chat-body" id="chatBody"></div>
    <div class="chat-footer">
        <input type="text" id="userInput" placeholder="Say 'hello'...">
        <button id="sendBtn">Send</button>
    </div>
</div>





<script>
document.getElementById("chatbot-btn").onclick = () =>
document.getElementById("chatbot-box").style.display = "block";

document.getElementById("closeChat").onclick = () =>
document.getElementById("chatbot-box").style.display = "none";

function toggleSubmenu(e){
    e.preventDefault();
    e.stopPropagation(); 
    let submenu = e.target.nextElementSibling;
    submenu.style.display = submenu.style.display === "block" ? "none" : "block";
}

const items = document.querySelectorAll(".dropdown-item");
items.forEach(item => {
    item.addEventListener("click", function () {
        items.forEach(i => i.classList.remove("active-menu"));
        this.classList.add("active-menu");
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="chatbot.js"></script>
</body>
</html>