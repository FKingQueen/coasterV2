<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name' => 'Project 1',
            'description' => 'Coastal Erosion Trends and Management Strategies for Region 1',
        ]);
        DB::table('projects')->insert([
            'name' => 'Project 2',
            'description' => 'Assesment Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in Region 1',
        ]);
        DB::table('projects')->insert([
            'name' => 'Project 3',
            'description' => 'Development of Science-based Engineering Approach to Coastal Prediction in Region 1',
        ]);
        DB::table('projects')->insert([
            'name' => 'Project 4',
            'description' => 'Enhancing Coastal Design and Infrastructure Intervention through the Establishment of Wave Testing Facility',
        ]);
    }
}
