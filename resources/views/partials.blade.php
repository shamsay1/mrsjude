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
                <td>{{ $users->firstItem() + $index }}</td> <!-- Hii inafanya namba zifuate mtiririko hata kwenye page ya 2, 3 nk. -->
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
                    <span class="badge bg-info text-dark">
                        {{ $user->role }}
                    </span>
                </td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>

                    <!-- Supervisor Action -->
                    @if($user->role == 'supervisor')
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#assignOrderModal{{ $user->id }}">
                            <i class="bi bi-clipboard-check"></i> Assign Order
                        </button>

                        <!-- Assign Order Modal -->
                        <div class="modal fade" id="assignOrderModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Assign Inspection Order to {{ $user->firstname }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('orders.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="supervisor_id" value="{{ $user->id }}">

                                            <div class="mb-3">
                                                <label class="form-label">School</label>
                                                <select name="school_id" class="form-select" required>
                                                    <option value="">Select School</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Inspection Date</label>
                                                <input type="date" name="inspection_date" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Instruction</label>
                                                <textarea name="instruction" rows="4" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-warning">Assign Order</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Toggle Status Form -->
                    <form action="{{ route('system-user.toggle-status', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm {{ $user->status == 'Active' ? 'btn-danger' : 'btn-success' }}" 
                                onclick="return confirm('Are you sure you want to {{ $user->status == 'Active' ? 'deactivate' : 'activate' }} this user?')">
                            {{ $user->status == 'Active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Edit User - {{ $user->firstname }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('system-user.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Middle Name</label>
                                                <input type="text" name="middlename" value="{{ $user->middlename }}" class="form-control">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Gender</label>
                                                <select name="gender" class="form-select">
                                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Leave blank if no change">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">District</label>
                                                <select name="district_id" class="form-select">
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}" {{ $user->district_id == $district->id ? 'selected' : '' }}>
                                                            {{ $district->district_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">School</label>
                                                <select name="school_id" class="form-select">
                                                    <option value="">N/A</option>
                                                    @foreach ($schools as $school)
                                                        <option value="{{ $school->id }}" {{ $user->school_id == $school->id ? 'selected' : '' }}>
                                                            {{ $school->school_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="text-center p-4">No Record Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3" id="paginationLinks">
    {{ $users->links() }}
</div>