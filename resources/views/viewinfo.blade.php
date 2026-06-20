@extends('layout.app')

@section('content')

<div class="content">

<div class="table-container">

<div class="row">

    <!-- LEFT -->
    <div class="col-lg-4">

        <img src="{{ asset('images/school.png') }}"
             class="img-fluid rounded-4 shadow-sm w-100"
             style="height:350px;object-fit:cover;">

        <div class="card border-0 bg-light mt-3 rounded-4">
            <div class="card-body text-center">

                <i class="fas fa-school fa-3x text-primary mb-2"></i>

                <h5 class="fw-bold">
                    {{ $order->school->school_name }}
                </h5>

                <small class="text-muted">
                    Assigned School
                </small>

            </div>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="col-lg-8">

        <div class="d-flex justify-content-between mb-4">

            <div>
                <h2 class="fw-bold text-success">
                    {{ $order->school->school_name }}
                </h2>

                <small class="text-muted">
                    School Inspection Information
                </small>
            </div>

            <span class="badge bg-success fs-6">

                {{ ucfirst($order->status) }}

            </span>

        </div>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            School Name
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $order->school->school_name }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            District
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $order->school->district->district_name ?? 'N/A' }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            Headmaster
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $headmaster->firstname ?? 'N/A' }}
                            {{ $headmaster->lastname ?? '' }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            Phone Number
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $headmaster->email ?? 'N/A' }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            Total Teachers
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $teacherCount }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">

                        <small class="text-muted">
                            Total Students
                        </small>

                        <h5 class="fw-bold mt-2">
                            {{ $studentCount }}
                        </h5>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card bg-light border-0">
                    <div class="card-body">

                        <small class="text-muted">
                            Remaining Weeks To Inspection Date
                        </small>

                        <h3 class="fw-bold text-danger">
                            {{ $weeksRemaining }} Week(s)
                        </h3>

                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 bg-light mt-4">
            <div class="card-body">

                <h5>
                    Inspection Instruction
                </h5>

                <p>
                    {{ $order->instruction }}
                </p>

            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('orders.index') }}"
               class="btn btn-dark">

                Back

            </a>
        </div>

    </div>

</div>

</div>

</div>

@endsection