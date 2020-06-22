<?php
if(!file_exists("config.php")){
    echo "Please run installer.php!";
    die();
}

include "config.php";
include "logDir/login/Login.php";

if($epgMode!=3)
    $disableEpg = "none";
    
if($_COOKIE['remember']==1){
    $url= $_COOKIE['iptv'];
    $epgUrl = $_COOKIE['epg'];
}

?>

    <!DOCTYPE HTML>
    <html>

    <head>
        <meta charset="utf-8">
        <title><?php echo $nameIptv; ?> Login</title>
        <link rel="icon" type="image/png" href="favicon.ico?<?php echo $version; ?>">
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/roboto-font.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/fonts/line-awesome/css/line-awesome.min.css">
        <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
        <link rel="stylesheet" href="/bootstrap/css/style.css"/>
    </head>

   <body class="form-v2">
        <div class="page-content">
            <div class="form-v2-content">
                <form class="form-detail" action="#" method="post" id="myform">
                    <h2>Welcome in <?php echo $nameIptv; ?></h2>
                    <label style="color: red;"><?php echo $msg_login; ?></label><br/>
                    <div class="form-row">
                        <label for="full-name">IPTV Url:</label>
                        <input type="text" name="user" id="user" class="input-text" placeholder="ex: http://iptv.tv/abcd" value="<?php echo $url; ?>">
                    </div>
                    <div class="form-row" style="display:<?php echo $disableEpg; ?>">
                        <label for="password">EPG Url:</label>
                        <input name="epg" id="epg" class="input-text" placeholder="ex: http://iptv.tv/abcd" value="<?php echo $epgUrl; ?>">
                    </div>
                    <label>
                        <input type="checkbox" style="appearance: auto;width: auto;" name="remember" id="remember" value="1">
                        <span>Remember me</span>
                    </label>
                    <div class="">
                        <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaSite; ?>"></div>
                    </div>
                    <input type="hidden" name="login">
                    <div class="form-row-last">
                        <input type="submit" name="login" class="register butto" value="Login">
                    </div>

                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script>
           var iptv = "<?php echo $url; ?>";
           var epg = "<?php echo $epgUrl; ?>";
           
            if(iptv){
                document.getElementById("user").setAttribute("class","form-group bmd-form-group is-filled");
                document.getElementById("remember").checked=true;
            }if(epg)
                document.getElementById("epg").setAttribute("class","form-group bmd-form-group is-filled");
           
       </script>
    </body>

<style>
    .form-row-last {
        margin-top:50px;
    }

    .butto{
        width: 100% !important;
        margin-bottom:40px !important;
    }
    
    .secondary_button{
        border-radius: 6px;
        -o-border-radius: 6px;
        -ms-border-radius: 6px;
        -moz-border-radius: 6px;
         -webkit-border-radius: 6px;
        width: 100% !important;
        margin: 6px 0 0px 0px;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 16px;
        background: white;
        color: #666;
        border-color: #666;
        border-style: double;
    }
    
</style>
    </html>