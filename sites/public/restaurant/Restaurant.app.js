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
    name: '',
    type: '',
    url: '',
};

Vue.component('create-resto-component', {
    data: function(){
        return data;
    },
    methods: {
        print:function(v){
            console.log(v);
        },
        post: function(){
            var request = new XMLHttpRequest()
            var self = this;
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var n = data.name;
            var t = data.type;
            var u = data.url;
            var o = new Object();
            o.name = data.name;
            o.type = data.type;
            o.url  = data.url;
            var d = JSON.stringify(o);
            request.send('application=restaurant&action=create&'+'data='+d);
            request.onload = function(){
                console.log(request.response);
            };
        },
    },
    template: '#create-resto'
});

Vue.component('resto-component', {
    props:['data'],
    template: '#resto',
    methods: {
        remove: function() {
            console.log("deleting "+ this.data.rid);
        },
    },
});

Vue.component('main-restaurant-component',{
    data: function(){
        return data;
    },
    template: '#resto-list'
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