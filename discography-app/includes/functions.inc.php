<?php 

        function redirect( $url ){
            
            header( 'Location: ' . $url );
            die( "Redirect to <a href=\"$url\">$url</a> failed.");
        }

            //SANITIZE ENTRIES

        function sanitize( $database, $data ){
            
            $data = trim( $data );
            $data = strip_tags( $data );
            $data = mysqli_real_escape_string( $database, $data );
            
            return $data;
        }


            //RETRIEVE ENTRY FUNCTION

        function get_entry( $database ){
            
            $addition = 'SELECT
                            id,
                            band_name,
                            album,
                            year
                                FROM discography';
            
            $result = mysqli_query( $database, $addition )
                            or die( mysqli_error( $database ) );
            return $result;
        }


            //ADD ENTRY FUNCTION


        function add_entry( $database, $artist_name, $album_name, $year_release ){
    
                $errors = array();
            
            if( strlen( $_POST[ 'artist_name' ] ) < 1 ){
                
                $errors['artist_name'] = '<p>Please enter an artist</p>';
            }
            
            if( strlen( $_POST[ 'album_name' ] ) < 1 ){
                
                $errors['album_name'] = '<p>Please enter an album</p>';
            }
            
            if( is_nan($_POST[ 'year_release' ]) ){
                
                $errors['year_release'] = '<p>Please enter a valid year</p>';
            }
            
            if( count( $errors ) == 0 ){
                
                $artist_name = sanitize( $database, $artist_name );
                
                $album_name = sanitize( $database, $album_name );
                
                $year_release = sanitize( $database, $year_release );
            
            
    $addition = "INSERT INTO discography(band_name, album, year)
                    VALUES('$artist_name', '$album_name', '$year_release')";
            
            $result = mysqli_query( $database, $addition )
        or die( mysqli_error( $database ) );
            
            if ( $result == true ){
                
                echo 'Success!';
                    
                //header( 'Location: ' . $_SERVER[ 'PHP_SELF' ] );
                //redirect( $_SERVER[ 'PHP_SELF' ] );
               
                
                
            }
    }
           return $errors;
}
        
        function delete_entry( $database, $delete_id){
            
            $errors = array();
            
            $delete_id = sanitize( $database, $delete_id );
            
            $deletion = "DELETE FROM discography
                        WHERE id = $delete_id
                        LIMIT 1";
            
            $result = mysqli_query( $database, $deletion )
                            or die( mysqli_error( $database ) );
            
            if ( $result == true ) {
                //header( 'Location: ' . $_SERVER[ 'PHP_SELF' ] );
                redirect( SITE_ROOT );
            } else {
                
                $errors[ 'delete' ] = '<p class="error">
                                            Could not delete, please try again.
                                        </p>';
            }
            return $errors;
        }
            //LOG IN STUFF

        function log_in( $database, $email, $password ){
            
            $errors = array();
                
            //VALIDATE THAT EMAIL IS IN PROPER FORMAT
                if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
                    $errors[ 'email' ] = '<p class="error">
                                            Please enter a proper email.</p>';
                    
                }
            
            //VALIDATE THAT PASSWORD IS CORRECT
                
                if( strlen( $password ) < 1 ){
                    
                    $errors[ 'password' ] = '<p class="error">
                                            Please enter a proper password.</p>';
                }
            
            if( count( $errors ) == 0 ){
                
                $email = sanitize( $database, $email );
                
                $addition = "SELECT
                                    id,
                                    firstname,
                                    lastname,
                                    password
                                        FROM users
                                        WHERE email ='$email'
                                        LIMIT 1";
                
                $result = mysqli_query( $database, $addition )
        or die( mysqli_error( $database ) );
                
                if( mysqli_num_rows( $result ) > 0){
                    
                    $row = mysqli_fetch_assoc( $result );
                    
                    if(md5($password) === $row[ 'password']){
                        
                        $_SESSION[ 'login_token' ] = LOGGED_IN;
                        $_SESSION[ 'user_id '] = $row[ 'id' ];
                        $_SESSION[ 'firstname' ] = $row[ 'firstname' ];
                        $_SESSION[ 'lastname' ] = $row[ 'lastname' ];
                        $_SESSION[ 'email' ] = $email;
                        
                        //redirect( '/' );
                        redirect( SITE_ROOT );
                    } else {
                        
                        $errors[ 'password' ] = '<p class="error">
                                                    Wrong Password.
                                                </p>';
                    } 
                }else {
                        
                        $errors[ 'email' ] = '<p class="error">
                                                    No Email like this.
                                                </p>';
                    }
            }
            
            return $errors;
        }
                 

        function check_login(){

            //if user is not logged in
            if( strcmp( $_SESSION[ 'login_token' ], LOGGED_IN ) != 0 ){
                if( REWRITE_URLS ){
                redirect( SITE_ROOT . 'login' );
            } else {
                    redirect( SITE_ROOT . '?action=login');
                }
            }
        }

        function logout(){
            
            $_SESSION[ 'login_token' ] = null;
            $_SESSION[ 'user_id' ] = null;
            $_SESSION[ 'firstname' ] = null;
            $_SESSION[ 'lastname' ] = null;
            $_SESSION[ 'email' ] = null;
            
            unset( $_SESSION[ 'login_token' ] );
            unset( $_SESSION[ 'user_id' ] );
            unset( $_SESSION[ 'firstname'] );
            unset( $_SESSION[ 'lastname'] );
            unset( $_SESSION[ 'email' ] );
            
                if( REWRITE_URLS ){
        redirect( SITE_ROOT . 'login' );
    } else {
            redirect( SITE_ROOT . '?action=login');
        }
}



