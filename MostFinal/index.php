<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/databaseUser.php";
    
    $sql = "SELECT * FROM userdata
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $userdata = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleS.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">

</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($userdata)): ?>
        
        <p>Hello <?= htmlspecialchars($userdata["name"]) ?></p>
        
        <p><a href="logout.php">Logout</a></p>
        
        <!-- line 31 deng 33 ini ganti deng header("Location: TU APK PE LOKASI.html"); -->
        
    <?php else: ?>
        
        echo "FAILED";
        
    <?php endif; ?>
    
</body>
</html>