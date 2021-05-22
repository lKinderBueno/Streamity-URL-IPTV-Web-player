### URL Version is discontinued. Please check the Xtream API version


# Streamity.tv URL version (by IPTVEditor.com dev)

![](https://streamity.tv/asset/img/git-min.png)

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/lKinderBueno/StreamityTV-Xtream)
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CVT6HXLZ3YNSG&source=url)

### Official Streamity.tv website: [Click here](https://streamity.tv)



Streamity is an online webplayer. Watch IPTV Channels, movies TV series online on your browser,
directly from your PC, phone or tablet, everywhere with no additional software required!
### (Xtream Api version: [Click here](https://github.com/lKinderBueno/Streamity-Xtream-IPTV-Web-player))


### Features
- IPTV Url and EPG Url support
- Customizable name and logo
- EPG Viewer
- Support to default epg xml, custom epg xml url, epg database mode
- EPG Shift in dashboard (each customer can shift epg)
- TMDB Api Support
- Save last movie and series watched
- Save last episode watch
- Automatic select next series episode
- Automatic fix and improve movie and series name
- Hide live/movie/series player
- Hide EPG
- Recatpcha 
- Pic in picture player
- Mobile friendly
- Save credentials
- Most of the code runs client side
- Javascript pure

### Other Pictures
![](https://streamity.tv/asset/img/2-min.png)
![](https://streamity.tv/asset/img/11-min.png?1)


### Installation
1. Download the latest release: [Click here](https://github.com/lKinderBueno/Streamity-URL-IPTV-Web-player/releases)
2. Extract everything in your domain folder (for example public_html)
3. Run installer.php (for example domain.com/installer.php)
4. Compile all the fields and then press on Install
5. Done


### Installer configuration
Basic configuration:
- IPTV Name: Your IPTV Service name (ex. Streamity)
- Upload IPTV Logo: Your IPTV Logo
- Upload IPTV Icon: Your IPTV Icon
- Replace index page with dashboard: your index page will be replaced with the dashboard page

Anti-abuse configuration:
- No limitation: customer can add list also from other providers
- Only IPTVEditor url: the player will accept only url and epg coming from iptveditor
- Customer Url: the player will accept only url from a domain selected by you


EPG configuration:
- XML + Database (reccomended for 20MB+ epg file): Every 4 hours Streamity.tv player will convert your epg xml file into an SQL database. This settings is the most reccommended if your epg xml file is over 20MB and will offer the best experience to your customer.
- Default EPG Url: the user doesn't have to add the epg url. The player will automatically use the epg you choose
- EPG Url provided by user: the user have to add the epg url
- Disable Epg

TMDb Api (optional)
- Streamity.tv syncs missing Vods and Series info (as cover, description, episode series title etc etc) with TMDb Api. VODs and Series info will be searched first from IPTV provider server and then from TMDb.

reCAPTCHA v2 (optional)
- reCAPTCHA is a free security service that protects your websites from spam and abuse. It will be integrated in the login page. 
IMPORTANT: Is advised to use an SSL protocol (https) in the login page to avoid issue with reCAPTCHA

Disable components
- Disable Live channels
- Disable Movie
- Disable Series

Advanced configuration (optional)
- When a customer login for the first time on Streamity.tv player on a new browser, the server will calculate the number of channels/vods/series avaible on the account.
This procedure will delay the login of 30-40 seconds for IPTV lists with a lot of channels.
Checking this box will disable this feature.
Number of channels/vod/series will be continue to be calculated during the opening of each player.
(for example: Live channels player will calculate only number of live channels)

