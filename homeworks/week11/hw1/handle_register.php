<?php
    session_start();
    require_once("conn.php");

    $nickname = $_POST['nickname'];
    $username = $_POST['username'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (
        empty($nickname) || 
        empty($username) ||
        empty($password)
    ) {
        header('Location: ./register.php?errorCode=1');
        die($conn->error);
    }
    

    $sql = "INSERT INTO chinghsuan_board_users(username, password, nickname) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $password, $nickname);
    $result = $stmt->execute();
    if(!$result) {
        $code = $conn->errno;
        if($code === 1062){
            header('Location: ./register.php?errorCode=2');
        }
        die($conn->error);
    }
    $_SESSION['username'] = $username;
    header("Location: index.php");
?>