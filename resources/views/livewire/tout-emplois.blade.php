<div>

    <div class=" iconContainer rounded">
        <div class="mdi mdi-magnify-remove-outline tbn" data-bs-toggle="modal" data-bs-target="#exampleModal333"></div>
    </div>

     {{-- modal Search --}}
    <div wire:ignore class="modal fade" id="exampleModal333" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Search Formateur</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input wire:model='SearchValue'  type="search" class="form-control rounded " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <select id='date-select' class="form-select"  wire:model="selectedValue" wire:change="updateSelectedIDEmploi($event.target.value)">
                    <option >Select date emploi</option>
                    @forEach( $Main_emplois as $Main_emploi)
                        <option value="{{ $Main_emploi->id }}">{{$Main_emploi->datestart  }} to {{$Main_emploi->dateend }}</option>
                    @endforeach
                </select>
                <select class="form-select"  wire:model="selectedType" wire:change="updateSelectedType($event.target.value)">
                    <option  disabled selected >Select type emploi</option>
                    <option value="Formateur" selected>Formateurs</option>
                    <option value="Group">Groupes</option>
                </select>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>

            </div>
          </div>
        </div>
      </div>

    {{-- modal Search --}}

    <div class="HeaderContainerInputs">

        <div style="height: 40px ;" class=" HEaderItem rounded">
            <input wire:model='SearchValue'  type="search" class="form-control rounded " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        </div>

        <div class="HEaderItem">
            <select id='date-select' class="form-select"  wire:model="selectedValue" wire:change="updateSelectedIDEmploi($event.target.value)">
                <option >Select date emploi</option>
                @forEach( $Main_emplois as $Main_emploi)
                    <option value="{{ $Main_emploi->id }}">{{$Main_emploi->datestart  }} to {{$Main_emploi->dateend }}</option>
                @endforeach
            </select>
        </div>

         <div class="HEaderItem">
            <select class="form-select"  wire:model="selectedType" wire:change="updateSelectedType($event.target.value)">
                <option  disabled selected >Select type emploi</option>
                <option value="Formateur" selected>Formateurs</option>
                <option value="Group">Groupes</option>
            </select>
         </div>

       </div>
    <div>
        <style>
                     .Mon{
            background-color: RGBa(80, 159, 236,0.2) !important;
        }
        .Tue{
            background-color: rgb(255, 224, 178) !important;
        }
        .Wed{
            background-color: rgb(200, 230, 201) !important;
        }
        .Thu{
            background-color: rgb(255, 205, 210) !important;
        }
        .Fri{
            background-color: rgb(232, 234, 246) !important;
        }
        .Sat{
            background-color: rgb(178, 235, 242) !important;
        }

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

        {{-- table --}}
         body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {

            height: 40px;
            width: 490px !important;
            border: 1.5px solid #272727;
            text-align: center;
        }
        td{
            height: 70px;
        }

        th {
            background-color: #f2f2f2;
        }
        td span {
            position: sticky ;
            color: #272727 ;
        }
        thead tr.day{
            font-size: 18px;
            /* font-weight: bold; */
            padding:30px
        }
      thead tr.se-row {
            height: 30px !important;
            width: 30px;
            margin: 0px;
            padding: 0px;
            font-size: 16px
        }

        #SearchInput{
            width: 45% !important;
        }

        @media screen and (max-width: 600px){
            #SearchInput{
            width: 100% !important;
        }
        }
       thead tr th {
            border: 1.5px solid rgb(44, 44, 44) ;
            outline: 0px ;
        }


        td span {
            display: block ;
            font-size: 14px !important;
            color: black !important;

        }
        td{
             color: black !important;
             font-size:18px;
        }
        thead  {

                position: sticky ;
                top: 0px ;
            }

            th:first-child {
            left: 0;
            z-index: 1;
        }
        td:first-child {
            position: sticky;
            top: 110px ;
            left: 0;
            background-color: #f2f2f2;
            z-index: 1;
        }

        .HeaderContainerInputs{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            z-index:98989888 ;
            position :absolute ;
            top:-3rem ;
            width :90vw ;
            margin: auto ;

        }


        .HEaderItem {
            max-width: calc(100% / 2);
        }
        @media screen and (max-width:730px ){
          .HeaderContainerInputs{
            display: none ;
          }
          .IconPlus{
            display: block ;
            left: 50%;
            transform: translate(0%, -50%);
          }

        }



        .iconContainer {
            color: white ;
            display: none;
            font-size:28px ;
            position: absolute ;
            top:-5.6rem ;
            left :75% ;
            transform:translate('0%' , '80%') ;
            z-index:30033 ;
            cursor: pointer;
        }

        @media screen and (max-width:730px ){
            #SearchInputContainer{
           display: none
        }
        .iconContainer{
            display: block ;
        }
        }
        </style>
        @php
    @endphp


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
        <div  style="height: 85vh">
            <div style=" width: 100% !important;
            height:100% !important;
            overflow: scroll;
            position: absolute ;
            bottom: 0px ;
            margin: 0px ;">


            <table id="example" style="overflow:scroll" class="col-md-12 "  >
                <thead>
                    <tr class="day">
                        <th style="width: 140px !important"  rowspan="3">@if ($selectedType ==="Formateur")
                           Nome  formateurs
                        @else
                        Nome Groupes
                        @endif</th>
                        <th colspan="4">Lundi</th>
                        <th colspan="4">Mardi</th>
                        <th colspan="4">Mercredi</th>
                        <th colspan="4">Jeudi</th>
                        <th colspan="4">Vendredi</th>
                        <th colspan="4">Samedi</th>
                    </tr>
                    <tr>
                        @for ($i =0 ; $i<6 ; $i++ )
                        <th colspan="2">Matin </th>
                        <th colspan="2">A.midi </th>
                        @endfor
                    </tr>
                    <tr class="se-row">
                             @for ($i =0 ; $i<12 ; $i++ )
                                <th >SE1</th>
                                <th>SE2</th>
                            @endfor
                    </tr>
                  </thead>
                <tbody>
                    @php
                     $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                @endphp
   {{-- FOR GROUPES  --}}
   @if($selectedType === 'Group')
   @foreach ($groups as $group)
   <tr>
       <td>{{$group->group_name}}</td>
       @foreach ($dayWeek as $day)
    @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
        @php
            $sessionFound = false;
            $currentSission = null;
        @endphp

        @foreach ($sissions as $sission)
            @if ($sission->day === $day && $sission->group_id === $group->id && $sission->day_part === substr($sessionType, 0, 5) && $sission->dure_sission === substr($sessionType, 5))
                @php
                    $sessionFound = true;
                    $currentSission = $sission;
                    break; // Exit the loop once the session is found
                @endphp
            @endif
        @endforeach

        <td style="background-color: {{ $sessionFound ? 'rgba(12, 72, 166, 0.3);' : '' }}" id="{{ $day.$sessionType.$group->id }}">
            @if ($sessionFound && $currentSission)
                <span>{{ $currentSission->sission_type }}</span>
                <span>{{ $currentSission->user_name }}</span>
                <span>{{ preg_replace('/^\d+/', ' ', $currentSission->module_name) }}</span>
                <span>{{ $currentSission->class_name ? $currentSission->class_name : 'SALLE' }}</span>
                <span>{{ $currentSission->typeSalle }}</span>
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
        <td>{{$formateur->user_name}}</td>
        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
            <td data-bs-toggle="modal" data-bs-target="#exampleModal" class="Cases {{$day}}" wire:click="getidCase('{{$day.$sessionType.$formateur->id }}')" id="{{$day . $sessionType . $formateur->id }}">                @php
                    $sessionWords = [];
                @endphp
                @foreach ($sissions as $sission)
                    @if ($sission->day === $day && $sission->user_id === $formateur->id && $sission->day_part === substr($sessionType, 0, 5) && $sission->dure_sission === substr($sessionType, 5))
                        @php
            $details = $sission->sission_type . '<br>'
             . ($sission->class_name ? $sission->class_name : 'SALLE') . '<br>'
             . $sission->typeSalle . '<br>'
             . $sission->group_name . '<br>'
             . preg_replace('/^\d+/', '', $sission->module_name);

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
    </div>
