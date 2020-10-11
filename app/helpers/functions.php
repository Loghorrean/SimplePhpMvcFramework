<?php
/* Functions to show error and success messages */

function showError() { // showing error messages
    if (isset($_SESSION["error"])) {
        echo '<p class="text-danger">'.$_SESSION["error"].'</p>';
        unset($_SESSION["error"]);
    }
}


function showSuccess() { // showing success messages
    if (isset($_SESSION["success"])) {
        echo '<p class="text-success">'.$_SESSION["success"].'</p>';
        unset($_SESSION["success"]);
    }
}


/* Checker functions */


function checkId($id) { // checking the id of the table
    if (empty($id)) {
        $_SESSION["error"] = "No id!";
        return false;
    }
    if (!is_numeric($id)) {
        $_SESSION["error"] = "Id should be a number!";
        return false;
    }
    if ($id < 0) {
        $_SESSION["error"] = "Id must be a positive integer!";
        return false;
    }
    return true;
}

function checkMail(string $mail) {
    if (empty($mail)) {
        $_SESSION["error"] = "No mail given";
        return false;
    }
    if (!preg_match("/.+@.+\..+/i", $mail)) {
        $_SESSION["error"] = "Wrong mail format (must include @ and .)";
        return false;
    }
    return true;
}

function checkPassword(string $password) {
    $check = true;
    $errors = array();
    if (empty($password)) {
        $_SESSION["error"] = "No password given";
        return false;
    }
    if (strlen($password) < 9) {
        $errors[] = "Password is too short<br>";
        $check = false;
    }
    if (!preg_match("/[0-9]+/", $password)) {
        $errors[] = "Password must include at least one number<br>";
        $check = false;
    }
    if (!preg_match("/[A-Z]+/", $password)) {
        $errors[] = "Password must include at least one capital letter (A, B, C...)<br>";
        $check = false;
    }
    if (!$check) {
        foreach($errors as $error) {
            $_SESSION["error"] .= $error;
        }
        return false;
    }
    else {
        return true;
    }
}

function filterInput($value) {
    $value = trim($value);
    $value = stripslashes($value);
    return $value;
}


/* Functions that create forms to confirm an action */


function showEditCategoryForm($cat_id, $cat_title, $error) { // showing the form to edit a category
        echo '<div class = "form-group">';
        echo '<label for = "cat_title_edit">Edit Category Title (id = ' . $cat_id . ')</label>';
        echo '<input class = "form-control" type="text" value = "' . $cat_title . '" name="cat_title_edit">';
        echo '<input type="hidden" value = "' . $cat_id . '" name="cat_id_edit">';
        echo '<span class = "text-danger">' . $error . '</span>';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<input class = "btn brn-primary" type="submit" name="submit_edit" value = "Edit category">';
        echo '</div>';
}

function showDeleteCategoryForm($cat_id) { // showing the form to delete a category
        echo '<div class = "form-group">';
        echo '<label for "cat_title">Delete Category (id = ' . $cat_id . ')</label>';
        echo '<input type="hidden" value = "' . $cat_id . '" name="cat_id_delete">';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<input class = "btn brn-primary" type="submit" name="submit_delete" value = "Delete category">';
        echo '</div>';
}

function showDeletePostForm($post_id) { // showing the form to delete a post
        echo '<form action = "" method = "POST">';
        echo '<div class = "form-group">';
        echo '<label for "post_title">Delete Post (id = '.$post["post_id"].')</label>';
        echo '<input type="hidden" value = "'.$post['post_id'].'" name="post_id">';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete post">';
        echo '</div>';
        echo '</form>';
}

