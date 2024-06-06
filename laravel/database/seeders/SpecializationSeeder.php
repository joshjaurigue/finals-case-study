<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            ['specialization_title' => 'Cardiology'],
            ['specialization_title' => 'Neurology'],
            ['specialization_title' => 'Pediatrics'],
            ['specialization_title' => 'Dermatology'],
            ['specialization_title' => 'Orthopedics'],
            ['specialization_title' => 'Ophthalmology'],
            ['specialization_title' => 'Gynecology'],
            ['specialization_title' => 'Oncology'],
            ['specialization_title' => 'Urology'],
            ['specialization_title' => 'Psychiatry'],
            ['specialization_title' => 'None']
        ];

        foreach ($specializations as $specialization) {
            Specialization::create($specialization);
        }
    }
}
