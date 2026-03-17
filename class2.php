<?php
include "./handler/connection.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Class 2</title>
</head>
<style>
    .alert-success {
        display: inline-block;
        background-color: green;
        color: white;
        padding: 5px 10px;
        margin-bottom: 20px;
        border-radius: 2px;
    }

    .alert-danger {
        display: inline-block;
        background-color: red;
        color: white;
        padding: 5px 10px;
        margin-bottom: 20px;
        border-radius: 2px;
    }
</style>

<body>
    <div class="container d-flex flex-column  align-items-center">
        <h1 class="text-center">Crud</h1>

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
        <form action="./handler/class2Handler.php" method="post" class="w-50 mt-4">
            <div>
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
            <div class="container">
                <input type="radio" name="gender" value="Male"> Male
                <input type="radio" name="gender" value="Female"> Female
                <input type="radio" name="gender" value="Other"> Other
            </div> <br>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>


    </div>
    <table class="table w-75 mt-5 mx-auto">
        
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Gender</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
        <?php 
            
    
            $query = "SELECT * FROM `infotable` ORDER BY id ASC";
            


            $mysql = mysqli_query($conn, $query);

            while($row = mysqli_fetch_assoc($mysql)){
                
            ?>

            <tr>
                <td><?php echo $row['id']??'' ?></td>
                <td><?php echo $row['user_name'] ?></td>
                <td><?php echo $row['u_email'] ?></td>
                <td><?php echo $row['p_number']??'' ?></td>
                <td><?php echo $row['gender']??'' ?></td>
                <td><?php echo $row['created_at']??'' ?></td>
                <td>
                    <!-- <button></button> -->
                </td>
            </tr>
            <?php
            }

        ?>
     
        </tbody>
    </table>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        let alertBox = document.querySelector('.alert');

        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = "none";
            }, 2000);
        }
    </script>
</body>

</html>