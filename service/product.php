<?php
    require_once 'config.php';
    
    if(isset($_POST['action']) && $_POST['action'] == 'create'){
        $sql = "INSERT INTO `product`(`product_name`, `price`, `cost`, `description`, `quantity`, `brand_id`, `type`) VALUES ('".$_POST['product_name']."','".$_POST['price']."','".$_POST['cost']."','".$_POST['description']."','".$_POST['quantity']."','".$_POST['brand_id']."','".$_POST['type']."')";
        echo $sql;
        $rs = getpdo($conn,$sql);
        if($rs){
        	$lastid = $conn->lastInsertId();
        	
        	if(isset($_FILES['files'])){
        		$total = count($_FILES['files']['name']);

				for( $i=0 ; $i < $total ; $i++ ) {
					$tmpFilePath = $_FILES['files']['tmp_name'][$i];
					if ($tmpFilePath != ""){
					    $newFilePath = "../uploadFiles/" . $_FILES['files']['name'][$i];
					    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					    	$sql = "INSERT INTO `product_image`(`fk_product_id`, `path`) VALUES ('".$lastid."','".$newFilePath."')";
	        				$rs = getpdo($conn,$sql);
						}
					}
				}
        	}

        	if(isset($_POST['racket']) && $_POST['racket'] == 1){
                $sql = "INSERT INTO `racket_detail`(`grip_size`, `balance`, `tension`, `weight_min`, `weight_max`, `flex`,`level`,`fk_product_id`) VALUES ('".$_POST['grip_size']."','".$_POST['balance']."','".$_POST['tension']."','".$_POST['weight_min']."','".$_POST['weight_max']."','".$_POST['flex']."','".$_POST['level']."','".$lastid."')";
                echo $sql;
        		$rs = getpdo($conn,$sql);
        		if($rs){
					$res = array("code" => 200, "result" => $rs);
		        	echo json_encode($res);
		            return ;
				}
        	}
			else{
				$res = array("code" => 200, "result" => $rs);
	        	echo json_encode($res);
	            return ;
			}
        }
    }else if(isset($_POST['action']) && $_POST['action'] == 'calculate' ){
        $exp = $_POST['exp'];
        $f = $_POST['f'];
        $bmi = $_POST['bmi'];
        $sex = $_POST['sex'];

        $style = $_POST['style'];
        $s = $_POST['s'];

        $position = $_POST['position'];
        $position_d = $_POST['position_d'];

        $brand = $_POST['brand'];

        $price = $_POST['price'];




        $sql_base = "SELECT *,((`weight_min` + `weight_max`) / 2) as `weight_avg` FROM `product` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id` WhERE "; //query product , racket and calculated weight average for check matching
        $sql = "";

        //exp = experience 1 low - 2 high
        //sex = 1 male 2 female
        //f = frequency
        //bmi = body mass index
        //style = technical play for speed play (smash ball) 1 low - 3 high
        //s = technical play for defence play (clear ball) 1 low - 3 high 
        //weight = 5u (75-79g) / 4u (80-84g) / 3u (85-89g) 
        //flex = flexible of racket
        
        if(($exp == 1 || $exp == 2) && $f == 1){
            if($sex == 1){
                if($bmi == 0){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) or (((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80)) ";
                }else if($bmi < 19){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80) or (((`weight_min` + `weight_max`) / 2) >= 70 and ((`weight_min` + `weight_max`) / 2) < 75)) ";
                }else if($bmi >= 19){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) ";
                }
            }else{
                if($bmi == 0){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) or (((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80)) ";
                }else if($bmi < 18){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80) or (((`weight_min` + `weight_max`) / 2) >= 70 and ((`weight_min` + `weight_max`) / 2) < 75)) ";
                }else if($bmi >= 18){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) ";
                }
            }

            if(($style == 1 && ($s == 1 || $s ==2)) || ($style == 2 && $s == 1)){
                $sql .= " and (`flex` = '3') ";
            }else{
                $sql .= " and (`flex` = '2') ";
            }

        }else{
            if($sex == 1){
                if($bmi == 0){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) ";
                }else if($bmi < 19){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80) or (((`weight_min` + `weight_max`) / 2) >= 70 and ((`weight_min` + `weight_max`) / 2) < 75)) ";
                }else if($bmi >= 19){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) ";
                }
            }else{
                if($bmi == 0){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85) ";
                }else if($bmi < 18){
                    $sql .= " (((`weight_min` + `weight_max`) / 2) >= 75 and ((`weight_min` + `weight_max`) / 2) < 80) ";
                }else if($bmi >= 18){
                    $sql .= " ((((`weight_min` + `weight_max`) / 2) >= 86 and ((`weight_min` + `weight_max`) / 2) < 90) or (((`weight_min` + `weight_max`) / 2) >= 80 and ((`weight_min` + `weight_max`) / 2) < 85)) ";
                }
            }

            if(($style == 1 && ($s == 1 || $s ==2)) || ($style == 2 && ($s == 1 || $s ==2)) || ($style == 3 && $s == 3)){
                $sql .= " and (`flex` = '2') ";
            }else if($style == 1 && $s == 3){
                $sql .= " and (`flex` = '3') ";
            }else{
                $sql .= " and (`flex` = '1') ";
            }

        } 

        if(($position_d == 2 || $position_d == 3 ) && $position == 3){
            $sql .= " and (`balance` = '1') ";
        }else if($position == 1){
            $sql .= " and (`balance` = '3') ";
        }else{
            $sql .= " and (`balance` = '2') ";
        }

        if($price == 1){
            $sql .= " ORDER BY (`price` <= '2000') DESC ";
        }else if($price == 2 ){
            $sql .= " ORDER BY (`price` >= '2000'  and `price` <= 3500) DESC ";
        }else{
            $sql .= " ORDER BY (`price` > '3500') DESC ";
        }

        if($brand == 1){
            $sql .= " , (`brand_id` = '1') DESC";
        }else if($brand == 2 ){
            $sql .= " , (`brand_id` = '3') DESC";
        }else{
            $sql .= " , (`brand_id` = '2') DESC";
        }

        $rs = getpdo($conn,$sql_base.$sql." LIMIT 10");
        // echo $sql_base.$sql." LIMIT 10";
        if(gettype($rs) == 'array'){
            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product` JOIN `racket_detail` ON `product`.`product_id` = `racket_detail`.`fk_product_id` WHERE ".$sql." )";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs,"product_images" => $rs2));
            echo json_encode($res);
            return ;
        }

    }else if (isset($_POST['action']) && $_POST['action'] == 'show_product_card'){
        $sql_pro = "SELECT * FROM `product` left JOIN racket_detail ON `product_id` = `racket_detail`.`fk_product_id` WHERE `product_name` LIKE '%".$_POST['search']."%' OR `price` LIKE '%".$_POST['search']."%' ORDER BY `product_id` DESC";
        $rs = getpdo($conn,$sql_pro);

        if(gettype($rs) == 'array'){

            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product`)";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs,"product_images" => $rs2));
        	echo json_encode($res);
            return ;
        }
    }else if (isset($_POST['action']) && $_POST['action'] == 'get_product_detail'){
        $sql_pro = "SELECT * FROM `product` left JOIN racket_detail ON `product_id` = `racket_detail`.`fk_product_id` WHERE `product_id`= '".$_POST['product_id']."' ORDER BY `product_id` DESC";
        $rs = getpdo($conn,$sql_pro);

        if(gettype($rs) == 'array'){

            $sql = "SELECT * FROM `product_image`  WHERE `fk_product_id` in (SELECT `product_id` FROM `product`) AND `fk_product_id` = '".$_POST['product_id']."'";
            $rs2 = getpdo($conn,$sql);

            $res = array("code" => 200, "result" => array("product" => $rs[0],"product_images" => $rs2));
        	echo json_encode($res);
            return ;
        }
    } 

    $result = array("message" => "Error someting");
    $res = array("code" => 401, "result" => $result);
    echo json_encode($res);
?>