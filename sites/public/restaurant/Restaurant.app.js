/*!
 * (c) 2018 Cédric Clément.
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
        createResto: function (resto){
            console.log(resto[0]);
            var r = new Object();
            var newResto = wm.createResto(resto[0]);
            data.restaurants.push(newResto);
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
                var state = request.responseText;
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    var resto = response.payload;
                    self.createResto(resto);
                } else {
                    console.log('while trying to create resto');
                }
            };
        },
    },
    template: '#create-resto'
});

Vue.component('resto-chooser-component', {
   props:['data'],
   template: '#resto-chooser',
   data: function(){
    return {
        all:true,
        unrated:false,
        other:false,
    }
   },
   methods: {
    untoggle: function(){
        this.all = false;
        this.unrated = false;
    },
    toggleAll: function(){
        this.untoggle();
        this.all = !this.all;
        if(this.all){
            this.getAll();
        }
    },
    toggleUnrated: function(){
        this.untoggle();
        this.unrated = !this.unrated;
        if(this.unrated){
            this.getUnrated();
        }
    },
    getUnrated: function(){
        var request = new XMLHttpRequest()
        request.open("POST", '../dispatch/index.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('application=restaurant&action=get_unrated_restaurants&'+'data=null');
        var self = this;
        request.onload = function(){
            var response = JSON.parse(request.responseText);
            if (response.state == 'success') {
                self.$parent.restaurants = response.payload;
            } else {
                console.log('an error occured');
            }
        };            
    },
    getAll: function(){
        var request = new XMLHttpRequest()
        request.open("POST", '../dispatch/index.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('application=restaurant&action=get_all_restaurants&'+'data=null');
        var self = this;
        request.onload = function(){
            var response = JSON.parse(request.responseText);
            if (response.state == 'success') {
                self.$parent.restaurants = response.payload;
            } else {
                console.log('an error occured');
            }
        };            
        
    },
   },
});

Vue.component('resto-component', {
    props:['data'],
    // data: function(){
        // return data;
    // },
    template: '#resto',
    methods: {
        deleteResto: function (){
            this.$emit('remove-resto');
        },
        remove: function() {
            var request = new XMLHttpRequest()
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('application=restaurant&action=delete&'+'data='+this.data.rid);
            var self = this;
            request.onload = function(){
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    self.deleteResto();
                } else {
                    console.log(response.message);
                }
            };
        },
        getMenu: function(){
            var request = new XMLHttpRequest()
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('application=restaurant&action=list_menu&'+'data='+this.data.rid);
            var self = this;
            request.onload = function(){
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    self.data.menu = response.payload;
                } else {
                    console.log('an error occured');
                }
            };
        },
    },
});

Vue.component('main-restaurant-component',{
    data: function(){
        return data;
    },
    template: '#resto-list',
    methods: {
        removeChild: function(index) {
            data.restaurants.splice(index, 1);
        },
    }
});

var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        var r = this.injectProperties(parsed);
        data.restaurants = r;
    },
    methods: {
        addChild: function(child) {
            data.restaurants.push(child);
        },
        createResto: function(data){
            var resto       = new Object();
            resto.rid       = data.rid;
            resto.name      = data.name;
            resto.type      = data.type;
            resto.url       = data.url;
            resto.phone     = data.phone;
            resto.menu      = [];
            resto.ratings   = [];
            resto.locations = [];
            return resto;
            
        },
        injectProperties: function(restos) {
            var ret = [];
            for(var i in restos){
                var r = this.createResto(restos[i]);
                ret.push(r);
            }
            return ret;
        },
    }
    
});