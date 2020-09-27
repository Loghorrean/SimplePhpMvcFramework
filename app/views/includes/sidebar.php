<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Log In Form</h4>
        <?php
        showError();
        showSuccess();
        ?>
        <form action="includes/login.php" method="POST">
            <div class="form-group">
                <input type="text" name = "username" class="form-control" placeholder="Enter username">
            </div>
            <div class="input-group">
                <input type="password" name = "password" class="form-control" placeholder="Enter password">
                <span class = "input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Submit</button>
                        </span>
                <?php if (isset($_SESSION["user_id"])) { ?>
                    <span class = "input-group-btn">
                                <button class="btn btn-primary" name="logout" type="submit">Logout</button>
                            </span>
                <?php } ?>
            </div>
            <div class = "input-group">
                <input type="checkbox" name="remember" value="1"> Remember me
            </div>
        </form>
        <?php
        if (!isset($_SESSION["user_id"])) { ?>
            <div class = "form-group">
                <h4>Don't have an account yet? - <a href = "registration.php">Make one!</a></h4>
            </div>
        <?php } ?>
        <!-- /.input-group -->
    </div>


    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
            <div class="input-group">
                <input type="text" name = "search" class="form-control">
                <span class="input-group-btn">
                        <button name = "submit" type = "submit" class="btn btn-default" type="button">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    foreach ($data["categories"] as $category) {
                        echo "<li><a href = '".URL_ROOT."/main/cat/{$category["cat_id"]}'>{$category["cat_title"]}</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php
    require_once APP_ROOT."/views/includes/widget.php";
    ?>

</div>