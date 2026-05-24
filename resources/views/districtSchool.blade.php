@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">
       @foreach ($districts as $district)

    <h4 class="mt-4 mb-3 text-primary">
        {{ $district->district_name }}
    </h4>

    <div class="row">

        @forelse ($district->schools as $school)

            <div class="col-md-3 mb-3">

                <a href="{{ route('school.teachers', $school->id) }}"
                   style="text-decoration:none;">

                    <div class="card school-card shadow-sm">

                        <div class="card-body text-center">

                            <i class="bi bi-building fs-1 text-primary"></i>

                            <h6 class="mt-2">
                                {{ $school->school_name }}
                            </h6>

                            <small style="color: blue;">
                                Click to view teachers
                            </small>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <p class="text-muted">No schools in this district</p>

        @endforelse

    </div>

    <hr>

@endforeach

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection