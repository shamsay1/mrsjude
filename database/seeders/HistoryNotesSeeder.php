<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoryNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Sources and Importance of History' => [
                'Meaning of History',
                'Importance of History',
                'Sources of Historical Information'
            ],

            'Evolution of Man, Technology and Environment' => [
                'Theories of Human Origin',
                'Stages of Human Evolution',
                'Development of Technology',
                'Relationship between Technology and Environment'
            ],

            'Development of Economic Activities and their Impact' => [
                'Development of Agriculture',
                'Handicraft Industries',
                'Mining',
                'Trade in Pre-colonial Africa'
            ],

            'Development of Social and Political Systems' => [
                'Kinship Organization',
                'Clan Organization',
                'Age-set System',
                'State Organization in Africa'
            ]

        ],

        'Form Two' => [

            'Interactions among the People of Africa' => [
                'Social Interactions',
                'Economic Interactions',
                'Political Interactions',
                'Effects of Interactions'
            ],

            'The Coming of Europeans in Africa' => [
                'Reasons for the Coming of Europeans',
                'Activities of Missionaries',
                'Activities of Traders',
                'Explorers',
                'Effects of European Penetration'
            ],

            'Colonialism and Colonial Economy' => [
                'Establishment of Colonial Rule',
                'Colonial Administrative Systems',
                'Colonial Economic Sectors',
                'Impact of Colonial Economy'
            ],

            'African Reactions to Colonial Rule' => [
                'Collaboration',
                'Resistance',
                'Reasons and Results of African Reactions'
            ]

        ],

        'Form Three' => [

            'Establishment of Colonialism' => [
                'Scramble for Africa',
                'Partition of Africa',
                'Establishment of Colonial Rule'
            ],

            'Colonial Administrative Systems' => [
                'Direct Rule',
                'Indirect Rule',
                'Assimilation',
                'Association'
            ],

            'Colonial Economy' => [
                'Agriculture',
                'Mining',
                'Trade',
                'Labour'
            ],

            'Nationalism and Decolonization' => [
                'Meaning of Nationalism',
                'Factors for Nationalism',
                'Independence Struggles',
                'Decolonization in Africa'
            ]

        ],

        'Form Four' => [

            'Africa after Independence' => [
                'Political Development',
                'Economic Development',
                'Social Development',
                'Challenges after Independence'
            ],

            'Africa in International Affairs' => [
                'Regional Cooperation',
                'Continental Cooperation',
                'International Organizations'
            ],

            'Contemporary World Issues' => [
                'Globalization',
                'Neo-colonialism',
                'Conflicts',
                'Environmental Issues',
                'Human Rights'
            ]

        ],

    ];

    // Tafuta somo la History kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['history']
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
