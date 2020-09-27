<?php require_once APP_ROOT . "/views/includes/header.php";?>
<?php require_once APP_ROOT . "/views/includes/navigation.php";?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Main Page
            </h1>
            <!-- First Blog Post -->
            <?php
            if (empty($data["posts"])) {
                echo '<h1 class="text-center">No Published Posts Yet</h1>';
            }
            else {
                foreach($data["posts"] as $post) {
                    $post["post_content"] = (strlen($post["post_content"]) > 35) ? substr($post["post_content"], 0, 35)."..." : $post["post_content"];
                    showPost($post, true);
                }
            }
            ?>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>
    </div>
</div>
<?php require_once APP_ROOT . "/views/includes/footer.php";?>
