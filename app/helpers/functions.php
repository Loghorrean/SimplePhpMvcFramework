<?php
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
    return true;
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
        echo '<label for "post_title">Delete Post (id = '.$post_id.')</label>';
        echo '<input type="hidden" value = "'.$post_id.'" name="post_id">';
        echo '</div>';
        echo '<div class = "form-group">';
        echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete post">';
        echo '</div>';
        echo '</form>';
}

function showPost($post, $read_more = false) {
    echo '<h2><a href="' . URL_ROOT . '/main/post/'.$post["post_id"].'">' . htmlspecialchars($post["post_title"]) . '</a></h2>';
    echo '<p class = "lead">by <a href="' . URL_ROOT . '/main/author/'.$post["username"].'">' . htmlspecialchars($post["username"]) . '</a></p><hr>';
    echo '<p><span class="glyphicon glyphicon-time"></span> Posted on ' . htmlspecialchars($post["post_date"]) . '</p><hr>';
    echo '<a href="' . URL_ROOT . '/main/post/'.$post["post_id"].'"><img class="img-responsive" src="'.URL_ROOT.'/public/images/'. $post["post_image"] . '" alt="Loading..."></a><hr>';
    echo '<p style="font-weight: 700">' . $post["post_content"] . '</p>';
    if ($read_more) {
        echo '<a class="btn btn-primary" href="' . URL_ROOT . '/main/post/' . $post["post_id"] . '">Read More ';
        echo '<span class="glyphicon glyphicon-chevron-right"></span>';
        echo '</a>';
    }
}

function showDeleteCommentForm($com_id) { // showing a form to delete a comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Delete Comment (id = '.$com_id.')</label>';
    echo '<input type="hidden" value="'.$com_id.'" name="comment_id">';
    echo '<input type="hidden" value="'.$com_id.'" name="comment_post_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_delete" value = "Delete comment">';
    echo '</div>';
}

function showApproveForm($com_id) { // showing the form to approve comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Approve Comment (id = '.$com_id.')</label>';
    echo '<input type="hidden" value="'.$com_id.'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_approve" value = "Approve comment">';
    echo '</div>';
}

function showUnapproveForm($com_id) { // showing the form to unapprove comment
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for="post_title">Unapprove Comment (id = '.$com_id.')</label>';
    echo '<input type="hidden" value="'.$com_id.'" name="comment_id">';
    echo '</div>';
    echo '<div class = "form-group">';
    echo '<input class = "btn btn-primary" type="submit" name="submit_unapprove" value = "Unapprove comment">';
    echo '</div>';
}

function showDeleteUserForm($u_id) {
    echo '<form action="" method = "POST">';
    echo '<div class = "form-group">';
    echo '<label for "user_title">Delete User (id = '.$u_id.')</label>';
    echo '<input type="hidden" value = "'.$u_id.'" name="user_id" id = "user_id">';
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

function buttonIsPressed($buttonName) {
    if (isset($_POST[$buttonName])) {
        return true;
    }
    return false;
}

function redirect($page) {
    header("Location: " . URL_ROOT . "/" . $page);
}

function flashMessager($name = "", $message = "", $class = "text-success") {
    if (!empty($name)) {
        if (!empty($message) && !isset($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . "_class"] = $class;
        } elseif (empty($message) && isset($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . "_class"]) ? $_SESSION[$name . "_class"] : "";
            echo '<div class = ' . $class . ' id = "msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . "_class"]);
        }
    }
}

function checkFileSize(int $fileSize) {
    if ($fileSize > MAX_FILE_SIZE) {
        return false;
    }
    return true;
}

function checkFileType(string $fileType) {
    if (!in_array($fileType, ALLOWED_TYPES)) {
        return false;
    }
    return true;
}

function isFileValid($post_image_size, $post_image_type) {
    if ($post_image_size > MAX_FILE_SIZE) {
        return false;
    }
    if (!in_array($post_image_type, ALLOWED_TYPES)) {
        return false;
    }
    return true;
}

function uploadFile(string $uploadDir, string $fileSelect) {
    if (!empty($_FILES[$fileSelect]["name"])) {
        $post_image = basename($_FILES[$fileSelect]["name"]);
        $target_file = $uploadDir . $post_image;
        $post_image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // type of uploaded file
        $post_image_temp = $_FILES[$fileSelect]["tmp_name"]; // temporary file name on client's computer
        $post_image_size = $_FILES[$fileSelect]["size"]; // size of uploaded file
        if (isFileValid($post_image_size, $post_image_type)) {
            move_uploaded_file($post_image_temp, $target_file);
            return $post_image;
        }
        return false;
    }
    return false;
}