<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\School;
use App\Models\Student;
use App\Models\SystemUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with([
        'school',
        'supervisor'
    ])
    ->where('supervisor_id', Auth::id())
    ->latest()
    ->get();

    $totalOrders = $orders->count();

    return view('orders', compact(
        'orders',
        'totalOrders'
    ));
}
    public function store(Request $request)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:system_users,id',
            'school_id' => 'required|exists:schools,id',
            'instruction' => 'required',
            'inspection_date' => 'required|date',
        ]);

        Order::create([
            'supervisor_id' => $request->supervisor_id,
            'school_id' => $request->school_id,
            'instruction' => $request->instruction,
            'inspection_date' => $request->inspection_date,
            'status' => 'pending',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Order assigned successfully.');
    }
    public function show($id)
{
    $order = Order::with([
        'school',
        'supervisor'
    ])->findOrFail($id);

    $headmaster = SystemUser::where('school_id',$order->school_id)
        ->where('role','headmaster')
        ->first();

    $teacherCount = SystemUser::where('school_id',$order->school_id)
        ->where('role','teacher')
        ->count();

    $studentCount = Student::where('school_id',$order->school_id)
        ->count();

    $today = Carbon::today();

    $inspectionDate = Carbon::parse(
        $order->inspection_date
    );

    $weeksRemaining = ceil(
        $today->diffInDays($inspectionDate,false) / 7
    );

    return view(
        'viewinfo',
        compact(
            'order',
            'headmaster',
            'teacherCount',
            'studentCount',
            'weeksRemaining'
        )
    );
}

    public function complete($id)
{
    $order = Order::findOrFail($id);

    $order->update([
        'status' => 'completed'
    ]);

    return back()->with(
        'success',
        'Inspection completed successfully'
    );
}

    public function index1() {
    $orders = Order::with(['supervisor', 'school'])->get();
    $supervisors = SystemUser::where('role', 'supervisor')->get();
    $schools = School::all();

    return view('viewWorks', compact('orders', 'supervisors', 'schools'));
}
}
