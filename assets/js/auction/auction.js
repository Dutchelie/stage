self.onmessage = function (e) {
    var data = e.data;
    var xmlhttp = new XMLHttpRequest();
    setInterval(function () {
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                self.postMessage(xmlhttp.responseText);
            }
        };
        xmlhttp.open("GET", data.url, true);
        xmlhttp.send();
    }, 1000);
};