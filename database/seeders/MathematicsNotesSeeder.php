<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MathematicsNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Numbers' => [
                'Numbers'
            ],

            'Algebra' => [
                'Algebra'
            ],

            'Geometry' => [
                'Geometry'
            ],

            'Coordinate Geometry' => [
                'Coordinate Geometry'
            ],

            'Ratio, Proportion and Rates' => [
                'Ratio, Proportion and Rates'
            ],

            'Perimeter and Area' => [
                'Perimeter and Area'
            ],

            'Statistics' => [
                'Statistics'
            ]

        ],

        'Form Two' => [

            'Exponents and Radicals' => [
                'Exponents and Radicals'
            ],

            'Equations and Inequalities' => [
                'Equations and Inequalities'
            ],

            'Trigonometry' => [
                'Trigonometry'
            ],

            'Congruence and Similarity' => [
                'Congruence and Similarity'
            ],

            'Circles' => [
                'Circles'
            ],

            'Probability' => [
                'Probability'
            ],

            'Transformations' => [
                'Transformations'
            ]

        ],

        'Form Three' => [

            'Relations' => [
                'Relations'
            ],

            'Functions' => [
                'Functions'
            ],

            'Linear Programming' => [
                'Linear Programming'
            ],

            'Three-Dimensional Figures' => [
                'Three-Dimensional Figures'
            ],

            'Financial Mathematics' => [
                'Financial Mathematics'
            ],

            'Vectors' => [
                'Vectors'
            ],

            'Matrices and Transformations' => [
                'Matrices and Transformations'
            ]

        ],

        'Form Four' => [

            'Quadratic Expressions and Equations' => [
                'Quadratic Expressions and Equations'
            ],

            'Sequence and Series' => [
                'Sequence and Series'
            ],

            'Earth as a Sphere' => [
                'Earth as a Sphere'
            ],

            'Coordinate Geometry II' => [
                'Coordinate Geometry II'
            ],

            'Calculus (Introduction)' => [
                'Calculus (Introduction)'
            ],

            'Accounts' => [
                'Accounts'
            ],

            'Data Analysis' => [
                'Data Analysis'
            ]

        ],

    ];

    // Tafuta somo la Mathematics kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['mathematics']
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
