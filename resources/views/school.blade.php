@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add School Button -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addSchoolModal">

            + Add School
        </button>

        <!-- Add Modal -->
        <div class="modal fade" id="addSchoolModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">Add School</h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('school.store') }}" method="POST">

                        @csrf

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label>School Name</label>

                                    <input type="text"
                                        name="school_name"
                                        class="form-control"
                                        placeholder="Enter school name">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>School Code</label>

                                    <input type="text"
                                        name="school_code"
                                        class="form-control"
                                        placeholder="Enter school code">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12 mb-3">

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

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save School
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
                    <th>School Name</th>
                    <th>School Code</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($schools as $index => $school)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $school->school_name }}</td>

                        <td>{{ $school->school_code }}</td>

                        <td>{{ $school->district->district_name }}</td>

                        <td>

                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editSchoolModal{{ $school->id }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- Delete -->
                            <form action="{{ route('school.destroy', $school->id) }}"
                                method="POST"
                                style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this school?')">

                                    Delete

                                </button>

                            </form>

                            <!-- Edit Modal -->
                            <div class="modal fade"
                                id="editSchoolModal{{ $school->id }}">

                                <div class="modal-dialog modal-lg">

                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">

                                            <h5>Edit School</h5>

                                            <button class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('school.update', $school->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>School Name</label>

                                                        <input type="text"
                                                            name="school_name"
                                                            value="{{ $school->school_name }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-6 mb-3">

                                                        <label>School Code</label>

                                                        <input type="text"
                                                            name="school_code"
                                                            value="{{ $school->school_code }}"
                                                            class="form-control">

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>District</label>

                                                        <select name="district_id"
                                                            class="form-control">

                                                            @foreach ($districts as $district)

                                                                <option value="{{ $district->id }}"
                                                                    {{ $school->district_id == $district->id ? 'selected' : '' }}>

                                                                    {{ $district->district_name }}

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
                        <td colspan="5" style="text-align: center">No Record Found</td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection