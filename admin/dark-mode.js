var switchbtn = document.getElementById("dark-btn");
var dark = document.getElementById("dark-on");
var light = document.getElementById("light-on");
var lightmode = true

switchbtn.addEventListener("click", switchMode );

function switchMode() {
    if (lightmode) {
        dark.style.visibility = "visible";
        light.style.visibility = "hidden";

        document.documentElement.style.setProperty("--main", "darkgreen");
        document.documentElement.style.setProperty("--second", "#003700");
        document.documentElement.style.setProperty("--background", "#28252f");
        document.documentElement.style.setProperty("--bg1", "#353343");
        document.documentElement.style.setProperty("--red1", "#960000");
        document.documentElement.style.setProperty("--red2", "#570000");
        document.documentElement.style.setProperty("--text1", "#ececec");
        document.documentElement.style.setProperty("--shadow", "black");
        document.documentElement.style.background = "url(admin-image/admin-back-dark.png)";
        
        document.body.classList.add("invert");

        document.cookie = "darkmode";
    } else {
        dark.style.visibility = "hidden";
        light.style.visibility = "visible";

        document.documentElement.style.setProperty("--main", "lime");
        document.documentElement.style.setProperty("--second", "#02c702");
        document.documentElement.style.setProperty("--background", "white");
        document.documentElement.style.setProperty("--bg1", "#ddd");
        document.documentElement.style.setProperty("--red1", "red");
        document.documentElement.style.setProperty("--red2", "#960000");
        document.documentElement.style.setProperty("--text1", "black");
        document.documentElement.style.setProperty("--shadow", "lightgray");
        document.documentElement.style.background = "url(admin-image/admin-back.png)";

        document.body.classList.remove("invert");

        document.cookie = "lightmode";
    }
    lightmode = !lightmode;
}


if (document.cookie == "darkmode") {
    lightmode = true;
    switchMode();
}