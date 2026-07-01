<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputerNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Introduction to Computer Science' => [
                'Meaning of Computer Science',
                'Applications of Computer Science',
                'Fields Related to Computer Science'
            ],

            'Computer Systems' => [
                'Concept of Computer Systems',
                'Computer Generations',
                'Classification of Computers'
            ],

            'Computer Hardware' => [
                'Concept of Computer Hardware',
                'Input Devices',
                'Processing Devices',
                'Storage Devices',
                'Output Devices'
            ],

            'Computer Software' => [
                'Concept of Computer Software',
                'System Software',
                'Application Software',
                'Software Installation'
            ],

            'Computer System Handling and Care' => [
                'Concept of Computer System Handling and Care',
                'Computer Laboratory Management',
                'Safety Precautions'
            ],

            'Computer System Maintenance' => [
                'Preventive Maintenance',
                'Corrective Maintenance',
                'Maintenance Tools'
            ],

            'Computer System Troubleshooting' => [
                'Common Computer Problems',
                'Troubleshooting Techniques'
            ],

            'Problem Solving' => [
                'Problem Solving Concepts',
                'Algorithms',
                'Flowcharts',
                'Pseudocode'
            ]

        ],

        'Form Two' => [

            'Internet' => [
                'Internet Concepts',
                'Internet Services',
                'World Wide Web',
                'Search Engines'
            ],

            'Cybersecurity' => [
                'Cyber Threats',
                'Malware',
                'Data Protection',
                'Safe Internet Practices'
            ],

            'Introduction to Computer Programming' => [
                'Programming Concepts',
                'Programming Languages',
                'Program Development Process'
            ],

            'Computer Programming with C' => [
                'Structure of a C Program',
                'Variables and Data Types',
                'Operators',
                'Selection Statements',
                'Iteration Statements',
                'Functions'
            ],

            'Computer Programming with Python' => [
                'Python Fundamentals',
                'Variables',
                'Input and Output',
                'Decision Making',
                'Loops',
                'Functions'
            ]

        ],

        'Form Three' => [

            'Data Representation' => [
                'Number Systems',
                'Binary Arithmetic',
                'Character Encoding',
                'Data Measurement Units'
            ],

            'Database Systems' => [
                'Database Concepts',
                'Database Management Systems (DBMS)',
                'Tables',
                'Queries',
                'Forms',
                'Reports'
            ],

            'Computer Networks' => [
                'Network Concepts',
                'Types of Networks',
                'Network Topologies',
                'Network Devices',
                'Network Media'
            ],

            'Website Development' => [
                'HTML Basics',
                'Web Pages',
                'Hyperlinks',
                'Images',
                'Tables',
                'Forms'
            ],

            'Multimedia' => [
                'Multimedia Concepts',
                'Images',
                'Audio',
                'Video',
                'Animation'
            ]

        ],

        'Form Four' => [

            'Object-Oriented Programming' => [
                'Classes',
                'Objects',
                'Encapsulation',
                'Inheritance',
                'Polymorphism'
            ],

            'Systems Analysis and Design' => [
                'System Development Life Cycle (SDLC)',
                'System Investigation',
                'System Design',
                'System Implementation',
                'System Evaluation'
            ],

            'Emerging Technologies' => [
                'Artificial Intelligence (AI)',
                'Internet of Things (IoT)',
                'Cloud Computing',
                'Big Data'
            ],

            'Computer Project' => [
                'Problem Identification',
                'Planning',
                'System Development',
                'Testing',
                'Documentation',
                'Presentation'
            ]

        ],

    ];

    // Tafuta somo la Computer Science kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['computer science']
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
