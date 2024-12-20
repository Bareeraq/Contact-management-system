<?php

$servername = "localhost";
$username = "root"; 
$password = "Bareera@21"; 
$dbname = "contact_management"; 
//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//delete message display
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
    case 'last_name_asc':
        $sort_query = "ORDER BY last_name ASC";
        break;
    case 'last_name_desc':
        $sort_query = "ORDER BY last_name DESC";
        break;
    case 'email_asc':
        $sort_query = "ORDER BY email ASC";
        break;
    case 'email_desc':
        $sort_query = "ORDER BY email DESC";
        break;
    case 'phone_asc':
        $sort_query = "ORDER BY phone ASC";
        break;
    case 'phone_desc':
        $sort_query = "ORDER BY phone DESC";
        break;
    case 'address_asc':
        $sort_query = "ORDER BY address ASC";
        break;
    case 'address_desc':
        $sort_query = "ORDER BY address DESC";
        break;
    case 'gender_male':
        $sort_query = "WHERE gender = 'Male'";
        break;
    case 'gender_female':
        $sort_query = "WHERE gender = 'Female'";
        break;
    case 'gender_other':
        $sort_query = "WHERE gender = 'Other'";
        break;
    case 'gender_all':
        $sort_query = ""; // No filter for gender (show all)
        break;
    default:
        $sort_query = "ORDER BY first_name ASC"; // Default sort by first name
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
    <link rel="stylesheet" href="style.home.css?v=1.0">
</head>
<body>
    <div class="dashboard">
        <!-- Horizontal Navigation Bar -->
        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Contacts</a></li>
                <li><a href="add_contact.php">Add Contact</a></li>
            </ul>
        </nav>
        
        <!-- Main Content Area -->
        <div class="main-wrapper">
            <div class="main-content">
                <h1>Contact Management System</h1>
                   
                <div class="contact-header">
                    <h2>Contact List</h2>
                    <!-- Search Box -->
                    <div class="search-box">
                        <form action="index.php" method="GET">
                            <input type="text" name="search" placeholder="Search by name or number..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit">Search</button>
                        </form>
                    </div> 
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    First Name
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="name_asc" <?php echo ($sort_option === 'name_asc') ? 'selected' : ''; ?>>A-Z</option>
                                            <option value="name_desc" <?php echo ($sort_option === 'name_desc') ? 'selected' : ''; ?>>Z-A</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>
                                    Last Name
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="last_name_asc" <?php echo ($sort_option === 'last_name_asc') ? 'selected' : ''; ?>>A-Z</option>
                                            <option value="last_name_desc" <?php echo ($sort_option === 'last_name_desc') ? 'selected' : ''; ?>>Z-A</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>
                                    Email
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="email_asc" <?php echo ($sort_option === 'email_asc') ? 'selected' : ''; ?>>A-Z</option>
                                            <option value="email_desc" <?php echo ($sort_option === 'email_desc') ? 'selected' : ''; ?>>Z-A</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>
                                    Phone
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="phone_asc" <?php echo ($sort_option === 'phone_asc') ? 'selected' : ''; ?>>0-9</option>
                                            <option value="phone_desc" <?php echo ($sort_option === 'phone_desc') ? 'selected' : ''; ?>>9-0</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>
                                    Address
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="address_asc" <?php echo ($sort_option === 'address_asc') ? 'selected' : ''; ?>>A-Z</option>
                                            <option value="address_desc" <?php echo ($sort_option === 'address_desc') ? 'selected' : ''; ?>>Z-A</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>
                                    Gender
                                    <form action="index.php" method="GET" style="display:inline;">
                                        <select name="sort" onchange="this.form.submit()">
                                            <option value="gender_all" <?php echo ($sort_option === 'gender_all') ? 'selected' : ''; ?>>All</option>
                                            <option value="gender_male" <?php echo ($sort_option === 'gender_male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="gender_female" <?php echo ($sort_option === 'gender_female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="gender_other" <?php echo ($sort_option === 'gender_other') ? 'selected' : ''; ?>>Others</option>
                                        </select>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    </form>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch and display contacts from the database
                                if ($result->num_rows > 0) {
                                    // Output each row as a table row
                                    while ($row = $result->fetch_assoc()) {
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
    <script>
        // Show the modal if the message exists
        <?php if (!empty($message)): ?>
            document.getElementById("myModal").style.display = "block";
        <?php endif; ?>

        // Close the modal when the user clicks on the "x"
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>    
</body>
</html>
