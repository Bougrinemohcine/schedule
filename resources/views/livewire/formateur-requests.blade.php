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
            <button id="createRequestBtn" type="button"
                class="btn btn-outline-warning waves-effect waves-light position-relative @if($existingRequest) bg-success @else bg-danger @endif">
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
                            @php $seanceFound = false; @endphp
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
                                    if ($seance_part == 'SE1' || $seance_part == 'SE2') {
                                            $day_part = 'Matin';
                                        } elseif ($seance_part == 'SE3' || $seance_part == 'SE4') {
                                            $day_part = 'Amidi';
                                        }
                                @endphp
                                @if ($AllSeance->day == $day_of_week && $AllSeance->dure_sission == $seance_part)
                                    @php $seanceFound = true; @endphp
                                    <td data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
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
                                <td data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
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
    <div class="modal fade" id="createRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="createRequestModalLabel" aria-hidden="true" wire:ignore.self>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            id="cancelRequests">Fermer</button>
                        <button type="submit" id="cancelRequestcs" class="btn btn-primary">Submit</button>
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
        $('#cancelRequestcs').click(function() {
            $('#createRequestModal').modal('hide');
        });
        $('#cancelRequests').click(function() {
            $('#createRequestModal').modal('hide');
        });
    });

</script>
