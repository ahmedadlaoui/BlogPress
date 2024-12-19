<?php
session_start();
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
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
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
            <?php
            if (isset($_SESSION['username'])) {
                echo '<form method="post">
            <button type="submit" name="logout" id="log-out">
                Log out <img src="images/logout_24dp_EFEFEF_FILL1_wght400_GRAD0_opsz24.svg" alt="">
            </button>
        </form>';
            } else {
                echo '<button id="login">Log in</button>';
                echo '<button id="signup">Sign Up</button>';
            }
            ?>
        </div>

    </header>

    <section class="loginn">
        <div class="welcomemsg">
            <h1>Log In</h1>
        </div>
        <form action="index.php" method="POST" id="login">
            <input type="email" name="connectionemail" placeholder="E-mail" required>
            <div style="position: relative;width:100%;">
                <input type="password" name="connectionpassword" placeholder="Password" required id="passlog">
                <img src="images/invisiblepassword.svg" alt="" class="togglevis" id="invis">
                <img src="images/visiblepassword (1).svg" alt="" class="togglevis" id="vis">
            </div>
            <h5>You don't have an account ?<span id="span-register">Register here</span></h5>
            <button type="submit">Log In</button>
        </form>

    </section>

    <section class="signupp">
        <div class="welcomemsg">
            <h1>Sign Up</h1>
        </div>
        <form action="index.php" id="signup" name="signup" method="POST">
            <input type="text" name="username" placeholder="Name" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Password" required>
            <h5>You already have an account? <span id="span-login">Log in</span></h5>
            <button type="submit" id="creation-acc">Create</button>
        </form>

    </section>
    <div>
        <?php


        if (isset($_SESSION['username'])) {
            echo '<h1 class="wlc">Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</h1>';
        } else {
            echo '<h1 class="wlc">Welcome, Guest!</h1>';
        }
        ?>
    </div>
    <section class="whole-article">
        
        <?php
        $created_at = $article['created_at'];
        $created_date = new DateTime($created_at);
        $formatted_date = $created_date->format('Y-m-d');
        echo '<p class="date">' . htmlspecialchars($formatted_date) . '</p>';
        ?>

        <img src="<?php echo htmlspecialchars($article['poster']); ?>" alt="">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
    </section>

    <!-- <section class="whole-article">
        <img src="images/image 5.svg" alt="">
        <h1>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Suscipit, debitis.</h1>
        <P>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur ipsa reiciendis voluptatem delectus temporibus eligendi esse culpa facere a architecto nesciunt deserunt voluptatum aspernatur aut, perferendis aliquid recusandae? Quibusdam perspiciatis, veritatis aspernatur nulla ratione consectetur saepe possimus fugiat ut itaque? In itaque corporis perferendis nam dolorem mollitia vel laudantium eaque natus officia possimus tenetur consequuntur nulla adipisci quisquam voluptatum, consequatur fugiat hic? Excepturi in veniam, quo consequuntur deleniti ducimus, saepe tempore ex sunt labore provident neque culpa nisi officia voluptatum consectetur magni impedit delectus sed. Blanditiis numquam quis quos suscipit debitis sed minus reiciendis architecto. Sint non animi eos voluptate.</P>
    </section> -->
</body>

</html>