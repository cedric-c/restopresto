<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerRestaurant extends Controller {

    const INSERT = 'create';
    const DELETE = 'delete';
    const LIST_MENU = 'list_menu';

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
        
        if($action == self::DELETE){
            Response::add('payload', $data);
            $result = $model->delete($data);
            if ($result == 1) {
                Response::add('state','success');
            } else {
                Response::add('state','error');
                Response::add('message', 'Could not delete target from database');
            }
        } else if ($action == self::INSERT) {
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
        } else if ($action == self::LIST_MENU) {
            $menuModel = new MenuItem();
            $result = $menuModel->getKeyValue('rid', $data);
            Response::add('payload', $result);
            Response::add('state', 'success');
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');
        }
        Response::send();
    }
    
}