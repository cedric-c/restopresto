<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerPerson extends Controller {

    // H)
    const GET_LOWER_STAFF_RATING = 'lower_staff_rating';

    /**
     * The location for all the app's files.
     */
    public function getAppDir(): string {
        return 'person';
    }
    
    /**
     * The print friendly version of the app name.
     */
    public function getAppName(): string {
        return 'Profile';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return 'person';
    }
    
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Restaurant();
        
        if($action == self::GET_LOWER_STAFF_RATING){
            $result = $model->staffRateLowerThanRater($data);
            Response::add('state', 'success');
            Response::add('payload', $result);
        } else if ($action == '') {
            $id = (int) $model->getNextId();
            $name = $data['name'];
            $type = $data['type'];
            $url  = $data['url'];
            // echo 'nextid: ',$id;
            $result = $model->insert($id, $name, $type, $url);
            if ($result == 1){
                $newResto = $model->get($id);
                Response::add('payload', $newResto);
                Response::add('state', 'success');
            } else {
                Response::add('state', 'error');
                Response::add('message', 'Could not create restaurant');
            }
        } else if ($action == '') {
            $menuModel  = new MenuItem();
            $result     = $menuModel->getKeyValue('rid', $data);
            Response::add('payload', $result);
            Response::add('state', 'success');
        
        } else if ($action == '') {
            $data       = $model->getAll();
            Response::add('payload', $data);
            Response::add('state', 'success');
                
        } else if ($action == '') {
            $result         = $model->getUnrated();
            Response::add('payload',$result);
            Response::add('state', 'success');
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');
        }
        Response::send();
    }
    
}