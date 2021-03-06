<?php require_once APP_ROOT . "/views/includes/header.php";?>
<?php require_once APP_ROOT . "/views/includes/navigation.php";?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            flashMessager("success");
            flashMessager("error");
            ?>
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
                    showPost($post, true);
                }
            }
            ?>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <?php for($i = 1; $i <= $data["countPosts"]; $i++) { ?>
                    <li><a href = "<?=URL_ROOT?>?page=<?=$i?>"><?=$i?></a></li>
                <?php } ?>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>
        <?php
        require_once APP_ROOT."/views/includes/sidebar.php";
        ?>
    </div>
<?php require_once APP_ROOT . "/views/includes/footer.php";?>
