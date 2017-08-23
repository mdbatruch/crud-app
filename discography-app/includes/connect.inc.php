<?php

    // DATABASE CONNECTION
    $database = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die( mysqli_connect_error() );