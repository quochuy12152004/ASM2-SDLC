<?php
    $_servername = "localhost";
    $_username = "root";
    $_password = "";
    $_dbname = "btec-list student";

    // Create connection
    $connection = new mysqli($_servername, $_username, $_password, $_dbname);

    $id = "";
    $masv = "";
    $fullname = "";
    $email = "";
    $password = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $masv = $_POST['masv'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = $connection->query($check_sql);

        if ($check_result->num_rows > 0) {
            $errorMessage = "Error: Email already exists in the system.";
        } else {
            if (empty($id) || empty($masv) || empty($fullname) || empty($email) || empty($password)) {
                $errorMessage = "Complete student information is required";
            } else {
                // Add new student to the database
                $stmt = $connection->prepare("INSERT INTO users (id, masv, fullname, email, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $id, $masv, $fullname, $email, $hashed_password);

                if ($stmt->execute()) {
                    $id = "";
                    $masv ="";
                    $fullname = "";
                    $email = "";
                    $password = "";
                    $successMessage = "Student added correctly";

                    header("location: /fpi/home_page.php");
                    exit;
                } else {
                    $errorMessage = "Error executing query: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
    ?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Add Student</h2>
    <form method="POST" action="">
        <div class="mb-4">
            <label for="id" class="block mb-2 font-bold">ID:</label>
            <input type="text" name="id" class="form-control" value="<?php echo htmlspecialchars($id); ?>">
        </div>

        <div class="mb-4">
            <label for="masv" class="block mb-2 font-bold">MASV:</label>
            <input type="text" name="masv" class="form-control" value="<?php echo htmlspecialchars($masv); ?>">
        </div>

        <div class="mb-4">
            <label for="fullname" class="block mb-2 font-bold">Full Name:</label>
            <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($fullname); ?>">
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 font-bold">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-2 font-bold">Password:</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-4">
            <input type="submit" value="Add Student" class="btn btn-primary">
            <a class="btn btn-outline-primary" href="/fpi/home_page.php" role="button">Cancel</a>
        </div>
    </form>

    <?php
    if (!empty($errorMessage)) {
        echo '<p class="text-danger mt-4">' . $errorMessage . '</p>';
    }

    if (!empty($successMessage)) {
        echo '<p class="text-success mt-4">' . $successMessage . '</p>';
    }
    ?>
</div>

<style>
    /* // background img// */
  body {
    background-image: url('https://gcs.tripi.vn/public-tripi/tripi-feed/img/474087ejw/hinh-anh-background-dep-don-gian_102938083.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
</style>
</body>
</html>