@extends('layout.app')

@section('content')
<div class="content mt-4">
    
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h5><i class="fa fa-filter"></i> Filter Syllabus Report</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/syllabus-report') }}" method="GET" class="row g-3">
                
                <div class="col-md-4">
                    <label class="form-label fw-bold">Select School:</label>
                    <select name="school_id" class="form-select" required>
                        <option value="">-- Choose School --</option>
                        @foreach(\DB::table('schools')->get() as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Select Class:</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Choose Class --</option>
                        @foreach(\DB::table('class_rooms')->get() as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Select Subject:</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">-- Choose Subject --</option>
                        @foreach(\DB::table('subjects')->get() as $sub)
                            <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->subjectName }} 
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4><i class="fa fa-book"></i> SYLLABUS COVERAGE REPORT</h4>
            <span class="badge bg-light text-dark p-2">Admin Panel</span>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Main Topic (Topic Name)</th>
                            <th width="15%" class="text-center">Total Sub-topics</th>
                            <th width="15%" class="text-center">Taught Sub-topics</th>
                            <th width="15%">Progress</th>
                            <th width="15%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topicsReport as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $report['topic_name'] }}</strong></td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $report['total_sub_topics'] }}</span></td>
                                <td class="text-center"><span class="badge bg-info text-dark">{{ $report['completed_sub_topics'] }}</span></td>
                                <td>
                                    <div class="progress" style="height: 22px;">
                                        <div class="progress-bar bg-{{ $report['badge_color'] }}" 
                                             role="progressbar" 
                                             style="width: {{ $report['progress'] }}%; font-weight: bold;" 
                                             aria-valuenow="{{ $report['progress'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ $report['progress'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $report['badge_color'] }} p-2 fs-6 text-uppercase" style="min-width: 110px; display: inline-block;">
                                        {{ $report['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fa fa-arrow-up fa-2x mb-2 text-primary animate-bounce"></i>
                                    <p class="mb-0 fw-bold">Please select School, Class, and Subject above, then click "Search" to view the report.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection