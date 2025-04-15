<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-futbol"></i> Sports Login Form</h1>
        <form action="login.php" method="post">
            <fieldset>
                <p>
                    <label><i class="fas fa-users"></i> Team Name</label>
                    <input type="text" required placeholder="Enter Team Name" name="team_name">
                </p>
                <p>
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" required placeholder="user123@gmail.com" name="email">
                </p>
                <p>
                    <label><i class="fas fa-gamepad"></i> Sport</label>
                    <select name="sports" required>
                        <option value="">Select a Sport</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Football">Football</option>
                        <option value="Kabaddi">Kabaddi</option>
                        <option value="Volleyball">Volleyball</option>
                    </select>
                </p>
                <div class="btn-container">
                    <button type="submit" name="login"><i class="fas fa-paper-plane"></i> Login</button>
                </div>
                <br>
                <div class="reg">
                    <a href="reg.php"><i class="fas fa-user-plus"></i> Not registered? Sign up here</a>
                </div>
            </fieldset>
        </form>
    </div>

    <?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_name = htmlspecialchars($_POST['team_name']);
    $email = htmlspecialchars($_POST['email']);
    $sport = htmlspecialchars($_POST['sports']);

    if (empty($sport)) {
        echo "<script>alert('Please select a sport before logging in.');</script>";
        exit();
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'sportsdb');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind statement
    $stmt = $conn->prepare("SELECT * FROM registerdata2 WHERE team_name = ? AND email = ? AND sports = ?");
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $team_name, $email, $sport);
    $stmt->execute();
    $result = $stmt->get_result();

    // User validation
    if ($result->num_rows > 0) {
        $_SESSION['team_name'] = $team_name; // Store session
        $_SESSION['sport'] = $sport;

        // Redirect based on selected sport
        switch ($sport) {
            case 'Cricket':
                header('Location: cricket.html');
                break;
            case 'Football':
                header('Location: football.html');
                break;
            case 'Kabaddi':
                header('Location: kabaddi.html');
                break;
            case 'Volleyball':
                header('Location: volleyball.html');
                break;
        }
        exit();
    } else {
        echo "<script>alert('Invalid credentials. Please check your details.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
