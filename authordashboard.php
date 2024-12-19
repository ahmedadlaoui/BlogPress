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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-article'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $illustration = trim($_POST['illustration']);
    $author_id = $_SESSION['user_id'];
    $author_username = $_SESSION['username'];

    if (!empty($title) && !empty($content) && !empty($illustration)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO articles (title, content, poster, user_id,username) 
                VALUES (:title, :content, :poster, :user_id, :username)
            ");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':poster', $illustration);
            $stmt->bindParam(':user_id', $author_id);
            $stmt->bindParam(':username', $author_username);
            $stmt->execute();
            header("Location: authordashboard.php?success=1");
            exit;
        } catch (PDOException $e) {
            echo "Error adding article: " . $e->getMessage();
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




    <section class="mainsec">

        <div class="side">
            <?php
            $author_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("
        SELECT a.id, a.title, a.poster, a.views, 
               (SELECT COUNT(*) FROM comments c WHERE c.article_id = a.id) AS comment_count 
        FROM articles a 
        WHERE a.user_id = :author_id
    ");
            $stmt->bindParam(':author_id', $author_id);
            $stmt->execute();
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($articles as $article) {
            ?>
                <div class="popular-article">
                    <div class="details">
                        <img src="<?= htmlspecialchars($article['poster']) ?>" class="article-poster" alt="Article Poster">
                        <p><?= htmlspecialchars($article['title']) ?></p>
                        <div class="comment" style="display: flex;align-items:center;column-gap:4px;">
                            <img src="images/newcomment.svg" alt="Comments Icon">
                            <?= htmlspecialchars($article['comment_count']) ?>
                        </div>
                        <div class="views" style="display: flex;align-items:center;column-gap:4px;">
                            <img src="images/NEwview.svg" alt="Views Icon">
                            <?= htmlspecialchars($article['views']) ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        </div>

        <form class="content-form" method="POST">
            <h1 style="margin-bottom: 24px;font-family:roboto;border-bottom:1px solid white;width:100%;">Add new article :</h1>
            <input type="text" name="title" id="title" placeholder="Title :" required>
            <textarea name="content" id="content" placeholder="Content :" required></textarea>
            <input type="text" name="illustration" id="ilu" placeholder="Add illustration here (URL)...">
            <button type="submit" id="submit-article" name="submit-article">Submit</button>
        </form>
    </section>

    <script src="Script.js"></script>
</body>

</html>