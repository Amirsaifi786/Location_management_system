🌍 Laravel Location Management System
This project provides a robust solution to bulk import Countries, States, and Cities from JSON files directly into your Laravel application. It leverages a custom Artisan command for efficient and controlled data population.

🚀 Features
✅   Bulk Import: Seamlessly import comprehensive location data (Countries, States, Cities) into your database.

✅   Duplicate Prevention: Utilizes updateOrCreate() to ensure no duplicate entries are created during the import process.

✅   Custom Artisan Command: Features a dedicated command, php artisan import:locations, for easy execution.

✅   Relational Integrity: Automatically sets up relationships between Country → State → City, maintaining data consistency.

✅   JSON-Driven Architecture: Data is sourced from well-structured JSON files, making it easy to manage and update.

✅   Laravel 12 Support: Built with compatibility for Laravel 12, ensuring modern development practices.

📷 Screenshots
Country Add
Country List
State Add
State List
City Add
City List
⚙️ Setup Instructions
Follow these steps to set up and use the Laravel Location Management System in your project.

1️⃣ Project Structure
Ensure your project has a similar structure, particularly for the console command, models, migrations, and JSON data files:

app/
├── Console/
│   └── Commands/
│       └── ImportLocationData.php
├── Models/
│   ├── Country.php
│   ├── State.php
│   └── City.php
database/
├── migrations/
│   ├── 202x_xx_xx_create_countries_table.php
│   ├── 202x_xx_xx_create_states_table.php
│   └── 202x_xx_xx_create_cities_table.php
storage/
└── app/
    ├── countries.json
    ├── states.json
    └── cities.json

2️⃣ Migrations
Create the necessary database tables for countries, states, and cities using the following migration schemas.

countries table
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

3️⃣ Models & Relationships
Define your Eloquent models for Country, State, and City, including their relationships:

Country.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['country_name', 'sortname', 'phoneCode'];

    /**
     * Get the states for the country.
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}

State.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = ['state_name', 'country_id'];

    /**
     * Get the country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the cities for the state.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}

City.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $fillable = ['city_name', 'state_id'];

    /**
     * Get the state that owns the city.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}

4️⃣ JSON File Format
Create the JSON files in the storage/app/ directory with the following structure.

storage/app/countries.json
{
  "countries": [
    {
      "id": 1,
      "country_name": "India",
      "sortname": "IN",
      "phoneCode": "91"
    },
    {
      "id": 2,
      "country_name": "United States",
      "sortname": "US",
      "phoneCode": "1"
    }
  ]
}

storage/app/states.json
{
  "states": [
    {
      "id": 1,
      "state_name": "Uttar Pradesh",
      "country_id": 1
    },
    {
      "id": 2,
      "state_name": "California",
      "country_id": 2
    }
  ]
}

storage/app/cities.json
{
  "cities": [
    {
      "id": 1,
      "city_name": "Lucknow",
      "state_id": 1
    },
    {
      "id": 2,
      "city_name": "Los Angeles",
      "state_id": 2
    }
  ]
}

5️⃣ Artisan Command
Generate a new Artisan command and implement the import logic within its handle() method.

Generate command:
php artisan make:command ImportLocationData

This will create app/Console/Commands/ImportLocationData.php.

Register the command signature:
In app/Console/Commands/ImportLocationData.php, define the $signature property:

protected $signature = 'import:locations';
protected $description = 'Imports countries, states, and cities from JSON files.';

Implement handle() method:
Add the following logic to the handle() method in app/Console/Commands/ImportLocationData.php:

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class ImportLocationData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:locations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports countries, states, and cities from JSON files.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting data import...');

        // Import Countries
        $countriesPath = storage_path('app/countries.json');
        if (File::exists($countriesPath)) {
            $data = json_decode(File::get($countriesPath), true);
            foreach ($data['countries'] ?? [] as $country) {
                if (!isset($country['id'])) {
                    $this->warn("Skipping country entry due to missing 'id': " . json_encode($country));
                    continue;
                }
                Country::updateOrCreate(
                    ['id' => $country['id']],
                    [
                        'country_name' => $country['country_name'],
                        'sortname' => $country['sortname'] ?? null,
                        'phoneCode' => $country['phoneCode'] ?? null
                    ]
                );
            }
            $this->info('Countries imported successfully.');
        } else {
            $this->error("countries.json not found at: {$countriesPath}");
        }

        // Import States
        $statesPath = storage_path('app/states.json');
        if (File::exists($statesPath)) {
            $data = json_decode(File::get($statesPath), true);
            foreach ($data['states'] ?? [] as $state) {
                if (!isset($state['id']) || !isset($state['country_id'])) {
                    $this->warn("Skipping state entry due to missing 'id' or 'country_id': " . json_encode($state));
                    continue;
                }
                State::updateOrCreate(
                    ['id' => $state['id']],
                    [
                        'state_name' => $state['state_name'],
                        'country_id' => $state['country_id']
                    ]
                );
            }
            $this->info('States imported successfully.');
        } else {
            $this->error("states.json not found at: {$statesPath}");
        }

        // Import Cities
        $citiesPath = storage_path('app/cities.json');
        if (File::exists($citiesPath)) {
            $data = json_decode(File::get($citiesPath), true);
            foreach ($data['cities'] ?? [] as $city) {
                if (!isset($city['id']) || !isset($city['state_id'])) {
                    $this->warn("Skipping city entry due to missing 'id' or 'state_id': " . json_encode($city));
                    continue;
                }
                City::updateOrCreate(
                    ['id' => $city['id']],
                    [
                        'city_name' => $city['city_name'],
                        'state_id' => $city['state_id']
                    ]
                );
            }
            $this->info('Cities imported successfully.');
        } else {
            $this->error("cities.json not found at: {$citiesPath}");
        }

        $this->info('✅ All data import process completed!');
        return Command::SUCCESS;
    }
}

🚀 Run Import Command
After setting up the migrations, models, and Artisan command, run the following command to import the data:

php artisan migrate
php artisan import:locations

This will first create the necessary tables and then import the data from your JSON files into your database.

🤝 Contributing
Feel free to fork this repository, open issues, or submit pull requests. Your contributions are welcome!

📎 License
This project is open-source and free to use under the MIT License.

🙋 Author
Amir Saifi