# ThreatWatch Nigeria 🇳🇬
### Real-Time Security Incident Reporting & Monitoring Platform

---

## Overview

ThreatWatch Nigeria is a civic-tech platform for tracking and reporting security incidents across all 36 states and the FCT. It provides public incident feeds, an interactive heatmap, user reporting, comment moderation, emergency helplines, and a full admin panel.

---

## Tech Stack

| Layer       | Technology                          |
|-------------|-------------------------------------|
| Backend     | Laravel 11 · PHP 8.3+               |
| Database    | MySQL 8.0+                          |
| Frontend    | Blade Templates · TailwindCSS (CDN) |
| Interactivity | Alpine.js v3                      |
| Maps        | Leaflet.js · OpenStreetMap          |
| Heatmap     | leaflet-heat plugin                 |
| Charts      | Chart.js v4                         |

---

## Features

### Public
- 🏠 Homepage with live stats, recent incidents, heatmap preview
- 📋 Incident listing with filters (state, type, severity, date, search)
- 🔍 Incident detail pages with comments, map pin, related incidents
- 🗺️ Interactive heatmap with filter panel (heatmap + marker modes)
- 📞 Emergency helplines directory (national + state-specific)
- 📝 Threat report submission form (with evidence upload, anonymous option)

### Authenticated Users
- Submit threat reports
- Track report status
- Comment on incidents (with replies)
- Delete own comments

### Admin / Moderator
- 📊 Dashboard with charts (monthly trend, severity breakdown, attack types)
- ✅ Approve / reject / feature incidents
- 🔄 Convert user reports → verified incidents
- 👥 User management (role, status, profile view)
- 💬 Comment moderation
- 📞 Helpline CRUD
- 🗑 Soft-delete with full audit trail

---

## User Roles

| Role         | Capabilities                                              |
|--------------|-----------------------------------------------------------|
| `super_admin`| Full access including user management and destructive ops |
| `moderator`  | Approve/reject incidents, manage comments, helplines      |
| `user`       | Browse, submit reports, comment                           |

---

## Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/your-org/threatwatch-ng.git
cd threatwatch-ng

# 2. Install PHP dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=threatwatch_ng
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# 5. Create the MySQL database
mysql -u root -p -e "CREATE DATABASE threatwatch_ng CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Run migrations + seed
php artisan migrate --seed

# 7. Link storage
php artisan storage:link

# 8. Start development server
php artisan serve
```

Visit: **http://localhost:8000**

---

## Default Credentials (after seeding)

| Role         | Email                    | Password      |
|--------------|--------------------------|---------------|
| Super Admin  | admin@threatwatch.ng     | Admin@12345   |
| Moderator    | mod@threatwatch.ng       | Mod@12345     |
| Demo User    | user@threatwatch.ng      | User@12345    |

> ⚠️ Change all passwords immediately in production!

---

## Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/               # Admin controllers
│   │   │   ├── DashboardController.php
│   │   │   ├── IncidentController.php
│   │   │   ├── ReportController.php
│   │   │   ├── UserController.php
│   │   │   ├── CommentController.php
│   │   │   └── HelplinesController.php
│   │   ├── Auth/
│   │   │   ├── RegisteredUserController.php
│   │   │   └── AuthenticatedSessionController.php
│   │   ├── HomeController.php
│   │   ├── IncidentController.php
│   │   ├── ReportController.php
│   │   ├── CommentController.php
│   │   ├── HeatmapController.php
│   │   └── HelplinesController.php
│   └── Middleware/
│       └── EnsureUserIsAdmin.php
├── Models/
│   ├── User.php
│   ├── State.php
│   ├── Lga.php
│   ├── Incident.php
│   ├── Comment.php
│   ├── Report.php
│   └── Helpline.php
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/                  # All 7 migrations
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php           # 3 default users
    ├── StateSeeder.php          # All 37 states with GPS coords
    ├── LgaSeeder.php            # Major LGAs per state
    ├── HelplineSeeder.php       # 12 national helplines
    └── IncidentSeeder.php       # 10 sample incidents

resources/views/
├── layouts/
│   ├── app.blade.php            # Public layout
│   └── admin.blade.php          # Admin layout
├── auth/                        # Login, Register
├── home.blade.php               # Homepage
├── incidents/                   # Index, Show
├── heatmap/                     # Interactive map
├── helplines/                   # Emergency lines
├── reports/                     # Create, My Reports
├── admin/
│   ├── dashboard.blade.php
│   ├── incidents/               # Index, Show, Create, Edit, _form
│   ├── reports/                 # Index, Show
│   ├── users/                   # Index, Show
│   ├── comments/                # Index
│   └── helplines/               # Index, Create, Edit, _form
├── partials/
│   └── incident-card.blade.php  # Reusable card component
└── vendor/pagination/           # Custom TailwindCSS pagination

routes/
└── web.php                      # All routes (public + auth + admin)
```

---

## API Endpoints

| Method | URL                        | Description                    |
|--------|----------------------------|--------------------------------|
| GET    | `/api/lgas?state_id=X`     | Load LGAs for a state (AJAX)   |
| GET    | `/api/heatmap/data`        | Heatmap point data (JSON)      |
| GET    | `/api/heatmap/states`      | State-level stats (JSON)       |

---

## Database Schema

```
users            → id, firstname, surname, email, password, role, phone, avatar, is_active
states           → id, name, slug, latitude, longitude
lgas             → id, state_id, name, slug, latitude, longitude
incidents        → id, title, slug, state_id, lga_id, town, attack_type, description,
                   casualties, kidnapped_count, latitude, longitude, incident_date,
                   incident_time, status, severity, source_url, images, is_featured,
                   is_anonymous, views, created_by, approved_by, approved_at, rejection_reason
comments         → id, user_id, incident_id, parent_id, comment, status
reports          → id, user_id, state_id, lga_id, town, attack_type, title, description,
                   casualties, kidnapped_count, latitude, longitude, incident_date,
                   incident_time, evidence_files, is_anonymous, reporter_name, reporter_phone,
                   status, admin_notes, reviewed_by, reviewed_at
helplines        → id, state_id, lga_id, agency_name, phone, phone_alt, category,
                   address, description, is_national, is_active, sort_order
```

---

## Production Deployment

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Run migrations
php artisan migrate --force

# Set up cron (for cache expiry, queued jobs)
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

### Nginx Config
```nginx
server {
    listen 80;
    server_name threatwatch.ng www.threatwatch.ng;
    root /var/www/threatwatch-ng/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
```

---

## Color Palette

| Token      | Hex       | Usage                           |
|------------|-----------|---------------------------------|
| ng-green   | `#009A44` | Primary brand color             |
| ng-dark    | `#006B2F` | Hover states, headings          |
| ng-light   | `#00C453` | Accents, live indicators        |
| ng-muted   | `#E8F7EE` | Backgrounds, card fills         |

---

## License

Proprietary — © {{ date('Y') }} ThreatWatch Nigeria. All rights reserved.

Built to protect lives and communities across Nigeria 🇳🇬
#   t h r e a t - n i g e r i a  
 