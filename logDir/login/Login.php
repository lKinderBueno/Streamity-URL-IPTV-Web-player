<?php
session_start();
if ($_SESSION["user"] == true)
{
    header("Location: dashboard.php");
}
else session_destroy();

$msg_login = "";
if (isset($_POST["login"]))
{
    $iptv = addslashes(htmlspecialchars($_POST["user"]));
    $iptv = filter_var($iptv, FILTER_SANITIZE_URL);

    if ($limitation == 1 && (strpos($iptv, 'iptveditor.com') == false && strpos($iptv, 'opop.ga') == false)) {
        $msg_login = "IPTV Url is not valid";
        return;
    }
    else if ($limitation == 2 && strpos($iptv, $urlCheck) == false) {
        $msg_login = "IPTV Url is not valid";
        return;
    }

    if ($epgMode == 3)
    {
        $epgDl = addslashes(htmlspecialchars($_POST["epg"]));
        $epgDl = filter_var($epgDl, FILTER_SANITIZE_URL);
    }

    if (empty($iptv))
    {
        return;
    }

    if (filter_var($iptv, FILTER_VALIDATE_URL) == false)
    {
        $msg_login = "IPTV Url is not valid";
        return;
    }

    if ($recaptchaPrivate) if (isset($_POST['g-recaptcha-response']))
    {
        require (dirname(__FILE__) . '/autoload.php');
        $recaptcha = new \ReCaptcha\ReCaptcha($recaptchaPrivate);
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        if (!$resp->isSuccess())
        {
            $msg_login = "Captcha not valid.";
            return;
        }
    }
    else
    {
        $msg_login = "Captcha not valid.";
        return;
    }

    $options = array(
        'http' => array(
            'timeout' => 20,
            'method' => "GET",
            'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n" . // check function.stream-context-create on php.net
            "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
            // i.e. An iPad
            
        )
    );

    if ($_COOKIE['iptv'] != $iptv || (!$_COOKIE['live'] || !$_COOKIE['movie'] || !$_COOKIE['series']))
    {
        $countMovie = 0;
        $countLive = 0;
        $countSeries = 0;
        $context = stream_context_create($options);
        $text = file_get_contents($iptv, false, $context);
        $lines =  explode(PHP_EOL,$text);
        foreach($lines as $line) {
            if(substr( $line, 0, 2 ) === "ht"){
                if (!$noSeries && strpos($line, 'series') !== false) 
                    $countSeries++;
                else if (!$noMovie && strpos($line, 'movie') !== false) 
                    $countMovie++;
                else if (!$noLive)  
                    $countLive++;
            }
        }
        unset($text);
        if ($countMovie == 0 && !$noMovie) 
            $countMovie = (int)substr_count($text, "mkv") + (int)substr_count($text, "mp4") + (int)substr_count($text, "avi")+ (int)substr_count($text, "mpg");
        setcookie("live", $countLive, time() + 720000, "/");
        setcookie("movie", $countMovie, time() + 720000, "/");
        setcookie("series", $countSeries, time() + 720000, "/");

        if ($countLive == 0 && $countMovie == 0 && $countSeries == 0)
        {
            $msg_login = "IPTV Url is not valid";
            return;
        }

    }else{
        setcookie("live", $_COOKIE['live'], time() + 720000, "/");
        setcookie("movie", $_COOKIE['movie'], time() + 720000, "/");
        setcookie("series", $_COOKIE['series'], time() + 720000, "/");
    }
    setcookie("iptv", $iptv, time() + 720000, "/");
    
    if($_POST['remember']==1){
        setcookie("remember", true, time() + 720000, "/");
    }else setcookie("remember", false, time() + 720000, "/");
    
    session_start(); 
    $_SESSION["iptv"] = true;
    $_SESSION["iptv"] = $iptv;

    if ($epgMode == 3) {
        $_SESSION["epg"] = $epgDl;
        if($_COOKIE['remember']==1)
            setcookie("epg", $epgDl, time() + 720000, "/");
    }

    if (!$_COOKIE['shift']) 
        setcookie("shift", 0, time() + 720000);

    if (!$_COOKIE['h24']) 
        setcookie("h24", 24, time() + 720000);

    if (!$epgDb) 
        if (!$_COOKIE['epg']) 
        setcookie("epg", false, time() + 720000);

    header("Location: dashboard.php");

}
?>