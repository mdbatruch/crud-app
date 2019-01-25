<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        
        <title><?php echo $page_title; ?></title>

        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/font-awesome.css"' ?>/>
        <!-- Bootstrap -->
        <!-- <link rel="stylesheet" <php echo 'href="' . SITE_ROOT . 'css/bootstrap.css"' >/> -->
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
            <div class="container-fluid">
                <div class="row">
                <div class="header-title">
                    <h1>Album Listing</h1>
                </div>
                <!-- <div class="col-md-1 col-lg-3"></div> -->
                <!-- <div id="search-container"> -->
                <div class="ml-auto">
                <nav class="navbar navbar-expand-md">
                    <!-- <button type="button" class="navbar-toggler navbar-dark navbar-toggler-right ml-auto" data-toggle="collapse" data-target="#navSearch" aria-expanded="false" aria-controls="navbar" style="border: 3px solid #fff;"> -->
                    <button type="button" class="nav-open navbar-toggler navbar-dark navbar-toggler-right ml-auto" data-toggle="offcanvas" data-target="#navSearch" aria-expanded="false" aria-controls="navbar" style="border: 3px solid #fff;">
                        <span class="icon-bar navbar-toggler-icon"></span>
                        <!-- <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> -->
                    </button>
                     <div class="navbar-collapse offcanvas-collapse" id="navSearch">
                         <ul>
                            <li>
                                <button class="close-btn navbar-toggler text-white btn-block text-center ml-auto my-1" type="button" data-toggle="offcanvas" data-target="#navSearch" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </li>
                         </ul>
                        <ul class="navbar-nav nav-fill ml-auto">
                            <li class="menu-item search ml-auto">
                                <form id="search-bar" name="q" action="<?php echo SITE_ROOT . 'index.php' ?>" method="get">
                            <!-- <form id="search-bar" name="q" action="<?php echo $search_artist_action; ?>" method="get"> -->
                                    <div id="search-icon">
                                    <input type="text"
                                        name="search-bar"
                                        placeholder="Search.." class="h-100">
                                        <button type="submit">
                                            <i class="fa fa-search fa-2x" aria-hidden="true"></i>
                                        </button>
                                    </div>
            <!--                   <input type="submit" name="search-submit" value="Search">-->
                                </form>
                            </li>
                            <li class="menu-item">
                                <a href="#">test</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">test</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">test</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">test</a>
                            </li>
                            <!-- <li>
                                <button class="navbar-toggler text-white btn-block text-center my-1" type="button" data-toggle="offcanvas" data-target="#navSearch" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </li> -->
                        </ul>
                    </div>
                </nav>
                </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </header>
    <main>
        <?php 
            if (isset($response)) {
                echo '<pre>';
                print_r($response);
            }
        ?>
       <section id="greeting">
           <div class="container-fluid pt-4 pb-4">
               Hello Mike, here is your account.
           </div>
       </section>
       <section id="main-row">
            <div class="container-fluid">
            <?php
                if (!isset($errors['delete'])) {
                    $errors['delete'] = '';
                } else {
                    echo $errors['delete'];
                }
            ?>
            <div class="row">
                <?php
                    include( 'includes/templates/artist-form.tpl.php' )
                ?>
            </div>
                <div class="row">
                    <div class="col-md-6">
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
                        </div>
                    </div>
                </div>
            </section>
        </main>
<!--            var_dump($search_query); -->
            <div class="clearfix"></div>
            <div id="space"></div>
        <footer>
            <div id="logout" class="container-fluid">
                <a href="<?php echo SITE_ROOT . 'logout'?>">Log Out</a>
            </div>
        </footer>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script type="text/javascript">

            $(function () {
                $('[data-toggle="offcanvas"]').on('click', function () {
                    // alert('you clicked');
                    $('.offcanvas-collapse').toggleClass('open');
                    $('body').toggleClass('noscroll');
                });
            });

        </script>
        <script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
//]]></script>
    </body>
</html>