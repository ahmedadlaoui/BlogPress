<?php
session_start();
// session_unset();
// session_destroy();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'visitor')");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error during signup: " . $e->getMessage();
        }
    }

    // Login
    if (isset($_SESSION['user_id'])) {
        session_unset();
        session_destroy();
    }

    if (isset($_POST['connectionemail']) && isset($_POST['connectionpassword'])) {
        $connectionemail = trim($_POST['connectionemail']);
        $connectionpassword = trim($_POST['connectionpassword']);

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $connectionemail);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($connectionpassword, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];  
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            echo "Error during login: " . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the homepage
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

    <section class="popular-articles">
        <div class="hero">
            <img src="images/image 5.svg" alt="">
            <h1>The game Awards 2024: all of the biggest trailers and announcements</h1>
            <a href="Article.php" target="_blank"><button>Read more...</button></a>
        </div>

        <div class="side-articles">
            <H1 style="font-family: roboto;margin-bottom:24px;border-bottom:1px solid white;margin-right:50%;">Top articles :</H1>
            <div class="popular-grid">
                <div class="popular-article">
                    <div class="details">
                        <p>The game Awards 2024: all of the biggest trailers and announcements</p>
                        <img src="images/image 5.svg" class="article-poster">
                    </div>
                    <div class="writer">
                        <p>Ahmed</p>
                        <img src="images/history_edu_24dp_FFC067_FILL1_wght400_GRAD0_opsz24.svg">
                    </div>
                </div>

                <div class="popular-article">
                    <div class="details">
                        <p>The game Awards 2024: all of the biggest trailers and announcements</p>
                        <img src="images/image 5.svg" class="article-poster">
                    </div>
                    <div class="writer">
                        <p>Ahmed</p>
                        <img src="images/history_edu_24dp_FFC067_FILL1_wght400_GRAD0_opsz24.svg">
                    </div>
                </div>

                <div class="popular-article">
                    <div class="details">
                        <p>The game Awards 2024: all of the biggest trailers and announcements</p>
                        <img src="images/image 5.svg" class="article-poster">
                    </div>
                    <div class="writer">
                        <p>Ahmed</p>
                        <img src="images/history_edu_24dp_FFC067_FILL1_wght400_GRAD0_opsz24.svg">
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="Script.js?v=<?php echo time(); ?>"></script>
</body>

</html>