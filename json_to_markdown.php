<?php

$jsonData = file_get_contents('1f856d64-0e25-4b74-a9fd-e24b0035d36b.json');
$saveTo = '1f856d64-0e25-4b74-a9fd-e24b0035d36b.md';

// Decode JSON data
$conversationData = json_decode($jsonData, true);

if ($conversationData === null) {
    echo "Invalid JSON data.";
    exit;
}

function extractData($conversationData) {
    // Extracting conversation details if available
    $title = $conversationData['title'] ?? 'Untitled Conversation';
    $createTime = $conversationData['create_time'] ?? time();
    $updateTime = $conversationData['update_time'] ?? time();
    $messages = $conversationData['mapping'] ?? [];

    // Start building Markdown content
    $markdown = "# $title\n\n";
    $markdown .= "### Conversation Details\n";
    //$markdown .= "- **Create Time:** " . date('Y-m-d H:i:s', $createTime) . "\n";
    if (isset($conversationData['create_time'])) {
        $markdown .= "- **Create Time:** " . date('Y-m-d H:i:s', strtotime($createTime)) . "\n";
    }
    //$markdown .= "- **Update Time:** " . date('Y-m-d H:i:s', $updateTime) . "\n\n";
    if (isset($conversationData['update_time'])) {
        $markdown .= "- **Update Time:** " . date('Y-m-d H:i:s', strtotime($updateTime)) . "\n\n";
    }

    $markdown .= "### Conversation:\n";

    // Loop through messages if available
    if (!empty($messages)) {
        foreach ($messages as $message) {
            if (isset($message['message']['content']['parts'][0])) {
                // Extracting role and actual message
                $content = $message['message']['content']['parts'][0];
                $role = ucfirst($message['message']['author']['role']);

                // check if User Message, then get first line of message only
                if ($role == 'User') {
                    continue;
                    $content = explode("\n", $content)[0];
                }

                // check if Assistant Message, then get first two lines of message only
                if ($role == 'Assistant') {
                    //$content = explode("\n", $content)[0] . "\n" . explode("\n", $content)[1];
                }

                $markdown .= "#### $role Message\n";
                $markdown .= "```\n$content\n```\n\n";
            }
        }
    } else {
        $markdown .= "No messages found in the conversation.\n";
    }

    // Output the Markdown
    #echo $markdown;
    return $markdown;
}

//echo extractData($conversationData);

// save to file
// exit if file already exists
if (file_exists($saveTo)) {
    echo "File already exists.";
    exit;
}
if (file_put_contents($saveTo, extractData($conversationData))) {
    echo "File saved successfully.";
} else {
    echo "Error saving file.";
}
?>
