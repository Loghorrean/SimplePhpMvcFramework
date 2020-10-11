<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href=".">CMS (Admin Page)</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="<?=URL_ROOT?>">Main Page</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?=$_SESSION["username"]?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="<?=URL_ROOT?>/admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="<?=URL_ROOT?>/admin/posts"><i class="fa fa-fw fa-dashboard"></i>View post</a>
            </li>
            <li>
                <a href="<?=URL_ROOT?>/admin/categories"><i class="fa fa-fw fa-wrench"></i> Categories page</a>
            </li>
            <li>
                <a href="<?=URL_ROOT?>/admin/users"><i class="fa fa-fw fa-file"></i> Users</a>
            </li>
            <li>
                <a href="<?=URL_ROOT?>/admin/comments"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <li>
                <a href="<?=URL_ROOT?>/main/author/<?=$_SESSION["username"]?>"><i class="fa fa-fw fa-wrench"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>