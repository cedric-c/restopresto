<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerRestaurant extends Controller {

    const ACTION_INSERT = 'create';
    const ACTION_DELETE = 'delete';

    public function getAppDir(): string {
        return 'restaurant';
    }
    
    public function getAppName(): string {
        return 'Restaurant List';
    }
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Restaurant();
        
        if($action == self::ACTION_DELETE){
            Response::add('target', $data);
            Response::add('state', 'success');
            Response::send();
            return;
            $result = $model->delete($data);
            if ($result == 1) {
                Response::add('state','success');
                Response::send();
            } else {
                Response::add('state','error');
                Response::add('message', 'Could not delete target from database');
                Response::send();
            }
        } else if ($action == self::ACTION_INSERT) {
            $id = (int) $model->getNextId();
            $name = $data['name'];
            $type = $data['type'];
            $url  = $data['url'];
            // echo 'nextid: ',$id;
            $result = $model->insert($id, $name, $type, $url);
            if ($result == 1){
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    
}