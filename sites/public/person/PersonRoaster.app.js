/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var mixin = {
    methods: {
        getPackage: function(application, action, data, callback){
            var r = new XMLHttpRequest();
            r.open('POST', '../../dispatch/index.php');
            r.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            r.send('application='+application+'&action='+action+'&data='+data);
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

Vue.component('user-item-component',{
    template: '#user-item',
    mixins:[mixin],
    props:['user'],
    
});

Vue.component('user-list-component',{
    template: '#user-list',
    mixins:[mixin],
    data: function(){return data;}
});

Vue.component('create-person-component',{
    template: '#create-person',
    mixins: [mixin],
    data: function(){
        return {
            name: null,
            email: null,
            type: null,
            reputation: null,
        }
    },
    methods: {
        createUser: function(){
            console.log('hello');
            var ob = new Object();
            ob.name = this.name;
            ob.email = this.email;
            ob.type = this.type;
            ob.reputation = this.reputation;
            var package = JSON.stringify(ob);
            wm.getPackage('person-roaster', 'create_user', package, wm.addUser);
            this.clear();
        },
        clear: function(){
            this.name = null,
            this.email = null,
            this.type= null,
            this.reputation = null
        },
    }
});

var data = {
    users: null,
};


var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var obj  = JSON.parse(jsn);
        this.users = obj;

    },
    computed:{
        
    },
    methods: {
        addUser: function(response){
            var o = response.payload;
            console.log(o);
            data.users.push(o[0]);
        },
    }
    
});