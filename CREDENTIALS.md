# Login credentials (local / demo)

## Admin panel
URL: http://localhost:8000/club-unimy/admin.php

| Field | Value |
|---|---|
| Student ID (or username `zayque`) | `b09190001` |
| Password | `akmal12345` |

## Student portal
URL: http://localhost:8000/club-user/loginUser.php

| Field | Value |
|---|---|
| Email | `munir@yahoo.com` |
| Student ID | `B08180002` |

Students sign in with the email and student ID they registered with,
so any student added through the registration form can log in the same way.

## Database (Docker container `clubhub-mysql`, e.g. for DBeaver)

| Field | Value |
|---|---|
| Host | `localhost` |
| Port | `3306` |
| Database | `clubunimy` |
| User | `root` |
| Password | *(empty)* |

DBeaver: if it refuses to connect, set `allowPublicKeyRetrieval=true` in the driver properties.
