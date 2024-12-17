<?php

$servername = "localhost";
$username = "root"; 
$password = "Bareera@21"; 
$dbname = "contact_management"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['message'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : ''; //search term
$sql = "SELECT id, first_name, last_name, email, phone, address, gender FROM contacts";
if ($search) {
    $sql = "SELECT id, first_name, last_name, email, phone, address, gender 
            FROM contacts 
            WHERE first_name LIKE ? OR last_name LIKE ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    $sql = "SELECT id, first_name, last_name, email, phone, address, gender FROM contacts";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management System</title>
    <link rel="stylesheet" href="style.home.css">
</head>
<body>
    <div class="dashboard">
            <!-- Sidebar -->
            <div class="sidebar">
                <h2>Dashboard</h2>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="index.php">Contacts</a></li>
                    <li><a href="add_contact.php">Add Contact</a></li>
                </ul>
            </div>
        <!-- Main Content Area -->
        <div class="main-wrapper">
            <div class="main-content">
                <h1>Contact Management System</h1>

                <!-- Search Box -->
                <div class="search-box">
                <form action="index.php" method="GET">
                    <input type="text" name="search" placeholder="Search by name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
                </div> 
                
                <h2>Contact List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // fetch and display contacts from the database
                            if ($result->num_rows > 0) {
                                // Output each row as a table row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row["first_name"]) . "</td>
                                            <td>" . htmlspecialchars($row["last_name"]) . "</td>
                                            <td>" . htmlspecialchars($row["email"]) . "</td>
                                            <td>" . htmlspecialchars($row["phone"]) . "</td>
                                            <td>" . htmlspecialchars($row["address"]) . "</td>
                                            <td>" . htmlspecialchars($row["gender"]) . "</td>
                                            <td>
                                                <form action='delete_contact.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                                                    <button type='submit' onclick='return confirm(\"Are you sure you want to delete this contact?\")'>Delete</button>
                                                </form>
                                                <form action='edit_contact.php' method='GET' style='display:inline;'>
                                                    <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                                                    <button type='submit'>Edit</button>
                                                </form>                                  
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No contacts found</td></tr>";
                            }

                            $conn->close(); // Close the connection after displaying the contacts
                        ?>
                </tbody>
                </table>
            </div>    
        </div>
    </div>    
</body>
</html>
