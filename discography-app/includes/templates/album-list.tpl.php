<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        
        <title><?php echo $page_title; ?></title>
        
        <!--            FONT AWESOME            -->
        <link rel="stylesheet" href="../../css/font-awesome.css" />
        
        <!-- main stylesheet link -->
        <link rel="stylesheet" href="css/stylesheet.css" />
               
        <!-- HTML5Shiv: adds HTML5 tag support for older IE browsers -->
        <!--[if lt IE 9]>
	    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header>
            <h1>Album Listing</h1>
               <div id="search-container">
                    <form id="search-bar" action="<?php echo $_SERVER[ 'PHP_SELF' ]; ?>?action=search" method="post">
                            <div id="search-icon">
                               <input type="text"
                                name="search-bar"
                                placeholder="Search..">
                                <button type="submit">
                                    <i class="fa fa-search fa-3x" aria-hidden="true"></i>
                                </button>
                            </div>
    <!--                   <input type="submit" name="search-submit" value="Search">-->
                    </form>
               </div>
        </header>
<!--        <p>Hello, here are your albums.</p>-->
       <main>
           
           <?php 
                echo $errors[ 'delete' ];
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