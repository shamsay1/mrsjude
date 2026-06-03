@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addStudentModal">

            + Add Student

        </button>

        <!-- Add Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">
                            Add Student
                        </h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('student.store') }}"
                        method="POST">

                        @csrf

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-4 mb-3">

                                    <label>First Name</label>

                                    <input type="text"
                                        name="firstname"
                                        class="form-control">

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>Middle Name</label>

                                    <input type="text"
                                        name="middlename"
                                        class="form-control">

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>Last Name</label>

                                    <input type="text"
                                        name="lastname"
                                        class="form-control">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label>Gender</label>

                                    <select name="gender"
                                        class="form-control">

                                        <option value="">
                                            Select Gender
                                        </option>

                                        <option value="Male">
                                            Male
                                        </option>

                                        <option value="Female">
                                            Female
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>Class</label>

                                    <select name="class_id"
                                        class="form-control">

                                        <option value="">
                                            Select Class
                                        </option>

                                        @foreach($classes as $class)

                                            <option value="{{ $class->id }}">
                                                {{ $class->class_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save Student
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <!-- Table -->
        <table class="table table-sm table-hover">

            <thead class="table-dark">

                <tr>

                    <th>S/N</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Class</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($students as $index => $student)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $student->firstname }}</td>

                        <td>{{ $student->middlename }}</td>

                        <td>{{ $student->lastname }}</td>

                        <td>{{ $student->gender }}</td>

                        <td>{{ $student->classRoom->class_name ?? '' }}</td>

                        <td>

                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editStudentModal{{ $student->id }}">

                                Edit

                            </button>

                            <form action="{{ route('student.destroy',$student->id) }}"
                                method="POST"
                                style="display:inline-block">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this student?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade"
                        id="editStudentModal{{ $student->id }}">

                        <div class="modal-dialog modal-lg">

                            <div class="modal-content">

                                <div class="modal-header bg-primary text-white">

                                    <h5>Edit Student</h5>

                                    <button class="btn-close"
                                        data-bs-dismiss="modal"></button>

                                </div>

                                <form action="{{ route('student.update',$student->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-4 mb-3">

                                                <label>First Name</label>

                                                <input type="text"
                                                    name="firstname"
                                                    value="{{ $student->firstname }}"
                                                    class="form-control">

                                            </div>

                                            <div class="col-md-4 mb-3">

                                                <label>Middle Name</label>

                                                <input type="text"
                                                    name="middlename"
                                                    value="{{ $student->middlename }}"
                                                    class="form-control">

                                            </div>

                                            <div class="col-md-4 mb-3">

                                                <label>Last Name</label>

                                                <input type="text"
                                                    name="lastname"
                                                    value="{{ $student->lastname }}"
                                                    class="form-control">

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 mb-3">

                                                <label>Gender</label>

                                                <select name="gender"
                                                    class="form-control">

                                                    <option value="Male"
                                                        {{ $student->gender == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>

                                                    <option value="Female"
                                                        {{ $student->gender == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>

                                                </select>

                                            </div>

                                            <div class="col-md-6 mb-3">

                                                <label>Class</label>

                                                <select name="class_id"
                                                    class="form-control">

                                                    @foreach($classes as $class)

                                                        <option value="{{ $class->id }}"
                                                            {{ $student->class_id == $class->id ? 'selected' : '' }}>

                                                            {{ $class->class_name }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button class="btn btn-success">
                                            Update
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            No Record Found
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@if(session('success') || session('error'))

<div class="modal fade" id="successModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content text-center">

            @if(session('success'))

                <div class="modal-body p-5">

                    <i class="fas fa-check-circle text-success"
                       style="font-size:80px;"></i>

                    <h3 class="mt-3 text-success">
                        Success
                    </h3>

                    <p style="color:green">
                        {{ session('success') }}
                    </p>

                    <button type="button"
                            class="btn btn-success"
                            data-bs-dismiss="modal">
                        OK
                    </button>

                </div>

            @endif

            @if(session('error') || $errors->any())

<div class="modal-body p-5">

    <i class="fas fa-times-circle text-danger"
       style="font-size:80px;"></i>

    <h3 class="mt-3 text-danger">
        Failed
    </h3>

    @if(session('error'))
        <p style="color:red">
            {{ session('error') }}
        </p>
    @endif

    @if($errors->any())
        <ul class="text-danger text-start">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <button type="button"
            class="btn btn-danger"
            data-bs-dismiss="modal">
        OK
    </button>

</div>

@endif

        </div>

    </div>

</div>

@endif
@if(session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    let modal = new bootstrap.Modal(
        document.getElementById('successModal')
    );
    modal.show();
});
</script>
@endif
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection