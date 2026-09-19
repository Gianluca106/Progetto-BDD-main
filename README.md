# Progetto BdD – Wine/E-commerce Ordering System

A full-stack e-commerce web application built with **PHP and MySQL** for the Databases and Web course (Basi di Dati e Web) at the University of Parma. It supports user registration/login, a product catalog, a session-based shopping cart, checkout with stock updates, and a per-user order history.

Developed with Federico Cardelli ([@fedecardelli](https://github.com/fedecardelli)) as a university project.

## Overview

The application lets a visitor register an account and log in, browse a product catalog backed by a MySQL database, add items to a cart, and complete a checkout that decreases stock levels and records the order. Logged-in users can view their past orders, including the shipping address and product list, from the database.

## Key Features

- **User accounts:** registration and login, with session-based authentication
- **Product catalog:** products (title, price, image, stock) loaded from the database and displayed as a grid
- **Shopping cart:** add products with a chosen quantity, view running total, empty the cart, stored in the PHP session
- **Checkout:** validates and updates product stock, records the order (items, total, date) linked to the logged-in user
- **Order history:** a dedicated page listing a user's past orders with shipping address, product list, and total amount

## Tech Stack

- **Backend:** PHP
- **Database:** MySQL (via `mysqli`)
- **Frontend:** HTML, CSS

## Project Structure

```
Progetto-BDD/
├── LoginPage.html          # Login and registration forms
├── loginhandler.php        # Authentication and registration logic
├── dbcontroller.php        # Database connection and query helper class
├── Cliente_no_ui.php       # Product catalog and shopping cart view
├── purchase.php            # Adds a product to the cart (session)
├── checkout.php            # Processes the cart: updates stock, creates the order
├── empty_cart.php          # Clears the shopping cart
└── thankyou.php            # Order confirmation / order history page
```

## Running Locally

**1. Requirements**
- A local PHP + MySQL environment (e.g. XAMPP, MAMP, or WAMP)

**2. Database**
- Create a MySQL database named `progetto`
- Create the required tables: `userlist` (username, password, nome, cognome, indirizzo), `products` (id, title, price, image, in_stock), and `orders` (order_id, user_id, order_date, product_list, total_amount)
- The app connects using local development defaults (`localhost`, user `root`, empty password) defined in `dbcontroller.php` — update these if your local setup differs

**3. Start the app**
- Place the project folder in your PHP server's document root (e.g. `htdocs` for XAMPP)
- Open `LoginPage.html` in the browser to register a user and start shopping

---

> University project for the Databases and Web course (Unipr), co-developed with [Federico Cardelli](https://github.com/fedecardelli).
