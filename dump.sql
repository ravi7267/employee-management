CREATE TABLE departments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE employees (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  phone VARCHAR(20),
  joining_date DATE,
  profile_photo VARCHAR(255),
  department_id BIGINT UNSIGNED,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255),
  role VARCHAR(50) DEFAULT 'user',
  remember_token VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
