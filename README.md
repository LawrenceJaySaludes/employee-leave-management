# Employee Leave Management System

A full-stack Employee Leave Management System built with Laravel REST API and React.

## Features

### Authentication

- Login
- Logout
- Laravel Sanctum Authentication
- Role-based Authorization
- Admin Middleware

### Employee Management

- Create Employee
- Update Employee
- Delete Employee
- Search Employees
- Pagination
- Sorting

### Leave Types

- CRUD Leave Types
- Search
- Pagination
- Sorting
- Status Filter

### Leave Requests

Employees

- Submit Leave Request
- View Own Requests
- Cancel Pending Request

Admin

- View All Requests
- Approve Request
- Reject Request
- Search Employee
- Filter Status
- Filter Department
- Filter Leave Type
- Filter Date
- Pagination
- Sorting

### Dashboard

Admin Dashboard

- Total Employees
- Total Leave Types
- Total Requests
- Pending Requests
- Approved Requests
- Rejected Requests
- Monthly Statistics
- Recent Requests
- Most Used Leave Types

Employee Dashboard

- Total Requests
- Pending
- Approved
- Rejected
- Monthly Statistics
- Recent Requests

---

## Tech Stack

Backend

- Laravel 13
- Sanctum
- MySQL
- PHP 8.3

Frontend

- React
- Axios
- TailwindCSS

Development Tools

- XAMPP
- VS Code
- Git
- GitHub
- Postman

---

## Installation

Clone repository

```bash
git clone https://github.com/LawrenceJaySaludes/employee-leave-management.git
```

Install dependencies

```bash
composer install
```

Copy environment

```bash
cp .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Run migration

```bash
php artisan migrate
```

Run seeders

```bash
php artisan db:seed
```

Run server

```bash
php artisan serve
```

API

```
http://127.0.0.1:8000/api
```

---

## Authentication

Uses Laravel Sanctum.

Login endpoint

```
POST /api/login
```

Returns a Bearer Token.

All protected routes require

```
Authorization: Bearer YOUR_TOKEN
```

---

## Author

Lawrence Jay Saludes

BS Information Technology