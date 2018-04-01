<?php 
    /**
     * @author Cédric Clément <cclem054@uottawa.ca>
     * @version 1.0
     * @since 1.0
     * (c) Copyright 2018 Cédric Clément.
     */
    $appName = $this->getController()->getAppName();
    $data    = base64_encode($this->getModel()->jsonSerialize());
    $n       = $this->getController()->getAppDir();
    $m       = $this->getController()->getAppFileName();
    $path    =  $n . '/' . $m . '.app.js' ;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="/static/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/static/css/styles.css">
        <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css">

        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $appName ;?></title>
    </head>
    <body>
        
        <template id="lower-rated-item">
            <li class="recordObject">
                <div class="row"><b>{{restaurant.name}}</b> opened on <b>{{restaurant.opened}}</b></div>
            </li>
        </template>
        
        <template id="lower-rated-list">
            <div class="panel panel-default">
                <div class="panel panel-heading"><h3 class="panel-title">Lower Rated Restaurants</h3></div>
                <div class="panel-body">
                    <ul><transition-group name="list">
                        <lower-rated-item-component class="list-item" v-for="(restaurant, index) in lowerRatings" :restaurant="restaurant" :key="restaurant.rid">
                        </lower-rated-item-component>
                    </transition-group></ul>
                </div>
            </div>
        </template>
        
        <template id="user-info">
            <div>
                <div class="row"><h2>{{name}} ({{reputation}})</h2></div>
                <div class="row">
                    <div class="col-xs-4">Type: {{type}}</div>
                    <div class="col-xs-4">Joined: {{joined}}</div>
                    <div class="col-xs-4">Email: {{email}}</div>
                </div>                   
            </div>
        </template>
        
        
        <div class="masthead">
            <div class="container">
                <h1><?php echo $appName ;?></h1>
            </div>
        </div>
        <div id="app" class="container">
            <header>
            <div id="app-data" style="display: none;" data="<?php echo $data;?>"></div>
            </header>
            <div id="main_content">
                <div class="row"><user-info-component></user-info-component></div>
                <div class="row"><lower-rated-list-component></lower-rated-list-component></div>
                <div class="row"></div>
                <div class="row"></div>
            
            </div>
        </div>

    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
