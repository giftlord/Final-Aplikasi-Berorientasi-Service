<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/databaseUser.php";
    
    $sql = sprintf("SELECT * FROM userdata
                    WHERE email = '%s'",
                $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $userdata = $result->fetch_assoc();
    
    if ($userdata) {
        
        if (password_verify($_POST["password"], $userdata["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $userdata["id"];
            
            header("Location: rest-client/");
            exit;
        }
    }
    
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> LOGIN PAGE </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styleS.css">
    </head>
    <body>
        <div class="container">
            <h1>LOGIN</h1>

            <?php if ($is_invalid): ?>
                <em>Invalid login</em>
            <?php endif; ?>

            <form method="post">

                <label for="email">email</label>
                <input type="email" name="email" id="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
        
                <button>Login</button>

            </form>
        </div>
    </body>
</html>