<?php

require "config.php";
require "admin_functions.php";
// insert new product






?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>admin page</title>
</head>

<body>


    <?php


    ?>



    <section class="container">
        <div class="admin_product_form_container">
            <h2>ADD A NEW PRODUCT</h2>




            <?php

            // add_new_product();
            if (isset($_GET['id_edit'])) {
                $edit_id = $_GET['id_edit'];
                display_data_in_inputs($edit_id);
            }

            if (isset($_POST['update'])) {
                $edit_id = $_GET['id_edit'];
                update_product($edit_id);
            }
            ?>


        </div>


        <!-- php code to display product from db -->

        <div class="product_display">
            <table class="product_display_table">
                <thead>
                    <tr>
                        <td>product image</td>
                        <td>product name</td>
                        <td>product price</td>
                        <td colspan="2">options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_all = "SELECT * FROM `products`";
                    $select_query = $connection->prepare($select_all);
                    $select_query->execute();
                    while ($row = $select_query->fetch(PDO::FETCH_ASSOC)) {







                    ?>

                        <tr>
                            <td><img src="product_imgs/<?= $row['product_image'] ?>" alt=""></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td>



                                <a href="admin_update.php?id_edit=<?= $row['product_id'] ?>" class="edit"><input type="submit" name="edit" value="edit"><span> <i class="fas fa-edit"></i></span></a>


                                <a href="admin_page.php?id_delete=<?= $row['product_id'] ?>" class="delete"><input type="submit" name="delete" value="delete"><span> <i class="fas fa-trash"></i></span></a>

                            </td>
                        </tr>
                    <?php
                        // end  braces of while loop
                    }
                    ?>

                </tbody>
            </table>
        </div>

    </section>
</body>

</html>