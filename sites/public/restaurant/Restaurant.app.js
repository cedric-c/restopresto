/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var data = {
};



var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        console.log(parsed);
    },
    methods: {
    }
    
});