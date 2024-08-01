<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $song = $_POST['song'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $video_creator = $_POST['video_creator'];
    $collaboration = $_POST['collaboration'];

    $sql = "INSERT INTO music (song, artist, album, video_creator, collaboration) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssss", $song, $artist, $album, $video_creator, $collaboration);
        if ($stmt->execute()) {
            header("location: home.php");
            exit();
        } else {
            echo "Error: Could not execute query: $sql. " . $mysqli->error;
        }
    } else {
        echo "Error: Could not prepare query: $sql. " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Record</title>
</head>
<body>
    <h1>Add New Record</h1>
    <form action="create.php" method="post">
        <label>Song:</label>
        <input type="text" name="song" required><br>
        <label>Artist:</label>
        <input type="text" name="artist" required><br>
        <label>Album:</label>
        <input type="text" name="album" required><br>
        <label>Video Creator:</label>
        <input type="text" name="video_creator" required><br>
        <label>Collaboration:</label>
        <input type="text" name="collaboration" required><br>
        <input type="submit" value="Submit">
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>
