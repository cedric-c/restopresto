console.log("Hello world");
var appData = document.getElementById("app-data");
var wm = new Vue({
    el: '#app',
    data: {
        objects: null,
    },
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        this.objects = parsed;
    },
});