<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Bareera@21";
$dbname = "contact_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'search' parameter is set
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT id, first_name, last_name, email, phone, address, gender FROM contacts";
if ($search) {
    $sql .= " WHERE first_name LIKE ? OR last_name LIKE ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

// Output the results as a table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['first_name']) . "</td>
            <td>" . htmlspecialchars($row['last_name']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['phone']) . "</td>
            <td>" . htmlspecialchars($row['address']) . "</td>
            <td>" . htmlspecialchars($row['gender']) . "</td>
            <td>
                <form action='delete_contact.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' onclick='return confirm(\"Are you sure you want to delete this contact?\")'>Delete</button>
                </form>
                <form action='edit_contact.php' method='GET' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit'>Edit</button>
                </form>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No contacts found</td></tr>";
}

$stmt->close();
$conn->close();
?>
