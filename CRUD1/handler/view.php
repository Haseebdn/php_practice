<?php
include "./connection.php";
include "../partials/header.php";

if (isset($_GET['id']) && $_GET['id'] != "") {
    $id = $_GET['id'];

    $query = "SELECT * FROM `infotable` WHERE `id` = '$id'";

    $sql = mysqli_query($conn, $query);

    $record = mysqli_fetch_assoc($sql);

    // print_r($record);
    // die();
} ?>

<div class="container my-4 w-100 d-flex gap-4 ">
    <div class="image w-25 ">
        <?php
        if (isset($_GET['id']) && isset($record['profile_img'])) {
        ?>
            <div>
                <img src="../uploads/profilePictures/<?php echo $record['profile_img'] ?>" alt="IMAGE" width="80%">
            </div>

        <?php
        }
        ?>
    </div>
   
    <div class="details w-60 d-flex flex-column lh-1 ">

        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold ">ID:</p>
            <p class="fs-6"><?php echo @$record['id'] ?></p><br>
        </div>
        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold ">Name:</p>
            <p class="fs-6"><?php echo @$record['user_name'] ?></p><br>
        </div>

        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold ">Email:</p>
            <p class="fs-6"><?php echo @$record['u_email'] ?></p><br>
        </div>
        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold d-inline ">Phone Number:</p>
            <p class="fs-6"><?php echo @$record['p_number'] ?></p><br>
        </div>
        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold d-inline ">Gender:</p>
            <p class="fs-6"><?php echo ucfirst(@$record['gender']) ?></p><br>
        </div>
        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold d-inline "> Subjects: </p>
            <p class="fs-6"><?php
                            $subjects = explode(',', @$record['subjects']);

                            $subjects = array_map(function ($item) {
                                return ucwords(trim($item));
                            }, $subjects);

                            echo implode(', ', $subjects);
                            ?></p>
        </div>



        <?php
        $query = "SELECT t.teacher_name 
          FROM infotable AS i 
          LEFT JOIN teachers AS t 
          ON i.teacher_id = t.id
          WHERE i.id = '$id'";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        ?>

        <div class="d-flex gap-3">
            <p class="fs-6 fw-bold d-inline">Teacher:</p>
            <p class="fs-6"><?php echo !empty($row['teacher_name']) ? ucwords($row['teacher_name']) : 'N/A'; ?></p>
        </div>

        <div class="d-flex gap-3 ">
            <p class="fs-6 fw-bold ">Created At:</p>
            <p class="fs-6"><?php echo @$record['created_at'] ?></p><br>
        </div>
    </div>
</div>

<?php
include "../partials/footer.php";
?>