</div>

  <!-- Modal -->

 <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Êtes-vous sûr(e)?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
            Voulez-vous supprimer toutes les sessions de ce emploi ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
            <button type="button" wire:click='deleteAllSessions' class="btn btn-danger">Oui Supprimer l'emploi</button>
          </div>
      </div>
    </div>
  </div>
</div>
    <div style="">
        <button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5">télécharger</button>
        <button type="button" class="btn btn-danger col-3 mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal1"> Supprimer tout</button>
    </div>



    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script type="text/javascript" >

    function ExportToExcel(type, fn, dl) {
           var elt = document.getElementById('tbl_exporttable_to_xls');
           var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
           return dl ?
             XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
             XLSX.writeFile(wb, fn || ('Schedule.' + (type || 'xlsx')));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const handleDomChanges = function(mutationsList, observer) {

                // console.log( document.querySelectorAll('.TableCases'));
                let elements = document.querySelectorAll('[data-bs-toggle="modal"]');
            elements.forEach(element => {
                element.addEventListener('click', function() {
                    Livewire.emit('receiveVariable', element.id);
                    console.log(element.id)
                });
            });
            };
                const observerConfig = { childList: true, subtree: true };
                const observer = new MutationObserver(handleDomChanges);
                observer.observe(document.body, observerConfig);
        })


    document.addEventListener('livewire:load', function () {
    const selectElement = document.getElementById('date-select');
    let elements = document.querySelectorAll('[data-bs-toggle="modal"], .Cases');
    elements.forEach(element => {
        element.addEventListener('click', function() {
            if (element.classList.contains('Cases')) {
                Livewire.emit('receiveVariable', element.id);
                console.log(element.id);
            }
        });
    });
});


</script>



