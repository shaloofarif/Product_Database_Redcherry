`README.md` file for **Product Database Management System** project:

---

# Product Database Management System (Product Database)

## Overview
The **Product Database Management System** is a Laravel-based web application designed for managing products and their associated data efficiently. This project includes functionalities to add, view and delete products with associated images and brands. 

It demonstrates adherence to **MVC architecture** and employs **AJAX** for seamless interaction between the frontend and backend.

---

## Features
1. **Product Management**
   - Add products with details such as code, name, brand, price, and images.
   - View a list of all products with their details.
   - Delete products (including associated images from storage).

2. **Image Management**
   - Upload and associate multiple images with a product.
   - Display the first image of a product in the list view.

3. **Brand Management**
   - Products can be linked to brands.
   - Dynamically populate the brand dropdown when adding products.

4. **AJAX Integration**
   - Asynchronous requests for adding and deleting products.

---

## Technologies Used
- **Backend:** PHP, Laravel Framework
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Database:** MySQL
- **Additional Libraries/Tools:**
  - jQuery (for AJAX)
  - Laravel File Storage (for image handling)

---

## Requirements
- PHP >= 8.0
- Composer
- MySQL Database
- Laravel 9.x
- A web server (e.g., Apache or Nginx)

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone [repository_link]
cd ProductDatabase
```

### 2. Install Dependencies
Run the following command to install Laravel and other dependencies:
```bash
composer install
```

### 3. Configure the Environment
- Create a `.env` file in the project root:
  ```bash
  cp .env.example .env
  ```
- Update the following fields in `.env`:
  ```
  DB_DATABASE=product_db
  DB_USERNAME=root
  DB_PASSWORD=
  ```

### 4. Set Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Seed the Database (Optional)
Seed sample brands data into the database:
```bash
php artisan db:seed
```

### 7. Storage Configuration
Link the `storage` directory for file uploads:
```bash
php artisan storage:link
```

### 8. Start the Development Server
```bash
php artisan serve
```

### 9. Access the Application
Visit `http://localhost:8000/products` in your browser.

---

## Folder Structure
```
PRODUCTDATABASE
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── ProductController.php
│   │   │   └── BrandController.php
│   │   └── Middleware
│   ├── Models
│   │   ├── Product.php
│   │   ├── ProductImage.php
│   │   └── Brand.php
├── bootstrap
│   └── app.php
├── database
│   ├── migrations
│   │   ├── 2024_12_XX_create_products_table.php
│   │   ├── 2024_12_XX_create_product_images_table.php
│   │   └── 2024_12_XX_create_brands_table.php
│   └── seeders
├── public
│   ├── css
│   ├── js
│   ├── images
│   ├── storage
│   │   └── product_images
│   └── index.php
├── resources
│   ├── views
│   │   ├── layouts
│   │   │   └── app.blade.php
│   │   ├── products
│   │   │   └── index.blade.php
│   │   └── brands
│   │       └── index.blade.php
├── routes
│   └── web.php
├── storage
│   ├── app
│   │   └── public
│   │       └── product_images
├── tests
├── vendor
├── .env
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
└── README.md

```

---

## API Endpoints (Optional)
- **GET** `/products` - Fetch all products.
- **POST** `/products` - Add a new product.
- **DELETE** `/products/{id}` - Delete a product.

---

## Notes
- Ensure the `storage/app/public/product_images` directory is writable for image uploads.
- Test the application using provided setup instructions and verify database connectivity.

---

## License
This project is for demonstration purposes and is not intended for commercial use.

---