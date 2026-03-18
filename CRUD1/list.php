<?php
include "./handler/connection.php";
include "./partials/header.php";
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center">

        <h2>User Data</h2>
        <a class="btn btn-primary" href="./userForm.php">Add</a>
    </div>

    <?php
    if (isset($_GET['success'])) {
        if ($_GET['success'] == 1) {
    ?>
            <div class="alert alert-success">Date saved successfully</div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger">Date save failed</div>
    <?php
        }
    }
    ?>


    <form class="d-flex my-5 gap-5">
        <input class="form-control w-50" name="search_name" type="search" placeholder="Search By Name" value="<?php echo (isset($_GET['search_name'])) ? $_GET['search_name'] : '' ?>">
        <div>

            <button class="btn btn-primary">Search</button>
            <a class="btn btn-secondary" href="./list.php">Reset</a>
        </div>
    </form>
    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Created At</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php


            $query = "SELECT * FROM `infotable`";

            if (isset($_GET['search_name'])) {

                $fullname = $_GET['search_name'];

                $query = $query . "WHERE `user_name` LIKE '%$fullname%'";
            }

            $query = $query . "ORDER BY id ASC";

            $mysql = mysqli_query($conn, $query);

            $count = mysqli_num_rows($mysql);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($mysql)) {
            ?>
                    <tr>
                        <td><?php echo $row['id'] ?? '' ?></td>
                        <td><?php echo $row['user_name'] ?></td>
                        <td><?php echo $row['u_email'] ?></td>
                        <td><?php echo $row['p_number'] ?? '' ?></td>
                        <td><?php echo $row['gender'] ?? '' ?></td>
                        <td><?php echo $row['created_at'] ?? '' ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary"><i class="fa-solid fa-pen"></i></a>
                            <a class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" align="center">No Records Found</td>
                </tr>

            <?php
            }
            ?>


        </tbody>
    </table>

</div>



<?php
include "./partials/footer.php";
?>