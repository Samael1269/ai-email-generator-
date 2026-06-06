<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Email Reply Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="page-wrapper">

    <div class="header">
        <div class="logo-box">
            <i class="fa-regular fa-envelope"></i>
        </div>

        <h1>AI Email Reply Generator</h1>
        <p>Generate professional email replies using AI</p>
    </div>

    <div class="card">
        <form id="replyForm">

            <div class="form-group">
                <label for="message">Paste the email or message you received</label>
                <textarea 
                    id="message" 
                    name="message" 
                    placeholder="Hi there, I wanted to follow up on our previous conversation about the project proposal. Could you please update me on the current status and next steps?"
                ></textarea>

                <small>Your message will be sent to the AI API to generate a reply.</small>
                <p class="error-text" id="messageError"></p>
            </div>

            <div class="form-group">
                <label for="tone">Choose reply tone</label>
                <select id="tone" name="tone">
                    <option value="">Select tone</option>
                    <option value="Friendly">Friendly</option>
                    <option value="Professional">Professional</option>
                    <option value="Formal">Formal</option>
                    <option value="Short">Short</option>
                    <option value="Apologetic">Apologetic</option>
                </select>

                <p class="error-text" id="toneError"></p>
            </div>

            <button type="submit" class="generate-btn" id="generateBtn">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span id="btnText">Generate Reply</span>
            </button>

            <p class="loading-text" id="loadingText">
                <i class="fa-solid fa-spinner fa-spin"></i>
                Generating your reply...
            </p>

        </form>
    </div>

    <div class="card result-card" id="resultCard">
        <h2>Generated Reply</h2>

        <div class="reply-box" id="replyBox">
            Your AI-generated reply will appear here.
        </div>

        <p class="success-text" id="copySuccess">Copied to clipboard.</p>

        <div class="action-row">
            <button class="secondary-btn" id="copyBtn">
                <i class="fa-regular fa-copy"></i>
                Copy Reply
            </button>

            <button class="secondary-btn" id="regenerateBtn">
                <i class="fa-solid fa-rotate"></i>
                Regenerate
            </button>

            <button class="clear-btn" id="clearBtn">
                <i class="fa-regular fa-trash-can"></i>
                Clear
            </button>
        </div>
    </div>

</div>

<script src="script.js"></script>
</body>
</html>