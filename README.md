# 🍽️ Food Catering System (PHP & MySQL)

A web-based food catering application built using **PHP**, **MySQL**, and **Bootstrap**.  
It allows users to browse and order food items, and provides admin features to manage menu and orders.

---

## 🔧 Features

### 👤 User Panel
- User Registration & Login
- View Menu with image-based animated cards
- Add items to Cart
- Place Orders
- View Order History
- Contact Us (feedback form)
- About Us section

### 🔐 Admin Panel
- Admin Login (Username: `admin`, Password: `admin123`)
- Manage Menu (Add/Delete items with image & price)
- View and Manage Orders (with status)
- Logout functionality

---

## 📁 Folder Structure

```
/food-catering
│
├── db.php                  # Database connection file
├── index.php               # Landing page (Choose User/Admin)
│
├── /admin
│   ├── login.php
│   ├── dashboard.php
│   ├── manage_menu.php
│   ├── manage_orders.php
│
├── /user
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── menu.php
│   ├── cart.php
│   ├── add_to_cart.php
│   ├── place_order.php
│   ├── orders.php
│   ├── contact.php
│   ├── about.php
│   ├── logout.php
│
├── /uploads                # Stores menu item images
│
└── README.md               # This file
```

---

## 🛠️ How to Set Up & Run Locally

### 1. 📦 Prerequisites

- PHP >= 7.4
- MySQL
- Apache (XAMPP or LAMP recommended)
- Web browser (Chrome, Firefox, etc.)

---

### 2. 📥 Download Project

If using Git:

```bash
git clone https://github.com/your-username/food-catering.git
```

Or manually download and extract the ZIP into:

```bash
/opt/lampp/htdocs/food-catering   # For Ubuntu
C:\xampp\htdocs\food-catering     # For Windows
```

---

### 3. 🧱 Create MySQL Database

- Open **phpMyAdmin** or use terminal.
- Create a database:

```sql
CREATE DATABASE food_catering;
USE food_catering;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Menu Items Table
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255)
);

-- Cart Table
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (item_id) REFERENCES menu_items(id)
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    order_items TEXT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Contact Table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    email VARCHAR(150),
    message TEXT,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

### 4. ⚙️ Configure Database Connection

In `db.php` file:

```php
<?php
$host = 'localhost';
$db   = 'food_catering';
$user = 'root';      // or your MySQL username
$pass = '';          // or your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
```

---

### 5. 📂 Ensure Folder Permissions

In Ubuntu, run:

```bash
sudo chmod -R 777 /opt/lampp/htdocs/food-catering/uploads
```

> So that image uploads (menu items) work properly.

---

### 6. 🚀 Run the Project

- Start Apache & MySQL from XAMPP (or terminal)
- Go to browser and visit:

```
http://localhost/food-catering/
```

---

## 🔑 Default Admin Credentials

```
Username: admin
Password: admin123
```

---

## 🧑‍💻 Author

**Hasti Garala**  
Project by: *Food Catering Web App using PHP & MySQL*

---

## 📄 License

This project is for educational use. MIT License can be applied optionally.
