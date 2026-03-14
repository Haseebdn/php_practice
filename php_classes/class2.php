<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Class 2</title>
</head>

<body>
    <div class="container d-flex flex-column  align-items-center">
        <h1 class="text-center">Crud</h1>
        <form class="w-50 mt-4">
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
                <input type="radio" name="gender"> Male
                <input type="radio" name="gender"> Female
                <input type="radio" name="gender"> Other
            </div> <br>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>