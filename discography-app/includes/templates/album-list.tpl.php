<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        
        <title><?php echo $page_title; ?></title>
        
        <!--            FONT AWESOME            -->
        <!-- <link rel="stylesheet" href="../../css/font-awesome.css" /> -->
        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/font-awesome.css"' ?>/>
        <!-- main stylesheet link -->
        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/stylesheet.css"' ?>/>
               
        <!-- HTML5Shiv: adds HTML5 tag support for older IE browsers -->
        <!--[if lt IE 9]>
	    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <?php

        // $search_artist_action = REWRITE_URLS ?
        // SITE_ROOT . 'search-bar' :
        // SITE_ROOT . '?action=search-bar' . $_GET['search-bar'];

        if (isset($_GET['search-bar'])) {
            function get_from_api( $query ){
       
                global $consumerKey;
                global $consumerSecret;
                global $token;
                global $tokenSecret;
         
                 $mySearch = $_GET['search-bar'];
         
              //  require '../vendor/autoload.php';
                
             //    require '../../php-discogs-api-example/vendor/autoload.php';
                 require dirname(SITE_ROOT) . '/vendor/autoload.php';
                
         //        use OAuth\OAuth1\Service\BitBucket;
                //use OAuth\Common\Storage\Session;
                 // OAuth\Common\Consumer\Credentials;
         
                ini_set('date.timezone', 'Europe/Amsterdam');
         
                $uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
                $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
                $currentUri->setQuery('');
                
                
                $client = Discogs\ClientFactory::factory([]);
                $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
                    'consumer_key'    => $consumerKey, // from Discogs developer page
                    'consumer_secret' => $consumerSecret, // from Discogs developer page
                    'token'           => $token, // get this using a OAuth library
                    'token_secret'    => $tokenSecret // get this using a OAuth library
                ]);
                $client->getHttpClient()->getEmitter()->attach($oauth);
         
                $response = $client->search([
                 //    'q' => 'The Gaslight Anthem'
         
                        'q' => $mySearch
                ]);
                
                return $response;
            }
        }
    ?>
    <body>
        <header>
            <h1>Album Listing</h1>
               <div id="search-container">
                    <form id="search-bar" name="q" action="<?php echo SITE_ROOT . 'index.php' ?>" method="get">
                    <!-- <form id="search-bar" name="q" action="<?php echo $search_artist_action; ?>" method="get"> -->
                            <div id="search-icon">
                               <input type="text"
                                name="search-bar"
                                placeholder="Search..">
                                <button type="submit">
                                    <i class="fa fa-search fa-2x" aria-hidden="true"></i>
                                </button>
                            </div>
    <!--                   <input type="submit" name="search-submit" value="Search">-->
                    </form>
               </div>
        </header>
<!--        <p>Hello, here are your albums.</p>-->
<span>
    <?php 
        if (isset($response)) {
            echo '<pre>';
            print_r($response);
        }
    ?>
</span>
       <main>
           <?php
                if (!isset($errors['delete'])) {
                    $errors['delete'] = '';
                } else {
                    echo $errors['delete'];
                }
           ?>
            <?php 

                include( 'includes/templates/artist-form.tpl.php' )
            ?>
               <ul id="artists"><?php while( $rows = mysqli_fetch_assoc( $result ) ): ?>
                   <li id="entry-<?php echo $rows['id']; ?>">
                        <p id="artist-name" class="data">
                            <?php echo $rows[ 'band_name' ] ?>
                        </p>
                        <p id="album-name" class="data">
                            <?php echo $rows[ 'album' ] ?>
                        </p>
                        <p id="year-name" class="data">
                            <?php echo $rows[ 'year' ] ?>
                        </p>
                        <p>
                        
                        <?php 
                        
                            $delete_href = REWRITE_URLS ?
                                SITE_ROOT . "delete/{$rows[ 'id' ]}" :
                                SITE_ROOT . "?action=delete&amp;delete-id={$rows[ 'id' ]}";
                        
                        ?>
                        <div class="delete-button">
                              <a class="delete" href="<?php echo $delete_href; ?>">Delete</a>
                       </div>
                        </p>
                   </li>
                   <?php endwhile; ?>
               </ul>
        </main>
<!--            var_dump($search_query); -->
            <div class="clearfix"></div>
            <div id="space"></div>
        <footer>
            <div id="logout">
                <a href="<?php echo SITE_ROOT . 'logout'?>">Log Out</a>
            </div>
        </footer>
        <script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
//]]></script>
    </body>
</html>