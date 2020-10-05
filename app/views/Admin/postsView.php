<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
<div id="wrapper">
    <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Posts
                    </h1>
                </div>
    <form action="" method = "POST">
        <table class = "table table-bordered table-hover">
            <div id = "bulkOptionsContainer" class = "col-xs-4">
                <select class = "form-control" name="bulkOptions" id="">
                    <option value="none" disabled>Select Option</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                </select>
            </div>
            <div class = "col-xs-4">
                <input type="submit" name="submitBulk" class="btn btn-success" value="Apply">
                <a href="?source=add_post" class="btn btn-primary">Add New</a>
            </div>
            <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"</th>
                <th>Post ID</th>
                <th>Category Title</th>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Image</th>
                <th>Content</th>
                <th>Tags</th>
                <th>Comment Count</th>
                <th>Status</th>
                <th>Number of views</th>
                <th>View Post</th>
                <th>Delete Post</th>
                <th>Edit Post</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data["posts"] as $post) {
                $cat_title = $post["cat_title"] ?? "Non existent";
                $post_author = $post["post_author"] ?? "Non existent";
                ?>
                <tr>
                    <td><input class="checkBoxes" type="checkbox" name = "checkBoxArray[]" value = <?=$post["post_id"]?>></td>
                    <td><?=htmlspecialchars($post["post_id"])?></td>
                    <td><?=htmlspecialchars($cat_title)?></td>
                    <td><?=htmlspecialchars($post["post_title"])?></td>
                    <td><?=htmlspecialchars($post_author)?></td>
                    <td><?=htmlspecialchars($post["post_date"])?></td>
                    <td><img width = "150" src="/mvcframework/public/images/<?=$post["post_image"]?>" alt = "Image"></td>
                    <td><?=htmlspecialchars($post["post_content"])?></td>
                    <td><?=$post["post_tags"]?></td>
                    <td><?=$post["post_comment_count"]?></td>
                    <td><?=$post["post_status"]?></td>
                    <td><?=$post["view_count"]?></td>
                    <td><button class = "btn"><a href="/mvcframework/main/post/<?=$post["post_id"]?>">View</a></button></td>
                    <td><button class = "btn"><a href="/mvcframework/admin/posts?delete=<?=$post["post_id"]?>">Delete</a></button></td>
                    <td><button class = "btn"><a href="/mvcframework/admin/posts/<?=$post["post_id"]?>?source=edit_post">Edit</a></button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
    <?php
    if (isset($_GET["delete"])) {
        showDeletePostForm($_GET["delete"]);
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