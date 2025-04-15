<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Registration</title>
    <link rel="stylesheet" href="rege.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-futbol"></i> Sports Registration Form</h1>
        <form action="reg.php" method="post">
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
                    <label><i class="fas fa-map-marker-alt"></i> Address</label>
                    <input type="text" required placeholder="Enter Address" name="address">
                </p>
                <p>
                    <label><i class="fas fa-phone"></i> Mobile Number</label>
                    <input type="tel" required placeholder="Enter Mobile Number" name="mobile">
                </p>
                <p>
                    <label><i class="fas fa-gamepad"></i> Sport</label>
                    <select name="sports">
                        <option value="">Select a Sport</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Football">Football</option>
                        <option value="Kabaddi">Kabaddi</option>
                        <option value="Volleyball">Volleyball</option>
                    </select>
                </p>
                <div class="btn-container">
                    <button name="reg"><i class="fas fa-paper-plane"></i> Register</button>
                </div><br><br>
                <div class="login">
                    <a href="login.php"><i class="fas fa-sign-in-alt"></i> Already registered? Login here</a>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="message">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $team_name = $_POST['team_name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $sports = $_POST['sports'];

            $errors = [];
            if (empty($team_name)) $errors[] = "Team Name is required.";
            if (empty($email)) $errors[] = "Email is required.";
            if (empty($address)) $errors[] = "Address is required.";
            if (empty($mobile)) $errors[] = "Mobile Number is required.";
            if (empty($sports)) $errors[] = "Sport selection is required.";
            if (!is_numeric($mobile)) $errors[] = "Mobile Number must be numeric.";

            // Email uniqueness check
            $conn = new mysqli('localhost', 'root', '', 'sportsdb');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $email_check = $conn->prepare("SELECT * FROM registerdata2 WHERE email = ?");
            $email_check->bind_param("s", $email);
            $email_check->execute();
            $result = $email_check->get_result();
            if ($result->num_rows > 0) {
                $errors[] = "Email is already registered. Please use a different email.";
            }

            if (count($errors) > 0) {
                echo "<div class='error'>" . implode("<br>", $errors) . "</div>";
            } else {
                $stmt = $conn->prepare("INSERT INTO registerdata2 (team_name, email, address, mobile, sports) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $team_name, $email, $address, $mobile, $sports);
                if ($stmt->execute()) {
                    echo "<script>alert('Registration successful! Redirecting...');</script>";
                    // Redirect based on sport selection
                    echo "<script>setTimeout(function(){ window.location.href = '" . strtolower($sports) . ".html'; }, 2000);</script>";
                } else {
                    echo "<div class='error'>Error: " . $stmt->error . "</div>";
                }

                $stmt->close();
            }
            $email_check->close();
            $conn->close();
        }
        ?>
    </div>
</body>

</html>
