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
        return 'Restaurant Manager';
    }
    
    public function processPost(array $post): void {
        $data   = $post['data'];
        $data = json_decode($data, true);
        $action = $post['action'];
        $model = new Restaurant();
        if($action == self::ACTION_DELETE){
            // echo 'server deleting ' . $data;
            $result = $model->delete($data);
            echo $result;
        } else if ($action == self::ACTION_INSERT) {
            $id = (int) $model->getNextId();
            $name = $data['name'];
            $type = $data['type'];
            $url  = $data['url'];
            // echo 'nextid: ',$id;
            $result = $model->insert($id, $name, $type, $url);
            echo $result;
        }
    }
    
}