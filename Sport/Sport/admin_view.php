<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_view</title>
    <link rel="stylesheet" href="admin_view.css">
</head>
<body>
<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Increment the count of logged-in users
if (!isset($_SESSION['logged_in_users'])) {
    $_SESSION['logged_in_users'] = 0;
}
$_SESSION['logged_in_users']++;

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sportsdb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all registered users
$result = $conn->query("SELECT team_name, email, address, mobile, sports FROM registerdata2");

echo "<div class='container'>";
echo "<h1>Logged In Users</h1>";

if ($result->num_rows > 0) {
    echo "<h2>Registered Users:</h2>";
    echo "<table>
            <tr>
                <th>Team Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Sport</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['team_name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['address']) . "</td>
                <td>" . htmlspecialchars($row['mobile']) . "</td>
                <td>" . htmlspecialchars($row['sports']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No registered users found.</p>";
}

// Optionally, provide a way to log out and decrement the count
if (isset($_POST['logout'])) {
    $_SESSION['logged_in_users']--;
    echo "<p>You have logged out.</p>";
    session_destroy();
}
?>
<form method="post">
    <div class="google-form" >
        <br>
        <br>
        <a href="https://docs.google.com/spreadsheets/d/1YZfZwmNN4eRGSVFfh-BYdHiFFeApGsblcNvO6mSNlM4/edit?usp=sharing" style="color:rgb(235, 144, 9);" >View Player's Details </a>
    </div>
    <button type="submit" name="logout">Logout</button>
</form>
</div>
</body>
</html>


