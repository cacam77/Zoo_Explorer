<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loginzoo";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Access player name
    $playername = $_POST["playername"];

    // Access file information
    $file = $_FILES["file"];
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    
    // Insert data into the database
    $sql = "INSERT INTO player (playername, filename) VALUES ($playername, $file)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $playername, $fileName);
    
    if ($stmt->execute()) {
        // File upload logic here if needed
        move_uploaded_file($fileTmpName, "your_upload_directory/" . $fileName);
        echo "Data and file uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

