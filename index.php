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

// Get search and sort parameters
$search = isset($_GET['search']) ? $_GET['search'] : ''; // search term
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc'; // sorting order (default)

// Define sorting query logic
switch ($sort_option) {
    case 'name_asc':
        $sort_query = "ORDER BY first_name ASC";
        break;
    case 'name_desc':
        $sort_query = "ORDER BY first_name DESC";
        break;
    case 'phone_asc':
        $sort_query = "ORDER BY phone ASC";
        break;
    case 'phone_desc':
        $sort_query = "ORDER BY phone DESC";
        break;
    default:
        $sort_query = "ORDER BY first_name ASC";
        break;
}

// Base SQL query
$sql = "SELECT id, first_name, last_name, email, phone, address, gender FROM contacts";

// search and sorting conditions
if ($search) {
    $sql .= " WHERE first_name LIKE ? OR last_name LIKE ? OR phone LIKE?";
}
$sql .= " $sort_query";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

if ($search) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
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

                <!-- Search & Sort  Box-->
                <div class="search-box">
                    <form action="index.php" method="GET">
                        <input type="text" name="search" placeholder="Search by name or number..." value="<?php echo htmlspecialchars($search); ?>">
                        
                        <!-- Dropdown for Sorting -->
                        <select name="sort" onchange="this.form.submit()"> <!-- Automatic form submission -->
                            <option value="name_asc" <?php echo ($sort_option === 'name_asc') ? 'selected' : ''; ?>>Sort by Name (A-Z)</option>
                            <option value="name_desc" <?php echo ($sort_option === 'name_desc') ? 'selected' : ''; ?>>Sort by Name (Z-A)</option>
                            <option value="phone_asc" <?php echo ($sort_option === 'phone_asc') ? 'selected' : ''; ?>>Sort by Phone (Ascending)</option>
                            <option value="phone_desc" <?php echo ($sort_option === 'phone_desc') ? 'selected' : ''; ?>>Sort by Phone (Descending)</option>
                        </select>
                        
                        <button type="submit">Search</button>
                    </form>
                </div> 
                
                <h2>Contact List</h2>

                <div class="table-container"></div>
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
    </div>    
</body>
</html>
