<?php
require_once "config.php"; // Ensure this file includes the $mysqli variable

// Initialize variables
$song = $artist = $album = $video_creator = $collaboration = "";
$song_err = $artist_err = $album_err = $video_creator_err = $collaboration_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $song = trim($_POST["song"]);
    if (empty($song)) {
        $song_err = "Please enter a song.";
    }

    $artist = trim($_POST["artist"]);
    if (empty($artist)) {
        $artist_err = "Please enter an artist.";
    }

    $album = trim($_POST["album"]);
    if (empty($album)) {
        $album_err = "Please enter an album.";
    }

    $video_creator = trim($_POST["video_creator"]);
    if (empty($video_creator)) {
        $video_creator_err = "Please enter a video creator.";
    }

    $collaboration = trim($_POST["collaboration"]);
    if (empty($collaboration)) {
        $collaboration_err = "Please enter a collaboration.";
    }

    // Check input errors before updating the database
    if (empty($song_err) && empty($artist_err) && empty($album_err) && empty($video_creator_err) && empty($collaboration_err)) {
        // Prepare an update statement
        $sql = "UPDATE music SET song=?, artist=?, album=?, video_creator=?, collaboration=? WHERE id=?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssi", $song, $artist, $album, $video_creator, $collaboration, $id);
            $id = $_POST["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                header("Location: home.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            echo "Error preparing statement.";
        }

        $stmt->close();
    }
    
    $mysqli->close();
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM music WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    // Retrieve individual field value
                    $song = $row["song"];
                    $artist = $row["artist"];
                    $album = $row["album"];
                    $video_creator = $row["video_creator"];
                    $collaboration = $row["collaboration"];
                } else {
                    header("Location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            echo "Error preparing statement.";
        }

        $stmt->close();
        $mysqli->close();
    } else {
        header("Location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the music record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Song</label>
                            <input type="text" name="song" class="form-control <?php echo (!empty($song_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($song); ?>">
                            <span class="invalid-feedback"><?php echo $song_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Artist</label>
                            <input type="text" name="artist" class="form-control <?php echo (!empty($artist_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($artist); ?>">
                            <span class="invalid-feedback"><?php echo $artist_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Album</label>
                            <input type="text" name="album" class="form-control <?php echo (!empty($album_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($album); ?>">
                            <span class="invalid-feedback"><?php echo $album_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Video Creator</label>
                            <input type="text" name="video_creator" class="form-control <?php echo (!empty($video_creator_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($video_creator); ?>">
                            <span class="invalid-feedback"><?php echo $video_creator_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Collaboration</label>
                            <input type="text" name="collaboration" class="form-control <?php echo (!empty($collaboration_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($collaboration); ?>">
                            <span class="invalid-feedback"><?php echo $collaboration_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
