@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <div class="d-flex justify-content-between mb-3">

            <h5>
                My Inspection Orders
            </h5>

            <span class="badge bg-primary fs-6">
                Total Orders: {{ $totalOrders }}
            </span>

        </div>

        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">

                <tr>
                    <th>#</th>
                    <th>Instruction</th>
                    <th>Inspection Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($orders as $index => $order)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    

                    <td>
                        {{ $order->instruction }}
                    </td>

                    <td>
                        {{ $order->inspection_date }}
                    </td>

                    <td>

                        @if($order->status == 'pending')

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        @elseif($order->status == 'completed')

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($order->status) }}
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $order->created_at->diffForHumans() }}
                    </td>
                    <td>
    <a href="{{ route('orders.show',$order->id) }}"
       class="btn btn-sm btn-info">
        view info
    </a>

    @if($order->status == 'pending')
    <form action="{{ route('orders.complete',$order->id) }}"
          method="POST"
          style="display:inline-block">
        @csrf
        @method('PATCH')

        <button class="btn btn-sm btn-success"
                onclick="return confirm('Complete this inspection?')">
            Complete
        </button>
    </form>
    @endif
</td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center">
                        No Orders Found
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

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection