@extends("layout.app")

<style>
    .flash-message {
        background-color: #d1e7dd; /* Light green background */
        border-color: #badbcc; /* Darker green border */
        color: #0f5132; /* Dark green text */
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-in-out;
    }

    .flash-message .alert-heading {
        color: #0f5132;
        font-weight: bold;
    }

    .flash-message .btn-close {
        color: #0f5132;
        opacity: 0.8;
    }

    .flash-message .bi-check-circle-fill {
        font-size: 1.5rem;
        color: #28a745; 
    }
</style>

@section("content")

<div class="content" id="content">

    <div class="five-cols">

        @if(Auth::user()->role == "admin")

            <div class="card-custom">
                <div class="card-title">Total Schools</div>
                <div class="card-value">{{ $total_school }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">District Officers</div>
                <div class="card-value">{{ $total_district }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Total Teachers</div>
                <div class="card-value">{{ $total_teachers }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Head Masters</div>
                <div class="card-value">{{ $total_headmaster }}</div>
            </div>

        @elseif(Auth::user()->role == "d_officer")

            <div class="card-custom">
                <div class="card-title">Total Schools</div>
                <div class="card-value">{{ $total_school }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Total Teachers</div>
                <div class="card-value">{{ $total_teachers }}</div>
            </div>

        @elseif(Auth::user()->role == "supervisor")

            <div class="card-custom">
                <div class="card-title">Total Orders</div>
                <div class="card-value">{{ $total_orders }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Completed Orders</div>
                <div class="card-value text-success">{{ $completed_orders }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Incomplete Orders</div>
                <div class="card-value text-danger">{{ $incomplete_orders }}</div>
            </div>

        @elseif(Auth::user()->role == "teacher")

            <div class="card-custom">
                <div class="card-title">My Subjects</div>
                <div class="card-value">{{ $teacher_subjects_count }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">My Classes</div>
                <div class="card-value">{{ $teacher_classes_count }}</div>
            </div>

        @else

            <div class="card-custom">
                <div class="card-title">Total Teachers</div>
                <div class="card-value">{{ $total_school_teachers }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Total Students</div>
                <div class="card-value">{{ $total_school_students }}</div>
            </div>

            <div class="card-custom">
                <div class="card-title">Total Classes</div>
                <div class="card-value">{{ $total_school_class }}</div>
            </div>

        @endif

    </div>

    <div class="row mt-4">

        @if(Auth::user()->role == "admin")

            <div class="col-md-8">
                <div class="table-container">
                    <div style="width:100%; max-width:900px; margin:auto;">
                        <canvas id="schoolChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="table-container">
                    <h3 style="font-family:'Times New Roman', Times, serif; font-size:14px; text-align:center;">
                        SCHOOL PER DISTRICT
                    </h3>
                    <canvas id="districtPieChart"></canvas>
                </div>
            </div>

        @else

            <div class="col-md-12">
                <div class="alert alert-dismissible fade show flash-message mt-1"
                     role="alert"
                     style="background-color:white;">

                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>

                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-1">Staff Information</h6>

                            <p class="mb-0 text-success">
                                Welcome Mr/Mrs:
                                {{ Auth::user()->firstname }}
                                {{ Auth::user()->middlename }}
                                {{ Auth::user()->lastname }}
                                (Role: {{ ucfirst(Auth::user()->role) }})
                            </p>
                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>
                    </div>

                </div>
            </div>

        @endif

    </div>

    <div class="row mt-1">
        <div class="col-md-12">
            <div class="table-container p-3">

                @if(Auth::user()->role == "supervisor")
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-tasks me-2"></i>
                            Recent Orders Assigned
                        </h5>
                    </div>

                    <div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>School Name</th>
                <th>Instruction</th>
                <th>Inspection Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><strong>{{ $order->school_name }}</strong></td>
                    <td>{{ Str::limit($order->instruction, 50) }}</td>
                    <td>{{ isset($order->inspection_date) ? date('d M Y', strtotime($order->inspection_date)) : 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

                @elseif(Auth::user()->role == "teacher")

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-history me-2"></i>
                            My Recent Activities / Recordings
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task/Concept Description</th>
                                    <th>Period Log Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teacher_recent_logs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $log->content_covered ?? 'Workbook Entry Record Registered' }}</td>
                                        <td>{{ isset($log->date) ? date('d M Y', strtotime($log->date)) : 'N/A' }}</td>
                                        <td><span class="badge bg-success">Recorded</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No recent workbook logs created yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @else
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-users me-2"></i>
                            All loggings activity
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP ADDRESS</th>
                                    <th>Platform</th>
                                </tr>
                            </thead>


                            <tbody>
                                 @foreach ($activities as $a)
                                 <tr>
                                    <td>{{ $a->module }}</td>
                                    <td>{{ $a->action }}</td>
                                    <td>{{ $a->description }}</td>
                                    <td>{{ $a->ip_address }}</td>
                                    <td>{{ $a->platform }}</td>
                                 </tr>
                                 
                                     
                                 @endforeach
                                 <tr>
                                    <td colspan="100%" style="text-align: center"><a href="{{ route('all_logs') }}">View all</a></td>
                                 </tr>
                            </tbody>
                            
                        </table>
                    </div>

                @endif

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(Auth::user()->role == "admin")
const schoolNames = @json($schoolNames);
const teacherCounts = @json($teacherCounts);
const barctx = document.getElementById('schoolChart');

new Chart(barctx, {
    type: 'bar',
    data: {
        labels: schoolNames,
        datasets: [{
            label: 'Number of Teachers',
            data: teacherCounts,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: 'Teachers in Each School' }
        },
        scales: { y: { beginAtZero: true } }
    }
});

const districtNames = @json($districtNames);
const schoolCounts = @json($schoolCounts);
const piectx = document.getElementById('districtPieChart');

new Chart(piectx, {
    type: 'pie',
    data: {
        labels: districtNames,
        datasets: [{
            label: 'Schools Per District',
            data: schoolCounts,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            title: { display: true, text: 'Schools Per District' }
        }
    }
});
@endif
</script>
{{-- <script>
setInterval(function(){
    fetch("{{ route('dashboard.table') }}")
    .then(response => response.text())
    .then(data => {
        document.getElementById("recent-data-table").innerHTML = data;
    })
    .catch(error => console.log('Error refreshing data table:', error));
}, 300);
</script> --}}

@endsection