//    function get_from_api( $query ){
//        
//        $consumerKey = 'QqEvzUDLnQlhOtIfXgki';
//        $consumerSecret = 'ViJWGMiEQrLAuMpIahyEOgfMiFQawWNX';
//        $token = 'WZmaWBUvZRwNVnLQaxXANIytUzgSFNyvxJCBvhGg';
//        $tokenSecret = 'IMGBMWAnGXvfqfQNieBuqDiFAQGDMdwYjnBWlXgA';
//
//      //  require '../vendor/autoload.php';
//        
//        require '../../php-discogs-api-example/vendor/autoload.php';
//        
////        use OAuth\OAuth1\Service\BitBucket;
//        //use OAuth\Common\Storage\Session;
//        use OAuth\Common\Consumer\Credentials;
//
//        ini_set('date.timezone', 'Europe/Amsterdam');
//
//        $uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
//        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
//        $currentUri->setQuery('');
//        
//        
//        $client = Discogs\ClientFactory::factory([]);
//        $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
//            'consumer_key'    => $consumerKey, // from Discogs developer page
//            'consumer_secret' => $consumerSecret, // from Discogs developer page
//            'token'           => $token, // get this using a OAuth library
//            'token_secret'    => $tokenSecret // get this using a OAuth library
//        ]);
//        $client->getHttpClient()->getEmitter()->attach($oauth);
//
//        $response = $client->search([
//            //'q' => 'The Gaslight Anthem'
//
//                'q' => $query
//        ]);
//        
//        return $response;
//    }

//        function test_api( ){
//            
//            $curl = curl_init();
//            
//            // $search_query = urlencode( $search_query );
//            
//            $options = array(
//                
//                CURLOPT_URL => "https://api.discogs.com/releases/249504",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_HEADER => false,
//                CURLOPT_SSL_VERIFYPEER => false,
//                CURLOPT_USERAGENT => 'MIKES_APP/0.1 +http://mike-batruch.ca'
//            );
//            
//            curl_setopt_array( $curl, $options );
//            
//            $response = json_decode( curl_exec( $curl ) );
//            
//            return( $response );
//       }
