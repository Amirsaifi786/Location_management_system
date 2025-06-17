# 🌍 Laravel Location Management System

This project provides a way to **bulk import Countries, States, and Cities** from JSON files into your Laravel application using a custom Artisan command.

---

## 📦 Features

- ✅ Bulk import of location data (Countries, States, Cities)
- ✅ Avoids duplicate entries using `updateOrCreate()`
- ✅ Custom Artisan command: `php artisan import:locations`
- ✅ Relationships set between Country → State → City
- ✅ JSON-driven architecture
- ✅ Laravel 12 support

---

## ⚙️ Setup Instructions

### 1️⃣ Create Artisan Command

Run the following command to generate a custom artisan command:

```bash
<p>php artisan make:command ImportLocationData</p>app/
├── Console/
│ └── Commands/
│ └── ImportLocationData.php

database/
├── migrations/
│ └── 202x_xx_xx_create_countries_table.php
│ └── 202x_xx_xx_create_states_table.php
│ └── 202x_xx_xx_create_cities_table.php

app/
├── Models/
│ └── Country.php
│ └── State.php
│ └── City.php

storage/
└── app/
├── countries.json
├── states.json
└── cities.json



---

## 📁 Migrations

### `countries` table

```php
Schema::create('countries', function (Blueprint $table) {
    $table->id();
    $table->string('country_name');
    $table->string('sortname')->nullable();
    $table->string('phoneCode')->nullable();
    $table->timestamps();
});
states table

Schema::create('states', function (Blueprint $table) {
    $table->id();
    $table->string('state_name');
    $table->foreignId('country_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
cities table

Schema::create('cities', function (Blueprint $table) {
    $table->id();
    $table->string('city_name');
    $table->foreignId('state_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
🧩 Models & Relationships
Country.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['country_name', 'sortname', 'phoneCode'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
State.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['state_name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
City.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['city_name', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
📂 JSON File Format
storage/app/countries.json
json

{
  "countries": [
    {
      "id": 1,
      "country_name": "India",
      "sortname": "IN",
      "phoneCode": "91"
    }
  ]
}
storage/app/states.json
json

{
  "states": [
    {
      "id": 1,
      "state_name": "Uttar Pradesh",
      "country_id": 1
    }
  ]
}
storage/app/cities.json
json

{
  "cities": [
    {
      "id": 1,
      "city_name": "Lucknow",
      "state_id": 1
    }
  ]
}
🛠️ Artisan Command
Generate command:

bash

php artisan make:command ImportLocationData
Register it in the file:


protected $signature = 'import:locations';
handle() method

public function handle()
{
    $this->info('Starting data import...');

    // Import Countries
    $countriesPath = storage_path('app/countries.json');
    if (File::exists($countriesPath)) {
        $data = json_decode(File::get($countriesPath), true);
        foreach ($data['countries'] ?? [] as $country) {
            if (!isset($country['id'])) continue;
            Country::updateOrCreate(
                ['id' => $country['id']],
                ['country_name' => $country['country_name'], 'sortname' => $country['sortname'] ?? null, 'phoneCode' => $country['phoneCode'] ?? null]
            );
        }
        $this->info('Countries imported.');
    }

    // Import States
    $statesPath = storage_path('app/states.json');
    if (File::exists($statesPath)) {
        $data = json_decode(File::get($statesPath), true);
        foreach ($data['states'] ?? [] as $state) {
            if (!isset($state['id'])) continue;
            State::updateOrCreate(
                ['id' => $state['id']],
                ['state_name' => $state['state_name'], 'country_id' => $state['country_id']]
            );
        }
        $this->info('States imported.');
    }

    // Import Cities
    $citiesPath = storage_path('app/cities.json');
    if (File::exists($citiesPath)) {
        $data = json_decode(File::get($citiesPath), true);
        foreach ($data['cities'] ?? [] as $city) {
            if (!isset($city['id'])) continue;
            City::updateOrCreate(
                ['id' => $city['id']],
                ['city_name' => $city['city_name'], 'state_id' => $city['state_id']]
            );
        }
        $this->info('Cities imported.');
    }

    $this->info('✅ All data imported successfully!');
}
🚀 Run Import Command
bash

php artisan import:locations
This will import data from the JSON files into your database.

📷 Screenshots
Import Artisan Command

JSON Folder Example

📎 License
This project is open-source and free to use.

🙋 Author
Amir Saifi
