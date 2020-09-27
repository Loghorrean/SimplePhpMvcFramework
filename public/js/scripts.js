// validating comments
function doCommentsValidate() {
    try {
        let cont = document.getElementById('comment_content').value;
        if (!cont) {
            alert("All fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
}
// validating users
function doUsersValidate() {
    try {
        let user = document.getElementById('username').value;
        let fname = document.getElementById('user_firstname').value;
        let lname = document.getElementById('user_lastname').value;
        let mail = document.getElementById('user_email').value;
        if (!user || !fname || !lname || !mail) {
            alert("All fields must be filled out");
            return false;
        }
        if (mail.indexOf('@') == -1) {
            alert("Wrong mail format");
            return false;
        }
        return true;
    } catch (e) {
        return false;
    }
}
// validating registration
function doRegisterValidate() {
    try {
        let user = document.getElementById('username').value;
        let mail = document.getElementById('email').value;
        let pass1 = document.getElementById('key1').value;
        let pass2 = document.getElementById('key2').value;
        if (!user || !mail || !pass1 || !pass2) {
            alert("All fields must be filled out");
            return false;
        }
        if (pass1 != pass2) {
            document.getElementById('key2').style.color = "red";
            alert("Passwords must match");
            return false;
        }
        else {
            document.getElementById('key2').style.color = "black";
        }
        if (mail.indexOf("@") == -1) {
            alert("Wrong mail format");
            return false
        }
        return true;
    } catch (e) {
        return false;
    }
}