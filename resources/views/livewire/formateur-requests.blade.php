<div>
    <div class="button-container-calendar">
        <select id='date-select' class="form-select" wire:change="handleEmploiChange($event.target.value)">
            @foreach ($mainEmplois as $MainEmploi)
                <option @if ($MainEmploi->id == $emploiID) selected="selected" @endif value="{{ $MainEmploi->id }}">
                    {{ $MainEmploi->datestart }} - {{ $MainEmploi->dateend }}
                </option>
            @endforeach
        </select>

        <div class="fixed-button">
            @php
                if($existingRequest){
                    $clr = 'green';
                }else{
                    $clr = 'red';
                }
            @endphp
            <button id="createRequestBtn" type="button"
                class="btn btn-outline-warning waves-effect waves-light position-relative " style="background-color: {{$clr}}" >
                <i class="fa fa-exclamation-circle" style="font-size:16px;"></i>
                Creer une demande
            </button>
            <button onclick="ExportToExcel('xlsx')" class="btn btn-primary waves-effect waves-light"><i
                    class="mdi mdi-download"></i>
                telecharger</button>

        </div>
    </div>

    <div id="tbl_exporttable_to_xls_1" class="table-responsive">
        <table id="tbl_exporttable_to_xls" style="overflow: scroll" class="col-md-12">
            <thead>
                <!-- Header row for seance parts -->
                <tr>
                    <th rowspan="2">Days/Seance</th>
                    <!-- Loop through days part -->
                    @foreach ($daysPart as $dayPart)
                        <!-- Display days part in the top row -->
                        <th colspan="2">{{ $dayPart }}</th>
                    @endforeach
                    <!-- Empty cell for spacing -->
                </tr>
                <tr>
                    <!-- Loop through seance part -->
                    @foreach ($seancesPart as $seance_part)
                        <!-- Display seance part in the bottom row -->
                        <th>{{ $seance_part }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                <!-- Loop through each day -->
                @foreach ($daysOfWeek as $day_of_week)
                    <tr class="dtdynamic bg-light-gray">
                        <!-- Display the day -->
                        @php
                            switch ($day_of_week) {
                                case 'Mon':
                                    $day = 'Lundi';
                                    break;
                                case 'Tue':
                                    $day = 'Mardi';
                                    break;
                                case 'Wed':
                                    $day = 'Mercredi';
                                    break;
                                case 'Thu':
                                    $day = 'Jeudi';
                                    break;
                                case 'Fri':
                                    $day = 'Vendredi';
                                    break;
                                case 'Sat':
                                    $day = 'Samedi';
                                    break;
                                default:
                                    $day = $day_of_week;
                                    break;
                            }
                        @endphp
                        <th>{{ $day }}</th>
                        <!-- Loop through each seance part -->

                        @foreach ($seancesPart as $seance_part)
                            @php $seanceFound = false;
                            if ($seance_part == 'SE1') {
                                $day_part = 'MatinSE1';
                            }elseif ($seance_part == 'SE2') {
                                $day_part = 'MatinSE2';
                            }elseif ($seance_part == 'SE3') {
                                $day_part = 'AmidiSE3';
                            }elseif ($seance_part == 'SE4') {
                                $day_part = 'AmidiSE4';
                            }
                           @endphp
                            @foreach ($allSeances as $AllSeance)
                                @php
                                    $color = '';
                                    if ($AllSeance->status_sission === 'Pending') {
                                        $color = 'orange';
                                    } elseif ($AllSeance->status_sission === 'Accepted') {
                                        $color = 'green';
                                    } elseif ($AllSeance->status_sission === 'Cancelled') {
                                        $color = 'red';
                                    }

                                @endphp
                                @if ($AllSeance->day == $day_of_week && $AllSeance->dure_sission == $seance_part)
                                    @php $seanceFound = true; @endphp
                                    <td wire:click="updateCaseStatus({{ $seanceFound ? 'false' : 'true' }},'{{ $day_of_week . $day_part }}')" data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
                                        data-day="{{ $day_of_week }}" data-seance="{{ $seance_part }}"
                                        data-seanceId="{{ $AllSeance->id }}" class="Cases"
                                        style="color: {{ $color }}">
                                        {{ $AllSeance->sission_type }}<br>
                                        {{ $AllSeance->group->group_name }} <br>
                                        {{ $AllSeance->class_room->class_name }}
                                    </td>

                                @endif
                            @endforeach
                            @if (!$seanceFound)
                                <td wire:click="updateCaseStatus({{ $seanceFound ? 'false' : 'true' }},'{{ $day_of_week . $day_part }}')" data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
                                data-day="{{ $day_of_week }}" data-seance="{{ $seance_part }}"
                                    class="Cases">
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    </div>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- MODAL  --}}
    <div wire:ignore.self class="modal fade col-9" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg  ">
            <div class="modal-content  col-9">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create session</h1>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div id="liveAlertPlaceholder" class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="UpdateSession">
                    <div class="modal-body">
                        {{-- branches  --}}
                            @if (!$checkValues[0]->branch)
                                <select wire:model='brancheId' class="form-select "
                                    aria-label="Default select example">
                                    <option>Filiére</option>
                                    @if ($baranches)
                                        @foreach ($baranches as $baranche)
                                            <option value="{{ $baranche->id }}">{{ $baranche->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif

                            @if (!$checkValues[0]->year)
                                <select wire:model='selectedYear' class="form-select "
                                    aria-label="Default select example">
                                    <option>année</option>
                                    @if ($yearFilter)
                                        @foreach ($yearFilter as $item)
                                            <option value="{{ $item }}">{{ $item }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif

                        <div style="display: flex">

                            {{-- Formateur --}}

                                <select wire:model="group" class="form-select"
                                    aria-label="Default select example">
                                    <option value="" selected>Groupes</option>
                                    @if (!$groupes->isEmpty())
                                        @foreach ($groupes as $grp)
                                            <option value="{{ $grp->id }}">{{ $grp->group_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option>Pas de groupe trouvé <i style="color:black"
                                                class="mdi mdi-alert-rhombus"></i></option>
                                    @endif
                                </select>

                            {{-- module  content --}}
                            @if (!$checkValues[0]->module)
                                <select wire:model="module" class="form-select "
                                    aria-label="Default select example">
                                    <option selected>Modules</option>
                                    @if ($modules)
                                        @foreach ($modules as $module)
                                            <option value="{{ $module->id }}">
                                                {{ preg_replace('/^\d+/', '', $module->id) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif

                            {{-- salle --}}
                            @if (!$checkValues[0]->salle)
                                <select wire:model="salle" class="form-select"
                                    aria-label="Default select example">
                                    <option selected>les salles</option>
                                    @if ($salles)
                                        @foreach ($salles as $salle)
                                            <option value="{{ $salle->id }}">
                                                {{ $salle->class_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif
                        </div>
                        {{-- tyope session --}}
                        <div style="display: flex;justify-content: space-between">
                            @if (!$checkValues[0]->typeSalle)
                                <select wire:model="salleclassTyp" class="form-select"
                                    aria-label="Default select example">
                                    <option selected>les Types</option>
                                    @if ($classType)
                                        @foreach ($classType as $classTyp)
                                            <option value="{{ $classTyp->class_room_types }}">
                                                {{ $classTyp->class_room_types }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif
                            {{-- id case --}}
                            <input type="hidden" value="{{ $receivedVariable }}">
                        </div>
                        {{-- day part && type sission --}}
                        <div style="display: flex">
                            @if (!$checkValues[0]->typeSession)
                                <select wire:model="TypeSesion" class="form-select"
                                    aria-label="Default select example">
                                    <option selected>Types</option>
                                    <option value="presentielle">Presentielle</option>
                                    <option value="teams">Teams</option>
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close
                        </button>

                        @if($seanceFirst !== null && $seanceFirst->isNotEmpty())
                            @php
                                $thevalue = $seanceFirst[0]->status_sission;
                            @endphp
                            @if ($thevalue !== 'Accepted')
                                @if ($isCaseEmpty == false)
                                    <button data-bs-dismiss="modal" wire:click="DeleteSession" aria-label="Close"
                                    type="button" class="btn btn-danger">supprimer</button>
                                @endif
                                <button data-bs-dismiss="modal" wire:click="UpdateSession" aria-label="Close"
                                type="submit" class="btn btn-success">
                                @if ($isCaseEmpty == false)
                                    Update

                                @else
                                    Save
                                @endif
                            </button>
                            @endif
                        @else
                            <button data-bs-dismiss="modal" wire:click="UpdateSession" aria-label="Close"
                            type="submit" class="btn btn-success">Save</button>
                        @endif


                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- MODAL REQUESTS -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" role="dialog" aria-labelledby="createRequestModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">Create Request Emploi</h5>
                    <button type="button" class="close btn btn-danger" id="cancelRequest" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRequestForm" wire:submit.prevent="createRequestEmploi">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" id="cmt" name="comment" rows="3" wire:model="comment"></textarea>
                        </div>
                        <br>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelRequests">Fermer</button>
                        <button type="submit" id="submitRequest" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('modal-hidden', function () {
                $('#createRequestModal').modal('hide');
            });
        });

        $(document).ready(function() {
            $('#createRequestBtn').click(function() {
                $('#createRequestModal').modal('show');
            });

            $('#cancelRequest').click(function() {
                $('#createRequestModal').modal('hide');
            });

            $('#cancelRequests').click(function() {
                $('#createRequestModal').modal('hide');
            });

            $('#submitRequest').click(function() {
                $('#createRequestModal').modal('hide');
            });

            // Show the session creation modal when clicking on a case
            document.querySelectorAll('.Cases').forEach(item => {
                item.addEventListener('click', event => {
                    $('#exampleModal').modal('show');
                });
            });
        });

    </script>
