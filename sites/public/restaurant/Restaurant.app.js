/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var data = {
    name: null,
    type: null,
    url: null,
    phone: null, 
    open_hours: null,
    end_hours: null,
    most_expensive: null,
    rid: null,
    managers: [],
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
        data.rid  = r.rid;
        
        // get locations
        this.getPackage('restaurant','get_location',data.rid,this.setLocation);
        
        // get manager
        this.getPackage('restaurant','get_manager_info',data.rid,this.setManager);
        
        // get menu
        this.getPackage('restaurant','get_menu',data.rid,this.setMenu);

    },
    methods: {
        printResult(result){
            console.log(result);
        },
        setLocation(response){
            var loc = response.payload;
            for(var i in loc){data.locations.push(loc[i]);}
        },
        setManager(response){
            var m = response.payload;
            for(var i in m){data.managers.push(m[i]);}
        },
        setMenu(response){
            var m = response.payload;
            for(var i in m){data.menu.push(m[i]);}
        },
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
    }
    
});