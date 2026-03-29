CREATE DATABASE IF NOT EXISTS viatorbookings_vKO1OwGg8kFJYOt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE viatorbookings_vKO1OwGg8kFJYOt;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_number VARCHAR(50) NOT NULL UNIQUE,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    otg_number VARCHAR(100) NOT NULL,
    date_of_tour DATE NOT NULL,
    time_of_tour TIME NOT NULL,
    number_of_members INT UNSIGNED NOT NULL,
    number_of_2_seater_utvs INT UNSIGNED NOT NULL DEFAULT 0,
    number_of_3_seater_utvs INT UNSIGNED NOT NULL DEFAULT 0,
    number_of_4_seater_utvs INT UNSIGNED NOT NULL DEFAULT 0,
    number_of_5_seater_utvs INT UNSIGNED NOT NULL DEFAULT 0,
    pickup_time TIME NOT NULL DEFAULT '00:00:00',
    pickup_location VARCHAR(255) NOT NULL,
    dropoff_location VARCHAR(255) NOT NULL,
    tour_duration VARCHAR(100) NOT NULL DEFAULT '4 Hours',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

