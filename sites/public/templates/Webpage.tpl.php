<?php 
    /**
     * @author Cédric Clément <cclem054@uottawa.ca>
     * @version 1.0
     * @since 1.0
     * (c) Copyright 2018 Cédric Clément.
     */    
    $appName = $this->getApp()->getName();
    $render  = $this->getApp()->render();
    $data    = base64_encode(json_encode($this->getApp()->getData()));
    $n       = $this->getApp()->getDir();
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

    <template id="login">
        <div>
            <button id="myModalTrigger" @click="showModal" class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Login</button>
            <button id="logout" @click="logout" class="btn btn-primary" type="button">Logout</button>
            <div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Sign in or Register</h4>
                  </div>
                  <div class="modal-body">
                    <h5>Sign in</h5>
                    <div class="row">
                        <label for="email-login">Email address</label>
                        <input v-model="email" type="email" class="form-control" id="email-login" placeholder="email@example.com">
                    </div>
                    <div class="row">
                        <label for="password-login">Password</label>
                        <input type="password" v-model="password" class="form-control" id="password-login" placeholder="Password">
                    </div>
                    <div class="row">
                        <button type="submit" @click="login" class="btn btn-primary">Sign in</button>                        
                    </div>
                            
                    <h5>Register</h5>
                    <div class="row">
                        <label for="name-register">Name</label>
                        <input type="text" v-model="name" class="form-control" id="name-register" placeholder="Bill Burr">
                    </div>
                    <div class="row">
                        <label for="email-register">Email address</label>
                        <input type="email" v-model="email" class="form-control" id="email-register" placeholder="email@example.com">
                    </div>
                    <div class="row">
                        <label for="password-register">Password</label>
                        <input type="password" v-model="password" class="form-control" id="password-register" placeholder="Password">
                    </div>
                    <div class="row">
                        <label for="type-register">Type</label>
                        <input type="text" v-model="type" class="form-control" id="type-register" placeholder="Type">
                    </div>
                    <div class="row">
                        <button type="submit" @click="register" class="btn btn-primary">Register</button>                        
                    </div>
                    
                    
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                  </div>
                </div>
              </div>
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
            <div id="main_content"><?php echo $render;?></div>
        </div>
    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
