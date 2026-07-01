<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhysicsNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Introduction to Physics' => [
                'Meaning of Physics',
                'Branches of Physics',
                'Importance of Physics',
                'Scientific Method',
                'Laboratory Safety'
            ],

            'Measurement' => [
                'Physical Quantities',
                'SI Units',
                'Fundamental and Derived Units',
                'Measuring Instruments',
                'Accuracy and Precision',
                'Significant Figures'
            ],

            'Force' => [
                'Meaning of Force',
                'Types of Forces',
                'Effects of Force',
                'Resultant Force',
                'Friction',
                'Moment of a Force',
                'Centre of Gravity',
                'Stability'
            ],

            'Pressure' => [
                'Pressure in Solids',
                'Pressure in Liquids',
                'Atmospheric Pressure',
                'Applications of Pressure'
            ],

            'Structure and Properties of Matter' => [
                'States of Matter',
                'Kinetic Theory',
                'Physical and Chemical Changes',
                'Density',
                'Elasticity'
            ]

        ],

        'Form Two' => [

            'Work, Energy and Power' => [
                'Work',
                'Energy',
                'Forms of Energy',
                'Conservation of Energy',
                'Power',
                'Efficiency'
            ],

            'Light' => [
                'Sources of Light',
                'Reflection',
                'Refraction',
                'Lenses',
                'Mirrors',
                'Image Formation',
                'Optical Instruments'
            ],

            'Heat' => [
                'Temperature',
                'Heat Transfer',
                'Expansion',
                'Specific Heat Capacity',
                'Change of State'
            ],

            'Sound' => [
                'Production of Sound',
                'Propagation',
                'Characteristics of Sound',
                'Echo',
                'Noise'
            ]

        ],

        'Form Three' => [

            'Current Electricity' => [
                'Electric Current',
                'Potential Difference',
                'Resistance',
                'Ohm\'s Law',
                'Series and Parallel Circuits',
                'Electrical Power',
                'Domestic Wiring'
            ],

            'Magnetism' => [
                'Magnets',
                'Magnetic Field',
                'Electromagnets',
                'Applications of Electromagnets'
            ],

            'Electromagnetism' => [
                'Electromagnetic Induction',
                'Generators',
                'Transformers',
                'Electric Motors'
            ],

            'Waves' => [
                'Wave Motion',
                'Types of Waves',
                'Wave Properties',
                'Electromagnetic Spectrum',
                'Applications of Waves'
            ]

        ],

        'Form Four' => [

            'Electronics' => [
                'Semiconductors',
                'Diodes',
                'Transistors',
                'Logic Gates',
                'Integrated Circuits'
            ],

            'Radioactivity' => [
                'Atomic Structure',
                'Radioactive Decay',
                'Types of Radiation',
                'Half-life',
                'Uses of Radioisotopes',
                'Radiation Hazards'
            ],

            'Atomic Physics' => [
                'Atomic Models',
                'Electron Arrangement',
                'Energy Levels',
                'Photoelectric Effect'
            ],

            'Communication' => [
                'Communication Systems',
                'Radio Communication',
                'Television',
                'Mobile Communication',
                'Satellite Communication',
                'Fibre Optics'
            ]

        ],

    ];

    // Tafuta somo la Physics kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['physics']
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
