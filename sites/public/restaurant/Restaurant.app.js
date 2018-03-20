/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 *
 * NOTE: PLACE ALL COMPONENTS ABOVE THE VUE DECLARATION.
 *
 */
var appData = document.getElementById("app-data");

var data = {
    restaurants: [],
};

Vue.component('resto-component', {
    props:['data'],
    template: '<p class="app">{{data.name}}</p>'
});

Vue.component('main-restaurant-component',{
    data: function(){
        return data;
    },
    template: 
        '<ul>'+
        '<resto-component v-for="resto in restaurants" :data="resto" :key="resto.name">'+
        '</resto-component>'+
        '</ul>'
});

var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        data.restaurants = parsed;
    },
});