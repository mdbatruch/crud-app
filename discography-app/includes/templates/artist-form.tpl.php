<?php 

    $add_artist_action = REWRITE_URLS ?
        SITE_ROOT . 'add_entry' :
        SITE_ROOT . '?action=add_entry';
?>
   <form action="<?php echo $add_artist_action; ?>" method="post" style="float: left;">
    <fieldset>
            <legend>Add an Album by an Artist</legend>
                <ul id="submission-form">
                    <li>
                      <?php echo $errors['artist_name']; ?>
<!--                       <label>Artist:</label>-->
                        <input type="text"
                               size="80"
                               name="artist_name"
                               placeholder="artist"
                               value="<?php echo $_POST[ 'artist_name' ]; ?>"/>
                    </li>
                    <li>
<!--                       <label>Album:</label>-->
                        <input type="text" 
                               name="album_name"
                               placeholder="album"
                               value="<?php echo $_POST[ 'album_name' ]; ?>" />
                    </li>
                    <li>
<!--                       <label>Year of Release:</label>-->
                        <input type="text"
                               name="year_release"
                               placeholder="Year of Release"
                               value="<?php echo $_POST[ 'year_release' ]; ?>" />
                    </li>
                    <li>
<!--                       <label>Upload:</label>-->
                        <input type="file" name="upload">
                    </li>
                    
                    <li>
                        <input type="submit" name="submit" />
                    </li>
                </ul>
    </fieldset>
</form>

<?php

        $curl = curl_init();

        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.discogs.com/artists/1/releases?page=1&per_page=75",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $config['useragent'],
            CURLOPT_REFERER => 'https://www.discogs.com/',
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic Og=="
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $response = json_decode($response);

            // echo '<pre>';
            // print_r($response->releases);
        }
?>

<div class="artist-search">
    <ul id="response-test">
        <?php
            $count = 0;
            foreach ($response->releases as $artist) {
                $count++;
                // for ($count=0; $count <= 4; $count++) { 
                    echo '<li class="test">';
                    echo '<p id="artist-name" class="data">';
                    echo $artist->artist;
                    echo '</p>';
                    echo '<p id="album-name" class="data">';
                    echo $artist->title;
                    echo '</p>';
                    echo '<p id="year-name" class="data">';
                    echo $artist->year;
                    echo '</p>';
                    echo '</li>';
                // }
                echo $count;
                if ($count==3) {
                    break;
                }
            } 
        ?>
    </ul>
</div>
<div class="clearfix"></div>