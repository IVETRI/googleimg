<?php
require_once __DIR__ . '/config.php';

$request = trim($_SERVER['PATH_INFO'],'/');

if($request == "insert"){
  $stringHTML = "<!DOCTYPE html><html>
  <head><title>@$DB_TABLE_NAME</title>
  <link rel='stylesheet' type='text/css' href='/css/bootstrap.css'>
  </head>
  <body>
<br/><br/>  <form method='POST'>
  <input class='form-control' type='text' name='tags' required placeholder='mammootty,sad,cry,kadha parayumbol'><br/>
  <input class='form-control' type='text' name='uuri' required placeholder='https://i.imgur.com/RHjEnuO.jpg'><br/><br/>
  <button type='submit' class='btn btn-default'>insert</button><br/>
  </form>
  </body>
  </html>";
  if(isset($_POST['uuri'])){
    $tagSS = $_POST["tags"];
    $uuri = $_POST["uuri"];
    $tagS = explode(",", $tagSS);
    $tag = urlencode(implode("###", $tagS));
    $query = "INSERT INTO $DB_TABLE_NAME(`TAGS`, `UURI`) VALUES ('$tag', '$uuri');";
    if($mysqli->query($query) === TRUE){
      $returnarray = array();
      header('Content-Type: application/json');
      $returnarray["OK"] = "200";
      echo json_encode($returnarray);
    }
    else{
      $returnarray = array();
      header('Content-Type: application/json');
      $returnarray["OK"] = "403";
      echo json_encode($returnarray);
    }
  }
  else{
    header('Content-Type: text/html');
    echo $stringHTML;
  }
}
else if(startsWith($request, "search")){
  $q = $_REQUEST["q"];
  $returnarray = array();
  header('Content-Type: application/json');
  $query = "SELECT * FROM $DB_TABLE_NAME WHERE `TAGS` LIKE '%$q%';";
  $result = $mysqli->query($query);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $a = urldecode($row["TAGS"]);
      $tagS = explode("###", $a);
      $uuri = $row["UURI"];
      $r = array(
        "TAGS" => $tagS,
        "UURI" => $uuri
      );
      $returnarray[] = $r;
    }
  }
  echo json_encode($returnarray);
}
else {
  $returnarray = array();
  header('Content-Type: application/json');
  $returnarray["OK"] = "404";
  $returnarray["MSG"] = "these are not the kittens that you are looking for";
  echo json_encode($returnarray);
}
?>
