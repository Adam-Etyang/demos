<?php

namespace App\classes;

use PDO;

class User
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function create($email, $password, $name)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $verificationToken = bin2hex(random_bytes(32));

        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, verification_token, created_at)
             VALUES (?, ?, ?, ?, NOW())",
        );

        if (
            $stmt->execute([$name, $email, $hashedPassword, $verificationToken])
        ) {
            return $verificationToken;
        }

        return false;
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function verifyEmail($token)
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET is_verified = 1, verification_token = NULL
             WHERE verification_token = ?",
        );

        return $stmt->execute([$token]);
    }

    public function getUserByToken($token)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE verification_token = ?",
        );
        $stmt->execute([$token]);
        return $stmt->fetch();
    }
}
