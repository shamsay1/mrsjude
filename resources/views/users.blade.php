@extends("layout.app")
<style>
    .filter-btn{
    transition: all .25s ease;
    margin-right:5px;
}

.filter-btn.active{
    color:#fff;
}

.btn-outline-warning.active{
    color:#000;
}
</style>
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

    <div class="mb-3">

    <button type="button"
        class="btn btn-outline-primary filter-btn active"
        data-role="">
        All
    </button>

    <button type="button"
        class="btn btn-outline-success filter-btn"
        data-role="headmaster">
        Headmaster
    </button>

    <button type="button"
        class="btn btn-outline-info filter-btn"
        data-role="teacher">
        Teacher
    </button>

    <button type="button"
        class="btn btn-outline-warning filter-btn"
        data-role="supervisor">
        Supervisor
    </button>

</div>

    

</form>
@endif
    @if(Auth::user()->role=="headmaster")
      <h2 style="color: green;font-family: 'Times New Roman', Times, serif">Teachers Information</h2>
      <hr>
      @endif
        <div id="usersTable">
    @include('partials')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Kazi ya kubofya filter za Role
    $('.filter-btn').click(function(e) {
    e.preventDefault(); // Hii inazuia kabisa fomu au ukurasa usijirefreshi (no reload)

    // Badilisha muonekano wa button iliyobonyezwa
    $('.filter-btn').removeClass('active');
    $(this).addClass('active');
    
    // Chukua role na upakie data
    let role = $(this).data('role');
    loadUsers(role, 1); 
});

    // Kazi ya kupakia data (AJAX Load)
    function loadUsers(role, page = 1) {
        $.ajax({
            url: "{{ route('system-user.index') }}",
            type: "GET",
            data: {
                role: role,
                page: page
            },
            beforeSend: function() {
                $('#usersTable').html(
                    '<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading Users...</p></div>'
                );
            },
            success: function(response) {
                $('#usersTable').html(response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Kuna hitilafu imetokea wakati wa kupakia data.');
            }
        });
    }

    // AJAX Pagination kwa ajili ya Links zilizopo ndani ya Partials
    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        
        let page = $(this).attr('href').split('page=')[1];
        let role = $('.filter-btn.active').data('role') || ''; // Chukua role iliyopo active sasa hivi

        loadUsers(role, page);
    });
});
</script>

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