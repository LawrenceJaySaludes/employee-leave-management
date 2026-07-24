# Employee Leave Management API Documentation

---

## Authentication

POST /api/login

POST /api/logout

GET /api/me

---

## Dashboard

GET /api/dashboard

GET /api/employee/dashboard

---

## Employees

GET /api/employees

GET /api/employees/{id}

POST /api/employees

PUT /api/employees/{id}

DELETE /api/employees/{id}

Search

GET /api/employees?search=john

Pagination

GET /api/employees?page=2

Sorting

GET /api/employees?sort=oldest

---

## Leave Types

GET /api/leave-types

POST /api/leave-types

PUT /api/leave-types/{id}

DELETE /api/leave-types/{id}

Search

GET /api/leave-types?search=Annual

Status Filter

GET /api/leave-types?status=1

---

## Leave Requests

Employee

GET /api/leave-requests

POST /api/leave-requests

DELETE /api/leave-requests/{id}

Admin

GET /api/admin/leave-requests

PUT /api/leave-requests/{id}/approve

PUT /api/leave-requests/{id}/reject

Search

GET /api/admin/leave-requests?search=john

Status

GET /api/admin/leave-requests?status=pending

Department

GET /api/admin/leave-requests?department=IT

Leave Type

GET /api/admin/leave-requests?leave_type=1

Date

GET /api/admin/leave-requests?from=2026-08-01&to=2026-08-31