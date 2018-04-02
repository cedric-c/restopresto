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

var mixin = {
    methods: {
        getPackage: function(application, action, data, callback){
            var r = new XMLHttpRequest();
            r.open('POST', '../../dispatch/index.php');
            r.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var d = JSON.stringify(data);
            var sending = 'application='+application+'&action='+action+'&data='+d;
            // console.log(d);
            // console.log(sending);
            r.send(sending);
            // var self = this;
            r.onload = function(){
                var response = JSON.parse(r.responseText);
                if(response.state == 'success') {
                    callback(response);
                } else {
                    console.error(response);
                }
            };
        },
        getIndex: function(array, attr, value) {
            for(var i = 0; i < array.length; i += 1) {
                if(array[i][attr] === value) {
                    return i;
                }
            }
            return -1;
        },
        printResult(result){
            console.log(result);
        },                
    }
}

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

Vue.component('login-component',{
    mixins:[mixin],
    template: '#login',
    data: function(){
        return {
            modal: null,
            name:null,
            email:null,
            password:null,
            type:null,
        }
    },
    created: function(){
    },
    mounted: function(){
        var myModal = document.getElementById('myModal');
        this.modal = new Modal(myModal);
        
        
    },
    methods:{
        showModal: function(){
            this.modal.show();
        },
        hideModal: function(){
            this.modal.hide();
        },
        clear: function(){
            this.name = null,
            this.email = null,
            this.password = null,
            this.type = null
        },
        logout: function(){
            this.getPackage('session', 'logout', null, this.printResult);
        },
        login: function(){
            var o = new Object();
            o.email    = this.email;
            o.password = this.password;
            this.getPackage('session', 'login',o, this.printResult);
            this.hideModal();
            this.clear();
        },
        register: function(){
            var o = new Object();
            o.name = this.name;
            o.email = this.email;
            o.password = this.password;
            o.type = this.type;
            this.getPackage('session', 'register', o, this.printResult);
            this.hideModal();
            this.clear();
        },
    }
});

var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        data.apps = parsed.available_apps;
    },
});

