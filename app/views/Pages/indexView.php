<?php require_once APP_ROOT . "/views/includes/header.php";?>
<?php
echo "<pre>";
foreach ($data["users"] as $user) {
    echo $user["post_id"]."<br>";
}
echo "</pre>";
?>
<?php require_once APP_ROOT . "/views/includes/footer.php";?>