<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Country; // Assuming your models are in App\Models namespace
use App\Models\State;
use App\Models\City;
use Exception;

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
    protected $description = 'Imports countries, states, and cities data from JSON files.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting data import...');

        // --- Import Countries ---
        $this->line('Importing countries...');
        $countriesPath = storage_path('app/countries.json');
        if (File::exists($countriesPath)) {
            try {
                $jsonData = json_decode(File::get($countriesPath), true);
                $countriesData = $jsonData['countries'] ?? []; // Access the 'countries' key
                if (is_array($countriesData)) {
                    foreach ($countriesData as $country) {
                        // Ensure 'id' key exists before using it
                        if (!isset($country['id'])) {
                            $this->warn('Skipping country due to missing "id" key: ' . json_encode($country));
                            continue;
                        }
                        Country::updateOrCreate(
                            ['id' => $country['id']],
                            ['country_name' => $country['country_name'], 'sortname' => $country['sortname'] ?? null, 'phoneCode' => $country['phoneCode'] ?? null]
                        );
                    }
                    $this->info('Countries imported successfully.');
                } else {
                    $this->error('Countries data in JSON file is not an array or is malformed under "countries" key.');
                }
            } catch (Exception $e) {
                $this->error('Error importing countries: ' . $e->getMessage());
                return Command::FAILURE;
            }
        } else {
            $this->warn('countries.json not found in storage/app/. Skipping country import.');
        }

        // --- Import States ---
        $this->line('Importing states...');
        $statesPath = storage_path('app/states.json');
        if (File::exists($statesPath)) {
            try {
                $jsonData = json_decode(File::get($statesPath), true);
                $statesData = $jsonData['states'] ?? []; // Access the 'states' key
                if (is_array($statesData)) {
                    foreach ($statesData as $state) {
                        // Ensure 'id' key exists before using it
                        if (!isset($state['id'])) {
                            $this->warn('Skipping state due to missing "id" key: ' . json_encode($state));
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
                    $this->error('States data in JSON file is not an array or is malformed under "states" key.');
                }
            } catch (Exception $e) {
                $this->error('Error importing states: ' . $e->getMessage());
                return Command::FAILURE;
            }
        } else {
            $this->warn('states.json not found in storage/app/. Skipping state import.');
        }

        // --- Import Cities ---
        $this->line('Importing cities...');
        $citiesPath = storage_path('app/cities.json');
        if (File::exists($citiesPath)) {
            try {
                $jsonData = json_decode(File::get($citiesPath), true);
                $citiesData = $jsonData['cities'] ?? []; // Access the 'cities' key
                if (is_array($citiesData)) {
                    foreach ($citiesData as $city) {
                        // Ensure 'id' key exists before using it
                        if (!isset($city['id'])) {
                            $this->warn('Skipping city due to missing "id" key: ' . json_encode($city));
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
                    $this->error('Cities data in JSON file is not an array or is malformed under "cities" key.');
                }
            } catch (Exception $e) {
                $this->error('Error importing cities: ' . $e->getMessage());
                return Command::FAILURE;
            }
        } else {
            $this->warn('cities.json not found in storage/app/. Skipping city import.');
        }

        $this->info('Data import process completed.');
        return Command::SUCCESS;
    }
}
