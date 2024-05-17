<x-HeaderMenuFormateur>
    <style>
        .form-control {
            width: 100%;
            border: 1px solid rgb(31, 31, 150) !important;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <!-- Alert message -->

                    <div class="profile-widgets py-3">

                        <div class="text-center">
                            <div class="">
                                @php
                                    // Get the user's image
$userImage = Auth::user()->image;

// Check if the user has uploaded an image
if ($userImage) {
    // Use the uploaded image
    $imagePath = 'uploads/' . $userImage;
} else {
    // Use the default image
    $imagePath = 'assets/images/users/user.jpg';
                                    }

                                @endphp
                                <img class="avatar-lg mx-auto img-thumbnail rounded-circle" src="{{ asset($imagePath) }}"
                                    alt="Header Avatar">


                            </div>

                            <div class="mt-3 ">
                                <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->user_name }}</span>
                                <p class="text-body mt-1 mb-1">{{ $user->domaine }}</p>


                            </div>

                            <div class="row mt-4 border border-start-0 border-end-0 p-3">
                                <div class="col-md-3">
                                    <h6 class="text-muted" style="color: black !important">
                                        Nombres des demandes
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $DemandesList = \App\Models\RequestEmploi::where('user_id', $user->id)->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $DemandesList }}</h5>
                                </div>

                                <div class="col-md-3">
                                    <h6 class="text-muted" style="color: black !important">
                                        Nombres des seances
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $seancesList = \App\Models\sission::where('user_id', $user->id)->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $seancesList }}</h5>
                                </div>


                                <div class="col-md-3">
                                    <h6 class="text-muted" style="color: orange !important">
                                        Nombres des seances en attends
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $DemandesList = \App\Models\sission::where('user_id', $user->id)
                                            ->where('status_sission', 'Pending')
                                            ->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $DemandesList }}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted" style="color: green !important">
                                        Nombres des seances accepte
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $DemandesList = \App\Models\sission::where('user_id', $user->id)
                                            ->where('status_sission', 'Accepted')
                                            ->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $DemandesList }}</h5>
                                </div>





                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger " role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <!-- User Information Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body informations">
                        <h4 class="card-title mb-4">Informations Personnel : </h4>
                        <form action="{{ route('update_settings') }}" method="POST" class="outer-repeater"
                            enctype="multipart/form-data">
                            @csrf


                            <div data-repeater-list="outer-group" class="outer">
                                <div data-repeater-item class="outer">
                                    <div class="mb-3">
                                        <span class="form-span" for="matricule">Matricule :</span>
                                        <input type="text" class="form-control" id="matricule"
                                            value="{{ Auth::user()->id }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-span" for="FullName">Nom Complet :</span>
                                        <input type="text" class="form-control" id="FullName"
                                            value="{{ Auth::user()->user_name }}" readonly>
                                    </div>

                                    <div class="mb-3 form-email">

                                        <span class="form-span" for="formemail">Email:</span>
                                        <input type="email" name="email" class="form-control" id="formemail"
                                            placeholder="Enter your Email..." value="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3 form-picture">
                                        @php
                                            // Get the user's image
$userImage = Auth::user()->image;

// Check if the user has uploaded an image
if ($userImage) {
    // Use the uploaded image
    $imagePath = 'uploads/' . $userImage;
} else {
    // Use the default image
    $imagePath = 'assets/images/users/user.jpg';
                                            }
                                        @endphp
                                        <span class="form-span" for="inputGroupFile02">Upload:</span>
                                        <input type="file" name="image" class="form-control" id="inputGroupFile02">
                                        @if ($user->image)
                                            <input type="hidden" name="old_image" value="{{ $user->image }}">
                                            <img class="rounded-circle header-profile-user"
                                                src="{{ asset($imagePath) }}" alt="Header Avatar"
                                                style="max-width: 100px;">
                                        @endif
                                    </div>

                                    <div class="mb-3 form-Domaine">
                                        <span class="form-span" for="FormationDemaine">Domaine de Formation:</span>
                                        <input type="text" name="domaine" class="form-control" maxlength="25"
                                            id="FormationDemaine" value="{{ $user->domaine }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary Done">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Change Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body informations">
                        <h4 class="card-title mb-4">Change Password : </h4>
                        <form action="{{ route('update_password') }}" method="POST">
                            @csrf
                            <!-- Current password -->
                            <div class="mb-3">
                                <span for="current_password">Current Password:</span>
                                <input type="password" name="current_password" class="form-control"
                                    id="current_password">
                            </div>
                            <!-- New password -->
                            <div class="mb-3">
                                <span for="new_password">New Password:</span>
                                <input type="password" name="new_password" class="form-control" id="new_password">
                            </div>
                            <!-- Confirm new password -->
                            <div class="mb-3">
                                <span for="confirm_new_password">Confirm New Password:</span>
                                <input type="password" name="confirm_new_password" class="form-control"
                                    id="confirm_new_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-HeaderMenuFormateur>
