window.onload = function() {
    if(shift){
        document.getElementById("epg_shift").value = parseInt(shift);
    }else document.getElementById("epg_shift").value = "+0";
    try{
        if(!h24){
            document.getElementById("epgtime_24").checked=true;
        }else{
            document.getElementById("epgtime_"+h24).checked=true;
        }
    }catch(ex){ document.getElementById("epgtime_24").checked=true;}
    
    document.getElementById("epgshift_box").setAttribute("class","form-group bmd-form-group is-filled");
}


function openBrowser(mode){
    var h24 = document.getElementById("epgtime_24").checked;
    if(h24)
        setCookie("h24",24);
    else setCookie("h24",12);

    try{
        shift = parseInt(document.getElementById("epg_shift").value);
    }catch(ex){
        shift=0;
        document.getElementById("epg_shift").value=0;
        alert("Shift is not a number. It will be resetted");
    }
    setCookie("shift",shift);
    var path = document.URL.substr(0,document.URL.lastIndexOf('/')).replace("https","http");
    if(mode==1)
        var url = path+"/player/live/";
    else if(mode==2)
        var url = path+"/player/movie/";
    else var url = path+"/player/series/";   
    var win = window.open(url, '_blank');
    win.focus();
}



function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


function setCookie(cname, cvalue) {
  var d = new Date();
  d.setTime(d.getTime() + (7*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}