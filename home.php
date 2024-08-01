<?php
require_once "config.php";

$sql = "SELECT * FROM music";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Light background color for the page */
        }
        h1 {
            text-align: center;
            color: #fff;
            background-color: #28a745; /* Green background color */
            padding: 15px;
            border-radius: 5px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
            
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #000; /* Black color for the table */
            border-radius: 10px;
            overflow: hidden; /* Ensures that the border-radius is applied correctly */
            margin-bottom: 20px; 
        }
        th, td {
            border: 1px solid #333; /* Darker border for better contrast */
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            color: #8b0000; /* Dark red text color */
            font-size: 1.2em;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Slight shadow for depth */
        }
        td {
            background-color: rgba(255, 255, 255, 0.6); /* Semi-transparent white background */
            color: #8b0000; /* Dark red text color */
            transition: background-color 0.3s ease; /* Smooth background color transition */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Slight shadow for depth */
        }
        tr:nth-child(even) td {
            background-color: rgba(0, 0, 0, 0.1); /* Light gray background for even rows */
        }
        tr:hover td {
            background-color: rgba(0, 0, 0, 0.2); /* Darker background on hover */
        }
        caption {
            padding: 15px;
            font-size: 2em;
            color: #8b0000;
            background-color: #007bff; /* Solid background color */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); /* Slight shadow for caption text */
        }
        a {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: rgba(255, 182, 193, 0.5); /* Light red background */
            color: #8b0000; /* Dark red text color */
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: rgba(255, 182, 193, 0.7); /* Slightly darker red on hover */
        }
    </style>
</head>
<body>
    <h1>Music Records</h1>
    <a href="create.php">Add New Record</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Song</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Video Creator</th>
                <th>Collaboration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['song']; ?></td>
                        <td><?php echo $row['artist']; ?></td>
                        <td><?php echo $row['album']; ?></td>
                        <td><?php echo $row['video_creator']; ?></td>
                        <td><?php echo $row['collaboration']; ?></td>
                        <td>
                            <a href="read.php?id=<?php echo $row['id']; ?>">View</a>
                            <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
