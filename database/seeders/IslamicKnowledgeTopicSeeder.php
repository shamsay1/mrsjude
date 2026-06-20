<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IslamicKnowledgeTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            'Form One' => [

                'Qur\'ani Tukufu' => [
                    'Kushuka kwa Qur\'ani',
                    'Kukusanywa kwa Qur\'ani',
                    'Umuhimu wa Qur\'ani'
                ],

                'Hadithi' => [
                    'Maana ya Hadithi',
                    'Aina za Hadithi',
                    'Umuhimu wa Hadithi'
                ],

                'Aqida' => [
                    'Maana ya Aqida',
                    'Nguzo za Imani',
                    'Tauhidi'
                ],

                'Ibada' => [
                    'Twahara',
                    'Swala',
                    'Funga',
                    'Zaka',
                    'Hijja'
                ],

                'Akhlaq' => [
                    'Maadili mema',
                    'Heshima kwa wazazi',
                    'Uaminifu',
                    'Uvumilivu',
                    'Ushirikiano'
                ]

            ],

            'Form Two' => [

                'Sira ya Mtume Muhammad (S.A.W.)' => [
                    'Kuzaliwa kwa Mtume',
                    'Kuteuliwa kuwa Mtume',
                    'Hijra',
                    'Maisha ya Madina'
                ],

                'Sharia' => [
                    'Maana ya Sharia',
                    'Vyanzo vya Sharia',
                    'Umuhimu vya Sharia'
                ],

                'Muamala' => [
                    'Biashara katika Uislamu',
                    'Ndoa',
                    'Haki na wajibu wa familia',
                    'Mirathi'
                ],

                'Akhlaq ya Kiislamu' => [
                    'Haki za jirani',
                    'Malezi mema',
                    'Nidhamu',
                    'Uwajibikaji'
                ]

            ],

            'Form Three' => [

                'Historia ya Uislamu' => [
                    'Makhalifa Waongofu',
                    'Kuenea kwa Uislamu',
                    'Mchango wa Waislamu katika elimu na sayansi'
                ],

                'Ustaarabu wa Kiislamu' => [
                    'Maendeleo ya ustaarabu wa Kiislamu',
                    'Elimu',
                    'Sayansi',
                    'Utamaduni'
                ],

                'Masuala ya Kisasa' => [
                    'Madawa ya kulevya',
                    'UKIMWI',
                    'Uhifadhi wa mazingira',
                    'Amani na maridhiano'
                ]

            ],

            'Form Four' => [

                'Maadili ya Kiislamu' => [
                    'Uongozi',
                    'Haki za binadamu katika Uislamu',
                    'Uadilifu',
                    'Usawa',
                    'Uwajibikaji'
                ],

                'Uchumi wa Kiislamu' => [
                    'Zaka',
                    'Sadaka',
                    'Waqfu',
                    'Riba',
                    'Biashara halali'
                ],

                'Uislamu na Maisha ya Kisasa' => [
                    'Teknolojia',
                    'Utandawazi',
                    'Uhifadhi wa mazingira',
                    'Wajibu wa Muislamu katika jamii ya kisasa'
                ]

            ],

        ];

        $subjects = Subject::whereRaw(
    'LOWER(subjectName) = ?',
    ['dini ya kiislamu']
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