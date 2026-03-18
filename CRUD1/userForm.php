 <?php
    include "./handler/connection.php";
    include "./partials/header.php";
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
     <form action="./handler/add.php" method="post" class="w-50 mt-4">
         <h2 class="fw-bold">Add Student</h2>
         <hr>
         <div class="mt-4">
             <label class="fw-bold" for="">Name:</label><br>
             <input class="form-control w-100" type="text" name="user_name"><br>
         </div>
         <div>
             <label class="fw-bold" for="">Email:</label><br>
             <input class="form-control w-100" type="email" name="u_email"><br>
         </div>
         <div>
             <label class="fw-bold" for="">Phone Number:</label><br>
             <input class="form-control w-100" type="tel" name="p_number"><br>
         </div>
         <h6 class="fw-bold">Gender:</h6>
         <div class="container mb-4">
             <input type="radio" name="gender" value="Male"> Male
             <input type="radio" name="gender" value="Female"> Female
             <input type="radio" name="gender" value="Other"> Other
         </div>
         <hr>
         <div class="w-100 d-flex justify-content-end gap-2">
             <button type="submit" class="btn btn-primary">Submit</button>
             <a href="./list.php" class="btn btn-secondary">Cancel</a>
         </div>
     </form>
 </div>

 <?php
    include "./partials/footer.php";
    ?>