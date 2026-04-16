const chatBtn = document.getElementById("chatbot-btn");
const chatBox = document.getElementById("chatbot-box");
const closeChat = document.getElementById("closeChat");
const sendBtn = document.getElementById("sendBtn");
const navAiChat = document.getElementById("navAiChat");
const chatBody = document.getElementById("chatBody");

let currentStep = "start";
let userEducation = "";
let userSkills = "";

// --- OPEN/CLOSE LOGIC ---
function openChat() {
    chatBox.style.display = "flex";
    if (chatBody.innerHTML === "") {
        chatBody.innerHTML = `<div class="bot-msg">Hello 👋 I am JobBot!</div>`;
    }
}

chatBtn.onclick = openChat;

if (navAiChat) {
    navAiChat.onclick = (e) => {
        e.preventDefault();
        openChat();
        document.getElementById("userInput").focus();
    };
}

closeChat.onclick = () => {
    chatBox.style.display = "none";
};

// --- TYPING ANIMATION ---
function showTyping() {
    const typingDiv = document.createElement("div");
    typingDiv.className = "bot-msg typing";
    typingDiv.id = "typing-indicator";
    typingDiv.innerText = "Typing...";
    chatBody.appendChild(typingDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function removeTyping() {
    const indicator = document.getElementById("typing-indicator");
    if (indicator) indicator.remove();
}

// --- MESSAGE HANDLING ---
sendBtn.onclick = () => {
    const input = document.getElementById("userInput");
    const msg = input.value.trim();
    if (!msg) return;

    // Add User Message
    chatBody.innerHTML += `<div class="user-msg">${msg}</div>`;
    chatBody.scrollTop = chatBody.scrollHeight;
    input.value = "";

    showTyping();

    setTimeout(() => {
        removeTyping();
        let reply = "";
        const message = msg.toLowerCase();

        // STEP FLOW LOGIC
        if (currentStep === "start") {
            if (message.includes("hello") || message.includes("hi")) {
                reply = "How are you? 😊";
                currentStep = "askHowAreYou";
            } else {
                reply = "Say 'hello' to start 😊";
            }
        } 
        else if (currentStep === "askHowAreYou") {
            if (message.includes("what about you") || message.includes("and you")) {
                reply = "I'm doing great too 😄 Can you tell me your education? 🎓";
            } else {
                reply = "Glad to hear that 😊 Can you tell me your education? 🎓";
            }
            currentStep = "askEducation";
        } 
        else if (currentStep === "askEducation") {
            userEducation = message;
            reply = "Nice! 👍 What skills do you have? (Java, Python, SQL...)";
            currentStep = "askSkills";
        } 
        else if (currentStep === "askSkills") {
            userSkills = message;
            reply = suggestJob(userEducation, userSkills);
            currentStep = "done";
        } 
        else {
            reply = getBotReply(message);
        }

        chatBody.innerHTML += `<div class="bot-msg">${reply}</div>`;
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 1000);
};

// Allow Enter Key to Send
document.getElementById("userInput").addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendBtn.click();
});

// --- SUGGESTION & SMART REPLIES ---
function suggestJob(edu, skills) {
    if (edu.includes("mca") || edu.includes("bca") || edu.includes("btech")) {
        if (skills.includes("java")) {
            return `💼 You can become a Java Developer! <br><a href="https://www.linkedin.com/jobs/java-developer-jobs" target="_blank">Apply Now</a>`;
        }
        if (skills.includes("python")) {
            return `🐍 You can become a Data Analyst! <br><a href="https://www.linkedin.com/jobs/python-developer-jobs" target="_blank">Apply Now</a>`;
        }
    }
    return `💼 Explore jobs here: <br><a href="https://www.linkedin.com/jobs/" target="_blank">Browse LinkedIn</a>`;
}

function getBotReply(message) {
    if (message.includes("resume")) return "📄 Keep your resume to 1 page and highlight projects!";
    if (message.includes("interview")) return "🎤 Practice your introduction and basic coding questions.";
    return "Try asking about 'jobs' or 'resume'.";
}