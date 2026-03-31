<?php
include "./handler/connection.php";
include "./partials/header.php";

$limit = 10;


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;
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
            $countQuery = "SELECT COUNT(*) as total FROM infotable";
            $countResult = mysqli_query($conn, $countQuery);
            $totalRows = mysqli_fetch_assoc($countResult)['total'];

            $totalPages = ceil($totalRows / $limit);

            $query = "SELECT t.*,i.*, 
                i.id AS stdID, 
                i.created_at AS stdCreatedAt 
                FROM infotable AS i 
                LEFT JOIN teachers AS t 
                ON i.teacher_id = t.id";

            if (isset($_GET['search_name']) && $_GET['search_name'] != '') {
                $fullname = $_GET['search_name'];
                $query .= " WHERE i.user_name LIKE '%$fullname%' OR t.teacher_name LIKE '%$fullname%'";
            }


            $query .= " ORDER BY stdID ASC LIMIT $limit OFFSET $offset";

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
    <!-- Pagination Added -->
    <nav>
        <ul class="pagination justify-content-center">


            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search_name=<?php echo $_GET['search_name'] ?? ''; ?>">Previous</a>
            </li>

            <?php
            for ($i = 1; $i <= $totalPages; $i++) {


                if ($i <= 3 || $i > $totalPages - 3 || abs($i - $page) <= 1) {

            ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search_name=<?php echo $_GET['search_name'] ?? ''; ?>"">
                            <?php echo $i; ?>
                        </a>
                    </li>
            <?php
                } elseif ($i == 4 || $i == $totalPages - 3) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }
            ?>


            <li class=" page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search_name=<?php echo $_GET['search_name'] ?? ''; ?>">Next</a>
                    </li>

        </ul>
    </nav>
    <!-- Pagination Added -->

</div>



<?php
include "./partials/footer.php";
?>