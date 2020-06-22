<?php

function searchForGroup($id, $array) {
    for($i=0;$i<count($array);$i++){
        if ($array[$i]['Id'] === $id) {
           return $array[$i]['Name'];
       }
    }
}

function getVod($url){
$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
  )
);
$context = stream_context_create($options);

if(isset($url)) {
  $m3ufile = file_get_contents($url, false, $context);
} 


$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
$attributes = '/([a-zA-Z0-9\-\_]+?)="([^"]*)"/';

$m3ufile = str_replace('tvg-name', 'Name', $m3ufile);
$m3ufile = str_replace('tvg-logo', 'Image', $m3ufile);
$m3ufile = str_replace('group-title', 'Order', $m3ufile);
$m3ufile = str_replace("\r", "", $m3ufile);
$m3ufile = str_replace("#EXTINF:-1", "#EXTINF:0", $m3ufile);
$m3ufile = preg_replace('/(#EXTINF:0),(.*)/', '#EXTINF:0,Name2="$2"', $m3ufile, -1 );
$m3ufile = preg_replace('/(#EXTGRP).*(\n)/', '', $m3ufile, -1 );
$m3ufile = preg_replace('/(\w"),(.*)/', '$1,Name2="$2"', $m3ufile, -1 );



if($mode==4)
    $m3ufile = str_replace('id=', 'Id=', $m3ufile);


preg_match_all($re, $m3ufile, $matches);
unset($m3ufile);


$items = array();
$vods = array();

 foreach($matches[0] as $list) {
    
   preg_match($re, $list, $matchList);

   $mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
   $mediaURL = preg_replace('/\s+/', '', $mediaURL);
   $mediaURL = str_replace('"',"",$mediaURL);

   $newdata =  array (
    'IP' => $mediaURL
    );
    
    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
       $newdata[$match[1]] = $match[2];
    }

    if (($newdata['Name']==""||$newdata['Name']==null) && $newdata['Name2']!=null){
        $newdata['Name']=$newdata['Name2'];
    }else if($newdata['Name']==null){
        $newdata['Name']="";
    } 
    
    if($newdata['Image']==null){
        $newdata['Image']="Logo N/A";
    }
    
    if($newdata['Order']==null|| $newdata['Order']==""){
        $newdata['Order']="No category";
    }
    
    if(strpos($mediaURL, 'movie') !== false)
        $items[] = $newdata;
    else if ((strpos($mediaURL, 'mp4') == true||strpos($mediaURL, 'avi') == true||strpos($mediaURL, 'mkv') == true ||strpos($mediaURL, 'mpg') == true))
        $items[] = $newdata;

 }
    unset($matches);
     $finalList = array();
     setcookie("movie", count($items), time() + 720000, "/");
	 foreach($items as $key => $item){
	     $vod = $items[$key];
	     if(!$finalList[$vod['Order']]){
	         $finalList[$vod['Order']]= array();
	     }
	     $count = count($finalList[$vod['Order']]);
	     $toAdd["Name"]=$vod["Name"];
	     $toAdd["Image"]=$vod["Image"];
	     $toAdd["IP"]=$vod["IP"];
	     $toAdd["id"]=$count;
	     array_push($finalList[$vod['Order']], $toAdd);
	 }
	 


   return json_encode($finalList);
}


?>