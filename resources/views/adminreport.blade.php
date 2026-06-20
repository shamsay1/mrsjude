@extends('layout.app')

@section('content')
<div class="content mt-4">
    <div class="table-container">
        
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5><i class="fa fa-filter"></i> Filter Supervisor Reports by School</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('/admin/supervisor-reports') }}" method="GET" class="row g-3">
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Select Specific School:</label>
                        <select name="school_id" class="form-select">
                            <option value="">-- All Schools Reports --</option>
                            @foreach(\DB::table('schools')->get() as $school)
                                <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100 py-2">
                            <i class="fa fa-search"></i> Load Reports
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4><i class="fa fa-file-alt"></i> PROGRESS REPORTS FROM SUPERVISORS</h4>
                <span class="badge bg-light text-dark p-2">Total Reports: {{ $reports->count() }}</span>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Supervisor</th>
                                <th>School</th>
                                <th>Classroom</th>
                                <th>Report Type</th>
                                <th class="text-center">Average (Avg %)</th>
                                <th class="text-center">Pass Rate (%)</th>
                                <th class="text-center">Students (T/P/F)</th>
                                <th>Date</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $report->supervisor_name }}</strong></td>
                                    <td>{{ $report->school_name }}</td>
                                    <td><span class="badge bg-secondary">{{ $report->class_name }}</span></td>
                                    <td>{{ $report->report_type ?? 'N/A' }}</td>
                                    <td class="text-center fw-bold text-primary">{{ $report->average_score }}%</td>
                                    <td class="text-center fw-bold text-success">{{ $report->pass_rate }}%</td>
                                    <td class="text-center">
                                        <small class="d-block text-muted">Total: <strong>{{ $report->total_students }}</strong></small>
                                        <span class="badge bg-success">PASS: {{ $report->passed_students }}</span>
                                        <span class="badge bg-danger">FAIL: {{ $report->failed_students }}</span>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($report->report_date)) }}</td>
                                    <td>{{ $report->comments ?? 'No comments provided.' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-5">
                                        <i class="fa fa-folder-open fa-3x mb-3 text-muted"></i>
                                        <p class="mb-0 fw-bold">No supervisor reports have been submitted or found at the moment.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection