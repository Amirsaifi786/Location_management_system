# 🌍 Laravel Location Management System

This project provides a way to **bulk import Countries, States, and Cities** from JSON files into your Laravel application using a custom Artisan command.

---

## 📦 Features

- ✅ Bulk import of location data (Countries, States, Cities)
- ✅ Avoids duplicate entries using `updateOrCreate()`
- ✅ Custom Artisan command: `php artisan import:locations`
- ✅ Relationships set between Country → State → City
- ✅ JSON-driven architecture
- ✅ Laravel 10 support

---

## ⚙️ Setup Instructions

### 1️⃣ Create Artisan Command

Run the following command to generate a custom artisan command:

```bash
php artisan make:command ImportLocationData
###  app/Console/Commands/ImportLocationData.php
2️⃣ Create Migrations and Models
Create migration files and models for:

Countries

States

Cities

Also, set up model relationships.

Country.php

php
Copy
Edit
public function states() {
    return $this->hasMany(State::class);
}
