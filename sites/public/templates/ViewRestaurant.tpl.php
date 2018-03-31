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
      
      <template id="create-menu-item">
      
      
      
              <div class="row">
          <div class="panel panel-default">
              <div class="panel panel-heading"><h3 class="panel-title">New Menu Item</h3></div>
              <div class="panel-body">
            <div class="row">
              <div class="col-xs-3"><input type="text" v-model="name" class="form-control input-lg" placeholder="Name"></div>
              <div class="col-xs-3"><input type="text" v-model="type" class="form-control input-lg" placeholder="Type"></div>
              <div class="col-xs-3"><input type="text" v-model="category" class="form-control input-lg" placeholder="Category"></div>
              <div class="col-xs-3"><input type="text" v-model="price" class="form-control input-lg" placeholder="Price"></div>
            </div>
            <div class="row">
              <textarea class="form-control input-lg" v-model="comment" rows="3" id="comment" placeholder="Comment"></textarea>
              <div class="row">
                <button @click="newMenuItem" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
              </div>
            </div>
          </div>
          </div>
        </div>        

      
      
      
      
      
      </template>
      <template id="create-rating-item">
        
        <div class="row">
          <div class="panel panel-default">
              <div class="panel panel-heading"><h3 class="panel-title">New Review</h3></div>
              <div class="panel-body">
            <div class="row">
              <div class="col-xs-3"><input type="text" v-model="price" class="form-control input-lg" placeholder="Price"></div>
              <div class="col-xs-3"><input type="text" v-model="food" class="form-control input-lg" placeholder="Food"></div>
              <div class="col-xs-3"><input type="text" v-model="mood" class="form-control input-lg" placeholder="Mood"></div>
              <div class="col-xs-3"><input type="text" v-model="staff" class="form-control input-lg" placeholder="staff"></div>
            </div>
            <div class="row">
              <textarea class="form-control input-lg" v-model="comment" rows="3" id="comment" placeholder="Comment"></textarea>
              <div class="row">
                <button @click="newRatingItem" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
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
            <div id="main_content">
              <div class="row">
                <div class="container">
                  <div v-cloak class="container pdb15 restoinfo">
                    <div class="row">
                      <div class="col-xs-6"><h2>{{name}}</h2></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6"><a class="actionButton" :href="url"><i class="fa fa-link fa-3x"></i></a></div>
                      <div class="col-xs-12 restoinfo">
                        <p><b>Type</b>: {{type}}</p>
                        <p><b>Url</b>: {{url}}</p>
                        <p><b>Most Expensive</b>: {{mostExpensive}}</p>
                      </div>
                    </div>
                    <div class="row">
                    <create-menu-item-component></create-menu-item-component>
                    <create-rating-item-component></create-menu-item-component>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        
                        <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">Managers</h3></div>
                        <div class="panel-body">
                        <ul><transition-group name="list">
                        <div class="row menuObject" v-for="(o, index) in managers" :key="o.uid">
                          <div>
                            <b>Name</b>: {{o.name}}<br> 
                            <b>Email</b>: {{o.email}}<br> 
                            <b>Joined</b>: {{o.joined}}<br> 
                            <b>Rep</b>: {{o.reputation}}<br>
                            <b>Type</b>: {{o.type}}<br>
                            <br>
                          </div>
                        </div>
                      </transition-group></ul></div>
                    </div>
                      
                      
                    </div>
                    <div class="col-xs-6">


                        <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">Locations</h3></div>
                        <div class="panel-body">
                        <ul><transition-group name="list">
                        <div class="row menuObject" v-for="(o, index) in locations" :key="o.lid">
                          <div>
                            <b>Open</b>: {{o.hour_start}}<br> 
                            <b>Close</b>: {{o.hour_end}}<br> 
                            <b>Address</b>: {{o.address}}<br> 
                            <b>Opened</b>: {{o.opened}}<br>
                            <b>Phone</b>: {{o.phone}}<br>
                            <br>
                          </div>
                        </div>

                      </transition-group></ul></div>
                    </div>
                    </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="panel panel-default">
                          <div class="panel-heading"><h3 class="panel-title">Menu</h3></div>                  
                          <div class="panel-body">
                        <ul><transition-group name="list">
                        <div class="row menuObject reviews" v-for="(o, index) in menu" :key="o.mid">
                          <div>
                            <b>Name</b>: {{o.name}} 
                            <a class="actionButton" @click="deleteMenuItem(o.mid)"><i class="fa fa-times fa-2x"></i></a><br>
                            <b>Category</b>: {{o.category}}<br> 
                            <b>Type</b>: {{o.type}}<br> 
                            <b>Price</b>: {{o.price}}<br>
                            <b>Description</b>: {{o.description}}<br>

                          </div>
                        </div>
                      </transition-group></ul>
                    </div>
                      </div>
                    
                    </div>
                    
                    
                      <div class="row">
                        <div class="panel panel-default">
                          <div class="panel-heading"><h2 class="panel-title">Rater Counts</h2></div>
                          <div class="panel-body">
                            <ul><transition-group name="list">
                              <div class="row menuObject reviews" v-for="(o, index) in rater_counts" :key="o.uid">
                                <b>{{o.name}}</b>({{o.count}})
                              </div>
                            </transition-group></ul>
                          </div>
                        </div>
                      </div>
                      
                      
                      
                      <div class="row">
                        <div class="panel panel-default">
                          <div class="panel-heading"><h3 class="panel-title">Reviews</h3></div>
                          <div class="panel-body">
                          <ul><transition-group name="list">
                          <li class="row menuObject reviews" v-for="(o, index) in ratings" :key="o.key">
                            <div class="item-text">
                              <b>Name</b>: {{o.name}} <br>
                              <b>Date</b>: {{o.date_rated}}<br> 
                              <b>Food</b>: {{o.food}}<br> 
                              <b>Mood</b>: {{o.mood}}<br> 
                              <b>Staff</b>: {{o.staff}}<br> 
                              <b>Price</b>: {{o.price}}<br>
                              <b>Comment</b>: {{o.comment}}<br>

                            </div>
                          </li>
                        </transition-group></ul>
                      </div>
                        </div>  
                      </div>
                      
                      
                      
                    </div>
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
