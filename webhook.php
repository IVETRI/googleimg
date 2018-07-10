<?php

require_once __DIR__ . "/kyle2142_PHPBot.php";
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/config.php";

$telegram = new kyle2142\PHPBot($TG_BOT_TOKEN);
$content = file_get_contents('php://input');
$update = json_decode($content, true);
// do stuff with $update:

$text = $update['message']['text'];
$chat_id = $update["message"]["chat"]["id"];
$callback_query = $telegram->Callback_Query();
$data = $update;
$message_id = $data["message"]["message_id"];
$username = $data["message"]["from"]["username"];

// Check if the text is a command
// /start message below
if(isset($update['message']['text']) and startsWith($update['message']['text'], "/")){
  $messageToSend = $text;
  if(startsWith($text, "/id")){
    $messageToSend = $chat_id;
  }
  $reply_markup = array(
    "inline_keyboard" => array(
      array(
        array(
            "text" => "Go InLine",
            "switch_inline_query" => " "
          )
      )
    )
  );
  $telegram->sendMessage(
    $chat_id,
    $messageToSend,
    array(
    "reply_to_message_id" => $message_id,
    "reply_markup" => json_encode($reply_markup)
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
      $telegram->sendMessage(
        $chat_id,
        "200 OK",
        array(
        "reply_to_message_id" => $message_id
      ));
    }
    else{
      $telegram->sendMessage(
        $chat_id,
        "403 F\r\n" . $mysqli->error,
        array(
        "reply_to_message_id" => $message_id
      ));
    }
  }
  if(startsWith($text, "/stats")){
    $query = "SELECT COUNT(DISTINCT `UURI`) AS `count` FROM $DB_TABLE_NAME WHERE 1;";
    $result = $mysqli->query($query);
    if($result->num_rows == 1){
      $row = $result->fetch_assoc();
      $count = $row["count"];
      $telegram->sendMessage(
        $chat_id,
        "DataBase Count: $count",
        array(
        "reply_to_message_id" => $message_id
      ));
    }
  }
}

// check for inline queries
if(isset($update["inline_query"]) and $update["inline_query"] != ""){
    $query = $update["inline_query"]["query"];
    $results = ObjToJson(GetImgUrl($query));
    $content = array(
        'inline_query_id' => $update["inline_query"]["id"],
        'cache_time' => "0",
        'is_personal' => "True",
        'results' => $results
    );
    $reply = $telegram->api->answerInlineQuery($content);
}
