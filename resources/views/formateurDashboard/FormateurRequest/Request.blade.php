<x-HeaderMenuFormateur>



    <div class="button-container-calendar">
        <label class="left-arrow" id="previous" style="display: none;"></label>

        <form id="emploi-form" action="{{ route('DemanderEmploi') }}" method="GET">
            @csrf
            <select id='date-select' class="form-select" onchange="submitForm()">
                @foreach ($main_emplois as $Main_emploi)
                    <option @if ($Main_emploi->id == $emploiID) selected="selected" @endif value="{{ $Main_emploi->id }}">
                        {{ $Main_emploi->datestart }} - {{ $Main_emploi->dateend }}
                    </option>
                @endforeach

            </select>
            <input type="hidden" id="emploiID" name="emploiID">
        </form>

        <!-- Div contenant le message d'alerte -->
        <label class="right-arrow" id="next" onclick="next()" style="display: none;">&#8250;</label>
        <div id="message-div" class="alert alert-danger alert-dismissible fade show" role="alert">
            Veuillez attendre jusqu'à ce que l'admin crée l'emploi.

        </div>
        <div class="fixed-button">
            <button id="createRequestBtn" type="button" class="btn btn-outline-warning waves-effect waves-light"><i
                    class="fa fa-exclamation-circle" style="font-size:16px;"></i>
                Creer une demande </button>



            <button id="toggleTablesBtn" onclick="toggleTables()" class="btn btn-success waves-effect waves-light"><i
                    class="fas fa-table"></i> Changer la table</button>
            <button onclick="ExportToExcel('xlsx')" class="btn btn-primary waves-effect waves-light"><i
                    class="mdi mdi-download"></i>
                telecharger</button>

        </div>


    </div>


    <div id="tbl_exporttable_to_xls_2" class="table-responsive" style="display: none">
        <table id="tbl_exporttable_to_xls" style="overflow:scroll" class="col-md-12  active">
            <thead>
                <tr class="day">
                    @foreach ($days_of_week as $day_of_week)
                        <th class="text-uppercase" colspan="4">{{ $day_of_week }}</th>
                    @endforeach
                </tr>
                <tr class="dPart bg-light-gray">
                    @foreach ($days_of_week as $day_of_week)
                        @foreach ($days_part as $day_part)
                            <th class="text-uppercase" colspan="2">{{ $day_part }}</th>
                        @endforeach
                    @endforeach
                </tr>
                <tr class="se-row">
                    @foreach ($days_of_week as $day_of_week)
                        @foreach ($seances_part as $seance_part)
                            <th>{{ $seance_part }}</th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr class="dtdynamic bg-light-gray">
                    @foreach ($days_of_week as $day_of_week)
                        @foreach ($seances_part as $seance_part)
                            <td data-day="{{ $day_of_week }}" data-seance="{{ $seance_part }}" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" class="Cases">
                                @foreach ($AllSeances as $AllSeance)
                                    @if ($AllSeance->day == $day_of_week && $AllSeance->dure_sission == $seance_part)
                                        {{ $AllSeance->sission_type }} <br>
                                        {{ $AllSeance->group->group_name }} <br>
                                        {{ $AllSeance->class_room->class_name }}
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>
        </table>
        <br>

    </div>


    <div id="tbl_exporttable_to_xls_1" class="table-responsive">
        <table id="tbl_exporttable_to_xls" style="overflow: scroll" class="col-md-12">
            <thead>
                <!-- Header row for seance parts -->
                <tr>
                    <th rowspan="2">Days/Seance</th>
                    <!-- Loop through days part -->
                    @foreach ($days_part as $dayPart)
                        <!-- Display days part in the top row -->
                        <th colspan="2">{{ $dayPart }}</th>
                    @endforeach
                    <!-- Empty cell for spacing -->
                </tr>
                <tr>
                    <!-- Loop through seance part -->
                    @foreach ($seances_part as $seance_part)
                        <!-- Display seance part in the bottom row -->
                        <th>{{ $seance_part }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                <!-- Loop through each day -->
                @foreach ($days_of_week as $day_of_week)
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

                        @foreach ($seances_part as $seance_part)
                            @php $seanceFound = false; @endphp
                            @foreach ($AllSeances as $AllSeance)
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
                                    <td data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
                                        data-day="{{ $day_of_week }}" data-seance="{{ $seance_part }}"
                                        data-seanceId="{{ $AllSeance->id }}" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" class="Cases"
                                        style="color: {{ $color }}">
                                        {{ $AllSeance->sission_type }} <br>
                                        {{ $AllSeance->group->group_name }} <br>
                                        {{ $AllSeance->class_room->class_name }}
                                    </td>
                                @endif
                            @endforeach
                            @if (!$seanceFound)
                                <td data-emploi="{{ $emploiID }}" data-part="{{ $day_part }}"
                                    data-day="{{ $day_of_week }}" data-seance="{{ $seance_part }}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" class="Cases">
                                </td>
                            @endif
                        @endforeach


                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    </div>
    <button id="submitAll">Submit All</button>





    <div id="infoContainer"></div>
    </div>

    </div>


    {{-- start modal --}}
    <!-- Modal -->
    <div class="modal fade" id="groupModuleClassModal" tabindex="-1" role="dialog"
        aria-labelledby="groupModuleClassModalLabel" aria-hidden="true">
        <div class="test modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groupModuleClassModalLabel">Sélectionner des données</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="groupModuleClassForm" method="POST" action="{{ url('reciveData') }}">
                        @csrf
                        <div class="form-group">
                            <label for="group">Group:</label>
                            <select class="form-control" id="group" name="group" required>
                                @foreach ($GroupsList as $GroupList)
                                    @php
                                        $groupId = \App\Models\group::find($GroupList['group_id'])->id;
                                        $groupName = \App\Models\group::find($GroupList['group_id'])->group_name;
                                    @endphp
                                    <option value="{{ $groupId }}">{{ $groupName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="module">Module:</label>
                            <select class="form-control" id="module" name="module" required>
                                @foreach ($modulesList as $moduleList)
                                    @php
                                        $ModuleId = \App\Models\module::find($moduleList['module_id'])->id;
                                        $ModuleName = \App\Models\module::find($moduleList['module_id'])->module_name;
                                    @endphp
                                    <option value="{{ $ModuleId }}">{{ $ModuleName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Seance Type</label>
                            <select class="form-control" id="type" name="type" required>
                                @foreach ($seances_type as $index => $seance_type)
                                    <option value="{{ $index }}">{{ $seance_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class">Class:</label>
                            <select class="form-control" id="class" name="class" required>
                                @foreach ($class_rooms as $class_room)
                                    @php
                                        $RoomName = \App\Models\class_room::find($class_room['id'])->class_name;
                                        $RoomId = \App\Models\class_room::find($class_room['id'])->id;

                                    @endphp
                                    <option value="{{ $RoomId }}">{{ $RoomName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="msg">Type your message:</label>
                            <input type="text" id="msg" class="form-control">
                        </div>

                        <br />

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Soumettre</button>

                    </form>

                </div>


            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="createRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">Create Request Emploi</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRequestForm">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" id="cmt" name="comment" rows="3"></textarea>
                        </div>
                        <br>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            id="cancelRequest">Fermer</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- flash pop uo --}}

    {{-- end modal --}}

    <script>
        var emploi = {{ $emploiID }};

        function submitForm() {
            document.getElementById("emploi-form").submit();
        }
        document.getElementById('date-select').addEventListener('change', function() {
            document.getElementById('emploiID').value = this.value;
            submitForm();
        });


        document.addEventListener("DOMContentLoaded", function() {
            var cells = document.querySelectorAll("td.Cases");
            var daysOfWeek = @json($days_of_week);
            var daysPart = @json($days_part);
            var seancesPart = @json($seances_part);
            var seancesPemploiart = @json($emploiID);

            var clickedCell;
            var FlashMsg = document.createElement("div");

            var selectedData = [];

            var mainEmplois = @json($main_emplois);
            var emploiID = emploi;
            console.log(emploiID);
            var currentIndex = 0;

            document.getElementById('previous').addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + mainEmplois.length) % mainEmplois.length;
                afficherIDEmploi(currentIndex);

            });

            document.getElementById('next').addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % mainEmplois.length;
                afficherIDEmploi(currentIndex);

            });



            var mainEmploiId = mainEmplois[currentIndex].id;
            afficherIDEmploi(currentIndex)


            function afficherIDEmploi(index) {
                // var emploiID = mainEmplois[index].id;
                // console.log("ID de l'emploi actuel from funct:", emploiID);

                $.ajax({
                    type: 'GET',
                    url: '{{ route('DemanderEmploi') }}', // Assuming this route is correct
                    data: {
                        emploiID: emploiID
                    },
                    success: function(response) {
                        // Handle success response if needed
                    },
                    error: function(error) {
                        // Handle error response if needed
                    }
                });
            }
            // Function to open the pop-up form and display the flash message

            $(document).ready(function() {

                // Function to handle form submission
                $('#createRequestForm').submit(function(event) {
                    event.preventDefault();

                    // Send AJAX request to create request emploi
                    console.log('Request', mainEmploiId);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('createRequestEmploi') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            mainEmploiId: emploi, // Add main emploi variable
                            comment: $('#cmt').val(),
                            formData: $(this).serialize() // Serialize form data

                        },
                        success: function(response) {

                            if (response.status == 400) {
                                FlashMsg.innerHTML = `<br><div class="alert alert-warning">
                                        ${response.message}
                                    </div>`;
                            } else if (response.status == 300) {
                                FlashMsg.innerHTML = `<br><div class="alert alert-success">
                                        ${response.message}
                                    </div>`;
                            }
                            if (response.requestExists) {
                                // Si la demande existe, mettre à jour le bouton en 'Update'
                                $('#createRequestBtn').text('Update');
                                // Stocker l'état du bouton dans le stockage local
                                localStorage.setItem('requestButtonState', 'Update');
                            } else {
                                // Si la demande n'existe pas, mettre à jour le bouton en 'Create'
                                $('#createRequestBtn').text('Create');
                                // Stocker l'état du bouton dans le stockage local
                                localStorage.setItem('requestButtonState', 'Create');
                            }
                            document.getElementById('infoContainer').innerHTML = '';
                            document.getElementById('infoContainer').appendChild(
                                FlashMsg);
                            $('#createRequestModal').modal('hide');
                            console.log('ajaxREQUEST', response);
                            $('#comment').val('');
                        },
                        error: function(error) {
                            console.error('Error creating request emploi:',
                                error
                                .responseText);
                            // Handle error and display appropriate message to the user
                        }
                    });
                });

                // Function to show modal when button is clicked
                $('#createRequestBtn').click(function() {
                    $('#createRequestModal').modal('show');
                });

                // Function to hide modal when cancel button is clicked
                $('#cancelRequest').click(function() {
                    $('#createRequestModal').modal('hide');
                });
                $('#createRequestModal').on('click', '.btn-danger', function() {
                    $('#createRequestModal').modal('hide');
                });
            });



            cells.forEach(function(cell) {
                cell.addEventListener("click", function() {

                    clickedCell = this; // Assign the clicked cell to clickedCell
                    console.log(clickedCell);

                    $('#groupModuleClassModal').modal('show');

                    $('#groupModuleClassForm').off('submit').on('submit', function(event) {
                        event.preventDefault();

                        var selectedGroup = $('#group option:selected').val();
                        var selectedModule = $('#module option:selected').val();
                        var selectedType = $('#type option:selected').val();
                        var selectedClass = $('#class option:selected').val();
                        var ShowselectedGroup = $('#group option:selected').text();
                        var ShowselectedModule = $('#module option:selected')
                            .text();
                        var ShowselectedType = $('#type option:selected').text();
                        var ShowselectedClass = $('#class option:selected').text();
                        var ShowselectedMsg = document.getElementById("msg").value;

                        var dayOfWeek = clickedCell.dataset.day;
                        var seancePart = clickedCell.dataset.seance;
                        var seanceIds = clickedCell.dataset.seanceid ||
                            ''; // Use an empty string as a default value
                        console.log(
                            seanceIds
                        ); // Check if the `seanceIds` value is displayed in the console

                        var dayPart = (seancePart == "SE1" || seancePart == "SE2") ?
                            "Matin" : "Amidi";
                        var emploi = clickedCell.dataset.emploi;
                        console.log(dayOfWeek);
                        console.log(seancePart);
                        console.log(dayPart);
                        console.log(emploi);


                        // var seancePart = seancesPart[seancePartIndex];

                        //

                        // all data in once
                        selectedData.push({
                            'group': selectedGroup,
                            'module': selectedModule,
                            'type': ShowselectedType,
                            'class': selectedClass,
                            'day': dayOfWeek,
                            'dayPart': dayPart,
                            'seancePart': seancePart,
                            'mainEmploiId': emploi,
                            'message': ShowselectedMsg,
                            'seanceId': seanceIds
                        });



                        clickedCell.innerText = ShowselectedType + '\n ' +
                            ShowselectedGroup + '\n' + ShowselectedClass;

                        $('#groupModuleClassModal').modal('hide');
                    });
                });
            });

            $('#groupModuleClassModal').on('click', '.btn-danger', function() {
                $('#groupModuleClassModal').modal('hide');
            });

            $('#cancelButton').click(function() {
                $('#groupModuleClassForm')[0].reset();
                $('#groupModuleClassModal').modal('hide');
            });

            $('#groupModuleClassForm').on('submit', function(event) {
                event.preventDefault();
            });


            // sending all data code
            document.getElementById('submitAll').addEventListener('click', function() {
                if (selectedData.length === 0) {
                    FlashMsg.innerHTML = `<br><div class="alert alert-danger">
                                vous devez selectionner au moins une seance.
                            </div>`
                    document.getElementById('infoContainer').innerHTML = '';
                    document.getElementById('infoContainer').appendChild(FlashMsg);
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('submitAllData') }}',
                    data: {

                        '_token': '{{ csrf_token() }}',
                        'selectedData': selectedData,
                        'mainEmploiId': emploi,

                    },
                    success: function(response) {

                        if (response.status == 200) {
                            FlashMsg.innerHTML = `<br><div class="alert alert-success">
                                                            ${response.sucess}
                                                            </div>`
                        } else if (response.status == 599) {
                            FlashMsg.innerHTML = `<br><div class="alert alert-warning">
                                                            ${response.msg}
                                                            </div>`
                        }

                        selectedData = [];
                        document.getElementById('infoContainer').innerHTML = '';
                        document.getElementById('infoContainer').appendChild(FlashMsg);
                    },
                    error: function(error) {
                        console.error('Error creating sission emploi:',
                            error
                            .responseText);
                        // Handle error and display appropriate message to the user
                    }
                });
            });




            $(document).ready(function() {
                var buttonState = localStorage.getItem('requestButtonState');
                if (buttonState) {
                    $('#createRequestButton').text(buttonState);
                }
            });
        });

        function ExportToExcel(type, fn, dl) {
            var selectedEmploiID = $('#emploiID').val(); // Get the selected emploiID
            var dateStart = $('#date-select option:selected').text().split(' - ')[
                0]; // Extract date start from selected option
            var dateEnd = $('#date-select option:selected').text().split(' - ')[1]; // Extract date end from selected option

            // Depending on your implementation, you may need to adjust how you fetch the selected emploiID and dates

            var elt = document.getElementById('tbl_exporttable_to_xls_1');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });

            // Include date start and date end in the filename
            var filename = '{{ Auth::user()->user_name }} - ' + dateStart.trim() + ' - ' + dateEnd.trim() + '.' + (type ||
                'xlsx');

            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || filename, {
                    selectedEmploiID: selectedEmploiID // Pass the selected emploiID as a parameter
                });
        }
    </script>


</x-HeaderMenuFormateur>
