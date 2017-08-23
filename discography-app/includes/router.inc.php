<?php

        switch( $_GET[ 'action' ] ){
                
            case 'home':
                
               check_login();
                
                $result = get_entry( $database );
                
//                $search_query = test_api();
            
                break;
                
            case 'search':
                
               check_login();
                
                  if( isset( $_POST[ 'search-bar' ] ) ){
                    $search_results = get_from_api( $_POST[ 'search-bar' ] );
                      
                    echo '<pre>';
                    print_r( $search_results);
                    echo '</pre>';
                      
                  }
            break;
            
            case 'add_entry':
                
                check_login();
                
                    if( isset( $_POST[ 'artist_name' ] ) ){
                            $errors = add_entry(
                            
                            $database,
                            $_POST[ 'artist_name' ],
                            $_POST[ 'album_name'],
                            $_POST[ 'year_release']
                            );
                        
                    }
                $result = get_entry( $database );
            break;
                
            case 'delete':
                
                check_login();
                    
                    if (isset( $_GET['delete-id'] ) 
                        and is_numeric( $_GET[ 'delete-id'] ) ) {
                        
                            $errors = delete_entry( $database,
                                                $_GET['delete-id'] );
                    }
                
                $result = get_entry( $database );
                
            break;
                
            case 'login':
                $template = 'login-form.tpl.php';
                
                if( isset( $_POST[ 'email' ] ) ){
                    
                    $errors = log_in(
                        $database,
                        $_POST[ 'email' ],
                        $_POST[ 'password' ]
                    );
                }
            break;
                
            case 'logout':
                    logout();
            break;
                
            default:
                $template = '404.tpl.php';
                header( 'HTTP/1.0 404 Not Found' );
            break;
                
        }