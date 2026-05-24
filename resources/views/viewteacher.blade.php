@extends("layout.app")

@section("content")

<div class="content" id="content">

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

                    <a href=""
                       class="btn btn-sm btn-info">

                        View Scheme of work

                    </a>

                </td>
                <td>

                    <a href="{{ route('teacher.daily-records', $teacher->id) }}"
                       class="btn btn-sm btn-primary">

                        View assesment book

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