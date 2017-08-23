<?php

?>
               

<form action="" method="post">
    <fieldset>
            <legend>Add an Album by an Artist</legend>
                <ul>
                    <li>
                      <?php echo $errors['artist_name']; ?>
                       <label>Artist:</label>
                        <input type="text"
                               size="80"
                               name="artist_name"
                               value="<?php echo $_POST[ 'artist_name' ]; ?>"/>
                    </li>
                    <li>
                       <label>Album:</label>
                        <input type="text" 
                               name="album_name"
                               value="<?php echo $_POST[ 'album_name' ]; ?>" />
                    </li>
                    <li>
                       <label>Year of Release:</label>
                        <input type="text"
                               name="year_release"
                               value="<?php echo $_POST[ 'year_release' ]; ?>" />
                    </li>
                    <li>
                       <label>Upload:</label>
                        <input type="file" name="upload">
                    </li>
                    
                    <li>
                        <input type="submit" name="submit" />
                    </li>
                </ul>
    </fieldset>
</form>