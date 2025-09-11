<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\classes\Database;
use App\classes\User;
use App\classes\Mailer;

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if (empty($name) || empty($email) || empty($password)) {
        $message = "All fields are required.";
        $messageType = "danger";
    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $messageType = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
        $messageType = "danger";
    } else {
        try {
            $database = new Database();
            $user = new User($database);

            if ($user->emailExists($email)) {
                $message = "Email already registered.";
                $messageType = "warning";
            } else {
                $token = $user->create($email, $password, $name);

                if ($token) {
                    $mailer = new Mailer();
                    if ($mailer->sendVerificationEmail($email, $name, $token)) {
                        $message =
                            "Registration successful! Please check your email to verify your account.";
                        $messageType = "success";
                    } else {
                        $message =
                            "Registration successful, but failed to send verification email.";
                        $messageType = "warning";
                    }
                } else {
                    $message = "Registration failed. Please try again.";
                    $messageType = "danger";
                }
            }
        } catch (Exception $e) {
            $message = "An error occurred. Please try again.";
            $messageType = "danger";
            error_log($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-header">
            <h4 class="mb-0">Create Account</h4>
          </div>
          <div class="card-body">
            <?php if ($message): ?>
              <div class="alert alert-<?= $messageType ?>" role="alert">
                <?= htmlspecialchars($message) ?>
              </div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name"
                  value="<?= htmlspecialchars(
                      $_POST["name"] ?? "",
                  ) ?>" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                  value="<?= htmlspecialchars(
                      $_POST["email"] ?? "",
                  ) ?>" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>

            <div class="text-center mt-3">
              <a href="index.php">Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
