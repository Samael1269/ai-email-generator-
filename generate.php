<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "error" => "Invalid request method."
    ]);
    exit;
}

$message = trim($_POST["message"] ?? "");
$tone = trim($_POST["tone"] ?? "");

if ($message === "") {
    echo json_encode([
        "success" => false,
        "error" => "Please paste an email or message first."
    ]);
    exit;
}

if ($tone === "") {
    echo json_encode([
        "success" => false,
        "error" => "Please choose a reply tone."
    ]);
    exit;
}

/*
    Load API key from .env file
    .env format:
    DEEPSEEK_API_KEY=sk-your-api-key-here
*/
$envPath = __DIR__ . "/.env";

if (!file_exists($envPath)) {
    echo json_encode([
        "success" => false,
        "error" => ".env file not found."
    ]);
    exit;
}

$env = parse_ini_file($envPath);

$apiKey = trim($env["DEEPSEEK_API_KEY"] ?? "");

if (!$apiKey) {
    echo json_encode([
        "success" => false,
        "error" => "DeepSeek API key is missing. Please check your .env file."
    ]);
    exit;
}


$userPrompt = "Write a clear and natural email reply using a $tone tone.

Original email/message:
$message

Rules:
- Keep it concise.
- Make it sound human.
- Do not mention that you are an AI.
- Only return the email reply.";

$data = [
    "model" => "deepseek-chat",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a helpful assistant that writes professional and natural email replies."
        ],
        [
            "role" => "user",
            "content" => $userPrompt
        ]
    ],
    "temperature" => 0.7,
    "max_tokens" => 300,
    "stream" => false
];

$ch = curl_init("https://api.deepseek.com/chat/completions");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode([
        "success" => false,
        "error" => "cURL error: " . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

if ($httpCode !== 200) {
    echo json_encode([
        "success" => false,
        "error" => $result["error"]["message"] ?? "DeepSeek API request failed."
    ]);
    exit;
}

$reply = $result["choices"][0]["message"]["content"] ?? "";

if ($reply === "") {
    echo json_encode([
        "success" => false,
        "error" => "No reply was generated."
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "reply" => $reply
]);