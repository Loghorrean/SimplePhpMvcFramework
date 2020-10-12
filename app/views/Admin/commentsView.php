<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
    <div id="wrapper">
<?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments
                    </h1>
                </div>
                <?php
                flashMessager("comment_add_error");
                flashMessager("comment_add_success");
                ?>
                <table class = "table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Comment ID</th>
                        <th>Post ID</th>
                        <th>Email</th>
                        <th>Author</th>
                        <th>Content</th>
                        <th>In Response To</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Unapprove</th>
                        <th>Delete field</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data["comments"] as $comment) { ?>
                        <tr>
                            <td><?=htmlspecialchars($comment["comment_id"])?></td>
                            <td><?=htmlspecialchars($comment["comment_post_id"])?></td>
                            <td><?=htmlspecialchars($comment["user_email"])?></td>
                            <td><?=htmlspecialchars($comment["username"])?></td>
                            <td><?=htmlspecialchars($comment["comment_content"])?></td>
                            <td><a href="/mvcframework/main/post/<?=$comment["comment_post_id"]?>"><?=htmlspecialchars($comment["post_title"])?></a></td>
                            <td><?=htmlspecialchars($comment["comment_status"])?></td>
                            <td><?=htmlspecialchars($comment["comment_date"])?></td>
                            <td><a href="<?=URL_ROOT?>/admin/comments?approve=<?=$comment["comment_id"]?>">Approve</a></td>
                            <td><a href="<?=URL_ROOT?>/admin/comments?unapprove=<?=$comment["comment_id"]?>">Unapprove</a></td>
                            <td><a href="<?=URL_ROOT?>/admin/comments?delete=<?=$comment["comment_id"]?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
                flashMessager("comment_unapprove_error");
                flashMessager("comment_unapprove_success");
                if (isset($_GET["unapprove"])) {
                    showUnapproveCommentForm($_GET["unapprove"]);
                }
                flashMessager("comment_approve_error");
                flashMessager("comment_approve_success");
                if (isset($_GET["approve"])) {
                    showApproveCommentForm($_GET["approve"]);
                }
                flashMessager("comment_delete_error");
                flashMessager("comment_delete_success");
                if (isset($_GET["delete"])) {
                    showDeleteCommentForm($_GET["delete"]);
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
