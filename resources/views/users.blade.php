@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add User Button -->
        @if (Auth::user()->role == "admin")
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addUserModal">
            + Add User
        </button>
        @elseif (Auth::user()->role == "headmaster")
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addUserModal">
            + Add New Teacher
        </button>
        @endif

        <!-- Add Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1">

            <div class="modal-dialog modal-xl">

                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">Add User</h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('system-user.store') }}"
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

                                <div class="col-md-4 mb-3">

                                    <label>Email</label>

                                    <input type="email"
                                        name="email"
                                        class="form-control">

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>Gender</label>

                                    <select name="gender"
                                        class="form-control">

                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>

                                    </select>

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>Password</label>

                                    <input type="password"
                                        name="password"
                                        value="12345"
                                        class="form-control">

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">

                                    <label>Role</label>

                                    <select name="role"
        id="role"
        class="form-control">

    <option value="">Select Role</option>
        @if (Auth::user()->role == "admin")

    <option value="supervisor">Supervisor</option>
    <option value="headmaster">Head Master</option>
     @else
    <option value="teacher">Teacher</option>
    @endif

</select>

                                </div>
                            

                                <div class="col-md-6 mb-3" id="schoolField" style="display:none;">

    <label>School</label>

    <select name="school_id" class="form-control">

        <option value="">Select School</option>

        @foreach ($schools as $school)

            <option value="{{ $school->id }}">
                {{ $school->school_name }}
            </option>

        @endforeach

    </select>

</div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save User
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <!-- Table -->
        @if(Auth::user()->role!="headmaster")
        <form method="GET" action="{{ route('system-user.index') }}">

    <div class="row mb-3">

        <!-- ROLE -->
        <div class="col-md-3">

            <label>Filter By Role</label>

            <select name="role" class="form-control">

                <option value="">All Roles</option>

                <option value="teacher"
                    {{ request('role') == 'teacher' ? 'selected' : '' }}>

                    Teacher

                </option>

                <option value="headmaster"
                    {{ request('role') == 'headmaster' ? 'selected' : '' }}>

                    Headmaster

                </option>
                <option value="supervisor"
                    {{ request('role') == 'supervisor' ? 'selected' : '' }}>

                    Supervisor

                </option>

            </select>

        </div>

        <!-- DISTRICT -->
        @if(Auth::user()->role == "admin")
        <div class="col-md-3">

            <label>Filter By District</label>

            <select name="district_id" class="form-control">

                <option value="">All Districts</option>

                @foreach($districts as $district)

                    <option value="{{ $district->id }}"
                        {{ request('district_id') == $district->id ? 'selected' : '' }}>

                        {{ $district->district_name }}

                    </option>

                @endforeach

            </select>

        </div>
        @endif

        <!-- SCHOOL -->
        <div class="col-md-3">

            <label>Filter By School</label>

            <select name="school_id" class="form-control">

                <option value="">All Schools</option>

                @foreach($schools as $school)

                    <option value="{{ $school->id }}"
                        {{ request('school_id') == $school->id ? 'selected' : '' }}>

                        {{ $school->school_name }}

                    </option>

                @endforeach

            </select>

        </div>
        <div class="col-md-3">
            <br>
            <button class="btn btn-primary">
        Filter
    </button>

    <a href="{{ route('system-user.index') }}"
        class="btn btn-secondary">

        Reset

    </a>
        </div>

    </div>

    

