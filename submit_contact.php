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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Insert the data into the database
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, address, gender)
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$address', '$gender')";

    if ($conn->query($sql) === TRUE) {
        //Redirect to add_contact page with success message
        header("Location: add_contact.php?message=New contact added successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
