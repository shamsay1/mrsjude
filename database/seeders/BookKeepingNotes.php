<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookKeepingNotes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [

        'Form One' => [

            'Demonstrate Mastery of the Principles of Book-keeping' => [
                'Concept of Book-keeping',
                'Accounting Assumptions and Principles',
                'Double-entry System (Accounting Equation)',
                'Types of Accounts',
                'Source Documents',
                'Books of Original Entry',
                'Ledger Accounts',
                'Trial Balance'
            ],

            'Prepare Basic Financial Statements' => [
                'Basic Financial Statements',
                'Income Statement (Profit or Loss Statement)',
                'Statement of Financial Position (Balance Sheet)',
                'Statement of Cash Flows',
                'Basic Financial Statements for Audit'
            ]

        ],

        'Form Two' => [

            'Prepare Financial Statements for Non-commercial Organisations' => [
                'Commercial and Non-commercial Organisations',
                'Receipts and Payments Account',
                'Income and Expenditure Account',
                'Statement of Financial Position for Non-commercial Organisations'
            ],

            'Demonstrate Mastery of Financial Assets Control' => [
                'Bank Reconciliation Statement',
                'Budgeting and Budgetary Control',
                'Cash Budget',
                'Adjustments in Financial Statements',
                'Depreciation',
                'Bad Debts and Provision for Doubtful Debts',
                'Accruals and Prepayments'
            ]

        ],

        'Form Three' => [

            'Control Accounts' => [
                'Sales Ledger Control Account',
                'Purchases Ledger Control Account'
            ],

            'Incomplete Records' => [
                'Single Entry System',
                'Statement of Affairs',
                'Conversion to Double Entry'
            ],

            'Manufacturing Accounts' => [
                'Manufacturing Account',
                'Cost of Production'
            ],

            'Partnership Accounts' => [
                'Partnership Agreement',
                'Profit and Loss Appropriation Account',
                'Partners\' Current and Capital Accounts',
                'Admission and Retirement of Partners'
            ]

        ],

        'Form Four' => [

            'Company Accounts' => [
                'Company Capital',
                'Issue of Shares',
                'Company Financial Statements'
            ],

            'Accounts from Incomplete Information' => [
                'Reconstruction of Accounts',
                'Final Accounts from Incomplete Records'
            ],

            'Accounting Packages' => [
                'Introduction to Accounting Software',
                'Recording Transactions Using Accounting Packages',
                'Preparing Reports Using Accounting Software'
            ]

        ],

    ];

    // Tafuta somo la Book Keeping kwenye database
    $subjects = Subject::whereRaw(
        'LOWER(subjectName) = ?',
        ['book keeping']
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
