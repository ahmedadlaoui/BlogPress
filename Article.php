<?php
$servername = "localhost";
$username = "root";
$password = "06database@SM23";
$dbname = "BlogPress";
$port = 3306;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="overlay"></div>
    <header>
        <a href="index.php"><img src="images/logoBP.png" alt="" class="logo"></a>
        <ul>
        <a href="index.php">
            <li>Home</li>
        </a>
        <a href="#">
            <li>About Us</li>
        </a>
        
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'author') {
            echo '<a href="authordashboard.php"><li>Your articles</li></a>';
        }
        ?>
    </ul>
        <div class="connection-buttons">
            <button id="login">Log in</button>
            <button id="signup">Sign Up</button>
        </div>
    </header>
</body>
</html>