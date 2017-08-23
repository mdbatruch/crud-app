<?php 

    $add_artist_action = REWRITE_URLS ?
        SITE_ROOT . 'add_entry' :
        SITE_ROOT . '?action=add_entry';
?>
   <form action="<?php echo $add_artist_action; ?>" method="post">
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