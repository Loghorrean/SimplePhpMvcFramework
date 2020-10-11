<?php require_once APP_ROOT . "/views/includes/header.php";?>
    <div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Login</h1>
                        <?php
                        flashMessager("registration_success");
                        flashMessager("registration_error");
                        ?>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Your Username" value = "<?=$data["name"]?>">
                                <span class = "text-danger"><?=$data["name_error"]?></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key1" class="form-control" placeholder="Password" value = "<?=$data["password"]?>">
                                <span class = "text-danger"><?=$data["password_error"]?></span>
                            </div>
                            <input type="submit" name="submitLog" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Login!">
                        </form>
                        <p></p>
                        <a href="./login"><button class = "btn btn-custom btn-lg btn-block">Don't have an account yet? Register!</button></a>
                        <p></p>
                        <a href="<?=URL_ROOT?>"><button class = "btn btn-custom btn-lg btn-block">Back to the main page</button></a>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
<?php require_once APP_ROOT . "/views/includes/footer.php";?>