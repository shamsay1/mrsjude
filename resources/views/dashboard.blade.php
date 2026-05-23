@extends("layout.app")

@section("content")

<div class="content" id="content">

    <!-- Cards -->
    <div class="five-cols">

        <div class="card-custom">
            <div class="card-title">Total Guest</div>
            <div class="card-value">7</div>
        </div>

        <div class="card-custom">
            <div class="card-title">Available Rooms</div>
            <div class="card-value">8</div>
        </div>

        <div class="card-custom">
            <div class="card-title">Rooms Used</div>
            <div class="card-value">6</div>
        </div>
        
     
        <div class="card-custom">
            <div class="card-title">Receptionist</div>
            <div class="card-value">8</div>
        </div>
        <div class="card-custom">
            <div class="card-title">Total Revenue</div>
            <div class="card-value">0 TZS</div>
        </div>
        
       

        

    </div>

    <!-- Table -->
    
   <div>
    
    <div class="row">

    <!-- BAR GRAPH (col-8) -->
    <div class="col-md-8">
        <div class="table-container">
            <canvas id="reservationsChart"></canvas>
        </div>
    </div>

    <!-- PIE CHART (col-4) -->
    <div class="col-md-4">
        <div class="table-container">
            <h3 style="font-family: 'Times New Roman', Times, serif;font-size: 14px;text-align: center">ROOM USAGE STATUS</h3>
            <canvas id="roomsPieChart"></canvas>
        </div>
    </div>

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

{{-- <script>
const lineLabels = @json($lineDates);
const lineData = @json($lineData);

const ctxLine = document.getElementById('paymentsLineChart').getContext('2d');


const gradient = ctxLine.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(54, 162, 235, 0.6)');
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.05)');

new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: lineLabels,
        datasets: [{
            label: 'Payments (Last 30 Days)',
            data: lineData,
            fill: true,
            backgroundColor: gradient,
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 3,
            tension: 0.4, // smooth curve
            pointRadius: 0, // ❌ hakuna dots
            pointHoverRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- <script>
const barLabels = @json($dates);
const barData = @json($counts);

new Chart(document.getElementById('reservationsChart'), {
    type: 'bar',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Reservations (Last 7 Days)',
            data: barData,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});


/* =========================
   PIE CHART
========================= */
const pieLabels = @json($pieLabels);
const pieData = @json($pieData);

new Chart(document.getElementById('roomsPieChart'), {
    type: 'pie',
    data: {
        labels: pieLabels,
        datasets: [{
            data: pieData,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
</script> --}}
@endsection