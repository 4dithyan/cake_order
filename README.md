# Sugar Studio - Online Bakery

An e-commerce website for an online bakery business built with PHP, MySQL, and HTML/CSS.

## Features

- Product catalog with categories
- Shopping cart functionality
- User registration and authentication
- Order placement and tracking
- Admin panel for managing:
  - Products
  - Categories
  - Orders
  - Users

## Prerequisites

- XAMPP (or similar local server environment)
- PHP 7.0 or higher
- MySQL database

## Installation

1. Clone or copy the project files to your web server directory (e.g., `htdocs/sugar_studio`)
2. Start Apache and MySQL services in XAMPP
3. Create a database named `sugar_studio` in phpMyAdmin
4. Run the [init_db.php](file:///d:/Xampp/htdocs/PROJECTS/sugar_studio/init_db.php) script to set up the database tables
5. Access the site through your browser at `http://localhost/PROJECTS/sugar_studio/`

## Admin Access

- Email: admin@sugarstudio.com
- Password: admin123

## Customer Access

- Regsiter and login.
- 
## File Structure

- Public pages: Root PHP files (home.php, products.php, etc.)
- Admin pages: admin_*.php files
- Styles: style.css (public), admin-style.css (admin)
- Images: /image directory
- Configuration: config.php

## Security Notes

- All passwords are hashed using PHP's `password_hash()` function
- Sessions are used for authentication
- Prepared statements are used to prevent SQL injection

## Customization

- Update contact information in [footer.php](file:///d:/Xampp/htdocs/PROJECTS/sugar_studio/footer.php)
- Modify styles in style.css and admin-style.css
- Add new products through the admin panel
