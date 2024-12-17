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

$sql = "SELECT first_name, last_name, email, phone, address, gender FROM contacts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Gender</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone"]. "</td><td>" . $row["address"]. "</td><td>" . $row["gender"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>