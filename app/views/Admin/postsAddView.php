<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
<div id="wrapper">
    <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Add another Post!
                    </h1>
                </div>
<form action="" method="POST" enctype="multipart/form-data">
    <div class = "form-group">
        <label for = "post_title">Post Title</label>
        <input type="text" class = "form-control" name="post_title" id="post_title" value = <?=$data["post_title"]?>>
        <span class = "text-danger"><?=$data["post_title_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "post_category_id">Post Category</label><br>
        <select name="post_category_id" id = "post_category_id">
            <?php
            foreach($data["categories"] as $category) {
                $cat_id = $category["cat_id"];
                $cat_title = $category["cat_title"];
                echo "<option value = '{$cat_id}'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class = "form-group">
        <label for = "post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class = "form-group">
        <label for = "post_tags">Post Tags</label>
        <input type="text" class = "form-control" name="post_tags" id = "post_tags" value = <?=$data["post_tags"]?>>
        <span class = "text-danger"><?=$data["post_tags_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "body">Post Content</label><br>
        <textarea class = "form_control" id = "body" cols = "30" rows = "20" name = "post_content">
            <?=$data["post_content"]?>
        </textarea>
        <span class = "text-danger"><?=$data["post_content_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "post_status">Post Status</label>
        <select name="post_status" id = "post_status">
            <option value = "published">Published</option>
            <option value = "draft">Draft</option>
        </select>
    </div>
    <div class = "form-group">
        <input type="submit" name="create_post" value = "Create Post" class = "btn btn-primary">
    </div>
</form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->
<?php require_once APP_ROOT . "/views/includesAdmin/adminFooter.php";?>