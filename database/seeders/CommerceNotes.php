<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommerceNotes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'The Basics of Commerce' => [
                'The Concept of Commerce',
                'Elements of Commerce'
            ],

            'Production' => [
                'The Concept of Production',
                'Factors of Production and Their Rewards',
                'Stages of Production',
                'Needs and Wants',
                'The Concept of Productivity',
                'The Concept of Cost'
            ],

            'Entrepreneurship' => [
                'The Concept of Entrepreneurship',
                'The Concept of Self-employment'
            ],

            'Domestic Trade' => [
                'Retail Trade',
                'Wholesale Trade'
            ]

        ],

        'Form Two' => [

            'Entrepreneurship' => [
                'Skills and Attributes of a Successful Entrepreneur',
                'Entrepreneurial Motivation',
                'Entrepreneurial Activities in Tanzania',
                'Identification and Evaluation of Business Ideas',
                'Factors Hindering the Development of Entrepreneurship in Tanzania'
            ],

            'Theories of Demand and Supply' => [
                'Theory of Demand',
                'Theory of Supply'
            ],

            'Warehouse Management' => [
                'The Concept of Warehousing',
                'Stock Administration'
            ],

            'Transportation' => [
                'Concept of Transportation',
                'Modes of Transport',
                'Transportation Documents'
            ]

        ],

        'Form Three' => [

            'Business Communication' => [
                'The Concept of Communication',
                'Business Communication',
                'Barriers to Effective Business Communication',
                'Communication Media (Channels)',
                'Business Communication Documents',
                'Electronic Communication'
            ],

            'Marketing' => [
                'The Concept of Marketing',
                'Marketing Functions',
                'Marketing Mix',
                'Promotional Mix',
                'Marketing Institutions'
            ],

            'Money and Banking' => [
                'Meaning of Money',
                'Functions of Money',
                'Financial Institutions in Tanzania',
                'Bank Payment Systems',
                'Credit Facilities',
                'Loan Management'
            ],

            'International Trade' => [
                'Concept of International Trade',
                'Import Trade',
                'Export Trade',
                'International Trade Agents',
                'International Trade Documents',
                'Balance of Trade and Balance of Payments',
                'Trade Protectionism'
            ],

            'Entrepreneurship' => [
                'The Concepts of Invention and Innovation',
                'Sources of Capital for Entrepreneurs'
            ]

        ],

        'Form Four' => [

            'Entrepreneurship' => [
                'Business Planning',
                'Business Start-up and Preliminary Activities',
                'Overview of Businesses in Tanzania'
            ],

            'Business Units' => [
                'The Concept of Business Unit',
                'Forms of Business Units',
                'International Business Ventures'
            ],

            'Business Management' => [
                'The Concept of Business Management',
                'Business Organisational Structure',
                'Business Ethics'
            ],

            'Taxation' => [
                'The Concept of Tax and Taxation',
                'Practical Issues in Taxation',
                'Tax System',
                'Tax System in Tanzania',
                'Tariffs in Tanzania',
                'Value Added Tax (VAT)',
                'VAT Computation',
                'Effects of Taxation'
            ],

            'Insurance' => [
                'Insurance Concept',
                'Insurance Principles',
                'Types of Insurance',
                'Insurance Claims and Compensation'
            ]

        ],

    ];

    // Tafuta somo la Commerce kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['commerce']
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
