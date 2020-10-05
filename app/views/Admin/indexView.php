<?php require_once APP_ROOT . "/views/includesAdmin/adminHeader.php";?>
<div id="wrapper">
    <?php require_once APP_ROOT . "/views/includesAdmin/adminNavigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome, <?=$data["current_user"]?>
                    </h1>
                </div>
            </div>
            <!-- /.row -->
            <?php
            require_once APP_ROOT."/views/includesAdmin/adminWidgets.php";
            ?>
<!--            <div class = "row">-->
<!--                <script>-->
<!--                    let act_post_count = --><?//=$postCount?>
<!--//                    let draft_post_count = --><?////=$draftPostCount?><!--//;-->
<!--//                    let cat_count = --><?////=$catCount?><!--//;-->
<!--//                    let user_count = --><?////=$userCount?><!--//;-->
<!--//                    let sub_User_count = --><?////=$subUserCount?><!--//;-->
<!--//                    let com_count = --><?////=$comCount?><!--//;-->
<!--//                    let unapp_com_count = --><?////=$unappComCount?><!--//;-->
<!--//                </script>-->
<!--//                <script src="includes/columnChart.js"></script>-->
<!--//                <div id="columnchart_material" style="width: auto; height: 500px;"></div>-->
<!--           </div>-->
<!--        TODO: implement the columnchart properly-->
        </div>
        <!-- /.container-fluid -->
    </div>
</div>
<?php require_once APP_ROOT . "/views/includesAdmin/adminFooter.php";?>