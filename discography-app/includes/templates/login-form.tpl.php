<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Login Here</title>
        
        <!-- main stylesheet link -->
        <link rel="stylesheet" href="css/stylesheet.css" />
        
        <!-- HTML5Shiv: adds HTML5 tag support for older IE browsers -->
        <!--[if lt IE 9]>
	    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body>
<!--
            <form action=" echo $_SERVER[ 'REQUEST_URI' ]; ?>?action=home" method="post">-->
                <!-- <h1>
                    <php 

                        // global $timeout_message;

                        $timeout_message = true;

                        if ($timeout_message) {
                            echo $timeout_message;
                        }
                    >
                </h1> -->

                <?php if ($timeout_message): ?>
                    <h1>
                        <?php echo $timeout_message; ?>
                    </h1>
                <?php else : ?>
                    <h1>
                        NOT WORKING
                    </h1>
                <?php endif; ?>

               <form action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>" method="post" id="login-form">
               <h1>Please Login Here</h1>
                <ul>
                    <li>
                        <?php
                            if (!isset($errors['email'])) {
                                $errors['email'] = '';
                            } else {
                                echo $errors['email'];
                            }

                            if (!isset($errors['password'])) {
                                $errors['password'] = '';
                            } else {
                                echo $errors['password'];
                            }

                            if (!isset($_POST['email'])) {
                                $_POST['email'] = '';
                            }

                        ?>
                       <label>Email</label>
                        <input type="text" 
                               id="login-form-email"
                               size="80"
                               name="email"
                               value="<?php echo $_POST[ 'email' ]; ?>"/>
                    </li>
                    <li>
                        <label>Password</label>
                        <input type="password" 
                               id="login-form-password"
                               size="80"
                               name="password" />
                    </li>
                    <li>
                        <input type="submit" id="login-form-submit" name="Log In" />
                    </li>
                </ul>
                <div class="clearfix"></div>
            </form>
    </body>
</html>