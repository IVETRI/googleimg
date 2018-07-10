<?php

function startsWith($haystack, $needle) {
  $length = strlen($needle);
  return (substr($haystack, 0, $length) === $needle);
}

// <=> https://stackoverflow.com/a/834355/4723940

function endsWith($haystack, $needle) {
  $length = strlen($needle);
  if ($length == 0) {
      return true;
  }
  return (substr($haystack, -$length) === $needle);
}

function fetch_website($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function ObjToJson($obj){
  return json_encode($obj);
}

function JsonToObj($json){
  // => http://webtutsdepot.com/2009/08/31/how-to-read-json-data-with-php/
  return json_decode($json, true);
}

function GetimgUrlFromDB($search_str, $i = 0){
  $returnArray = array();
  $query = "SELECT * FROM $DB_TABLE_NAME WHERE `TAGS` LIKE '%$search_str%' ORDER BY `ID` DESC LIMIT 0 , 45;";
  $result = $mysqli->query($query);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $a = urldecode($row["TAGS"]);
      $tagS = explode("###", $a);
      $uuri = $row["UURI"];
      $tags = implode(",",$tagS);
      $type = "photo";
      $id = strval($i);
      $photo_url = $uuri;
      $thumb_url = $uuri;
      // $photo_width = 150;
      // $photo_height = 150;
      // $title = $tags;
      // $description = $tags;
      // $caption = "";//$images["htmlTitle"];
      $reply_markup = array(
        "inline_keyboard" => array(
          array(
            array(
                "text" => "Search Again",
                "switch_inline_query_current_chat" => $search_str
            )
          ),
          array(
            array(
                "text" => "GROUP",
                "url" => "https://t.me/GROUPLINK"
            ),
            array(
              "text" => "CHANNEL",
              "url" => "https://t.me/CHANNELLINK"
            )
          )
        )
      );
      $r = array(
        "type" => $type,
        "id" => $id,
        "photo_url" => $photo_url,
        "thumb_url" => $thumb_url,
        // "photo_width" => $photo_width,
        // "photo_height" => $photo_height,
        // "title" => $title,
        // "description" => $description,
        // "caption" => $caption,
        "reply_markup" => $reply_markup
      );
      $returnArray[] = $r;
      $i += 1;
    }
  }
  return $returnArray;
}

function GetImgUrl($search_str){
  $a = GetimgUrlFromDB($search_str, 1);
  return $a;
}
