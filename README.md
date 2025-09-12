# PHP User Registration with Email Verification


## Features

*   User registration with name, email, and password.
*   Email verification using a unique token.
*   Password hashing using modern PHP functions.
*   Uses PHPMailer for sending emails.
*   Simple and clean user interface using Bootstrap.
*   PSR-4 autoloading for clean code organization.

## Requirements

*   PHP 8.0 or higher
*   MySQL database
*   Composer

## Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/your-repo-name.git
    cd your-repo-name
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Create the database:**

    Create a new MySQL database and run the following SQL query to create the `users` table:

    ```sql
    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `VerificationToken` varchar(255) DEFAULT NULL,
      `IsVerified` tinyint(1) DEFAULT 0,
      `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) 
    ```

## Configuration

1.  **Database:**

    Open `src/config/database.php` and update the database credentials with your own:

    ```php
    <?php

    return [
        "host" => "your-database-host",
        "dbname" => "your-database-name",
        "username" => "your-database-username",
        "password" => "your-database-password",
        "charset" => "utf8mb4",
    ];
    ```

2.  **Email:**

    Open `src/classes/Mailer.php` and configure the SMTP settings for your email provider. By default, it's configured to use Gmail.

    ```php
    // src/classes/Mailer.php

    // ...
    $this->mailer->Host = "your-smtp-host";
    $this->mailer->Username = "your-email@example.com";
    $this->mailer->Password = "your-email-password";
    // ...
    ```

3.  **Verification URL:**

    Update the verification URL in `src/classes/Mailer.php` to match your development environment:

    ```php
    // src/classes/Mailer.php

    // ...
    $verificationUrl = "http://localhost/your-project-directory/public/verify.php?token=" . $token;
    // ...
    ```

---
For the sake of demonstration:
#### Database:

+----+-------------+------------------------+--------------------------------------------------------------+------------+------------------------------------------------------------------+---------------------+
| id | name        | email                  | password                                                     | IsVerified | VerificationToken                                                | CreatedAt           |
+----+-------------+------------------------+--------------------------------------------------------------+------------+------------------------------------------------------------------+---------------------+
|  1 | Adam Etyang | adametyang69@gmail.com | $2y$12$ouUa90/P8O3TuWjiHJGk9ebJxixIG9vGB0kyBrD7p/065vOEVQFJu |          0 | bdb0082ad9cef5e7452527c3f7b73085178a484471247db03aa7d2fd06bad769 | 2025-09-12 19:14:44 |
|  2 | Dalton Mule | daltonmulem@gmail.com  | $2y$12$ISKU.OGzVkM7ynCrQC9MT.ifST4C6JpMcc1GKcFj6un6SpIrKQCzC |          0 | fa404f487fa91a83f5a1e69a57ee0df5cf9fdf14e333258ff89faeb6f4a33f8a | 2025-09-12 19:28:36 |
+----+-------------+------------------------+--------------------------------------------------------------+------------+------------------------------------------------------------------+---------------------+
![Screenshot 2025-09-12 at 19 47 18](https://github.com/user-attachments/assets/446257ca-ab35-46d2-b186-27d78b42ec12)




