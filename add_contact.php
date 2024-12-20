<?php
session_start(); // Start session to access error messages and form data

// Fetch errors and form data from session
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

// Clear errors and form data from session after processing
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
    <link rel="stylesheet" href="style.add.css?v=1.0">
    <style>
        .error { color: red; font-size: 0.9em; }
    </style>
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
                <h1>Add New Contact</h1>

                <!-- Display success message if it exists -->
                <?php
                if (isset($_GET['message'])) {
                    echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
                }
                ?>

                <!-- Form to add new contact -->
                <form action="submit_contact.php" method="POST">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($form_data['first_name'] ?? ''); ?>" required><br>
                    <?php if (isset($errors['first_name'])): ?>
                        <p class="error"><?php echo $errors['first_name']; ?></p>
                    <?php endif; ?>

                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($form_data['last_name'] ?? ''); ?>" required><br>
                    <?php if (isset($errors['last_name'])): ?>
                        <p class="error"><?php echo $errors['last_name']; ?></p>
                    <?php endif; ?>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required><br>
                    <?php if (isset($errors['email'])): ?>
                        <p class="error"><?php echo $errors['email']; ?></p>
                    <?php endif; ?>

                    <label for="phone">Phone Number:</label><br>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>" required><br>
                    <?php if (isset($errors['phone'])): ?>
                        <p class="error"><?php echo $errors['phone']; ?></p>
                    <?php endif; ?>

                    <label for="address">Address:</label><br>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($form_data['address'] ?? ''); ?>" required><br>
                    <?php if (isset($errors['address'])): ?>
                        <p class="error"><?php echo $errors['address']; ?></p>
                    <?php endif; ?>

                    <label for="gender">Gender:</label><br>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo ($form_data['gender'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($form_data['gender'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($form_data['gender'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select><br>
                    <?php if (isset($errors['gender'])): ?>
                        <p class="error"><?php echo $errors['gender']; ?></p>
                    <?php endif; ?>

                    <button type="submit">Add Contact</button>
                </form>
            </div>
        </div>    
    </div>
</body>
</html>
