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
    // data: function (){
        // return data;  
    // },
    template: '<p class="app">{{data.caption}}</p>'
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
