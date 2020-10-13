<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
<div id="wrapper">
    <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Edit your post
                    </h1>
                </div>
<form action="" method="POST" enctype="multipart/form-data">
    <div class = "form-group">
        <label for = "post_title">Post Title</label>
        <input type="text" id = "post_title" class = "form-control" name="post_title" value="<?=$data["post_title"]?>">
        <span class = "text-danger"><?=$data["post_title_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "post_category_id">Post Category</label><br>
        <select name="post_category_id" id = "post_category_id">
            <?php
            foreach($data["categories"] as $category) { // categories
                $cat_id = $category["cat_id"];
                $cat_title = $category["cat_title"];
//                $selected = $cat_id == $post_cat_id ? "selected" : "";
                echo "<option value = '{$cat_id}'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class = "form-group">
        <label for = "post_image">Post Image</label><br>
        <img width = "200" src="<?=URL_ROOT?>/public/images/<?=htmlspecialchars($data["post_image"])?>" alt = "Loading image">
        <input type="file" name="post_image">
    </div>
    <div class = "form-group">
        <label for = "post_tags">Post Tags</label>
        <input type="text" id = "post_tags" class = "form-control" name="post_tags" value="<?=htmlspecialchars($data["post_tags"])?>">
        <span class = "text-danger"><?=$data["post_tags_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "post_content">Post Content</label><br>
        <textarea class = "form_control" id = "post_content" cols = "90" rows = "10" name = "post_content"><?=htmlspecialchars($data["post_content"])?></textarea><br>
        <span class = "text-danger"><?=$data["post_content_error"]?></span>
    </div>
    <div class = "form-group">
        <label for = "post_status">Post Status</label><br>
        <select id="post_status" name="post_status">
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
        </select>
    </div>
    <div class = "form-group">
        <input type = "hidden" name = "post_id" value = "<?=$row["post_id"]?>">
        <input type="submit" name="submit_edit" value = "Edit Post" class = "btn btn-primary">
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