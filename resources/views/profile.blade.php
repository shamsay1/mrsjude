@extends("layout.app")

@section("content")
<div class="content" id="content">

    <div class="table-container">
        <h4 class="mb-4" style="font-family: 'Times New Roman', Times, serif">My Account</h4>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                Profile
            </button>
        </li>
       

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="update-profile-tab" data-bs-toggle="tab" data-bs-target="#update-profile" type="button" role="tab" aria-controls="update-profile" aria-selected="false">
                Update Profile
            </button>
        </li>
    
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">
                Change Password
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="profileTabsContent">
        <!-- PROFILE TAB -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="card p-3" style="border-radius: 3px">
                <h5 style="color: green">Profile Information</h5>
                <p><strong style="color: green">Full Name:</strong> {{ auth()->user()->firstname}} {{ auth()->user()->lastname}}</p>
                <p><strong style="color: green">Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong style="color: green">Phone Number:</strong> {{ auth()->user()->mobile }}</p>
                <p><strong style="color: green">User Level:</strong> {{ auth()->user()->role }}</p>

                <p><strong>Joined:</strong> {{ auth()->user()->created_at->format('d-m-Y') }}</p>
            </div>
        </div>

        <!-- UPDATE PROFILE TAB -->
        <div class="tab-pane fade" id="update-profile" role="tabpanel" aria-labelledby="update-profile-tab">
            <div class="card p-3" style="border-radius: 3px">
                <h5>Update Profile</h5>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->firstname }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- CHANGE PASSWORD TAB -->
        <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
            <div class="card p-3" style="border-radius: 3px">
                <h5>Change Password</h5>
                <form action="{{ route('change.password') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Current Password</label>

        <input
            type="password"
            name="current_password"
            class="form-control"
            required>

        @error('current_password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">New Password</label>

        <input
            type="password"
            name="new_password"
            class="form-control"
            required>

        @error('new_password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm New Password</label>

        <input
            type="password"
            name="new_password_confirmation"
            class="form-control"
            required>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-key-fill"></i> Change Password
    </button>

</form>
            </div>
        </div>
    </div>

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