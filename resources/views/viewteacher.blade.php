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
<div class="col-md-12">
                <div class="alert alert-dismissible fade show flash-message mt-1"
                     role="alert"
                     style="background-color:white;">

                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>

                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-1">Teachers Workbooks Information</h6>

                            <p class="mb-0 text-success">
                                School Name: {{ $school->school_name ?? 'N/A' }}
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
    <div class="table-container">

        <!-- Table -->
        {{-- <h2 style="color: green;text-align: center;font-family: 'Times New Roman', Times, serif">All Teachers from {{ $school->school_name }}</h2> --}}
        
        <table class="table table-sm table-hover">

    <thead class="bg-secondary text-white">

        <tr>
            <th>S/N</th>
            <th>Teacher's Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Lesson Plan</th>
            <th>Daily Record</th>
            <th>Schemes of work</th>
            <th>Assement book</th>
        </tr>

    </thead>

    <tbody>

        @forelse ($teachers as $index => $teacher)

            <tr>

                <td>{{ $index + 1 }}</td>

                <td>
                    {{ $teacher->firstname }}
                    {{ $teacher->middlename }}
                    {{ $teacher->lastname }}
                </td>

                <td>{{ $teacher->email }}</td>

                <td>{{ $teacher->gender }}</td>

                <td>

                   <a href="{{ route('teacher.lesson-plans1', $teacher->id) }}"
   class="btn btn-sm btn-primary">

    View Lesson Plan

</a>

                </td>

                <td>

                    <a href="{{ route('teacher.daily-records', $teacher->id) }}"
                       class="btn btn-sm btn-success">

                        View Daily Record

                    </a>

                </td>
                <td>

                    <a href="{{ route('scheme.index1', $teacher->id) }}"
                    class="btn btn-sm btn-info">
                        View Scheme of Work
                    </a>

                </td>
                <td>

                    <a href="{{ route('teacher.assessment.book', $teacher->id) }}"
                    class="btn btn-sm btn-primary">

                        View Assessment Book

                    </a>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6" style="text-align:center;">
                    No Record Found
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection