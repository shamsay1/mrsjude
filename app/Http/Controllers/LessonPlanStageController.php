<?php

namespace App\Http\Controllers;

use App\Models\LessonPlanStage;
use Illuminate\Http\Request;

class LessonPlanStageController extends Controller
{
    public function store(Request $request)
{
    if (!$request->has('lesson_plan_id')) {
        return back()->with('error', 'Lesson Plan ID is missing.');
    }

    foreach ($request->input('stages', []) as $stageData) {
        
        if (empty($stageData['stage_name'])) {
            continue;
        }

        LessonPlanStage::updateOrCreate(
            [
                'lesson_plan_id' => $request->lesson_plan_id,
                'stage_name'     => $stageData['stage_name']
            ],
            [
                'minutes'             => $stageData['minutes'] ?? null,
                'teaching_activities' => $stageData['teaching_activities'] ?? null,
                'learning_activities' => $stageData['learning_activities'] ?? null,
                'assessment'          => $stageData['assessment'] ?? null,
            ]
        );
    }

    return back()->with('success', 'Stages Saved Successfully');
}
}
