<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userPrompt = $_POST['prompt'];

    // Prepare the data to send to Ollama
    $postData = json_encode([
        'model' => 'gemma3:1b',
        'prompt' => $userPrompt,
        'stream' => false
    ]);

    $ch = curl_init('http://localhost:11434/api/generate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
     
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $aiResponse = $responseData['response'] ?? 'No response from model.';
}
?>
h1 {
            text-align: center;
            margin-bottom: 20px;
        }
<!DOCTYPE html>
<html>
<head>
    <title>DeepSeek Chat</title>
</head>
<body>
    <h1>Chat with DeepSeek</h1>
    <form method="post">
        <input type="text" name="prompt" placeholder="Ask something..." required>
        <button type="submit">Send</button>
    </form>

    <?php if (!empty($aiResponse)): ?>
        <h3><strong>AI Response:</strong></h3>
        <p><?= nl2br(htmlspecialchars($aiResponse)) ?></p>
    <?php endif; ?>
</body>
</html>
