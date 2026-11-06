# ClubHub – Club Registration System

A club registration system with three parts:

| Part | URL (local) | Who uses it |
|---|---|---|
| Public registration form | `/club-unimy/club-form.php` | New students joining clubs |
| Student portal | `/club-user/loginUser.php` | Registered students |
| Admin panel | `/club-unimy/admin.php` | Club administrators |

## Features

**Students**
- Register for one or more clubs, with inline validation and duplicate checks
- Registration closes automatically when the limit is reached
- Portal: profile, "next up in your clubs" countdown, activities filtered by club
- Update their phone number and join or leave clubs themselves
- Add any activity to their calendar (`.ics` for Google, Outlook or Apple Calendar)

**Admins**
- Dashboard: member counts, members-per-club chart, capacity, recent registrations, upcoming activities
- Students: search, filter by club, add, edit, delete one or many, export to CSV
- Clubs: member list per club, remove members, print-ready list, CSV export
- Activities: create, edit and delete events with cover-image upload, filter by upcoming or past
- Registration settings: limit, "full" message, shareable form link
- Welcome email template with placeholders (`{name}`, `{clubs}` …) and live preview
- Manage admin accounts; change your own details and password

## Setup

Requirements: PHP 8.1+ (tested on 8.5) with `mysqli`, and MySQL 8 / MariaDB.

1. Create a database named `clubunimy` and import `clubunimy.sql`.
   Upgrading an older copy of the database? Run `upgrade.sql` once instead.
2. Database settings are in `club-unimy/config-mysqli.php` and `club-user/config-mysqli.php`
   (defaults: `localhost`, user `root`, no password). You can also set
   `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` environment variables.
3. Serve the repository root, for example:
   ```
   php -S localhost:8000
   ```
   or copy both folders into XAMPP's `htdocs`.

**MySQL with Docker**
```
docker run -d --name clubhub-mysql -p 3306:3306 -e MYSQL_ALLOW_EMPTY_PASSWORD=yes -e MYSQL_DATABASE=clubunimy mysql:8.4
docker exec -i clubhub-mysql mysql -uroot clubunimy < clubunimy.sql
```

### Welcome emails (optional)

Copy `club-unimy/mail-config.example.php` to `club-unimy/mail-config.php`, fill in your SMTP
details and set `'enabled' => true`. For Gmail, use an
[App password](https://myaccount.google.com/apppasswords). `mail-config.php` is git-ignored.
Registration works without it; emails are simply skipped.

## Sample logins

| | Login | Password / ID |
|---|---|---|
| Admin | `b09190001` | `akmal12345` |
| Student | `munir@yahoo.com` | `B08180002` |

Change the admin password after first sign-in (top bar → your name).

---
Originally built as a Final Year Project by Akmal Hafiz bin Hashim.
