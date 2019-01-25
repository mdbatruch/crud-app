<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Login Here</title>
        
        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/font-awesome.css"' ?>/>
        <!-- Bootstrap -->
        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/bootstrap.css"' ?>/>
        <!-- main stylesheet link -->
        <link rel="stylesheet" <?php echo 'href="' . SITE_ROOT . 'css/stylesheet.css"' ?>/>
        
        <!-- HTML5Shiv: adds HTML5 tag support for older IE browsers -->
        <!--[if lt IE 9]>
	    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">
       
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div id="sign-in-container" class="col-md-8 mt-5">
                    <!-- <form action="<php echo $_SERVER[ 'REQUEST_URI' ]; ?>" method="post" id="login-form"> -->
                    <form action="login-process.php" method="post" id="login-form">
                        <div id="sign-in">
                        <h1>Please Login Here</h1>
                            <div class="form-group">
                                <?php

                                if (!isset($_POST['email'])) {
                                    $_POST['email'] = '';
                                }

                                ?>
                                <label>Email</label>
                                <div class="controls">
                                    <input type="text" id="login-form-email" name="email"/>
                                    <div id="email-warning">
                                        <!-- <php 
                                            if (!isset($errors['email'])) {
                                                $errors['email'] = '';
                                            } else {
                                                echo '<div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">'
                                                    . $errors['email'] . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                            }
                                        > -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="controls">
                                    <input type="password" id="login-form-password" name="password" />
                                    <div id="password-warning">
                                        <!-- <php 
                                            if (!isset($errors['password'])) {
                                                $errors['password'] = '';
                                            } else {
                                                echo '<div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">'
                                                    . $errors['password'] . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                            }
                                        > -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    <input type="submit" id="login-form-submit" name="Log In" />
                                </div>
                            </div>
                        </div>
                        <div id="form-message"></div>
                        <div id="logout-message">
                            <?php if (isset($_SESSION['logout_message'])) : ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['logout_message']; 
                                        unset($_SESSION['logout_message']);
                                        session_destroy();
                                    ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php else : ?>
                                <h3></h3>
                            <?php endif; ?>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                </div>
            <div class="col-md-2"></div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="js/bootstrap.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

            <script type="text/javascript">

                // $(document).ready(function() {

                // $('#login-form').submit(function(e){
                //     e.preventDefault();
                // });

                // });

                $("#login-form").on("submit", function(e){

                    // alert('test');

                    e.preventDefault();

                    // function loginForm() {

                        var password = $("#login-form-password").val();
                        var email = $("#login-form-email").val();

                        $.ajax({
                            type: "POST",
                            url: "login-process.php",
                            dataType: "json",
                            data: {password:password, email:email},
                        }).done(function(data){

                            if (!data.success) {

                                    if (data.errors.email) {

                                        $('#email-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                    } else {
                                        $('#email-warning').html('');
                                    }

                                    if (data.errors.password) {

                                    $('#password-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                        } else {
                                    $('#password-warning').html('');
                                    }
                                
                                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                
                                    console.log('Not In!');
                                    // alert('Not In!');

                                } else {

                                    // window.location.replace("http://localhost:8888/Web-Stuff/crud-app/discography-app/");

                                    $(location).attr('href', 'http://localhost:8888/Web-Stuff/crud-app/discography-app/')

                                    // window.location.replace(data.redirecturl);

                                    // header('Location:' + data.redirecturl);
                                    
                                    console.log('Just got in!');
                                    // alert('Just got in!');

                                    // $('.alert-danger').remove();

                                    // $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                                    // $('#login-form').trigger("reset");
                                }
                            
                        });

                    // }
                });
            </script>
            <script id="__bs_script__">//<![CDATA[
            document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
            //]]></script>
        </div>
    </body>
</html>