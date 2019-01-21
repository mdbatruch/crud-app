<?php

    $add_artist_action = REWRITE_URLS ?
        SITE_ROOT . 'add_entry' :
        SITE_ROOT . '?action=add_entry';

        if (!isset($_POST['artist_name'])){
            $_POST['artist_name'] = '';
        }

        if (!isset($_POST['album_name'])){
            $_POST['album_name'] = '';
        }

        if (!isset($_POST['year_release'])){
            $_POST['year_release'] = '';
        }
?>
   <form action="<?php echo $add_artist_action; ?>" method="post" style="float: left;">
    <fieldset>
            <legend>Add an Album by an Artist</legend>
                <ul id="submission-form">
                    <li>
                      <?php 
                            if (!isset($errors['artist_name'])) {
                                $errors['artist_name'] = '';
                            } else {
                                echo $errors['artist_name'];
                            }
                        ?>
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

<div id="wanted-list">

<?php 
    // $t = time();

    // $format = date("H",$t);

    // $newtime = $t + 20;
    // // echo date("H:i:s");
    // echo $t;
    // echo '<br/>';
    // echo $newtime;

    // if ($format > 7203423234565430) {
    //     echo 'expired';
    // } else {
    //     echo 'not expired';
    // }

    // echo $_SESSION['expire'];
    echo $_SERVER['REQUEST_TIME'];
    echo '<br/>';
    echo $_SESSION['LAST_ACTIVITY'];
    echo '<br/>';
?>
    Hello Mike, here's your wanted list.
</div>


<?php

        $curl = curl_init();

        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.discogs.com/users/mdbatruch/wants",
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
                'authorization: OAuth oauth_consumer_key="QqEvzUDLnQlhOtIfXgki", oauth_nonce="PdPcf7jUZHJOMTS8Iz9j6G7XqmuCKfLX", oauth_signature="z%2Fs5zYhWwIQvarj5Mc1ZIAX8jlg%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1547830193", oauth_token="WZmaWBUvZRwNVnLQaxXANIytUzgSFNyvxJCBvhGg", oauth_version="1.0"',
                'content-type: application/xml'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $wants = json_decode($response);

            // echo '<img src="' . $wants->basic_information->cover_image . '" height="60" width="60">' . '<br/>';
            // echo $wants->basic_information->artists[0]->name . '<br/>';
            // echo $wants->basic_information->title;
            // echo '<pre>';
            // print_r($wants->wants[1]);

            $count = 1;
            echo '<ul style="list-style: none; float: left;">';
            foreach ($wants->wants as $wantlist) {
                // echo $count++;
                    echo '<li class="test" style="float: left; margin: 40px;">';
                    echo '<p id="artist-name" class="data">';
                    echo $wantlist->basic_information->artists[0]->name;
                    echo '</p>';
                    echo '<p id="album-name" class="data">';
                    echo '<img src="' . $wantlist->basic_information->cover_image . '" height="120" width="120">' . '<br/>';
                    echo $wantlist->basic_information->title;
                    echo '</p>';
                    echo '<p id="year-name" class="data">';
                    echo $wantlist->basic_information->year;
                    echo '</p>';
                    echo '</li>';
                if ($count==4) {
                    break;
                }
            }
            echo '</ul>';
}
?>

<?php

        $curl = curl_init();

        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

        curl_setopt_array($curl, array(
            // CURLOPT_URL => "https://api.discogs.com/artists/1/releases?page=1&per_page=75",
            // CURLOPT_URL => "https://api.discogs.com/artists/1167086",
            CURLOPT_URL => "https://api.discogs.com/artists/1167086/releases?year=2010",
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
            // print_r($response);
        }
?>

<?php

        $curl = curl_init();

        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.discogs.com/labels/249513/releases?page=1",
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

        $labelresponse = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $labelresponse = json_decode($labelresponse);

            // echo '<pre>';
            // print_r($labelresponse);
        }
?>

<!-- <php
        foreach ($labelresponse->releases as $label ) {
            echo $label->title;
            echo '<br/>';
        }
> -->



<!-- <div class="artist-search">
    <ul id="response-test">
        <span>
            <php 
                echo $response->releases[0]->artist;
            ?>
        </span>
        <php
            $count = 0;
            foreach ($response->releases as $release) {
                $count++;
                // for ($count=0; $count <= 4; $count++) { 
                    echo '<li class="test">';
                    echo '<p id="artist-name" class="data">';
                    echo $release->title;
                    echo '</p>';
                    echo '<p id="album-name" class="data">';
                    // echo $release->label;
                    echo '</p>';
                    echo '<p id="year-name" class="data">';
                    echo $release->year;
                    echo '</p>';
                    echo '</li>';
                // }
                // echo $count;
                if ($count==4) {
                    break;
                }
            } 
        ?>
    </ul>
</div>-->
<div class="clearfix"></div>