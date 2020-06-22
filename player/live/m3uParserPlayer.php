<?php

function searchForId($id, $array) {
    for($i=0;$i<count($array);$i++){
        if ($array[$i]['Id'] === $id) {
           return $i;
       }
    }
   return null;
}


function getChannels($url, $epgDb){
if(!$url){
    return "";
}
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
if(!$m3ufile){
    return "";
}

$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
$attributes = '/([a-zA-Z0-9\-\_]+?)="([^"]*)"/';

$m3ufile = str_replace('tvg-id', 'EPG', $m3ufile);
$m3ufile = str_replace('tvg-ID', 'EPG', $m3ufile);
$m3ufile = str_replace('tvg-logo', 'Image', $m3ufile);
$m3ufile = str_replace('group-title', 'Order', $m3ufile);
$m3ufile = str_replace('tvg-chno', 'chNumber', $m3ufile);
$m3ufile = str_replace('tvg-shift', 'EpgShift', $m3ufile);
$m3ufile = str_replace("\r", "", $m3ufile);
$m3ufile = str_replace("#EXTINF:-1", "#EXTINF:0", $m3ufile);
$m3ufile = preg_replace('/(#EXTINF:0),(.*)/', '#EXTINF:0,Name="$2"', $m3ufile, -1 );
$m3ufile = preg_replace('/(#EXTGRP).*(\n)/', '', $m3ufile, -1 );
$m3ufile = preg_replace('/(."),(.*)/', '$1,Name="$2"', $m3ufile, -1 );


if($mode==4)
    $m3ufile = str_replace('id=', 'Id=', $m3ufile);

preg_match_all($re, $m3ufile, $matches);
unset($m3ufile);
$items = array();
$epg = array();
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

    if($newdata['chNumber']==null){
        $newdata['chNumber']=-1;
    }
    
    if($newdata['Name']==null){
        $newdata['Name']="";
    } 
    
    if($newdata['Image']==null){
        $newdata['Image']="Logo N/A";
    }
    
    if($newdata['Order']==null|| $newdata['Order']==""){
        $newdata['Order']="-";
    }
    if($newdata['EpgShift']==null){
        $newdata['EpgShift']="+0";
    }
    
    if (strpos($mediaURL, 'ts')!==false||strpos($mediaURL, 'm3u8')!==false)
        $items[] = $newdata;
    else if(strpos($mediaURL, 'movie') !== false || strpos($mediaURL, 'series') !== false){
        
    }
    else if (strpos($mediaURL, 'mp4') == false  && strpos($mediaURL, 'avi') == false && strpos($mediaURL, 'mpg') == false && strpos($mediaURL, 'mkv') == false)
        $items[] = $newdata;
    
 }
 
    unset($matches);
    
     $groupsTemp = array();
     $groups = array();
	 $counter = 0;
	 $start=true;
	 $idCount = 0;
    
	 foreach($items as $key => $item){
	     if($start){
	         $start=false;
	         $groupsTemp[$item['Order']]=$counter;
	         $items[$key]['Order']=$counter;
	         $newdata =  array (
                    'Id' => $counter,
                    'Name' => $item['Order']
                );
	         array_push($groups, $newdata);
	     }else if($groupsTemp[$item['Order']]==null && $groupsTemp[$item['Order']]!="0"){
	         $counter++;
	         $idCount = 0;
	         $groupsTemp[$item['Order']]=$counter;
	         $items[$key]['Order']=$counter;
	         $newdata =  array (
                    'Id' => $counter,
                    'Name' => $item['Order']
                );
	         array_push($groups, $newdata);
	     }else{
	         $items[$key]['Order']=$groupsTemp[$item['Order']];
	     }

	     $items[$key]['chNumber']=$idCount++;
	 }
	 
	  setcookie("live", count($items), time() + 720000, "/");


    $globalitems =  array( 
    'Group' => $groups,
    'Channel' => $items,
    );
  $globalist['Group'] = $groups;
  $globalist['Channel'] = $items;
    return json_encode($globalist);
}
    
?>