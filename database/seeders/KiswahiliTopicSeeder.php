<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KiswahiliTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

    'Form One' => [

        'Utangulizi wa Kiswahili' => [
            'Maana ya Kiswahili',
            'Historia ya Kiswahili',
            'Umuhimu wa Kiswahili',
            'Kiswahili kama lugha ya taifa na mawasiliano',
            'Matumizi ya Kiswahili katika jamii'
        ],

        'Stadi za Kusikiliza na Kuzungumza' => [
            'Kusikiliza kwa ufahamu',
            'Kusikiliza habari',
            'Mazungumzo ya kawaida',
            'Matamshi sahihi',
            'Kujieleza mbele ya watu'
        ],

        'Stadi za Kusoma' => [
            'Usomaji wa sauti',
            'Usomaji wa kimya',
            'Ufahamu wa maandishi',
            'Kutambua mawazo makuu'
        ],

        'Sarufi ya Msingi' => [
            'Nomino',
            'Vitenzi',
            'Vivumishi',
            'Viwakilishi',
            'Sentensi rahisi'
        ],

        'Msamiati' => [
            'Maana ya msamiati',
            'Matumizi ya maneno',
            'Kuongeza msamiati',
            'Methali na misemo'
        ]

    ],

    'Form Two' => [

        'Stadi za Mawasiliano' => [
            'Mazungumzo rasmi na yasiyo rasmi',
            'Mahojiano',
            'Simu na mawasiliano ya kielektroniki',
            'Hotuba fupi'
        ],

        'Kusoma na Ufahamu' => [
            'Kusoma kwa kina',
            'Kutafuta maana katika maandishi',
            'Kutafsiri maandishi',
            'Kuelewa habari'
        ],

        'Uandishi' => [
            'Barua rasmi na zisizo rasmi',
            'Insha za maelezo',
            'Insha za masimulizi',
            'Ripoti'
        ],

        'Sarufi' => [
            'Nyakati',
            'Viunganishi',
            'Viwakilishi vya nafsi',
            'Sentensi tata'
        ],

        'Fasihi Simulizi' => [
            'Hadithi',
            'Methali',
            'Nahau',
            'Vitendawili',
            'Ushairi wa jadi'
        ]

    ],
    'Form Three' => [

    'Stadi za Juu za Mawasiliano' => [
        'Majadiliano (debate)',
        'Hotuba ndefu',
        'Mawasiliano ya kitaaluma',
        'Uwasilishaji wa taarifa'
    ],

    'Fasihi Andishi' => [
        'Riwaya',
        'Tamthilia',
        'Ushairi',
        'Mbinu za kifasihi'
    ],

    'Ufahamu na Uchanganuzi wa Maandishi' => [
        'Kuelewa dhamira',
        'Kuchambua wahusika',
        'Mandhari',
        'Maudhui ya maandishi'
    ],

    'Uandishi wa Kina' => [
        'Insha za hoja',
        'Insha za maoni',
        'Muhtasari',
        'Ripoti za kitaaluma'
    ],

    'Sarufi ya Juu' => [
        'Sentensi changamano',
        'Aina za vishazi',
        'Usemi wa taarifa',
        'Viambishi na mofolojia'
    ]

],

'Form Four' => [

    'Mawasiliano ya Kitaaluma' => [
        'Barua za maombi ya kazi',
        'CV (Wasifu binafsi)',
        'Barua rasmi za kiserikali',
        'Mawasiliano kazini'
    ],

    'Fasihi ya Kina' => [
        'Uchanganuzi wa riwaya',
        'Uchanganuzi wa tamthilia',
        'Uchanganuzi wa mashairi',
        'Uhakiki wa kazi za fasihi'
    ],

    'Uandishi wa Kitaaluma' => [
        'Insha za kitaaluma',
        'Ripoti za utafiti',
        'Muhtasari wa kina',
        'Hotuba rasmi'
    ],

    'Sarufi ya Kina' => [
        'Usemi halisi na usemi wa taarifa',
        'Sarufi ya vitenzi',
        'Sentensi tata na changamano',
        'Matumizi ya lugha fasaha'
    ],

    'Stadi za Mawasiliano ya Kisasa' => [
        'Mawasiliano ya kidijitali',
        'Vyombo vya habari',
        'Mawasiliano ya jamii',
        'Uandishi wa kitaaluma mtandaoni'
    ]

],

];

    $subjects = Subject::whereRaw('LOWER(subjectName) = ?', ['kiswahili'])
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
