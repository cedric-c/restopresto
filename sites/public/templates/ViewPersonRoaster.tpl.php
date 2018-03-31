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
        
        <template id="create-person">
            <div class="panel panel-default">
                <div class="panel panel-heading"><h3 class="panel-title">New User</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3"><input type="text" v-model="name" class="form-control input-lg" placeholder="Name"></div>
                        <div class="col-xs-3"><input type="text" v-model="email" class="form-control input-lg"  placeholder="Email"></div>
                        <div class="col-xs-2"><input type="text" v-model="type" class="form-control input-lg" placeholder="Type"></div>
                        <div class="col-xs-2"><input type="text" v-model="reputation" class="form-control input-lg" placeholder="Reputation"></div>
                        <div @click="createUser" class="col-xs-2"><button class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button></div>
                    </div>
                </div>
            </div>
        </template>
        
        <template id="user-item">
            <div class="recordObject">
                <div class="row">
                    <div class="col-xs-4"><h4>{{user.name}}</h4></div>
                    <div class="col-xs-6">
                        <div class="row">Email: {{user.email}}</div>
                        <div class="row">Joined: {{user.joined}}</div>
                        <div class="row">Type: {{user.type}}</div>
                        
                    </div>
                    <div class="col-xs-2">
                        <div class="row">
                            <button @click="printResult(user.uid)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div class="row">
                            
                        </div>
                    </div>
                    </div>
                </div>
                
            </div>
        </template>
        
        <template id="user-list">
            <div class="panel panel-default">
                <div class="panel panel-heading"><h3 class="panel-title">Current Users</h3></div>
                <div class="panel-body">
                    <ul>
                        <transition-group name="list">
                            <user-item-component class="list-item" v-for="(user, index) in users" :user="user" :key="user.uid">
                            </user-item-component>
                        </transition-group>
                    </ul>
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
              
              <create-person-component></create-person-component>
              <user-list-component></user-list-component>
            </div>
        </div>

    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
