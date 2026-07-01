<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnglishNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Introduction to English Language' => [
                'Meaning and Importance of English',
                'Uses of English in Tanzania',
                'English as a Second Language',
                'Basic Communication Skills'
            ],

            'Listening Skills' => [
                'Listening for Gist',
                'Listening for Specific Information',
                'Listening for Instructions',
                'Barriers to Effective Listening'
            ],

            'Speaking Skills' => [
                'Pronunciation',
                'Intonation and Stress',
                'Introducing Oneself and Others',
                'Asking and Answering Questions'
            ],

            'Reading Skills' => [
                'Reading Aloud',
                'Silent Reading',
                'Skimming and Scanning',
                'Reading Comprehension'
            ],

            'Writing Skills' => [
                'Handwriting Skills',
                'Sentence Formation',
                'Paragraph Writing',
                'Punctuation Marks'
            ],

            'Grammar Basics' => [
                'Parts of Speech',
                'Tenses',
                'Subject-Verb Agreement',
                'Simple Sentences'
            ]

        ],

        'Form Two' => [

            'Listening and Note Taking' => [
                'Listening for Details',
                'Summarizing Spoken Texts',
                'Note Taking Techniques'
            ],

            'Speaking Skills Development' => [
                'Dialogues and Conversations',
                'Public Speaking',
                'Describing Events and Objects',
                'Telephone Conversations'
            ],

            'Reading for Information' => [
                'Comprehension Passages',
                'Identifying Main Ideas',
                'Inference Skills',
                'Vocabulary in Context'
            ],

            'Writing Skills Development' => [
                'Letter Writing (Formal and Informal)',
                'Writing Reports',
                'Narrative Writing',
                'Descriptive Writing'
            ],

            'Grammar and Usage' => [
                'Continuous and Perfect Tenses',
                'Prepositions',
                'Conjunctions',
                'Active and Passive Voice'
            ]

        ],

        'Form Three' => [

            'Advanced Listening Skills' => [
                'Listening to Speeches',
                'Interpreting Information',
                'Listening to Discussions'
            ],

            'Advanced Speaking Skills' => [
                'Debates',
                'Interviews',
                'Public Presentations',
                'Expressing Opinions'
            ],

            'Advanced Reading Skills' => [
                'Intensive Reading',
                'Extensive Reading',
                'Literary Appreciation',
                'Interpretation of Texts'
            ],

            'Advanced Writing Skills' => [
                'Essay Writing',
                'Report Writing',
                'Speech Writing',
                'Summary Writing'
            ],

            'Grammar and Structure' => [
                'Complex Sentences',
                'Clauses (Main and Subordinate)',
                'Direct and Indirect Speech',
                'Modals'
            ]

        ],

        'Form Four' => [

            'Functional English' => [
                'Communication in Real Life Situations',
                'Job Applications',
                'Curriculum Vitae (CV) Writing',
                'Formal Correspondence'
            ],

            'Literature in English' => [
                'Prose',
                'Poetry',
                'Drama',
                'Literary Devices'
            ],

            'Advanced Grammar' => [
                'Advanced Tenses',
                'Conditionals',
                'Reported Speech',
                'Phrasal Verbs'
            ],

            'Critical Reading and Interpretation' => [
                'Analyzing Texts',
                'Identifying Themes and Messages',
                'Contextual Interpretation'
            ],

            'Communication Skills' => [
                'Media Communication',
                'Digital Communication',
                'Effective Presentation Skills'
            ]

        ],

    ];

    // Tafuta somo la English kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['english']
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
