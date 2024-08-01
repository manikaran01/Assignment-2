<?php
require_once "config.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM music WHERE id = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Error: Could not execute query: $sql. " . $mysqli->error;
        }
    } else {
        echo "Error: Could not prepare query: $sql. " . $mysqli->error;
    }
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
</head>
<body>
    <h1>View Record</h1>
    <p>ID: <?php echo $row['id']; ?></p>
    <p>Song: <?php echo $row['song']; ?></p>
    <p>Artist: <?php echo $row['artist']; ?></p>
    <p>Album: <?php echo $row['album']; ?></p>
    <p>Video Creator: <?php echo $row['video_creator']; ?></p>
    <p>Collaboration: <?php echo $row['collaboration']; ?></p>
    <a href="home.php">Back to Home</a>
</body>
</html>
