<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerDashboard extends Controller {
    
    // I)
    const GET_HIGHEST_RATED_FOOD = 'highest_rated_food';
    
    // J)
    const GET_MORE_POPULAR_THAN_TYPE = 'more_popular_than_type';
    
    /**
     * The location for all the app's files.
     */
    public function getAppDir(): string {
        return 'dashboard';
    }
    
    /**
     * The print friendly version of the app name.
     */
    public function getAppName(): string {
        return 'Dashboard';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return 'dashboard';
    }
    
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        
        if($action == self::GET_HIGHEST_RATED_FOOD){
            $model = new Restaurant();
            $d = $model->highestRatedInType($post['data']);
            Response::add('state', 'success');
            Response::add('payload',$d);
        } else if ($action == self::GET_MORE_POPULAR_THAN_TYPE){
            $model = new Restaurant();
            $d = $model->getMorePopularThanType($post['data']);
            Response::add('state', 'success');
            Response::add('payload', $d);
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');            
        }
        Response::send();
            
    }
    
}