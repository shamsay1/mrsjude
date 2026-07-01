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
                    <select name="school_id" id="school_id" class="form-select" required>
                        <option value="">-- Choose School --</option>
                        @foreach(\DB::table('schools')->get() as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }} data-name="{{ $school->school_name }}">
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Select Class:</label>
                    <select name="class_id" id="class_id" class="form-select" required>
                        <option value="">-- Choose Class --</option>
                        @foreach(\DB::table('class_rooms')->get() as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }} data-name="{{ $class->class_name }}">
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Select Subject:</label>
                    <select name="subject_id" id="subject_id" class="form-select" required>
                        <option value="">-- Choose Subject --</option>
                        @foreach(\DB::table('subjects')->get() as $sub)
                            <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }} data-name="{{ $sub->subjectName }}">
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
            <div>
                @if(isset($topicsReport) && count($topicsReport) > 0)
                    <button type="button" onclick="printReport()" class="btn btn-light btn-sm fw-bold text-primary me-2">
                        <i class="fa fa-print"></i> Print Report
                    </button>
                @endif
                <span class="badge bg-light text-dark p-2">Admin Panel</span>
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="syllabusTable">
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
                                <td class="text-center">
                                    <span class="badge bg-secondary badge-data">{{ $report['total_sub_topics'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark badge-data">{{ $report['completed_sub_topics'] }}</span>
                                </td>
                                <td>
                                    <div class="progress-wrapper" data-value="{{ $report['progress'] }}%">
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
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $report['badge_color'] }} p-2 fs-6 text-uppercase status-badge" style="min-width: 110px; display: inline-block;">
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

<script>
function printReport() {
    // Clone original DOM table safely to transform UI components into print-optimized structures
    const rawTableClone = document.getElementById("syllabusTable").cloneNode(true);
    
    // Convert interactive bootstrap multi-layered progress bars into standard tabular plain text metrics
    rawTableClone.querySelectorAll('.progress-wrapper').forEach(wrapper => {
        const structuralPctValue = wrapper.getAttribute('data-value');
        wrapper.outerHTML = `<span style="font-weight: bold;">${structuralPctValue}</span>`;
    });

    // Clean inline styling wrappers on non-status text components so they display cleanly on white paper sheets
    rawTableClone.querySelectorAll('.badge-data').forEach(badge => {
        badge.style.background = 'transparent';
        badge.style.color = '#000';
        badge.style.padding = '0';
        badge.style.fontSize = '14px';
    });

    const parsedTableHTML = rawTableClone.outerHTML;

    // Grab chosen dynamic descriptive drop-down options cleanly 
    const schoolSelect = document.getElementById('school_id');
    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');

    const schoolText = schoolSelect.options[schoolSelect.selectedIndex] ? schoolSelect.options[schoolSelect.selectedIndex].getAttribute('data-name') : 'ALL SCHOOLS';
    const classText = classSelect.options[classSelect.selectedIndex] ? classSelect.options[classSelect.selectedIndex].getAttribute('data-name') : 'ALL CLASSES';
    const subjectText = subjectSelect.options[subjectSelect.selectedIndex] ? subjectSelect.options[subjectSelect.selectedIndex].getAttribute('data-name') : 'ALL SUBJECTS';

    // Establish print file document download titles safely
    let parsedSubjectSlug = subjectText.replace(/[^a-zA-Z0-9]/g, "_");
    let targetFileName = `Syllabus_Coverage_Report_${parsedSubjectSlug}.pdf`;

    const printWindow = window.open('', '', 'width=1000,height=800');

    printWindow.document.write(`
        <html>
        <head>
            <title>${targetFileName}</title>
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
                h2 { font-size: 20px; text-transform: uppercase; font-weight: bold; }
                h4 { font-size: 16px; font-weight: bold; margin-top: 5px; }
                h5 { font-size: 13px; font-weight: normal; }
                .meta-summary {
                    margin-top: 15px;
                    border-bottom: 2px solid #000;
                    padding-bottom: 8px;
                    margin-bottom: 15px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 13px;
                    margin-top: 10px;
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
                .status-badge {
                    font-weight: bold;
                    text-transform: uppercase;
                }
            </style>
        </head>
        <body onload="window.print(); window.close();">
           
            <h4>SYLLABUS COVERAGE REPORT</h4>
            
            <div class="meta-summary">
                <h5><strong>Institution/School:</strong> ${schoolText.toUpperCase()}</h5>
                <h5><strong>Class Level:</strong> ${classText.toUpperCase()} | <strong>Target Subject Module:</strong> ${subjectText.toUpperCase()}</h5>
            </div>

            ${parsedTableHTML}
        </body>
        </html>
    `);

    printWindow.document.close();
}
</script>
@endsection