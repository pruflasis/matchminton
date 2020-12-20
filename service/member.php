<?php
require_once 'config.php';

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $sql = "SELECT `users`.`user_id`,`flex`, `balance`, `weight`, `name`, `surname` ,`email` ,`phone` FROM `users` left join `user_style` on `users`.`user_id` = `user_style`.`user_id` WHERE `username` = '" . $_POST['username'] . "' and `password` = '" . md5($_POST['password']) . "' and status=1";
    $rs = getpdo($conn, $sql);
    if (isset($rs) && count($rs) > 0) {
        $res = array("code" => 200, "result" => $rs[0]);
        echo json_encode($res);
        return;
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'admin_login') {
    $sql = "SELECT `users`.`user_id`,`flex`, `balance`, `weight`, `name`, `surname` ,`email` ,`phone` FROM `users` left join `user_style` on `users`.`user_id` = `user_style`.`user_id` WHERE `username` = '" . $_POST['username'] . "' and `password` = '" . md5($_POST['password']) . "' and status=2";
    $rs = getpdo($conn, $sql);
    if (isset($rs) && count($rs) > 0) {
        $res = array("code" => 200, "result" => $rs[0]);
        echo json_encode($res);
        return;
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'register') {
    if (!isset($_POST['username']) && !isset($_POST['password'])) {
        $result = array("message" => "Error parameter");
        $res = array("code" => 401, "result" => $result);
        echo json_encode($res);
        return;
    }

    $sql = "INSERT INTO `users`(`username`, `password`, `name`, `surname`, `email`) VALUES ('" . $_POST['username'] . "','" . md5($_POST['password']) . "','" . $_POST['name'] . "','" . $_POST['surname'] . "','" . $_POST['email'] . "')";
    $rs = getpdo($conn, $sql);
    if ($rs) {
        $res = array("code" => 200, "result" => $rs);
        echo json_encode($res);
        return;
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $sql = "UPDATE `users` SET `name`='" . $_POST['name'] . "',`surname`='" . $_POST['surname'] . "',`phone`='" . $_POST['phone'] . "',`email`='" . $_POST['email'] . "' WHERE `user_id` = '" . $_POST['user_id'] . "'";
    $rs = getpdo($conn, $sql);
    if ($rs) {
        $sql = "SELECT `user_id`, `name`, `surname` ,`email` ,`phone` FROM `users` WHERE `user_id` = '" . $_POST['user_id'] . "' and status=1";
        $rs = getpdo($conn, $sql);

        $res = array("code" => 200, "result" => $rs[0]);
        echo json_encode($res);
        return;
    }
} else if (isset($_POST['action']) && $_POST['action'] == 'update_style') {
    $sql = "SELECT `user_id`, `flex`, `balance`, `weight` FROM `user_style` WHERE `user_id` = '" . $_POST['user_id'] . "'";
    $rs = getpdo($conn, $sql);

    if (isset($rs) && count($rs) > 0) {

        $sql = "UPDATE `user_style` SET `flex` = '" . $_POST['flex'] . "' , `balance` = '" . $_POST['balance'] . "' ,`weight` = '" . $_POST['weight'] . "' WHERE `user_id` = '" . $_POST['user_id'] . "'";
        $rs = getpdo($conn, $sql);

        $res = array("code" => 200, "result" => $rs);
        echo json_encode($res);
        return;
    } else {
        $sql = "INSERT INTO `user_style`(`user_id`, `flex`, `balance`, `weight`) values ('" . $_POST['user_id'] . "','" . $_POST['flex'] . "','" . $_POST['balance'] . "','" . $_POST['weight'] . "')";
        $rs = getpdo($conn, $sql);

        $res = array("code" => 200, "result" => $rs);
        echo json_encode($res);
        return;
    }
}

$result = array("message" => "Error someting");
$res = array("code" => 401, "result" => $result, "sql" => $sql);
echo json_encode($res);
