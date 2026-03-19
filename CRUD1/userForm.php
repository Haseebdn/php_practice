 <?php
    include "./handler/connection.php";
    include "./partials/header.php";

    if (isset($_GET['id']) && $_GET['id'] != "") {
        $id = $_GET['id'];

        $query = "SELECT * FROM `infotable` WHERE `id` = '$id'";

        $sql = mysqli_query($conn, $query);

        $record = mysqli_fetch_assoc($sql);

    }

    ?>
 

 <div class="container d-flex flex-column  align-items-center">

     <?php
        if (isset($_GET['success'])) {
            if ($_GET['success'] == 1) {
        ?>
             <div class="alert alert-success">Message submitted successfully</div>
         <?php
            } else {
            ?>
             <div class="alert alert-danger">Message submition failed</div>
     <?php
            }
        }
        ?>
     <form action="<?php echo isset($_GET['id']) ? './handler/update.php?id=' . $_GET['id'] : './handler/add.php'; ?>" method="post" class="w-50 mt-4">
         <h2 class="fw-bold"><?php echo isset($_GET['id']) ? "Update Student" : "Add Student" ?></h2>
         <hr>
         <div class="mt-4">
             <label class="fw-bold" for="">Name:</label><br>
             <input class="form-control w-100" type="text" name="user_name" value="<?php echo @$record['user_name'] ?>"><br>
         </div>
         <div>
             <label class="fw-bold" for="">Email:</label><br>
             <input class="form-control w-100" type="email" name="u_email" value="<?php echo @$record['u_email'] ?>"> <br>
         </div>
         <div>
             <label class="fw-bold" for="">Phone Number:</label><br>
             <input class="form-control w-100" type="tel" name="p_number" value="<?php echo @$record['p_number'] ?>"><br>
         </div>

         <?php
            $checkValue = "male";
            if (isset($record['gender']) && $record['gender'] == "female") {
                $checkValue = "female";
            } else if (isset($record['gender']) && $record['gender'] == "other") {
                $checkValue = "other";
            }
            ?>

         <h6 class="fw-bold">Gender:</h6>
         <div class="container mb-4">
             <input type="radio" name="gender" value="male" <?php echo $checkValue == "male" ? "checked" : "" ?>> Male
             <input type="radio" name="gender" value="female" <?php echo $checkValue == "female" ? "checked" : "" ?>> Female
             <input type="radio" name="gender" value="other" <?php echo $checkValue == "other" ? "checked" : "" ?>> Other
         </div>
         <hr>
         <div class="w-100 d-flex justify-content-end gap-2">
             <button type="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Update' :  'Add'  ?></button>
             <a href="./list.php" class="btn btn-secondary">Cancel</a>
         </div>
     </form>
 </div>

 <?php
    include "./partials/footer.php";
    ?>