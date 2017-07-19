<?php
require_once __DIR__ . '/config.php';

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

function GetImgUrlFromGCS($GOOGLE_CSE_API, $search_str, $i = 0){
  $returnArray = array();
  $url = $GOOGLE_CSE_API . "&start=" . "1" . "&alt=json&searchType=image&q=" . urlencode($search_str);
  $response = JsonToObj(fetch_website($url));
  foreach ($response["items"] as $images){
    $mime_type = $images["mime"];
    if($mime_type == "image/jpeg"){
      $type = "photo";
      $id = strval($i);
      $photo_url = $images["link"];
      $thumb_url = $images["image"]["thumbnailLink"];
      $photo_width = $images["image"]["width"];
      $photo_height = $images["image"]["height"];
      $title = $images["title"];
      $description = $images["displayLink"];
      $caption = "";//$images["htmlTitle"];
      $reply_markup = array(
        "inline_keyboard" => array(
          array(
            array(
                "text" => "Search Again",
                "switch_inline_query_current_chat" => $search_str
              )
          )
        )
      );
      $r = array(
        "type" => $type,
        "id" => $id,
        "photo_url" => $photo_url,
        "thumb_url" => $thumb_url,
        "photo_width" => $photo_width,
        "photo_height" => $photo_height,
        "title" => $title,
        "description" => $description,
        "caption" => $caption,
        "reply_markup" => $reply_markup
      );
      $returnArray[] = $r;
      $i += 1;
    }
  }
  return $returnArray;
}

function GetimgUrlFromDB($base_url, $search_str, $i = 0){
  $returnArray = array();
  $url = $base_url . urlencode($search_str);
  $response = JsonToObj(fetch_website($url));
  foreach ($response as $value) {
    $uuri = $value["UURI"];
    // $tags = implode(",",$value["TAGS"]);
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
  return $returnArray;
}

function GetImgUrl($search_str){
  $DB_URL = "https://spechide-spechide.rhcloud.com/MemesPlanetBot/api.php/search?q=";
  $GOOGLE_CSE_API = "https://www.googleapis.com/customsearch/v1?key=" . $GLOBALS["GOOGLE_CSE_API_KEY"] . "&cx=" . $GLOBALS["GOOGLE_CSE_API_CX"];
  $r = array();
  $a = GetimgUrlFromDB($DB_URL, $search_str, 1);
  $c = count($a);
//  if($c == 0){
//    $b = GetImgUrlFromGCS($GOOGLE_CSE_API, $search_str, $c + 1);
    // => https://stackoverflow.com/a/4268954/4723940
//    $r = array_merge($a, $b);
//  }
//  else{
//    $r = $a;
//  }
  return $a;
}
