<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pwd = $_POST['pwd-logout'];
    $admin_id = $_SESSION['admin_id'];

    $sql = "SELECT pass_hash FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (password_verify($pwd, $row['pass_hash'])) {
        $_SESSION = array();
        session_destroy();
        echo '<script type="text/JavaScript">  
                    window.location.href = "../auth_librarian.php"; 
                    window.history.pushState(null, null, window.location.href);  
                    window.onpopstate = function () {
                        window.history.pushState(null, null, window.location.href);  
                    };
            </script>';
    } else {
        echo '<script type="text/javascript">
                alert("Invalid Password!");
                window.location.href = "../index.php";
            </script>';
    }

    $stmt->close();
    $conn->close();
}