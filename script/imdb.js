document.addEventListener('DOMContentLoaded', function () {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var MP = url.searchParams.get("MP");
    var items = document.getElementById(MP);
    if (MP !== "profile") {
        items.className += " active";
    }
}, false);



