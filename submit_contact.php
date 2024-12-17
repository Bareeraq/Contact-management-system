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
    // Initialize errors array
    $errors = [];

    // 1. First Name Validation
    $first_name = trim($_POST['first_name']);
    if (!preg_match("/^[a-zA-Z ]{1,50}$/", $first_name)) {
        $errors['first_name'] = "First name must contain 1-50 letters and spaces only.";
    }

    // 2. Last Name Validation
    $last_name = trim($_POST['last_name']);
    if (!preg_match("/^[a-zA-Z ]{1,50}$/", $last_name)) {
        $errors['last_name'] = "Last name must contain 1-50 letters and spaces only.";
    }

    // 3. Email Validation
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $errors['email'] = "Invalid email format or exceeds 254 characters.";
    }

    // 4. Phone Number Validation
    $phone = trim($_POST['phone']);
    if (!preg_match("/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/", $phone)) {
        $errors['phone'] = "Invalid phone number format. Use (123) 456-7890, 123-456-7890, or 1234567890.";
    }

    // 5. Address Validation (Free text)
    $address = trim($_POST['address']);
    if (empty($address)) {
        $errors['address'] = "Address cannot be empty.";
    }

    // 6. Gender Validation (Choice: Male/Female/Others)
    $gender = trim($_POST['gender']);
    if (!in_array($gender, ['Male', 'Female', 'Others'])) {
        $errors['gender'] = "Invalid gender selection. Please select Male, Female, or Other.";
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        foreach ($errors as $field => $error) {
            echo "<p style='color:red;'>$field: $error</p>";
        }
    } else {
        // Sanitize data for insertion
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $last_name = mysqli_real_escape_string($conn, $last_name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $address = mysqli_real_escape_string($conn, $address);
        $gender = mysqli_real_escape_string($conn, $gender);

        // Insert the data into the database
        $sql = "INSERT INTO contacts (first_name, last_name, email, phone, address, gender)
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$address', '$gender')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to add_contact page with success message
            header("Location: add_contact.php?message=New contact added successfully");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
