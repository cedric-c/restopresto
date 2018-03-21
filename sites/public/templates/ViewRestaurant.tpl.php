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
    $path    =  $n . '/' . $n . '.app.js' ;
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
        <template id="create-resto">
                <div class="row">
                  <div class="col-xs-4">
                    <input type="text" v-model="name" class="form-control" placeholder="Name">
                  </div>
                  <div class="col-xs-2">
                    <input type="text" v-model="type" class="form-control"  placeholder="Type">
                  </div>
                  
                  <div class="col-xs-3">
                    <input type="text" v-model="url" class="form-control" placeholder="URL">
                  </div>
                  <div class="col-xs-1">
                      <button @click="post" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </div>
                </div>
        </template>
        <template id="resto">
            <div class="container">
              <div class="row recordObject">
                <div class="col-xs-8">
                  <p class="txtb">{{data.name}}</p>
                  <p>{{data.type}}</p>
                </div>
                <div class="col-xs-4">
                  <a class="actionButton" :href="data.url"><i class="fa fa-external-link-square fa-3x"></i></a>
                  <a class="actionButton" @click="remove"><i class="fa fa-times fa-3x"></i></a>
                </div>
                </div>
              </div>
        </template>
        <template id="resto-list">
            <ul>
              <transition-group name="list">
                <resto-component class="list-item" v-for="(resto, index) in restaurants" :data="resto" :key="resto.rid" v-on:remove-resto="removeChild(index)"></resto-component>
              </transition-group>
            </ul>
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
              <div class="row">
                <div class="container">
                  <div class="container pdb15">
                    <h2>Add a Restaurant</h2>
                  <create-resto-component></create-resto-component>
                  </div>
                  <div class="container">
                    <h2>Current Restaurants</h2>
                  <main-restaurant-component>
                  </main-restaurant-component>
                  </div>
              </div>
              </div>
            </div>
        </div>
    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
