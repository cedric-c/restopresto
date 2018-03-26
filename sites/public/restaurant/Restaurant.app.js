/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var data = {
    name: null,
    type: null,
    url: null,
    phone: null, 
    ratings: [],
    locations: [],
    menu: [],
};



var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var r    = JSON.parse(jsn)[0];
        data.name = r.name;
        data.type = r.type;
        data.url  = r.url;
    },
    methods: {
        
    }
    
});