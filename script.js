const form = document.getElementById("replyForm");
const messageInput = document.getElementById("message");
const toneInput = document.getElementById("tone");

const generateBtn = document.getElementById("generateBtn");
const btnText = document.getElementById("btnText");
const loadingText = document.getElementById("loadingText");

const resultCard = document.getElementById("resultCard");
const replyBox = document.getElementById("replyBox");

const messageError = document.getElementById("messageError");
const toneError = document.getElementById("toneError");

const copyBtn = document.getElementById("copyBtn");
const regenerateBtn = document.getElementById("regenerateBtn");
const clearBtn = document.getElementById("clearBtn");
const copySuccess = document.getElementById("copySuccess");

let lastMessage = "";
let lastTone = "";

form.addEventListener("submit", function (event) {
    event.preventDefault();
    generateReply();
});

async function generateReply() {
    const message = messageInput.value.trim();
    const tone = toneInput.value.trim();

    messageError.textContent = "";
    toneError.textContent = "";
    copySuccess.style.display = "none";

    let hasError = false;

    if (message === "") {
        messageError.textContent = "Please paste an email or message first.";
        hasError = true;
    }

    if (tone === "") {
        toneError.textContent = "Please choose a reply tone.";
        hasError = true;
    }

    if (hasError) {
        return;
    }

    lastMessage = message;
    lastTone = tone;

    generateBtn.disabled = true;
    btnText.textContent = "Generating...";
    loadingText.style.display = "block";

    try {
        const formData = new FormData();
        formData.append("message", message);
        formData.append("tone", tone);

        const response = await fetch("generate.php", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            replyBox.textContent = data.reply;
            resultCard.style.display = "block";
        } else {
            replyBox.textContent = data.error || "Something went wrong.";
            resultCard.style.display = "block";
        }

    } catch (error) {
        replyBox.textContent = "Error connecting to the server. Please try again.";
        resultCard.style.display = "block";
    }

    generateBtn.disabled = false;
    btnText.textContent = "Generate Reply";
    loadingText.style.display = "none";
}

copyBtn.addEventListener("click", function () {
    const replyText = replyBox.textContent.trim();

    if (replyText === "" || replyText === "Your AI-generated reply will appear here.") {
        return;
    }

    navigator.clipboard.writeText(replyText);

    copySuccess.style.display = "block";

    setTimeout(function () {
        copySuccess.style.display = "none";
    }, 2000);
});

regenerateBtn.addEventListener("click", function () {
    if (lastMessage !== "" && lastTone !== "") {
        messageInput.value = lastMessage;
        toneInput.value = lastTone;
        generateReply();
    }
});

clearBtn.addEventListener("click", function () {
    messageInput.value = "";
    toneInput.value = "";
    replyBox.textContent = "Your AI-generated reply will appear here.";
    resultCard.style.display = "none";
    messageError.textContent = "";
    toneError.textContent = "";
    copySuccess.style.display = "none";
    lastMessage = "";
    lastTone = "";
});