CREATE TABLE users (
  id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email            VARCHAR(160) UNIQUE NOT NULL,
  password_hash    CHAR(60)       NOT NULL,
  confirmation_code CHAR(64)      NOT NULL,
  confirmed_at     DATETIME       NULL,
  created_at       DATETIME DEFAULT CURRENT_TIMESTAMP
);
