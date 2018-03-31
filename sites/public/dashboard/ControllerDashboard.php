<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerDashboard extends Controller {

    const GET_LOCATION          = 'get_location';  // a2
    const GET_MENU              = 'get_menu';      // c1 d2
    const GET_MOST_EXPENSIVE    = 'get_most_expensive'; // d1
    const GET_MANAGER_INFO      = 'get_manager_info';
    const NEW_MENU_ITEM         = 'new_menu_item';
    const DELETE_MENU_ITEM      = 'delete_menu_item';
    const GET_RATINGS           = 'get_ratings';

    const INSERT_REVIEW         = 'create_review';
    const DELETE                = 'delete';
    const GET_HIGHEST_RATERS    = 'get_high_raters';
    

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
        Response::add('payload', $post);
        Response::add('custom', ';)');
        Response::add('state', 'success');
        Response::send();
            
    }
    
}