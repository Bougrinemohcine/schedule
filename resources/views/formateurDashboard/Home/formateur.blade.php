<x-HeaderMenuFormateur>
    <div class="row">
        <div class="col-md-12 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="profile-widgets py-3">

                        <div class="text-center">
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
                            <div class="">
                                <img class="rounded-circle header-profile-user" src="{{ asset($imagePath) }}"
                                    alt="Header Avatar">


                            </div>

                            <div class="mt-3 ">
                                <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->user_name }}</span>
                                <p class="text-body mt-1 mb-1">{{ Auth::user()->domaine }}</p>


                            </div>

                            <div class="row mt-4 border border-start-0 border-end-0 p-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted" style="color: black !important">
                                        Nombres des demandes
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $DemandesList = \App\Models\RequestEmploi::where('user_id', $user->id)->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $DemandesList }}</h5>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-muted" style="color: black !important">
                                        Nombres des seances
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $emploi = \App\Models\main_emploi::where('establishment_id',$user->establishment_id)->orderBy('id', 'desc')->first();
                                        $seancesList = \App\Models\sission::where('user_id', $user->id)->where('main_emploi_id',$emploi->id)->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $seancesList }}</h5>
                                </div>

                            </div>
                            <div class="row mt-4 border border-start-0 border-end-0 p-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted" style="color: orange !important">
                                        Nombres des seances en attends
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $emploi = \App\Models\main_emploi::where('establishment_id',$user->establishment_id)->orderBy('id', 'desc')->first();

                                        $DemandesList = \App\Models\sission::where('user_id', $user->id)
                                        ->where('main_emploi_id',$emploi->id)
                                            ->where('status_sission', 'Pending')
                                            ->count();
                                    @endphp
                                    <h5 class="mb-0">{{ $DemandesList }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted" style="color: green !important">
                                        Nombres des seances accepte
                                    </h6>
                                    @php
                                        $user = Auth::user();
                                        $emploi = \App\Models\main_emploi::where('establishment_id',$user->establishment_id)->orderBy('id', 'desc')->first();

                                        $DemandesList = \App\Models\sission::where('user_id', $user->id)
                                        ->where('main_emploi_id',$emploi->id)
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Personal Information</h5>


                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Matricule</p>
                        <h6 class="">{{ Auth::user()->id }} </h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Nom complet</p>
                        <h6 class="">{{ Auth::user()->user_name }}</h6>
                    </div>
                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Domaine du formation</p>
                        <h6 class="">{{ Auth::user()->domaine }}</h6>
                    </div>

                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Email Address</p>
                        <h6 class="">{{ Auth::user()->email }}</h6>
                    </div>



                </div>
            </div>



        </div>

        <div class="col-md-12 col-xl-9">


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste Des groupes</h4>

                    <table id="FormateurgroupesTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>ID Du groupe</th>
                                <th>Nom Du groupe</th>
                                <th>Branch</th>
                                <th>Year</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (isset($groupsList) && $groupsList->count() > 0)
                                @php $counter = 0; @endphp
                                @foreach ($groupsList as $groupList)
                                    @php
                                        $groupId = substr(\App\Models\group::find($groupList['group_id'])->id, 1);

                                        $groupName = \App\Models\group::find($groupList['group_id'])->group_name;
                                        $groupBranch = substr(
                                            \App\Models\group::find($groupList['group_id'])->barnch_id,
                                            1,
                                        );
                                        $groupYear = \App\Models\group::find($groupList['group_id'])->year;
                                    @endphp
                                    <tr @if ($counter >= 3) style="display: none;" @endif>
                                        <td>{{ $groupId }}</td>
                                        <td>{{ $groupName }}</td>
                                        <td>{{ $groupBranch }}</td>
                                        <td>{{ $groupYear }}</td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                                @if ($counter > 3)
                                    <tr id="showMoreRow">
                                        <td colspan="4">
                                            <a href="{{ url('FormateurgroupeList') }}" class="btn btn-primary">Show
                                                More</a>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="4">No groups assigned to this formateur</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @push('scripts')
                    <script>
                        $(document).ready(function() {
                            $('#showMoreBtn').click(function() {
                                $('tr:hidden').slice(0, 3).slideDown();
                                if ($('tr:hidden').length === 0) {
                                    $('#showMoreRow').hide();
                                }
                            });
                        });
                    </script>
                @endpush
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste Des modules</h4>

                    <table id="FormateurmodulesTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>ID Du module</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (isset($modulesList) && $modulesList->count() > 0)
                                @php $counter = 0; @endphp
                                @foreach ($modulesList as $moduleList)
                                    @php
                                        $moduleName = \App\Models\module::find($moduleList['module_id'])->module_name;
                                        $moduleId = substr(\App\Models\module::find($moduleList['module_id'])->id, 1);
                                    @endphp
                                    <tr @if ($counter >= 3) style="display: none;" @endif>
                                        <td>{{ $moduleId }}</td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                                @if ($counter > 3)
                                    <tr id="showMoremodulesRow">
                                        <td colspan="1">
                                            <a href="{{ url('FormateurmoduleList') }}" class="btn btn-primary">Show
                                                More</a>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="1">No modules assigned to this formateur</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $('#showMoremodulesBtn').click(function() {
                            $('tr:hidden').slice(0, 3).slideDown();
                            if ($('tr:hidden').length === 0) {
                                $('#showMoremodulesRow').hide();
                            }
                        });
                    });
                </script>
            @endpush

        </div>


    </div>

</x-HeaderMenuFormateur>
