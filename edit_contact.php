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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contact = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    $sql = "UPDATE contacts SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ?, gender = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $address, $gender, $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=Contact updated successfully.");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.home.css">
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
        <div class="edit-contact-wrapper">
            <form class="edit-contact-form" action="edit_contact.php" method="POST">
                <h2>Edit Contact</h2>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($contact['id']); ?>">

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($contact['first_name']); ?>" required>
                        
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($contact['last_name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($contact['address']); ?>" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($contact['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($contact['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($contact['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <button type="submit">Update Contact</button>
            </form>
        </div> 
    </div>     
</body>
</html>

