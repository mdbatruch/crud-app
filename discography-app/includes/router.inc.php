<?php

    $search = SITE_ROOT . 'index.php';

        switch( $_GET[ 'action' ] ){
                
            case 'home':

            $_SESSION['login_token'] = LOGGED_IN;

            // echo $_SESSION['LAST_ACTIVITY'];
                
            // check_login();

            $time = $_SERVER['REQUEST_TIME'];

            $timeout_duration = 1800;

            // if (isset($_SESSION['LAST_ACTIVITY']) && 
            //     ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {

            //         // $timeout_message = 'We\'re sorry, but your session has expired. Please login again.';
                    
            //         unset( $_SESSION[ 'login_token' ] );
            //         unset( $_SESSION[ 'user_id' ] );
            //         unset( $_SESSION[ 'firstname'] );
            //         unset( $_SESSION[ 'lastname'] );
            //         unset( $_SESSION[ 'email' ] );
            //         // // unset( $_SESSION[ 'time' ] );

            //         session_unset(); 
            //         // session_destroy();

            //         $_SESSION['logout_message'] = 'We\'re sorry, but your session has expired. Please login again.';

            //         if( REWRITE_URLS ){
            //             // $timeout_message = 'We\'re sorry, but your session has expired. Please login again.';
            //             // return $timeout_message;
            //             redirect( SITE_ROOT . 'login' );
            //         } else {

            //                 // return $timeout_message;
            //                 redirect( SITE_ROOT . '?action=login');
            //             }
            //     } else {
            //         $_SESSION['LAST_ACTIVITY'] = '';
            //     }
                $result = get_entry( $database );

                break;
                
            case 'search':
                
               check_login();

               check_session();
                
                  if( isset( $_POST[ 'search-bar' ] ) ){
                    $search_results = get_from_api( $_POST[ 'search-bar' ] );
                      
                    echo '<pre>';
                    print_r( $search_results);
                    echo '</pre>';
                      
                  }
            break;
            
            case 'add_entry':
                
                check_login();

                check_session();
                
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

                check_session();
                    
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

            // case $search;

            //     check_login();

            //     check_session();

            //     function get_from_api( $query ){
       
            //         global $consumerKey;
            //         global $consumerSecret;
            //         global $token;
            //         global $tokenSecret;
             
            //          $mySearch = $_GET['search-bar'];
             
            //       //  require '../vendor/autoload.php';
                    
            //      //    require '../../php-discogs-api-example/vendor/autoload.php';
            //          require dirname(SITE_ROOT) . '/vendor/autoload.php';
                    
            //  //        use OAuth\OAuth1\Service\BitBucket;
            //         //use OAuth\Common\Storage\Session;
            //          // OAuth\Common\Consumer\Credentials;
             
            //         ini_set('date.timezone', 'Europe/Amsterdam');
             
            //         $uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
            //         $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
            //         $currentUri->setQuery('');
                    
                    
            //         $client = Discogs\ClientFactory::factory([]);
            //         $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
            //             'consumer_key'    => $consumerKey, // from Discogs developer page
            //             'consumer_secret' => $consumerSecret, // from Discogs developer page
            //             'token'           => $token, // get this using a OAuth library
            //             'token_secret'    => $tokenSecret // get this using a OAuth library
            //         ]);
            //         $client->getHttpClient()->getEmitter()->attach($oauth);
             
            //         $response = $client->search([
            //          //    'q' => 'The Gaslight Anthem'
             
            //                 'q' => $mySearch
            //         ]);
                    
            //         return $response;
            //     }

            // break;
                
            default:
                $template = '404.tpl.php';
                header( 'HTTP/1.0 404 Not Found' );
            break;
                
        }