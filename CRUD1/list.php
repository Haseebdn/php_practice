<?php
include "./handler/connection.php";
include "./partials/header.php";
?>

<style>
    .subject {
        background-color: skyblue;
        padding: 2px 8px;
        margin: 1px;
        border-radius: 4px;
    }
</style>

<div class=" w-100 container-fluid px-3 my-5">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <h2>Students Data</h2>
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

    if (isset($_GET['delete-success'])) {
        if ($_GET['delete-success'] == 1) {
            echo '<div class="alert alert-success">Record Deleted successfully</div>';
        } else {
            echo '<div class="alert alert-success">Record Deletion Failed</div>';
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
    <table class=" w-100 table">
        <!-- Table Header -->
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Profile Pic</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Gender</th>
                <th scope="col">Subjects</th>
                <th scope="col">Teacher</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <!-- Table Header -->

        <!-- Table Rows -->
        <tbody>
            <?php


            $query = "SELECT t.*,i.*, 
                i.id AS stdID, 
                i.created_at AS stdCreatedAt 
                FROM infotable AS i 
                LEFT JOIN teachers AS t 
                ON i.teacher_id = t.id";

            if (isset($_GET['fullName'])) {
                $fullname = $_GET['fullName'];
                $query .= " WHERE i.full_name LIKE '%$fullname%' OR t.teacher_name LIKE  '%$fullname%'";
            }


            $query = $query . " ORDER BY stdID ASC";

            $mysql = mysqli_query($conn, $query);

            $count = mysqli_num_rows($mysql);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($mysql)) {
            ?>
                    <tr>
                        <td><?php echo $row['stdID'] ?? '' ?></td>
                        <td><img src="./uploads/profilePictures/<?php echo $row['profile_img'] ?? '' ?>" alt="" width="50"></td>
                        <td><?php echo $row['user_name'] ?></td>
                        <td><?php echo $row['u_email'] ?></td>
                        <td><?php echo $row['p_number'] ?? '' ?></td>
                        <td><?php echo $row['gender'] ?? '' ?></td>
                        <td><?php
                            if ($row['subjects']) {
                                $subjects = explode(',', $row['subjects']);
                                if ($subjects) {
                                    foreach ($subjects as $sub) {
                                        echo  '<span class="subject">' . ucfirst($sub) . '</span>';
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $row['teacher_name'] ?? 'N/A' ?></td>
                        <td><?php echo $row['stdCreatedAt'] ?? '' ?></td>
                        <!-- Table Rows -->

                        <!-- Buttons -->
                        <td>
                            <a class="btn btn-sm btn-primary" href="./userForm.php?id=<?php echo $row['stdID'] ?? '' ?>"><i class="fa-solid fa-pen"></i></a>
                            <a class="btn btn-sm btn-danger" href="./handler/delete.php?id=<?php echo $row['stdID'] ?? '' ?>"><i class="fa-solid fa-trash"></i></a>
                            <a href="./handler/view.php?id=<?php echo $row['stdID'] ?? '' ?>" class="fw-bold text-decoration-none">View</>
                        </td>
                        <!-- Buttons -->
                    </tr>

                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="10" align="center">No Records Found</td>
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