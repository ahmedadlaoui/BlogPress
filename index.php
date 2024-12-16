<?php
$servername = "localhost"; 
$username = "root"; 
$password = "06database@SM23";
$dbname = "BlogPress";    
$port = 3306;   

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); 
}
?>

<?php
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="index.php"><li>Home</li></a>
            <a href="#"><li>About Us</li></a>
            <a href="#"><li>Your articles</li></a>
        </ul>
        <div class="connection-buttons">
            <button id="login">Log in</button>
            <button id="signup">Sign Up</button>
        </div>
    </header>

    <section class="loginn">
    <div class="welcomemsg">
    <h1>Log In</h1>
    </div>
        <form action="" id="login">
            <input type="text" placeholder="Name" required>
            <input type="email" placeholder="E-mail" required>
            <input type="text" placeholder="Password" required>
            <h5>You don't have an account ?<span id="span-register">Register here</span></h5>
            <button type="submit">Submit</button>
        </form>
    </section>
    
    <section class="signupp">
    <div class="welcomemsg">
    <h1>Sign Up</h1>
    </div>
        <form action="" id="signup">
            <input type="email" placeholder="E-mail" required>
            <input type="text" placeholder="Password" required>
            <button type="submit" id="creation-acc">Create</button>
        </form>
        <h5>You already have an account ?<span id="span-login">Log in</span></h5>
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

