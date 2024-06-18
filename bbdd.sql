CREATE DATABASE api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE api;

DROP TABLE IF EXISTS providers;
DROP TABLE IF EXISTS products;

CREATE TABLE IF NOT EXISTS providers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surnames VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    provider_id VARCHAR(255),
    secret_key VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    provider INT(11) NOT NULL,
    price INT(11) NOT NULL
    FOREIGN KEY (provider) REFERENCES providers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_provider ON products(provider);