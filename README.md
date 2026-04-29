# AutoParts Online System

Starter PHP/MySQL project for an auto parts online ordering system.

## Features
- Browse products from a simulated legacy parts source
- Display available quantity from new inventory table
- Add items to cart and checkout
- Simulated credit card authorization
- Store authorized orders and line items
- Warehouse receiving updates inventory
- Warehouse shipping marks orders as shipped
- Admin dashboard shows shipping rules and orders

## Setup
1. Create the MySQL database using `sql/create_schema.sql`
2. Seed rules with `sql/seed_shipping_rules.sql`
3. Seed users with `sql/seed_users.sql`
4. Update credentials in `config/db_connect.php`
5. Serve with PHP and open `customer/index.php`

## Notes
- Legacy product data is simulated in `includes/functions.php`
- Replace `getLegacyParts()` with the actual legacy DB or remote interface later
- Payment and email are mocked for initial development
