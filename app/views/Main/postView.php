<?php require_once APP_ROOT . "/views/includes/header.php";?>
<?php require_once APP_ROOT . "/views/includes/navigation.php";?>
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-8">

            <?php
            showPost($data["post"]);
            if ($data["editButton"]) {
                echo '<a class="btn btn-primary" style="" href="'.URL_ROOT.'/admin/posts/'.$data["post"]["post_id"].'?source=edit_post">Edit Post</a>';
            }
            ?>
            <!-- Comments Form -->
            <?php
            if (isset($_SESSION["user_id"])) { ?>
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="comment_content">Text</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="comment_content"></textarea>
                        </div>
                        <button type="submit" onclick="return doCommentsValidate();" class="btn btn-primary" name="create_comment">Comment!</button>
                    </form>
                </div>
            <?php } ?>
            <!-- Posted Comments -->

            <!-- Comment -->
            <h3>Comment section</h3>
            <?php
            showSuccess();
            showError();
            foreach ($data["comments"] as $comment) { ?>
                <div class = "media">
                    <a class="pull-left" href="#"><img class="media-object" src = "http://placehold.it/64x64" alt = "Loading image"></a>
                    <div class = "media-body">
                        <h4 class="media-heading"><?=$comment["comment_author"]?>
                            <small><?=$comment["comment_date"]?></small>
                        </h4>
                        <?=$comment["comment_content"]?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        require_once APP_ROOT."/views/includes/sidebar.php";
        ?>
    </div>
    <?php require_once APP_ROOT . "/views/includes/footer.php";?>
