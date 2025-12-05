# URL Shortener – Laravel Project

A simple and powerful URL Shortening application built using **Laravel 12**.

---

## 🚀 Installation Guide (Run Project on Local Machine)

Follow the steps below to set up this project locally.

---

## 1️⃣ Clone the Repository  
```bash
git clone <your-github-repo-url>

cd Url_Shortner

composer install

composer update

composer dump-autoload

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan db:seed --class=SuperAdminCredentialSeeder

| Field    | Value                                                 |
| -------- | ----------------------------------------------------- |
| Email    | **[s_admin@example.com]
| Password | **123456**                                            |

composer require "maatwebsite/excel:^3.1"

Select Command Prompt for this package.

https://docs.laravel-excel.com/3.1/getting-started/installation.html

Email Sending (Mailtrap Setup)

Use Mailtrap to test emails locally.

🔗 Mailtrap Website

https://mailtrap.io/home

📌 Steps to Configure Mailtrap

Visit Mailtrap.io and create a free account.

Login → Go to Inbox (default inbox created automatically).

Click "Integrations".

Select Laravel from the list.

You will get SMTP credentials like:

Host

Port

Username

Password

Copy those details into your .env file.

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=7f1cc55263f355
MAIL_PASSWORD=2440284bbb6695
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

Replace username & password with real values from Mailtrap dashboard.

php artisan serve


Test Project 

