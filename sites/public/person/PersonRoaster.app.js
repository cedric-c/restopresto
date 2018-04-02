/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var mixin = {
    methods: {
        getPackage: function(application, action, data, callback){
            var r = new XMLHttpRequest();
            r.open('POST', '../dispatch/index.php');
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

Vue.component('highest-overall-and-component',{
    template:'#highest-overall-and-list',
    mixins:[mixin],
    data: function(){
        return {
            raters: [],
        }
    },
    created: function(){
        this.getHighestFoodAndMood();
    },
    methods: {
        getHighestFoodAndMood: function(){
            this.getPackage('person-roaster', 'highest_raters_food_and_mood',-1,this.setHighestFoodAndMood);
        },
        setHighestFoodAndMood: function(response){
            this.raters = response.payload;
        },
    },
});

Vue.component('most-diverse-component',{
    template:'#most-diverse-list',
    mixins:[mixin],
    data: function(){
        return {
            raters: [],
        }
    },
    created: function(){
        this.getMostDiverse();
    },
    methods: {
        getMostDiverse: function(){
            this.getPackage('person-roaster', 'get_most_diverse', -1, this.setMostDiverse);
        },
        setMostDiverse: function(response){
            this.raters = response.payload;
        },
    },
});

Vue.component('highest-overall-or-component',{
    template:'#highest-overall-or-list',
    mixins:[mixin],
    data: function(){
        return {
            raters: [],
        }
    },
    created: function(){
        this.getHighestFoodOrMood();
    },
    methods: {
        getHighestFoodOrMood: function(){
            this.getPackage('person-roaster', 'highest_raters_food_or_mood',-1,this.setHighestFoodOrMood);
        },
        setHighestFoodOrMood: function(response){
            this.raters = response.payload;
        },
    },
});

// seems legit
Vue.component('raters-below-john-component',{
    template: '#raters-below-john-list',
    mixins:[mixin],
    data: function(){
        return {
            raters: [],
        }
    },
    created: function(){
        this.getRatersBelowJohn();
    },
    methods: {
        getRatersBelowJohn: function(){
            this.getPackage('person-roaster', 'raters_below_john', -1, this.setRatersBelowJohn);
        },
        setRatersBelowJohn: function(response){
            this.raters = response.payload;
        },
    }
});

Vue.component('user-item-component',{
    template: '#user-item',
    mixins:[mixin],
    props:['user'],
    data: function(){
        return {
            email:      this.user.email,
            joined:     this.user.joined,
            name:       this.user.name,
            reputation: this.user.reputation,
            type:       this.user.type,
            uid:        this.user.uid,
        }
    },
    methods: {
        deleteUser: function(){
            this.getPackage('person-roaster', 'delete_user',this.uid, wm.removeUser);
        },
        visitProfile: function(){
            // console.log('visiting profile for user with id '+this.uid);
            window.location.href="/person/id/index.php?id="+this.uid;
        },
    }
    
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
            data.users.push(o[0]);
        },
        removeUser: function(response){
            var o = response.payload;
            var i = this.getIndex(data.users, 'uid', o);
            data.users.splice(i, 1);
        },
    }
    
});