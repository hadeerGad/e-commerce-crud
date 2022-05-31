<?php
require "config.php";

// update a product
function update_product($id)
{
    global $connection;



    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_old_image = $_POST['product_old_image'];
    $product_new_image = $_FILES['product_new_image']['name'];
    $product_image_temp = $_FILES['product_new_image']['tmp_name'];

    $update_price_name = "UPDATE `products` SET `product_name`=?,`product_price`=? WHERE `product_id`= $id ";
    $update_price_name_prepare = $connection->prepare($update_price_name);
    $update_price_name_execute = $update_price_name_prepare->execute([$product_name, $product_price]);
    if ($update_price_name_execute) {
        $message[] = "the product has been updated sucessfully !";
    } else {
        $message[] = "no update occured !";
    }
    if (!empty($product_new_image)) {
        move_uploaded_file($product_image_temp, "product_imgs/$product_new_image");
        unlink("product_imgs/$product_old_image");
        $update_product_image = "UPDATE `products` SET `product_image`=? WHERE `product_id`= $id ";
        $update_product_image_prepare = $connection->prepare($update_product_image);
        $update_product_image_execute = $update_product_image_prepare->execute([$product_new_image]);
        if ($update_price_name_execute) {
            $message[] = "the product has been updated sucessfully !";
        } else {
            $message[] = "no update occured !";
        }
    }



    if (isset($message)) {
        show_messages($message);
    }
}



// delete function


function delete($id){
    global $connection;
  
    $delete_query="DELETE FROM `products` WHERE `product_id`=?";
    $delete_prepare=$connection->prepare($delete_query);
    $delete_execute=$delete_prepare->execute([$id]);
    if($delete_execute){
        // $message[]="the item has been deleted successfully !";
    }
    if (isset($message)) {
        show_messages($message);
    }

}


// update php code



function display_data_in_inputs($id)
{
    global $connection;

        
        $select_with_id = "SELECT * FROM `products` WHERE `product_id`=?";
        $select_with_id_prepare = $connection->prepare($select_with_id);
        $select_with_id_execute = $select_with_id_prepare->execute([$id]);
        $select_with_id_fetch =  $select_with_id_prepare->fetch(PDO::FETCH_ASSOC);
        // print_r($select_with_id_fetch['product_name']);
        $product_name_update = $select_with_id_fetch['product_name'];
        $product_image_update = $select_with_id_fetch['product_image'];
        $product_price_update = $select_with_id_fetch['product_price'];

        echo " <form action='' method='POST' enctype='multipart/form-data'>
        <input type='text' name='product_name' class='box' placeholder='enter product name' value='$product_name_update' >
        <input type='number' min='0' max='2000' step='1' name='product_price' class='box' placeholder='enter the price' value='$product_price_update'>
        <input type='hidden' name='product_old_image' class='box' value='$product_image_update'>
        <input type='file' name='product_new_image' class='box' >
        <input type='submit' name='update' value='update' class='btn'>
         <a href='admin_page.php' class='btn'>back</a>
         
    
          </form>";
     
}


// add new product
function add_new_product()
{
    global $connection;

    if (!empty($_POST["product_name"]) && !empty($_POST["product_price"]) && !empty($_FILES['product_image'])) {
        $product_name = $_POST["product_name"];
        $product_price = $_POST["product_price"];
        $product_image = $_FILES['product_image']['name'];
        $temp_image = $_FILES['product_image']['tmp_name'];

        $insert_query = "INSERT INTO `products`( `product_image`, `product_name`, `product_price`) VALUES (?,?,?)";
        $prepare = $connection->prepare($insert_query);
        $execute = $prepare->execute([$product_image, $product_name, $product_price]);
        if ($execute) {
            move_uploaded_file($temp_image, "product_imgs/$product_image");
            $message[] = "the product is added sucessfully !";
        } else {
            $message[] = "no product added !";
        }
    } else {
        $message[] = "all fields must be filled !";
    }





    echo " <form action='' method='POST' enctype='multipart/form-data'>
    <input type='text' name='product_name' class='box' placeholder='enter product name'>
    <input type='number' min='0' max='2000' step='1' name='product_price' class='box' placeholder='enter the price'>
    <input type='file' name='product_image' class='box'>
    <input type='submit' name='add' value='add' class='btn'>

         </form>
      
         ";
    if (isset($message)) {
        show_messages($message);
    }
}

// show message 
function show_messages($message)
{
    echo "<div class='message'>";
    foreach ($message as $msg) {
        echo " <h4>
       $msg
   </h4> ";
    }
    echo "<i class='fas fa-times' onclick='this.parentElement.remove()'></i>";

    echo "</div>";
}
