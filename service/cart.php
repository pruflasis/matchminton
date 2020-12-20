<?php
    require_once 'config.php';
    
    if (isset($_POST['action']) && $_POST['action'] == 'show_order'){
        $sql_pro = "SELECT * FROM `cart`
        JOIN `product` ON `cart`.`product_id` = `product`.`product_id`
        JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id` ORDER BY `cart`.`cart_id` ASC";
        $rs = getpdo($conn,$sql_pro);
// echo $sql_pro;
        if(gettype($rs) == 'array'){

            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id`)";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs,"product_images" => $rs2));
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'delete_order'){
        $sql = "UPDATE `orders` SET `stataus`= '0' WHERE `order_id`= '".$_POST['order_id']."' ";
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