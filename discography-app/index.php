<?php

    session_start();
    

    //LOAD CONFIGURATION SETTINGS
    require('includes/config.inc.php');
    
    //CONNECT TO THE DATABASE
    require('includes/connect.inc.php');

    //LOAD THE FUNCTIONS
    require('includes/functions.inc.php');


    $page_title = 'Discography Application';

    $errors = array();

    $template = 'album-list.tpl.php';

    if( strlen( $_SERVER[ 'QUERY_STRING' ] ) == 0 ){
        //if so, set the action to a known value of home
        $_GET[ 'action' ] = 'home';
    }


    //ROUTER STUFF
    require('includes/router.inc.php');

    include('includes/templates/' . $template );

//    require('../php-discogs-api-example/web/index.php');
?>