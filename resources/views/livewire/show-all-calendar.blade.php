<div>
    <div>
        <style>
            .checkboxContainer {
                background-color: white;
                border-radius: 7px;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 10px 15px;
                border: 1.5px solid #eee;
                max-height: 150px;
                overflow-y: scroll;
                width: 100%;
            }

            .checkboxContainer span {
                margin: 4px;
                display: block;
            }

            .checkboxContainer span:hover {
                background-color: #eee
            }

            .checkboxContainer span input {
                width: 35px;
            }

            /* Change the color of the checkbox when checked */
            input[type="checkbox"]:checked+label {
                background-color: #eee;
            }

            {{-- table --}} body {
                font-family: Arial, sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                table-layout: fixed;
                word-wrap: break-word;
            }

            th,
            td {

                height: 40px;
                width: 520px !important;
                border: 1px solid #ddd;
                text-align: center;
            }

            td {
                height: 70px;
            }

            th {
                background-color: #f2f2f2;
            }

            thead tr.day {
                font-size: 18px;
                /* font-weight: bold; */
                padding: 30px
            }

            thead tr.se-row {
                height: 30px !important;
                width: 30px;
                margin: 0px;
                padding: 0px;
                font-size: 16px
            }

            #SearchInput {
                width: 45% !important;
            }

            @media screen and (max-width: 600px) {
                #SearchInput {
                    width: 100% !important;
                }
            }
        </style>
        @php
        @endphp
        <div style="display: grid;
       grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
       ">

            <div style="height: 40px ;" class="input-group rounded">
                <input wire:model='SearchValue' type="search" class="form-control rounded " placeholder="Search"
                    aria-label="Search" aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
            </div>

            <div>

                <select id='date-select' class="form-select" wire:model="selectedValue"
                    wire:change="updateSelectedIDEmploi($event.target.value)">
                    <option>Select date emploi</option>
                    @foreach ($Main_emplois as $Main_emploi)
                        <option value="{{ $Main_emploi->id }}">{{ $Main_emploi->datestart }} to
                            {{ $Main_emploi->dateend }}</option>
                    @endforeach
                </select>
            </div>

            <div>

                <select class="form-select" wire:model="selectedType"
                    wire:change="updateSelectedType($event.target.value)">
                    <option disabled selected>Select type emploi</option>
                    <option value="Formateur" selected>Formateurs</option>
                    <option value="Group">Groupes</option>
                </select>
            </div>

        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
        <div class="table-responsive">

            <table id="tbl_exporttable_to_xls" style="overflow:scroll" class="col-md-12 ">
                <thead>
                    <tr class="day">
                        <th style="width: 140px !important" rowspan="3">
                            @if ($selectedType === 'Formateur')
                                Nom formateurs
                            @else
                                Nom Groupes
                            @endif
                        </th>
                        <th colspan="4">Lundi</th>
                        <th colspan="4">Mardi</th>
                        <th colspan="4">Mercredi</th>
                        <th colspan="4">Jeudi</th>
                        <th colspan="4">Vendredi</th>
                        <th colspan="4">Samedi</th>
                    </tr>
                    <tr>
                        @for ($i = 0; $i < 6; $i++)
                            <th colspan="2">Matin </th>
                            <th colspan="2">A.midi </th>
                        @endfor

                    </tr>
                    <tr class="se-row">
                        @for ($i = 0; $i < 12; $i++)
                            <th>SE1</th>
                            <th>SE2</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    @endphp
                    {{-- Model start --}}
                    
        </div>

        {{-- FOR GROUPES  --}}
        @if ($selectedType === 'Group')
            @foreach ($groups as $group)
                <tr>
                    <td>{{ $group->group_name }}</td>
                    @foreach ($dayWeek as $day)
                        @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                            @php
                                $sessionFound = false;
                            @endphp

                            @foreach ($sissions as $sission)
                                @if (
                                    $sission->day === $day &&
                                        $sission->group_id === $group->id &&
                                        $sission->day_part === substr($sessionType, 0, 5) &&
                                        $sission->dure_sission === substr($sessionType, 5))
                                    @php
                                        $sessionFound = true;
                                    @endphp
                                @endif
                            @endforeach
                            <td style="background-color :  {{ $sessionFound ? 'rgba(12, 72, 166, 0.3);' : '' }}"
                                data-bs-toggle="modal" data-bs-target="#exampleModal" class="Cases"
                                wire:click="getidCase('{{ $day . $sessionType . $group->id }}')"
                                id="{{ $day . $sessionType . $group->id }}">
                                @if ($sessionFound)
                                    {{ $sission->sission_type }}
                                    <br />{{ $sission->user_name }}
                                    <br />{{ preg_replace('/^\d+/', ' ', $sission->module_name) }}

                                    <br />{{ $sission->class_name }}
                                    <br />{{ $sission->typeSalle }}
                                @endif
                            </td>
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
    </div>
    {{-- FOR FORMATEUR --}}
@else
    @foreach ($formateurs as $formateur)
        <tr>
            <td>{{ $formateur->user_name }}</td>
            @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                    <td data-bs-toggle="modal" data-bs-target="#exampleModal" class="Cases"
                        wire:click="getidCase('{{ $day . $sessionType . $formateur->id }}')"
                        id="{{ $day . $sessionType . $formateur->id }}"> @php
                            $sessionWords = [];
                        @endphp
                        @foreach ($sissions as $sission)
                            @if (
                                $sission->day === $day &&
                                    $sission->user_id === $formateur->id &&
                                    $sission->day_part === substr($sessionType, 0, 5) &&
                                    $sission->dure_sission === substr($sessionType, 5))
                                @php
                                    $details =
                                        $sission->sission_type .
                                        '<br>' .
                                        $sission->class_name .
                                        '<br>' .
                                        $sission->typeSalle .
                                        '<br>' .
                                        $sission->group_name .
                                        '<br>' .
                                        preg_replace('/^\d+/', '', $sission->module_name);
                                    $uniqueDetails = [];
                                    foreach (explode('<br>', $details) as $word) {
                                        if (!in_array($word, $sessionWords)) {
                                            $uniqueDetails[] = $word;
                                            $sessionWords[] = $word;
                                        }
                                    }
                                    echo implode('<br>', $uniqueDetails);
                                @endphp
                            @endif
                        @endforeach
                    </td>
                @endforeach
            @endforeach
        </tr>
    @endforeach

    @endif


    </tbody>
    </table>
</div>
<button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5">
    telecharger</button>


<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript">
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('Schedule.' + (type || 'xlsx')));
    }

 
</script>


</div>
</div>
