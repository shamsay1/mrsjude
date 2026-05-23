@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add User Button -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addUserModal">

            + Add User

        </button>

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
                                        class="form-control">

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">

                                    <label>Role</label>

                                    <select name="role"
                                        class="form-control">

                                        <option value="">Select Role</option>

                                            <option value="d_officer">District Officer</option>
                                            <option value="teacher">Teacher</option>

                                    </select>

                                </div>
                                <div class="col-md-4 mb-3">

                                    <label>District</label>

                                    <select name="district_id"
                                        class="form-control">

                                        <option value="">Select District</option>

                                        @foreach ($districts as $district)

                                            <option value="{{ $district->id }}">
                                                {{ $district->district_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>School</label>

                                    <select name="school_id"
                                        class="form-control">

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
        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">

                <tr>

                    <th>S/N</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>District</th>
                    <th>School</th>
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

                        <td>{{ $user->district->district_name ?? 'N/A' }}</td>

                        <td>{{ $user->school->school_name ?? 'N/A' }}</td>

                        <td>

                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- Delete -->
                            <form action="{{ route('system-user.destroy', $user->id) }}"
                                method="POST"
                                style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this user?')">

                                    Delete

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
                        <td colspan="7">No Record Found</td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection