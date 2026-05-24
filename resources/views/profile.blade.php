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
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    </div>

</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection