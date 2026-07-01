<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeographyNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Introduction to Geography' => [
                'Meaning of Geography',
                'Branches of Geography',
                'Importance of Studying Geography',
                'Relationship between Geography and Other Subjects',
                'Careers Related to Geography'
            ],

            'The Earth and the Solar System' => [
                'The Earth as a Planet',
                'The Solar System',
                'Planets and their Characteristics',
                'Rotation and Revolution of the Earth',
                'Effects of Earth\'s Movements'
            ],

            'Weather and Climate' => [
                'Meaning of Weather and Climate',
                'Elements of Weather',
                'Factors Influencing Climate',
                'Instruments Used in Weather Station',
                'Reading Weather Data'
            ],

            'Map Reading and Interpretation' => [
                'Types of Maps',
                'Map Symbols and Keys',
                'Scale of Map',
                'Direction and Bearings',
                'Reading and Interpreting Maps'
            ],

            'The Structure of the Earth' => [
                'Layers of the Earth',
                'Types of Rocks',
                'Rock Cycle',
                'Formation of Major Landforms',
                'Earth Movements'
            ]

        ],

        'Form Two' => [

            'Population and Settlement' => [
                'Meaning of Population',
                'Population Distribution',
                'Population Density',
                'Population Growth',
                'Types of Settlements'
            ],

            'Environmental Issues' => [
                'Environmental Degradation',
                'Types of Pollution',
                'Causes and Effects of Pollution',
                'Environmental Conservation'
            ],

            'Agriculture' => [
                'Types of Agriculture',
                'Factors Affecting Agriculture',
                'Farming Methods in Tanzania',
                'Problems Facing Agriculture',
                'Agricultural Development'
            ],

            'Industry' => [
                'Types of Industries',
                'Factors Influencing Location of Industries',
                'Industrial Development in Tanzania',
                'Importance of Industries'
            ]

        ],

        'Form Three' => [

            'Transport and Communication' => [
                'Types of Transport',
                'Advantages and Disadvantages of Transport',
                'Communication Systems',
                'Importance of Transport and Communication'
            ],

            'Trade' => [
                'Types of Trade',
                'Import and Export',
                'Factors Affecting Trade',
                'Importance of Trade'
            ],

            'Tourism' => [
                'Meaning of Tourism',
                'Types of Tourism',
                'Tourist Attractions in Tanzania',
                'Importance of Tourism',
                'Problems Facing Tourism Sector'
            ],

            'Water Management' => [
                'Sources of Water',
                'Water Cycle',
                'Water Conservation Methods',
                'Importance of Water Resources'
            ]

        ],

        'Form Four' => [

            'Natural Resources and Conservation' => [
                'Types of Natural Resources',
                'Renewable and Non-renewable Resources',
                'Conservation Methods',
                'Sustainable Use of Resources'
            ],

            'Sustainable Development' => [
                'Meaning of Sustainable Development',
                'Principles of Sustainability',
                'Role of Environment in Development',
                'Environmental Challenges'
            ],

            'Geography of Tanzania' => [
                'Physical Features of Tanzania',
                'Climate Regions',
                'Vegetation Zones',
                'Economic Activities in Tanzania'
            ],

            'Field Work and Research' => [
                'Meaning of Field Work',
                'Methods of Data Collection',
                'Data Presentation',
                'Report Writing'
            ]

        ],

    ];

    // Tafuta somo la Geography kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['geography']
    )
    ->with('classRoom')
    ->get();

    foreach ($subjects as $subject) {

        $className = $subject->classRoom->class_name;

        if (!isset($data[$className])) {
            continue;
        }

        foreach ($data[$className] as $topicName => $subTopics) {

            $topic = Topic::create([
                'subject_id' => $subject->id,
                'topic_name' => $topicName
            ]);

            foreach ($subTopics as $subTopicName) {

                SubTopic::create([
                    'topic_id' => $topic->id,
                    'sub_topic_name' => $subTopicName
                ]);

            }
        }
    }
}
}
