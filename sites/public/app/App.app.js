/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 *
 * NOTE: PLACE ALL COMPONENTS ABOVE THE VUE DECLARATION.
 *
 */

console.log("Test App");
var appData = document.getElementById("app-data");

var data = {
    apps: [],
};

Vue.component('app-component', {
    props:['data'],
    methods: {
        post: function(){
            var request = new XMLHttpRequest()
            var self = this;
            request.open("POST", 'app/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('key1=value1&key2=value2');
            request.onload = function(){
                console.log(request.response);
            };
        },
    },
    template: '<div class="recordObject"><a v-bind:href="data.index"><p class="record-object-title">{{data.caption}}</p></a></div>'
});

Vue.component('applications-component',{
    data: function (){
        return data;  
    },
    template: '<ul>' +
            '<app-component v-for="app in apps" :data="app" :key="app.index"></app-component>'+
    '</ul>'
});

var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        data.apps = parsed.available_apps;
    },
});