</form>
@endif
    @if(Auth::user()->role=="headmaster")
      <h2 style="color: green;font-family: 'Times New Roman', Times, serif">Teachers Information</h2>
      <hr>
      @endif
        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">

                <tr>

                    <th>S/N</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>School</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($users as $index => $user)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            {{ $user->firstname }}
                            {{ $user->middlename }}
                            {{ $user->lastname }}
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>{{ $user->gender }}</td>

                        <td>{{ $user->school->school_name ?? 'N/A' }}</td>
                        <td>
                            @if($user->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Deactive</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td>

                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>
                            @if($user->role == 'supervisor')

<button class="btn btn-sm btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#assignOrderModal{{ $user->id }}">
    <i class="bi bi-clipboard-check"></i>
</button>

<!-- Assign Order Modal -->
<div class="modal fade" id="assignOrderModal{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-warning text-dark">
                <h5>Assign Inspection Order</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <input type="hidden"
                           name="supervisor_id"
                           value="{{ $user->id }}">

                    <div class="mb-3">
                        <label>School</label>
                        <select name="school_id"
                                class="form-control"
                                required>

                            <option value="">Select School</option>

                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">
                                    {{ $school->school_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Inspection Date</label>
                        <input type="date"
                               name="inspection_date"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Instruction</label>
                        <textarea name="instruction"
                                  rows="4"
                                  class="form-control"
                                  required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning">
                        Assign Order
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endif

                            <!-- Delete -->
                            <form action="{{ route('system-user.toggle-status', $user->id) }}"
      method="POST"
      style="display:inline-block;">

    @csrf
    @method('PATCH')

    <button
        class="btn btn-sm {{ $user->status == 'Active' ? 'btn-danger' : 'btn-success' }}"
        onclick="return confirm('Are you sure you want to {{ $user->status == 'Active' ? 'deactivate' : 'activate' }} this user?')">

        {{ $user->status == 'Active' ? 'Deactivate' : 'Activate' }}

    </button>

</form>

                            <!-- Edit Modal -->
                            <div class="modal fade"
                                id="editUserModal{{ $user->id }}">

                                <div class="modal-dialog modal-xl">

                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">

                                            <h5>Edit User</h5>

                                            <button class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('system-user.update', $user->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-md-4 mb-3">

                                                        <label>First Name</label>

                                                        <input type="text"
                                                            name="firstname"
                                                            value="{{ $user->firstname }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-4 mb-3">

                                                        <label>Middle Name</label>

                                                        <input type="text"
                                                            name="middlename"
                                                            value="{{ $user->middlename }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-4 mb-3">

                                                        <label>Last Name</label>

                                                        <input type="text"
                                                            name="lastname"
                                                            value="{{ $user->lastname }}"
                                                            class="form-control">

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4 mb-3">

                                                        <label>Email</label>

                                                        <input type="email"
                                                            name="email"
                                                            value="{{ $user->email }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-4 mb-3">

                                                        <label>Gender</label>

                                                        <select name="gender"
                                                            class="form-control">

                                                            <option value="Male"
                                                                {{ $user->gender == 'Male' ? 'selected' : '' }}>

                                                                Male

                                                            </option>

                                                            <option value="Female"
                                                                {{ $user->gender == 'Female' ? 'selected' : '' }}>

                                                                Female

                                                            </option>

                                                        </select>

                                                    </div>

                                                    <div class="col-md-4 mb-3">

                                                        <label>Password</label>

                                                        <input type="password"
                                                            name="password"
                                                            class="form-control"
                                                            placeholder="Leave blank if no change">

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>District</label>

                                                        <select name="district_id"
                                                            class="form-control">

                                                            @foreach ($districts as $district)

                                                                <option value="{{ $district->id }}"
                                                                    {{ $user->district_id == $district->id ? 'selected' : '' }}>

                                                                    {{ $district->district_name }}

                                                                </option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-md-6 mb-3">

                                                        <label>School</label>

                                                        <select name="school_id"
                                                            class="form-control">

                                                            @foreach ($schools as $school)

                                                                <option value="{{ $school->id }}"
                                                                    {{ $user->school_id == $school->id ? 'selected' : '' }}>

                                                                    {{ $school->school_name }}

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

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="100%" style="text-align: center">No Record Found</td>
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
<script>
document.addEventListener('DOMContentLoaded', function () {

    const role = document.getElementById('role');
    const schoolField = document.getElementById('schoolField');

    function toggleSchoolField() {

        if (role.value === 'headmaster') {
            schoolField.style.display = 'block';
        } else {
            schoolField.style.display = 'none';
        }

    }

    role.addEventListener('change', toggleSchoolField);

    toggleSchoolField();

});
</script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection