@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        {{-- <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addOrderModal">
            + Add Order
        </button>

        <div class="modal fade" id="addOrderModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Order</h5>
                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Supervisor</label>
                                <select name="supervisor_id" class="form-control" required>
                                    <option value="">-- Select Supervisor --</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->firstname }} {{ $supervisor->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">School</label>
                                <select name="school_id" class="form-control" required>
                                    <option value="">-- Select School --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Instruction / Work</label>
                                <textarea name="instruction" class="form-control" rows="3" placeholder="Enter instructions here..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Inspection Date</label>
                                <input type="date" name="inspection_date" class="form-control" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                Save Order
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div> --}}

        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">
                <tr>
                    <th>S/N</th>
                    <th>Supervisor</th>
                    <th>School</th>
                    <th>Instruction</th>
                    <th>Inspection Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($orders as $index => $order)

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->supervisor->firstname ?? 'N/A' }} {{ $order->supervisor->lastname ?? '' }}</td>
                        <td>{{ $order->school->school_name ?? 'N/A' }}</td>
                        <td>{{ $order->instruction }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->inspection_date)->format('d-m-Y') }}</td>
                        <td>
                            @if ($order->status == "completed")
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>

                            {{-- <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editOrderModal{{ $order->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('orders.toggle-status', $order->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('PATCH')

                                <button
                                    class="btn btn-sm {{ $order->status == 'completed' ? 'btn-warning text-dark' : 'btn-success' }}"
                                    onclick="return confirm('Are you sure you want to change this order status?')">
                                    {{ $order->status == 'completed' ? 'Mark Pending' : 'Mark Completed' }}
                                </button>
                            </form> --}}

                            {{-- <div class="modal fade" id="editOrderModal{{ $order->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">
                                            <h5>Edit Order</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body text-start">

                                                <div class="mb-3">
                                                    <label class="form-label">Supervisor</label>
                                                    <select name="supervisor_id" class="form-control" required>
                                                        @foreach($supervisors as $supervisor)
                                                            <option value="{{ $supervisor->id }}" {{ $order->supervisor_id == $supervisor->id ? 'selected' : '' }}>
                                                                {{ $supervisor->firstname }} {{ $supervisor->lastname }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">School</label>
                                                    <select name="school_id" class="form-control" required>
                                                        @foreach($schools as $school)
                                                            <option value="{{ $school->id }}" {{ $order->school_id == $school->id ? 'selected' : '' }}>
                                                                {{ $school->school_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Instruction / Work</label>
                                                    <textarea name="instruction" class="form-control" rows="3" required>{{ $order->instruction }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Inspection Date</label>
                                                    <input type="date" name="inspection_date" value="{{ $order->inspection_date }}" class="form-control" required>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">
                                                    Update Order
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div> --}}

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align: center">No Orders Found</td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if(session('success') || session('error') || $errors->any())

<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">

            @if(session('success'))
                <div class="modal-body p-5">
                    <i class="fas fa-check-circle text-success" style="font-size:80px;"></i>
                    <h3 class="mt-3 text-success">Success</h3>
                    <p style="color:green">{{ session('success') }}</p>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="modal-body p-5">
                    <i class="fas fa-times-circle text-danger" style="font-size:80px;"></i>
                    <h3 class="mt-3 text-danger">Failed</h3>
                    
                    @if(session('error'))
                        <p style="color:red">{{ session('error') }}</p>
                    @endif

                    @if($errors->any())
                        <ul class="text-danger text-start">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            @endif

        </div>
    </div>
</div>

@endif

@if(session('success') || session('error') || $errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    let modal = new bootstrap.Modal(
        document.getElementById('successModal')
    );
    modal.show();
});
</script>
@endif

@endsection