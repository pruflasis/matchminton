<?php
    require_once 'config.php';
    
    if (isset($_POST['action']) && $_POST['action'] == 'show_order'){
        $sql_pro = "SELECT * FROM `orders`
        JOIN `order_details` ON `orders`.`order_id` = `order_details`.`order_id`
        JOIN `product` ON `order_details`.`product_id` = `product`.`product_id`
        JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id` 
        WHERE `orders`.`user_id` = '".$_POST['user_id']."' ORDER BY `orders`.`order_id` DESC";
        // echo $sql_pro;
        $rs = getpdo($conn,$sql_pro);

        if(gettype($rs) == 'array'){

            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id`)";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs,"product_images" => $rs2));
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'show_order_detail'){
        $sql = "SELECT * FROM `orders` JOIN `order_details` ON `orders`.`order_id` = `order_details`.`order_id` JOIN `product` ON `order_details`.`product_id` = `product`.`product_id` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id` WHERE `orders`.`order_id` = '".$_POST['order_id']."'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(gettype($rs) == 'array'){

            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id`)";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs,"product_images" => $rs2));
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'tracking'){
        $sql = "UPDATE `orders` SET `tracking`= '".$_POST['tracking']."'  WHERE `order_id`='".$_POST['order_id']."'";
        // echo $sql;
        $rs = getpdo($conn,$sql);
        if(isset($rs)){
        	$res = array("code" => 200, "result" => $rs[0]);
        	echo json_encode($res);
            return ;
        }
    }

    $result = array("message" => "Error someting");
    $res = array("code" => 401, "result" => $result);
    echo json_encode($res);
?>