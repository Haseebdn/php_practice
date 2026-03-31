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


<div class="container d-flex my-4 flex-column align-items-center w-100">
    <!-- Image Div -->
    <div class="image w-50 d-flex justify-content-center align-items-center">
        <?php
        if (isset($_GET['id']) && isset($record['profile_img'])) {
        ?>
            <div class="w-50 d-flex justify-content-center align-items-center">
                <img src="../uploads/profilePictures/<?php echo $record['profile_img'] ?>" alt="IMAGE" class=" border p-1 border-primary border-4 rounded rounded-circle" width="100%">
            </div>

        <?php
        }
        ?>
    </div>
    <!-- Image Div -->
    <div class="container mt-5 w-75">

        <table class="table table-striped-columns">
            <tbody>
                <tr>
                    <!-- ID -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">ID</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo @$record['id'] ?></p>
                    </td>
                    <!-- ID -->

                    <!-- Full Name -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Full Name</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo ucfirst(@$record['user_name']) ?></p>
                    </td>
                    <!-- Full Name -->
                </tr>
                <tr>
                    <!-- Email -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Email</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo @$record['u_email'] ?></p>
                    </td>
                    <!-- Email -->

                    <!-- Phone Number -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Phone Number</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo @$record['p_number'] ?></p>
                    </td>
                    <!-- Phone Number -->
                </tr>
                <tr>
                    <!-- Date of Birth -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Date Of Birth</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo @$record['dateOfBirth'] ?></p>
                    </td>
                    <!-- Date of Birth -->

                    <!-- Gender -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Gender</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo ucfirst(@$record['gender']) ?></p>
                    </td>
                    <!-- Gender -->
                </tr>
                <tr>
                    <!-- Subjects -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Subjects</p>
                    </td>
                    <td>
                        <p class="fs-6 mb-0 text-center mb-0"><?php
                                                                $subjects = explode(',', @$record['subjects']);

                                                                $subjects = array_map(function ($item) {
                                                                    return ucwords(trim($item));
                                                                }, $subjects);

                                                                echo implode(', ', $subjects);
                                                                ?>
                        </p>
                    </td>
                    <!-- Subjects -->

                    <?php
                    $query = "SELECT t.teacher_name 
          FROM infotable AS i 
          LEFT JOIN teachers AS t 
          ON i.teacher_id = t.id
          WHERE i.id = '$id'";

                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <!-- Teacher -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Teacher</p>
                    </td>
                    <td>
                        <p class="fs-6 text-center mb-0"><?php echo !empty($row['teacher_name']) ? ucwords($row['teacher_name']) : 'N/A'; ?></p>
                    </td>
                    <!-- Teacher -->
                </tr>
                <tr>
                    <!-- Created At  -->
                    <td>
                        <p class="fs-6 mb-0 fw-bold ">Created At</p>

                    </td>
                    <td>
                        <p class="fs-6 mb-0 text-center"><?php echo @$record['created_at'] ?></p>
                    </td>
                    <!-- Created At  -->
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Certificates -->
    <div class="container mt-4 w-75">
        <h3>Certificates</h3>

        <div class="container  w-100 d-flex flex-wrap gap-3">
            <?php
            if (!empty($record['certificates'])) {

                $certificates = explode(',', $record['certificates']);

                foreach ($certificates as $cert) {
            ?>
                    <img src="../uploads/certificates/<?php echo trim($cert); ?>"
                        alt="Certificate"
                        width="30%"
                        class="border p-1 border-success rounded">
            <?php
                }
            } else {
                echo "<p>No certificates found</p>";
            }
            ?>
        </div>
        <!-- Certificates -->


    </div>
</div>
</div>


<?php
include "../partials/footer.php";
?>