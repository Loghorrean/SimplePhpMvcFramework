<?php require_once APP_ROOT . "/views/includes/header.php";?>
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value = "<?=$data["name"]?>">
                                <span class = "text-danger"><?=$data["name_error"]?></span>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value = "<?=$data["email"]?>">
                                <span class = "text-danger"><?=$data["email_error"]?></span>
                            </div>
                            <div class="form-group">
                                <label for="key1" class="sr-only">Password</label>
                                <input type="password" name="password" id="key1" class="form-control" placeholder="Password" value = "<?=$data["password"]?>">
                                <span class = "text-danger"><?=$data["password_error"]?></span>
                            </div>
                            <div class="form-group">
                                <label for="key2" class="sr-only">Verify Password</label>
                                <input type="password" name="verify_password" id="key2" class="form-control" placeholder="Repeat password" value = "<?=$data["verify_password"]?>">
                                <span class = "text-danger"><?=$data["verify_password_error"]?></span>
                            </div>
                            <input type="submit" name="submitReg" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                        <p></p>
                        <a href="./login"><button class = "btn btn-custom btn-lg btn-block">Already have an account? - Sign In!</button></a>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
<?php require_once APP_ROOT . "/views/includes/footer.php";?>