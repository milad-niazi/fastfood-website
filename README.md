# 🍔 Laravel FastFood Website

A complete fast food ordering website built with **Laravel** — includes both a **customer-facing store** and an **admin panel** for managing the system.

This project was created as a learning exercise while following a Laravel tutorial.  
The website allows users to view menus, register orders, and manage their profiles.

---

## 🧩 Project Structure

This project consists of **two separate Laravel applications** that work together:

### 🍔 1. Website (Main Store)
The main public-facing fast food website where customers can browse products, add to cart, and place orders.  
This part includes both frontend (UI) and backend (API & logic).

#### Features
- Dynamic slider and feature sections  
- About Us & Contact Us pages  
- Dynamic footer content  
- Product categories and product list pages  
- Product single page with details, discounts, and images  
- Menu page with filtering options  
- Wishlist system for users  
- Interactive map integration  
- Shopping cart with coupon/discount codes  
- Persian (Jalali) calendar support  
- OTP authentication via SMS  
- User profile (info, addresses, orders, transactions, favorites)

---

### 🧑‍💼 2. Admin Panel
A separate Laravel application used by administrators to manage the store content and monitor sales.  
This part also includes both frontend (admin UI) and backend logic.

#### Features
- Manage product categories and products (images, discounts, prices, dates)  
- Dashboard with charts and statistics  
- Coupon management system  
- User and order management  
- Role-based access control (authorization)  
- Admin authentication and session management  
- Persian calendar integration  

---

## 🧩 Technologies Used
- Laravel
- PHP
- MySQL
- HTML / CSS / JS
- Bootstrap
- jQuery
- Chart.js
- SMS OTP service
- Jalali Calendar

---
## 🧠 مواردی که در این پروژه کار شده
- توضیح بخش‌های قالب اصلی سایت فروشگاه  
- توضیح بخش‌های پنل ادمین (Admin Panel)  
- داینامیک کردن بخش‌های اسلایدر، ویژگی‌ها و فوتر  
- ایجاد صفحات درباره ما و تماس با ما  
- مدیریت دسته‌بندی‌ها و محصولات  
- ایجاد منوی محصولات و فیلترها  
- احراز هویت OTP (ارسال کد از طریق SMS)  
- مدیریت پروفایل کاربر (آدرس، سفارشات، تراکنش‌ها، علاقه‌مندی‌ها)  
- سبد خرید و کد تخفیف  
- استفاده از درگاه پرداخت  
- افزودن نمودار در پنل ادمین  
- استفاده از تقویم شمسی  

---
## 🚀 Setup & Run Locally
```bash
git clone https://github.com/milad-niazi/fastfood-website.git
cd fastfood-website
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
