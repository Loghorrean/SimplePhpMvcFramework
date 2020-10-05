<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
<div id="wrapper">
    <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users <a href="?source=add_user" class="btn btn-primary">Add New</a>
                    </h1>
                </div>
                <?php
                showError();
                showSuccess();
                ?>
                <table class = "table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Role</th>
                        <th>Delete user</th>
                        <th>Edit user</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data["users"] as $user) { ?>
                        <tr>
                            <td><?=htmlspecialchars($user["user_id"])?></td>
                            <td><?=htmlspecialchars($user["username"])?></td>
                            <td><?=htmlspecialchars($user["user_password"])?></td>
                            <td><?=htmlspecialchars($user["user_firstname"])?></td>
                            <td><?=htmlspecialchars($user["user_lastname"])?></td>
                            <td><?=htmlspecialchars($user["user_email"])?></td>
                            <td><?=htmlspecialchars($user["user_image"])?></td>
                            <td><?=htmlspecialchars($user["user_role"])?></td>
                            <td><a href="/mvcframework/admin/users?delete=<?=$user["user_id"]?>">Delete</a></td>
                            <td><a href="/mvcframework/admin/users/<?=$user["user_id"]?>?source=edit_user">Edit</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
                if (isset($_GET["delete"])) {
                    showDeleteUserForm($_GET["delete"]);
                }
                ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php require_once APP_ROOT . "/views/includesAdmin/adminFooter.php";?>