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
        .dateContent{
            width: 85vw ;
            display: flex ;
            justify-content: space-between ;
            position: absolute ;
            top: -2.5rem ;
            color: white ;
        }
        @media screen and (max-width:600px){
            .dateContent{
                background-color: red ;
              top: -10rem ;
            width: 95vw ;
            display: none

        }
        .hide{
            display: none ;
        }
        .data{
            margin-top:5px
        }
        }

        #SearchInput{
            width: 45% !important;
        }

        @media screen and (max-width: 600px){
            #SearchInput{
            width: 100% !important;
        }
        }
        .SEvalues{
                display: block
            }
        @media screen and (max-width:1200px){
            .SEvalues{
                display: none
            }
        }


        #SearchInputContainer{
            display: block ;
            max-width: 340px !important;
            position: absolute ;
            z-index: 10000001;
            top: -5.5rem ;
            left: 16rem ;

        }

        @media screen and (max-width: 600px){
            #SearchInputContainer{
           display: none
        }
        }

        .tableContainer{
            width: 100% !important;
            height:100% !important;
            overflow: scroll;
            position: absolute ;
            bottom: 0px ;
            margin:0px 0px 0px 0px;

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

        @media screen and (max-width: 600px){
            #SearchInputContainer{
           display: none
        }
        .iconContainer{
            display: block ;
        }
        }
    </style>



<div style=" height:90vh ; "  >
        @if($tableEmploi[0]->toutFormateur == '1')
        <style>
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
        </style>
          <div class=" iconContainer rounded">
            <div class="mdi mdi-magnify-remove-outline tbn" data-bs-toggle="modal" data-bs-target="#exampleModal333"></div>
        </div>

         {{-- modal Search --}}
        <div wire:ignore class="modal fade" id="exampleModal333" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Search Groupe</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input wire:model='SearchValue'  type="search" class="form-control rounded " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>

                </div>
              </div>
            </div>
          </div>

        {{-- modal Search --}}
        <div id="SearchInputContainer" class=" rounded">
            <input wire:model='SearchValue'  type="search" class="form-control rounded " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        </div>
        <div class="dateContent">
            @if ($this->checkValues[0]->modeRamadan)
            <h4 class="SEvalues" style="marign-top:15px " >
                SE1 = 08:30 - 10:20 SE2 = 10:25 - 12:15 SE3 = 12:45 - 14:35 SE4 = 14:40 - 16:30
            </h4>
            @else
            <h4 class="SEvalues">  SE1 = 08:30 - 11:20 SE2 = 11:30 - 13:30 SE3 = 13:30 - 16:20 SE4 = 16:30 - 18:30 </h4>
            @endif



                @if (!$dataEmploi->isEmpty())
                <h4 class='data' style="float: right; ">
                    @foreach ($dataEmploi as $item)
                        Du: {{ $item->datestart }} au {{ $item->dateend }}
                    @endforeach
                </h4>
                @else
                <h4 class='data' style="float: right;  padding: 0px 5px 0px 5px;
                 border-radius: 3px; background-color: #dc3545; color: white;">
                    Il faut créer un emploi
                </h4>
                @endif


        </div>

        <div  class="tableContainer">
        <table id="tbl_exporttable_to_xls" style="overflow:scroll ; " class="col-md-12 ">


              {{-- first table --}}

                        <thead>

                <tr class="day">
                    <th style="width: 140px !important" rowspan="4">Formateur Name</th>
                    <th colspan="4">Lundi</th>
                    <th colspan="4">Mardi</th>
                    <th colspan="4">Mercredi</th>
                    <th colspan="4">Jeudi</th>
                    <th colspan="4">Vendredi</th>
                    <th colspan="4">Samedi</th>
                </tr>
                <tr>

                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                  <th colspan="2">Matin </th>
                  <th colspan="2">A.midi </th>
                </tr>
                <tr class="se-row">

                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>
                    <th>SE1</th>
                    <th>SE2</th>

                </tr>
              </thead>
            <tbody>
                @if ($formateurs)
                @php
                     $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                @endphp
               @foreach ($formateurs as $formateur)
               <tr>
                   <td>{{ $formateur->user_name }}</td>
                   @foreach ($dayWeek as $day)
                       @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                           @php
                               $foundSession = false;
                               $groupes = [];
                               $salleValue ;
                               $typeSalle ;
                               $typeValue ;
                               $ModelValue ;
                           @endphp
                           @foreach ($sissions as $sission)
                               @if ($sission->day === $day &&
                                    $sission->user_id === $formateur->id &&
                                    $sission->day_part === substr($sessionType, 0, 5) &&
                                    $sission->dure_sission === substr($sessionType, 5))
                                   @php
                                       $foundSession = true;
                                       $groupes[] = $sission->group_name;
                                       $salleValue = $sission->class_name ;
                                       $typeSalle = $sission->typeSalle ;
                                       $typeValue = $sission->sission_type ;
                                       $ModelValue = $sission->module_name ;
                                   @endphp
                               @endif
                           @endforeach
                           <td wire:click="updateCaseStatus({{ $foundSession ? 'false' : 'true' }})"
                               colspan="1" rowspan="1"  data-bs-toggle="modal"  data-bs-target="#exampleModal"
                               style="!important;height: 50px !important; overflow: hidden ; background-color:{{ $foundSession ? 'rgba(12, 72, 166, 0.3)' :  ''}}"
                               class="TableCases {{$day}}" id="{{ $day.$sessionType.$formateur->id }}">
                               @if ($foundSession)
                                <span>   {{ $typeValue}}</span>
                                <span>
                                    @if($salleValue)
                                        {{ $salleValue }}
                                    @else
                                        SALLE
                                    @endif
                                    <br>
                                    {{ "\n" . $typeSalle }}
                                </span>

                                <span>   {{ implode(' - ', $groupes) }}</span>
                                   {{ preg_replace('/^\d/', ' ', $ModelValue) }}
                               @endif
                           </td>
                       @endforeach
                   @endforeach
               </tr>
           @endforeach
           @include('livewire.FormateurModule')
                        @endif
            </tbody>
              {{-- end first table table --}}
        </table>
        @else
        @include('livewire.ToutFormateur')
        @endif


    </div>
</div>
</div>


    <button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5 w-25">télécharger</button>
      <!-- Button trigger modal -->
<button type="button" class="btn btn-danger mt-5 col-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">   Supprimer tout </button>
  <!-- Modal for delete-->
  <div wire:ignore class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Êtes-vous sûr(e)?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Voulez-vous supprimer toutes les sessions que vous avez créées ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
          <button type="button" wire:click='deleteAllSessions' class="btn btn-danger">Oui Supprimer Tout</button>
        </div>
      </div>
    </div>
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


  document.addEventListener('livewire:load', function () {
  const selectElement = document.getElementById('date-select');
  selectElement.addEventListener('change', function() {
      Livewire.emit('receiveidEmploiid', selectElement.value);
  });

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

<script  >


    document.addEventListener('livewire:load', function () {
            let elements = document.querySelectorAll('[data-bs-toggle="modal"]');
            elements.forEach(element => {
                element.addEventListener('click', function() {
                    Livewire.emit('receiveVariable', element.id);
                    console.log(element.id)
                });
            });


        });


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
});


    </script>
</div>
