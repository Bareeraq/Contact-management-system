<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contact</title>
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
                <h2>Add Contact</h2>

                <?php
                // Display success message if it exists
                if (isset($_GET['message'])) {
                    echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
                }
                ?>
                <form action="submit_contact.php" method="POST">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" required><br><br>
                
                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" required><br><br>
                
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br><br>
                
                    <label for="phone">Phone Number:</label><br>
                    <input type="text" id="phone" name="phone" required><br><br>
                
                    <label for="address">Address:</label><br>
                    <input type="text" id="address" name="address" required><br><br>
                
                    <label for="gender">Gender:</label><br>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select><br><br>
                
                    <button type="submit">Add Contact</button>
                </form>
            </div>
        </div>    
    </div>
</body>
</html>
