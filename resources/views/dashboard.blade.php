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

    <!-- Cards -->
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
            <div class="card-title">Head masters</div>
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
        @endif
        
       

        

    </div>

    <!-- Table -->
    
   <div>
    
    <div class="row">

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
            <h3 style="font-family: 'Times New Roman', Times, serif;font-size: 14px;text-align: center">SCHOOL PER DISTRICT</h3>
            
            <canvas id="districtPieChart"></canvas>
        
        </div>
    </div>
    @else
    <div class="col-md-12 p-3">
    <div class="alert alert-dismissible fade show flash-message mt-3" role="alert" style="background-color: white">
  <div class="d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2"></i> <div class="flex-grow-1">
      <h6 class="alert-heading mb-1">Staff Information</h6>
      <p class="mb-0" style="color: green">Welcome Mr/Mrs: {{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  </div>
</div>
    @endif

</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="table-container" style="height: 600px;width: 100%">
            <canvas id="paymentsLineChart" style="width: 100%"></canvas>
        </div>
    </div>
</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

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
            legend: {
                display: true
            },

            title: {
                display: true,
                text: 'Teachers in Each School'
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>
<script>

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

            legend: {
                position: 'bottom'
            },

            title: {
                display: true,
                text: 'Schools Per District'
            }
        }
    }
});

</script>
@endsection