function showPost($row, $read_more = false) {
    echo '<h2><a href="' . URL_ROOT . '/main/post/'.$row["post_id"].'">' . htmlspecialchars($row["post_title"]) . '</a></h2>';
    echo '<p class = "lead">by <a href="' . URL_ROOT . '/main/author/'.$row["username"].'">' . htmlspecialchars($row["username"]) . '</a></p><hr>';
    echo '<p><span class="glyphicon glyphicon-time"></span> Posted on ' . htmlspecialchars($row["post_date"]) . '</p><hr>';
    echo '<a href="' . URL_ROOT . '/main/post/'.$row["post_id"].'"><img class="img-responsive" src="'.URL_ROOT.'/public/images/'. $row["post_image"] . '" alt="Loading..."></a><hr>';
    echo '<p style="font-weight: 700">' . $row["post_content"] . '</p>';
    if ($read_more) {
        echo '<a class="btn btn-primary" href="post.php?p_id='.$row["post_id"].'">Read More ';
        echo '<span class="glyphicon glyphicon-chevron-right"></span>';
        echo '</a>';
    }
}

function showDeleteCommentForm($com_id) { // showing a form to delete a comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Delete Comment (id = '.$comment["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$comment["comment_id"].'" name="comment_id">';
    echo '<input type="hidden" value="'.$comment["comment_post_id"].'" name="comment_post_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete comment">';
    echo '</div>';
}

function showApproveForm($com_id) { // showing the form to approve comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Approve Comment (id = '.$comment["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$comment["comment_id"].'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_approve" value = "Approve comment">';
    echo '</div>';
}

function showUnapproveForm($com_id) { // showing the form to unapprove comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Unapprove Comment (id = '.$comment["comment_id"].')</label>';
    echo '<input type="hidden" value="'.$comment["comment_id"].'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_unapprove" value = "Unapprove comment">';
    echo '</div>';
}

function showDeleteUserForm($u_id) {
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for "user_title">Delete User (id = '.$row["user_id"].')</label>';
    echo '<input type="hidden" value = "'.$row['user_id'].'" name="user_id" id = "user_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete user">';
    echo '</div>';
    echo '</form>';
}

function generateSalt()
{
    $salt = '';
    $saltLength = 8;
    for($i=0; $i<$saltLength; $i++) {
        $salt .= chr(mt_rand(33,126));
    }
    return $salt;
}

function checkUsersCookie($pdo) {
    if (empty($_SESSION["user_id"])) {
        if (!empty($_COOKIE["login"]) && !empty($_COOKIE["key"])) {
            $login = $_COOKIE["login"];
            $key = $_COOKIE["key"];
            $query = $pdo->prepare("SELECT * from users where username = :nam and cookie = :cook");
            $query->execute(array(":nam" => $login, ":cook" => $key));
            $user = $query->fetch(PDO::FETCH_LAZY);
            if (!empty($user)) {
                $_SESSION["name"] = $user["username"];
                $_SESSION["user_role"] = $user["user_role"];
                $_SESSION["user_id"] = $user["user_id"];
                header("Location: /");
            }
        }
    }
}

function checkFileSize(int $fileSize, int $maxSize) {
    if ($fileSize > $maxSize) {
        $maxSizeMb = floor($maxSize / 1024 / 1024);
        $_SESSION["error"] = "Invalid file size (max = {$maxSizeMb})!";
        return false;
    }
    return true;
}

function checkFileType(string $fileType, array $types) {
    $checked = false;
    for($i = 0; $i < count($types); $i++) {
        if ($fileType == $types[$i]) {
            $checked = true;
            break;
        }
    }
    return $checked;
}

function uploadFile(string $uploadDir, string $fileSelect, string $page, int $maxFileSize = 5000000, array $allowedTypes) {
    if (!empty($_FILES[$fileSelect]["name"])) {
        $post_image = basename($_FILES[$fileSelect]["name"]);
        $target_file = $uploadDir . $post_image;
        $post_image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // type of uploaded file
        $post_image_temp = $_FILES[$fileSelect]["tmp_name"]; // temporary file name on client's computer
        $post_image_size = $_FILES[$fileSelect]["size"]; // size of uploaded file
        if (!checkFileSize($post_image_size, $maxFileSize)) {
            header("Location: ".$page);
            exit();
        }
        if (!checkFileType($post_image_type, $allowedTypes)) {
            $_SESSION["error"] = "Unallowed file type!";
            header("Location: ".$page);
            exit();
        }
        move_uploaded_file($post_image_temp, $target_file);
        return $post_image;
    }
}