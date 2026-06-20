<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CivicsTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            'Form One' => [

                'Our Nation' => [
                    'Concept of a Nation',
                    'Components of a Nation',
                    'National Symbols',
                    'National Values'
                ],

                'Promotion of Life Skills' => [
                    'Meaning of Life Skills',
                    'Types of Life Skills',
                    'Importance of Life Skills',
                    'Applying Life Skills'
                ],

                'Human Rights' => [
                    'Concept of Human Rights',
                    'Types of Human Rights',
                    'Universal Declaration of Human Rights (UDHR)',
                    'Promotion and Protection of Human Rights',
                    'Limitations of Human Rights'
                ],

                'Responsible Citizenship' => [
                    'Meaning of Citizenship',
                    'Types of Citizenship',
                    'Responsibilities of Citizens',
                    'Importance of Responsible Citizenship'
                ],

                'Work' => [
                    'Meaning of Work',
                    'Types of Work',
                    'Importance of Work',
                    'Work Ethics'
                ],

                'Road Safety Education' => [
                    'Road Users',
                    'Causes of Road Accidents',
                    'Prevention of Road Accidents',
                    'Traffic Signs and Rules'
                ]

            ],

            'Form Two' => [

                'Promotion of Life Skills' => [
                    'Decision Making',
                    'Problem Solving',
                    'Critical Thinking',
                    'Creative Thinking',
                    'Communication Skills',
                    'Negotiation Skills'
                ],

                'The Constitution' => [
                    'Meaning of Constitution',
                    'Types of Constitutions',
                    'Constitution of Tanzania',
                    'Importance of the Constitution'
                ],

                'Government' => [
                    'Meaning of Government',
                    'Functions of Government',
                    'Organs of Government',
                    'Levels of Government'
                ],

                'Democracy' => [
                    'Meaning of Democracy',
                    'Principles of Democracy',
                    'Democratic Processes',
                    'Importance of Democracy'
                ],

                'Gender' => [
                    'Meaning of Gender',
                    'Gender Equality',
                    'Gender Equity',
                    'Gender-Based Violence'
                ]

            ],

            'Form Three' => [

                'Economic and Social Development' => [
                    'Meaning of Development',
                    'Indicators of Development',
                    'Factors Affecting Development',
                    'Sustainable Development'
                ],

                'Poverty' => [
                    'Meaning of Poverty',
                    'Types of Poverty',
                    'Causes of Poverty',
                    'Effects of Poverty',
                    'Poverty Reduction Strategies'
                ],

                'Fighting Corruption' => [
                    'Meaning of Corruption',
                    'Types of Corruption',
                    'Causes of Corruption',
                    'Effects of Corruption',
                    'Prevention of Corruption'
                ],

                'Social Services' => [
                    'Meaning of Social Services',
                    'Types of Social Services',
                    'Importance of Social Services',
                    'Challenges in Providing Social Services'
                ]

            ],

            'Form Four' => [

                'Culture' => [
                    'Meaning of Culture',
                    'Elements of Culture',
                    'Importance of Culture',
                    'Effects of Globalization on Culture'
                ],

                'Globalization' => [
                    'Meaning of Globalization',
                    'Dimensions of Globalization',
                    'Advantages and Disadvantages of Globalization'
                ],

                'International Cooperation' => [
                    'Meaning of International Cooperation',
                    'Importance of International Cooperation',
                    'International Organizations',
                    'Tanzania\'s International Relations'
                ],

                'International Affairs' => [
                    'International Conflicts',
                    'Peace and Security',
                    'Humanitarian Issues',
                    'Contemporary Global Challenges'
                ]

            ],

        ];

        // Tafuta somo la Civics kwenye database
        $subjects = Subject::whereRaw(
    'LOWER(subjectName) = ?',
    ['civics']
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