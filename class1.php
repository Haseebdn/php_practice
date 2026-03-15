<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>class 1</title>
</head>

<body>

    <h2>Class 1</h2>

    <?php
    echo "<h2>Hey</h2>";
    $userName = 'hamza';
    $hamza = 'sain';
    $fruits = ["mango", "banana", "apple", "strawberry"];
    $age = 18;
    ?>

    <!-- print variable -->
    <h2><?php echo $userName;    ?></h2>

    <!-- <h2><?php echo $$userName;    ?></h2> -->

    <!-- to print array -->
    <h2><?php print_r($fruits);    ?></h2>


    <!-- using if else statement -->

    <!-- method 1 -->
    <?php
    if ($age < 18) {
    ?>
        <h2>You are not eligible to vote</h2>
    <?php
    } else if ($age >= 18) {

    ?>
        <h2>You are eligible to vote</h2>
    <?php
    }
    ?>

    <!-- method 2 -->

    <?php
    if ($age < 18) {
        echo "<h2> You are not eligible to vote <h2>";
    } else if ($age >= 18) {
        echo "<h2> You are eligible to vote <h2>";
    }
    ?>

    <!-- method 3 -->

    <?php
    $alert = '';
    if ($age < 18) {
        $alert = "You are not eligible to vote";
    } else if ($age >= 18) {
        $alert = "You are eligible to vote";
    }
    ?>

    <h2>
        <?php echo $alert; ?>
    </h2>

    <!-- array and loop -->
     
    <?php
    $length = count($fruits);
    for ($i = 0; $i < $length; $i++) {
        echo "<p>$fruits[$i]</p>";
    }
    ?>


    <?php foreach ($fruits as $key => $value) {
        echo "key = $key and value= $value <br>";
    }   ?>

</body>

</html>