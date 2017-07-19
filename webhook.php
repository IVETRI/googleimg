<?php
require_once __DIR__ . '/config.php';

// Set the bot TOKEN
$bot_id = $GLOBALS["TG_BOT_TOKEN"];
// Instances the class
$telegram = new Telegram($bot_id);

// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();

$callback_query = $telegram->Callback_Query();
$data = $telegram->getData();
$message_id = $data["message"]["message_id"];
$username = $data["message"]["from"]["username"];

// Check if the text is a command
if (!is_null($text) && !is_null($chat_id)) {
  if($text == "/id"){
    $messageToSend = $chat_id;
  }
  else {
    $messageToSend = $text;
  }
  $telegram->sendMessage(array(
    "chat_id" => $chat_id,
    "text" => $messageToSend,
    "reply_to_message_id" => $message_id,
    "reply_markup" => array(
      "inline_keyboard" => array(
        array(
          array(
              "text" => "Go Inline",
              "switch_inline_query" => $text
            )
        )
      )
    )
  ));
}

if(in_array($chat_id, $GLOBALS["TG_ADMIN_IDS"])){
  if($data["message"]["photo"]){
    $caption = $data["message"]["caption"];
    $uuri = $data["message"]["photo"][0]["file_id"];
    $tagS = explode(" ", $caption);
    $tag = urlencode(implode("###", $tagS));
    $query = "INSERT INTO $DB_TABLE_NAME(`TAGS`, `UURI`) VALUES ('$tag', '$uuri');";
    if($mysqli->query($query) === TRUE){
      $telegram->sendMessage(array(
        "chat_id" => $chat_id,
        "text" => "200 OK",
        "reply_to_message_id" => $message_id
      ));
    }
  }
}

// check for inline queries
if ($data["inline_query"] !== null && $data["inline_query"] != "") {
    $query = $data["inline_query"]["query"];
    $results = ObjToJson(GetImgUrl($query));
    $content = array(
        'inline_query_id' => $data["inline_query"]["id"],
        'cache_time' => "300",
        'is_personal' => "False",
        'results' => $results
    );
    $reply = $telegram->answerInlineQuery($content);
}
