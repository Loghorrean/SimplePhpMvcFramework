<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href='<?=URL_ROOT?>'>CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                foreach ($data["categories"] as $category) {
                    echo "<li><a href = '".URL_ROOT."/main/cat/{$category["cat_title"]}'>{$category["cat_title"]}</a></li>";
                }
                if ($data["isAdmin"]) {
                    echo "<li style = 'font-weight: bold;'><a style = 'color: red;' href = '".URL_ROOT."/admin'>Admin</a></li>";
                }
                ?>
            </ul>
            <?php if (isset($_SESSION["auth"])) { ?>
                <ul class = "nav navbar-right navbar-nav">
                    <li>
                        <a href = "/mvcframework/main/author/<?=$_SESSION["username"]?>"><?=$_SESSION["username"]?></a>
                    </li>
                    <li>
                        <a href = "/mvcframework/users/logout">Logout</a>
                    </li>
                </ul>
            <?php } ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>