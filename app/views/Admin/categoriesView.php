<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
    <div id="wrapper">
        <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories
                        </h1>
                    </div>
                    <div class = "col-xs-6">
                        <form action="" method = "POST">
                            <?php
                            flashMessager("category_add_success");
                            flashMessager("category_add_error");
                            ?>
                            <div class = "form-group">
                                <label for = "cat_title">Add Category Title</label>
                                <input class = "form-control" type="text" name="cat_title" value = <?=$data["cat_title"]?>>
                                <span class = "text-danger"><?=$data["cat_title_error"]?></span>
                            </div>
                            <div class = "form-group">
                                <input class = "btn brn-primary" type="submit" name="submit_add" value = "Add category">
                            </div>
                        </form>
                        <form action="" method = "POST">
                            <?php
                            flashMessager("category_edit_success");
                            flashMessager("category_edit_error");
                            if (isset($_GET["edit"])) {
                                showEditCategoryForm($_GET["edit"], $data["cat_title_edit"], $data["cat_title_edit_error"]);
                            }
                            flashMessager("category_delete_success");
                            flashMessager("category_delete_error");
                            if (isset($_GET["delete"])) {
                                showDeleteCategoryForm($_GET["delete"]);
                            }
                            ?>
                        </form>
                    </div><!-- Add, delete and edit category forms -->
                    <div class = "col-xs-6">
                        <table class = "table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Category Id</th>
                                <th>Category Title</th>
                                <th>Delete field</th>
                                <th>Edit field</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data["categories"] as $category) { ?>
                                <tr>
                                    <td><?=$category["cat_id"]?></td>
                                    <td><?=$category["cat_title"]?></td>
                                    <td><a href="<?=URL_ROOT?>/admin/categories?delete=<?=$category['cat_id']?>">Delete</a></td>
                                    <td><a href="<?=URL_ROOT?>/admin/categories?edit=<?=$category['cat_id']?>">Edit</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
<!-- /#page-wrapper -->
<?php require_once APP_ROOT . "/views/includesAdmin/adminFooter.php";?>
