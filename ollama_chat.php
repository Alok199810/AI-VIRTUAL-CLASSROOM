<!DOCTYPE html>
<html>
<head>
    <title>Ollama Chat</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] { width: 300px; padding: 8px; }
        button { padding: 8px 12px; }
        .response { margin-top: 20px; background: #f4f4f4; padding: 15px; border-radius: 5px; width: 70%; }
    </style>
</head>
<body>
    <h2>Ask DeepSeek (Offline via Ollama)</h2>
    <form method="POST">
        <input type="text" name="user_input" placeholder="Type your question..." required />
        <button type="submit">Ask</button>
    </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST["user_input"];

    $data = [
        "model" => "deepseek-coder",  // Or the name you're running
        "prompt" => $user_input,
        "stream" => false
    ];

    $ch = curl_init("http://localhost:11434/api/generate");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $reply = $responseData["response"] ?? "No response received.";

    echo "<div class='response'><strong>DeepSeek:</strong><br>" . nl2br(htmlspecialchars($reply)) . "</div>";
}
?>
</body>
</html>
