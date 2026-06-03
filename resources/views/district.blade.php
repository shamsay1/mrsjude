@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add District Button -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addDistrictModal">

            + Add District
        </button>

        <!-- Add Modal -->
        <div class="modal fade" id="addDistrictModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add District</h5>
                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('district.store') }}" method="POST">
                        @csrf

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>District Name</label>

                                <input type="text"
                                    name="district_name"
                                    class="form-control"
                                    placeholder="Enter district name">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">
                                Save District
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
                    <th>District Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($districts as $index => $district)

                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $district->district_name }}</td>
                        <td>
                            @if ($district->status == "Active")
                            <span class="badge bg-success">{{ $district->status }}</span>
                            @else
                            <span class="badge bg-danger">{{ $district->status }}</span>
                            @endif
                        </td>

                        <td>

                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editDistrictModal{{ $district->id }}">

                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('district.toggle-status', $district->id) }}"
      method="POST"
      style="display:inline-block;">

    @csrf
    @method('PATCH')

    <button
        class="btn btn-sm {{ $district->status == 'Active' ? 'btn-danger' : 'btn-success' }}"
        onclick="return confirm('Are you sure?')">

        {{ $district->status == 'Active' ? 'Deactivate' : 'Activate' }}

    </button>

</form>
                            <!-- Edit Modal -->
                            <div class="modal fade"
                                id="editDistrictModal{{ $district->id }}">

                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">

                                            <h5>Edit District</h5>

                                            <button class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('district.update', $district->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="mb-3">

                                                    <label>District Name</label>

                                                    <input type="text"
                                                        name="district_name"
                                                        value="{{ $district->district_name }}"
                                                        class="form-control">

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
                        <td colspan="3" style="text-align: center">No Record Found</td>
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