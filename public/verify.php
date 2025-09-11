<?php
require_once "../vendor/autoload.php";

use App\classes\Database;
use App\classes\User;

$message = "";
$messageType = "";

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    try {
        $database = new Database();
        $user = new User($database);

        $userData = $user->getUserByToken($token);

        if ($userData) {
            if ($user->verifyEmail($token)) {
                $message = "Email verified successfully! You can now log in.";
                $messageType = "success";
            } else {
                $message = "Verification failed. Please try again.";
                $messageType = "danger";
            }
        } else {
            $message = "Invalid or expired verification token.";
            $messageType = "warning";
        }
    } catch (Exception $e) {
        $message = "An error occurred during verification.";
        $messageType = "danger";
        error_log($e->getMessage());
    }
} else {
    $message = "No verification token provided.";
    $messageType = "warning";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-header">
            <h4 class="mb-0">Email Verification</h4>
          </div>
          <div class="card-body text-center">
            <div class="alert alert-<?= $messageType ?>" role="alert">
              <?= htmlspecialchars($message) ?>
            </div>

            <a href="index.php" class="btn btn-primary">Go to Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
