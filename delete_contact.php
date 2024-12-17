<?php
$servername = "localhost";
$username = "root";
$password = "Bareera@21";
$dbname = "contact_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=Contact deleted successfully.");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
