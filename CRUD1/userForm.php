 <?php
    include "./handler/connection.php";
    include "./partials/header.php";

    if (isset($_GET['id']) && $_GET['id'] != "") {
        $id = $_GET['id'];

        $query = "SELECT * FROM `infotable` WHERE `id` = '$id'";

        $sql = mysqli_query($conn, $query);

        $record = mysqli_fetch_assoc($sql);
        // print_r($record);
        // die;
    } ?>

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

     <form action="<?php echo isset($_GET['id']) ? './handler/update.php?id=' . $_GET['id'] : './handler/add.php'; ?>" method="POST" enctype="multipart/form-data" class="w-50 my-4">

         <h2 class="fw-bold"><?php echo isset($_GET['id']) ? "Update Student" : "Add Student" ?></h2>
         <hr>

         <div>
             <label class="fw-bold" for="user_name">Name:</label><br>
             <input class="form-control w-100" type="text" id="user_name" name="user_name" value="<?php echo @$record['user_name'] ?>"><br>
         </div>

         <div>
             <label class="fw-bold" for="u_email">Email:</label><br>
             <input class="form-control w-100" type="email" id="u_email" name="u_email" value="<?php echo @$record['u_email'] ?>"> <br>
         </div>

         <div>
             <label class="fw-bold" for="p_number">Phone Number:</label><br>
             <input class="form-control w-100" type="tel" id="p_number" name="p_number" value="<?php echo @$record['p_number'] ?>"><br>
         </div>


         <div class="mb-4">
             <label for="img" class="fw-bold">Profile Picture</label>
             <input type="file" name="profile_img" class="form-control" id="img">
         </div>

         <?php
                     if(isset($_GET['id']) && isset($record['profile_img'])){
                        ?>
                    <div>
                        <img src="./uploads/profilePictures/<?php echo $record['profile_img'] ?>" alt="IMAGE" width="70">
                    </div>

                        <?php
                     }
                ?>

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

         <?php
            if (isset($record['subjects'])) {
                $subjects = explode(',', $record['subjects']);
            }
            ?>

         <h6 class="fw-bold">Subjects</h6>
         <div class=" container form-group mb-4 ">
             <input type="checkbox" name="subject[]" value="english" <?php echo (isset($subjects) && (in_array('english', $subjects))) ? "checked" : "" ?>> English

             <input class="ms-1" type="checkbox" name="subjects[]" value="urdu" <?php echo (isset($subjects) && (in_array('urdu', $subjects))) ? "checked" : "" ?>> Urdu

             <input class="ms-1" type="checkbox" name="subjects[]" value="math" <?php echo (isset($subjects) && (in_array('math', $subjects))) ? "checked" : "" ?>> Math

             <input class="ms-1" type="checkbox" name="subjects[]" value="physics" <?php echo (isset($subjects) && (in_array('physics', $subjects))) ? "checked" : "" ?>> Physics
         </div>

         <?php
            $query = "SELECT id,teacher_name FROM `teachers` WHERE is_active=1";
            $sql = mysqli_query($conn, $query);
            ?>

         <div class="mb-4">
             <label class="fw-bold" for="teacher_name">Teacher</label>
             <select class="form-select" id="teacher_name" name="teacher_id">
                 <?php while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                     <option value="<?php echo $row['id'] ?>" <?php echo isset($record['teacher_id']) == $row['id']? 'Selected':'' ?>>
                        <?php echo $row['teacher_name'] ?>
                    </option>
                 <?php
                    }
                    ?>
             </select>
         </div>

         <!-- <div class="mb-4">
             <label for="">Add Certificates</label>
             <input type="file" name="images[]" class="form-control" multiple>
         </div> -->

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