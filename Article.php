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
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE articles SET views = views + 1 WHERE id = :id");
    $stmt->execute(['id' => $article_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-comment'])) {
    $username = trim($_POST['comment-user-name']);
    $comment_content = trim($_POST['comment-content']);
    $article_ID = $_GET['id'];

    if (!empty($username) && !empty($comment_content) && isset($_GET['id'])) {

        try {
            $stmt = $conn->prepare("
                INSERT INTO comments (username, content, article_id) 
                VALUES (:username, :content, :article_ID)
            ");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':content', $comment_content);
            $stmt->bindParam(':article_ID', $article_ID);
            $stmt->execute();
            header("location : Article.php?id= $article_ID ");
            exit;
        } catch (PDOException $e) {
            echo "Error adding comment " . $e->getMessage();
        }
    }
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
                echo '<a href="authordashboard.php"><li>Dashboard</li></a>';
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
        <div class="like-div">
            <svg xmlns="http://www.w3.org/2000/svg" id="like-icon" height="40px" viewBox="0 -960 960 960" width="40px" fill="white">
                <path d="m480-147.34-35.9-32.51q-101.87-93.03-168.34-160.06-66.48-67.04-105.59-119.1-39.12-52.07-54.64-94.34Q100-595.63 100-638.46q0-83.25 56.14-139.39Q212.28-834 295.13-834q54.69 0 102.05 26.94 47.36 26.93 82.82 77.99 38.44-52.54 84.89-78.74Q611.34-834 664.87-834q82.85 0 138.99 56.15Q860-721.71 860-638.46q0 42.83-15.53 85.11-15.52 42.27-54.61 94.28-39.08 52.01-105.52 119.1T515.9-179.85L480-147.34Zm0-67.12q98.48-89.65 162.08-153.68 63.6-64.03 100.89-111.79 37.29-47.76 52.03-84.89 14.74-37.13 14.74-73.55 0-62.81-41.07-104.09-41.08-41.28-103.65-41.28-49.89 0-91.88 29.32-41.99 29.32-71.14 85.09h-44.41q-29.13-55.49-71.05-84.95t-91.56-29.46q-62.19 0-103.45 41.28-41.27 41.28-41.27 104.29 0 36.38 14.78 73.64 14.79 37.27 51.9 85.19 37.11 47.93 101.14 111.66Q382.1-303.95 480-214.46Zm0-284.64Z" />
            </svg>
            <?php echo htmlspecialchars($article['likes']);  ?>
        </div>
    </section>




    <div class="addcomment">
        <h1>Comments
            <button id="showform"><img src="images/add.svg" alt=""></button>
        </h1>
        <form action="Article.php?id=<?php echo htmlspecialchars($_GET['id']); ?>" method="post" class="comment-form">
            <input type="text" placeholder="Your name" name="comment-user-name" required>
            <input type="text" placeholder="add comment" name="comment-content" required>
            <button type="submit" name="submit-comment">Send<img src="images/sned.svg" alt=""></button>
        </form>
    </div>


    <section class="comments">

        <?php


        $stmt = $conn->prepare("SELECT * FROM comments WHERE article_id = :idd");
        $stmt->bindParam(':idd', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($comments as $comment) {
            echo '<div class="comment">
                <h4>' . $comment['username'] . '</h4>
                <p>' . $comment['content'] . '</p>
            </div>';
        }


        ?>
    </section>

    <script src="Script.js?v=<?php echo time(); ?>"></script>
</body>

</html>