# 📝 Blog — College Project

A full-featured blog platform built with **Laravel**, developed as part of our college curriculum. The application supports multi-role user management, Google OAuth authentication, a rich admin panel, and a clean public-facing blog experience.

---

## 🚀 Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Blade Templates, Vanilla CSS
- **Database:** MySQL
- **Auth:** Laravel Breeze + Google OAuth (Socialite)
- **CI:** GitHub Actions

---

## ✨ Features

- **Authentication** — Register, login, logout, email verification
- **Google OAuth** — Sign in / sign up with Google; connect or disconnect Google account from profile settings
- **Role System** — `admin` and `author` roles; admin role is assigned exclusively via the database seeder (no UI toggle)
- **Admin Panel** — Manage users, posts, and categories
- **Post CRUD** — Create, edit, publish, and delete blog posts
- **Categories** — Organize posts under categories
- **Likes & Comments** — Readers can like and comment on posts
- **Featured Posts** — Admins can mark posts as featured
- **User Profiles** — Public profile pages per author
- **Pagination** — On all listing pages

---

## ⚙️ Installation & Running the Project

```bash
# 1. Clone the repository
git clone https://github.com/rahulgotrekiya/Blog.git
cd Blog

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies and build assets (CSS & JS)
npm install && npm run build

# 4. Environment setup
cp .env.example .env
php artisan key:generate

# 5. Configure your database credentials in .env, then run migrations and seed
php artisan migrate --seed

# 6. Create the storage symlink (required for avatar and image uploads)
php artisan storage:link
```

### Google OAuth Setup

Add the following to your `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Running the Project

```bash
php artisan serve --host=localhost --port=8000
```

Then open [http://localhost:8000](http://localhost:8000) in your browser.

---

## 🔐 Default Credentials (after seeding)

| Role   | Email                  | Password |
|--------|------------------------|----------|
| Admin  | admin@blog.com         | password |
| Author | testauthor@blog.com    | password |

> **Note:** Admin role is managed only through `DatabaseSeeder.php`. There is no UI or command to change roles — this is intentional for security.

---

## 🗂️ Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   └── ...             # Public controllers
├── Models/
resources/views/
    ├── admin/          # Admin panel views
    ├── auth/           # Auth views
    └── ...             # Public views
database/
├── migrations/
└── seeders/
    └── DatabaseSeeder.php  # Only place to assign admin role
```

---

## 📋 Roadmap / To-Do

> Planned features for upcoming iterations:

- [ ] **AI Integration** — AI-assisted post writing or content suggestions
- [ ] **Messaging / Email** — In-app messaging or email notifications between users
- [ ] **Login to Read More** — Restrict full post content to logged-in users only
- [x] **Navigation Bar** — Public nav with Home, About, and Contact Us pages added
- [x] **About Page** — Static page describing the project
- [x] **Contact Us (Admin Inbox)** — Contact form that sends messages to the admin panel
- [x] **Remove Comment Count** — Clean up comment count display from the admin panel

---

## 📄 License

This project is for educational purposes only.
