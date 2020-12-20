<?php 
  require_once 'config.php';
?>

<?php
  if(isset($_GET["user_id"])){
    $date = date_create();
    $date_now = date_format($date, 'Y-m-d H:i:s') . "\n";
    $sql = "SELECT * FROM `cart` WHERE `user_id` = '".$_GET['user_id']."' and `product_id` = '".($_GET['product_id'])."'";
    $rs = getpdo($conn,$sql);
    if(isset($rs) && count($rs) > 0){
      $amount = $rs[0]['amount'] + 1;
      $sql = "UPDATE `cart` SET `amount`= '".$amount."' WHERE `cart_id` = '".$rs[0]['cart_id']."'";
      $rs = getpdo($conn,$sql);
    }else{
      $sql = "INSERT INTO `cart`(`user_id`, `product_id`, `amount`,`created_at`,`updated_at`) VALUES ('".$_GET['user_id']."','".$_GET['product_id']."', '1', '".$date_now."', '".$date_now."')";
      $rs = getpdo($conn,$sql);
    }
   

    if(!$rs)
    {
      echo "<script>";
        echo "alert(\" บันทึกไม่สำเร็จ\");"; 
        echo "window.history.back()";
      echo "</script>";
    }else{
      echo "<script>";
        echo "alert(\" บันทึกสำเร็จ\");"; 
        echo "window.history.back()";
      echo "</script>";
    }
  }
?>
