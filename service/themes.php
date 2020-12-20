<?php
    require_once 'config.php';


    if(isset($_POST['action']) && $_POST['action'] == 'create_theme'){
    	
        $sql = "INSERT INTO `theme`(`content`, `title`, `category`, `fk_user_id`) VALUES ('".$_POST['summernote']."','".$_POST['header']."','".$_POST['category']."','".$_POST['user_id']."')";
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'get_theme_with_id'){
        $sql = "SELECT `theme_id`, `content`, `title`, `category`, `status`, `create_at`, `update_at`, `fk_user_id` FROM `theme` WHERE  `fk_user_id` = '".$_POST['user_id']."' AND `status` = '1'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'get_theme'){
        $sql = "SELECT `theme_id`, `content`, `title`, `category`, `status`, `create_at`, `update_at`, `fk_user_id`,`ref_theme` FROM `theme` WHERE `ref_theme` IS NULL";
        if (isset($_POST['order_by'])) {
           $sql .= " ORDER BY ".$_POST['order_by']." DESC";
        }
        if (isset($_POST['theme_id'])) {
            $sql .= " WHERE `theme_id` ".$_POST['theme_id']." ";
         }
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'edit_theme'){
        $sql = "UPDATE `theme` SET `content`= '".$_POST['summernote']."',`title`='".$_POST['header']."'";
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'get_edit_theme'){
        $sql = "SELECT `theme_id`, `content`, `title`, `category`, `status`, `create_at`, `update_at`, `fk_user_id` FROM `theme` WHERE `theme_id` = '".$_POST['theme_id']."' LIMIT 1 ";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
            if (count($rs) > 0) {
                $res = array("code" => 200, "result" => $rs[0]);
                echo json_encode($res);
                return;
            }
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'get_trash'){
        $sql = "SELECT `theme_id`, `content`, `title`, `category`, `status`, `create_at`, `update_at`, `fk_user_id` FROM `theme` WHERE  `fk_user_id` = '".$_POST['user_id']."' AND `status` = '0'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'delete_theme'){
        $sql = "UPDATE `theme` SET `status`= '0' WHERE  `theme_id` = '".$_POST['theme_id']."' ";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'call_theme'){
        $sql = "UPDATE `theme` SET `status`= '1' WHERE  `theme_id` = '".$_POST['theme_id']."'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if(isset($_POST['action']) && $_POST['action'] == 'create_comment'){
    	
        $sql = "INSERT INTO `theme`( `content`,`fk_user_id`, `ref_theme`) VALUES ('".$_POST['summernote']."','".$_POST['user_id']."','".$_POST['ref_theme']."')";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if(isset($_POST['action']) && $_POST['action'] == 'get_comment'){
    	
        $sql = "INSERT INTO `theme`( `content`,`fk_user_id`, `ref_theme`) VALUES ('".$_POST['summernote']."','".$_POST['user_id']."','".$_POST['ref_theme']."')";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }else if(isset($_POST['action']) && $_POST['action'] == 'get_comment_with_id'){
        $sql = "SELECT `theme_id`, `content`, `title`, `category`, `status`, `create_at`, `update_at`, `fk_user_id`, `ref_theme` FROM `theme` WHERE `ref_theme`='".$_POST['theme_id']."'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs);
        	echo json_encode($res);
            return ;
        }
    }

    $result = array("message" => "Error someting");
    $res = array("code" => 401, "result" => $result);
    echo json_encode($res);
?>