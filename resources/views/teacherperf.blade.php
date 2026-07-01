@extends('layout.app')

@section('content')
<div class="content mt-4">
    
    <!-- FILTER CARD -->
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h5><i class="fa fa-filter"></i> Filter Teacher Workbook Performance Report</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/teacher-workbook-report') }}" method="GET" class="row g-3">
                
                <div class="col-md-3">
                    <label class="form-label fw-bold">Select School:</label>
                    <select name="school_id" id="school_id" class="form-select" required>
                        <option value="">-- Choose School --</option>
                        @foreach(\DB::table('schools')->get() as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }} data-name="{{ $school->school_name }}">
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Select Class:</label>
                    <select name="class_id" id="class_id" class="form-select">
                        <option value="">-- All Classes --</option>
                        @foreach(\DB::table('class_rooms')->get() as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }} data-name="{{ $class->class_name }}">
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Start Date:</label>
                    <input type="date" name="start_date" class="form-select" value="{{ request('start_date') }}" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">End Date:</label>
                    <input type="date" name="end_date" class="form-select" value="{{ request('end_date') }}" required>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fa fa-search"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- REPORT DATA CARD -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4><i class="fa fa-user-md"></i> TEACHER WORKBOOK & LESSON PLAN PERFORMANCE REPORT</h4>
            <div>
                @if(request('start_date') && request('end_date') && count($teachersReport) > 0)
                    <button type="button" onclick="printReport()" class="btn btn-light btn-sm me-2 fw-bold text-primary">
                        <i class="fa fa-print"></i> Print Report
                    </button>
                @endif
                <span class="badge bg-light text-dark p-2">
                    @if(request('start_date') && request('end_date'))
                        Period: {{ request('start_date') }} to {{ request('end_date') }}
                    @else
                        Admin Panel
                    @endif
                </span>
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="reportTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Teacher Name</th>
                            <th width="25%">Subject & Class</th>
                            <th width="15%" class="text-center">Periods Taught (Workbook Logs)</th>
                            <th width="15%" class="text-center">Lesson Plans Prepared</th>
                            <th width="10%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachersReport as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $report['teacher_name'] }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary mb-1 d-inline-block">{{ $report['subject_name'] }}</span> <br>
                                    <small class="text-muted"><i class="fa fa-graduation-cap"></i> {{ $report['class_name'] }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark fs-6">{{ $report['total_periods_taught'] }} Logs</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary fs-6">{{ $report['total_lesson_plans'] }} Prepared</span>
                                </td>
                               
                                <td class="text-center">
                                    <span class="badge bg-{{ $report['badge_color'] }} p-2 fs-6 text-uppercase status-text" style="min-width: 110px; display: inline-block;">
                                        {{ $report['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fa fa-arrow-up fa-2x mb-2 text-primary animate-bounce"></i>
                                    <p class="mb-0 fw-bold">Please select School, Date Range, and click "Generate Report" to view teacher workbook performance.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
function formatDate(dateString) {
    if(!dateString) return '';
    const date = new Date(dateString);
    const options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };
    return date.toLocaleDateString('en-GB', options);
}

function printReport() {
    // Clone table context to adjust layout components explicitly for a print sheet safely
    const tableClone = document.getElementById("reportTable").cloneNode(true);
    
    // Replace bootstrap progress wrapper elements with straightforward text content values for clear paper outputs
    tableClone.querySelectorAll('.progress-container').forEach(container => {
        const pctValue = container.getAttribute('data-percentage');
        container.outerHTML = `<span>${pctValue}</span>`;
    });

    tableClone.querySelectorAll('.badge').forEach(badge => {
        if(!badge.classList.contains('status-text')) {
             badge.style.background = 'transparent';
             badge.style.color = '#000';
             badge.style.padding = '0';
        }
    });

    const printTableHTML = tableClone.outerHTML;

    
    const schoolSelect = document.getElementById('school_id');
    const selectedSchoolText = schoolSelect.options[schoolSelect.selectedIndex] ? schoolSelect.options[schoolSelect.selectedIndex].getAttribute('data-name') : 'ALL SCHOOLS';
    
    const classSelect = document.getElementById('class_id');
    const selectedClassText = classSelect.options[classSelect.selectedIndex] && classSelect.value !== "" ? classSelect.options[classSelect.selectedIndex].getAttribute('data-name') : 'ALL CLASSES';

    let start_date = formatDate(@json($startDate ?? request('start_date') ?? ''));
    let end_date = formatDate(@json($endDate ?? request('end_date') ?? ''));

   
    let parsedSchoolSlug = selectedSchoolText.replace(/[^a-zA-Z0-9]/g, "_");
    let fileName = `Teacher_Workbook_Report_${parsedSchoolSlug}.pdf`;

    const printWindow = window.open('', '', 'width=1000,height=800');

    printWindow.document.write(`
        <html>
        <head>
            <title>${fileName}</title>
            <style>
                @page { margin: 20mm 15mm 20mm 15mm; }
                body {
                    margin: 0;
                    background: white;
                    font-family: 'Times New Roman', Times, serif;
                    color: black;
                }
                h2, h4, h5 {
                    text-align: center;
                    margin: 4px 0;
                    line-height: 1.4;
                }
                h2 { font-size: 22px; text-transform: uppercase; font-weight: bold; }
                h4 { font-size: 16px; font-weight: bold; }
                h5 { font-size: 14px; font-weight: normal; }
                .meta-header {
                    margin-top: 15px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 15px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 13px;
                    margin-top: 15px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px 6px;
                    text-align: left;
                    vertical-align: middle;
                }
                th {
                    background-color: #f2f2f2 !important;
                    text-transform: uppercase;
                    font-weight: bold;
                    text-align: center;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                .text-center {
                    text-align: center;
                }
                tr:nth-child(even) {
                    background: #fafafa;
                }
                .status-text {
                    font-weight: bold;
                    text-transform: uppercase;
                }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            <h4>TEACHER WORKBOOK & LESSON PLAN PERFORMANCE REPORT</h4>
            
            <div class="meta-header">
                <h5><strong>School Branch:</strong> ${selectedSchoolText.toUpperCase()} | <strong>Class Target:</strong> ${selectedClassText.toUpperCase()}</h5>
                <h5>This performance report monitors log activity records compiled from <strong>${start_date}</strong> to <strong>${end_date}</strong></h5>
            </div>

            ${printTableHTML}
        </body>
        </html>
    `);

    printWindow.document.close();
}
</script>
@endsection