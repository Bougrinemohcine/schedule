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


        @media screen  and (max-width : 700px){
            .ResponceUI{
            flex-direction: column ;

        }

        .selectDiv{
            width: 70vw !important;
            margin-left:0px !important ;
        }

    }

    .dateContent{

            max-width: 90vw ;
            display: flex ;
            justify-content: space-between ;
            margin: auto ;
        }
        .dateSE {
            display: block
        }
        @media screen and (max-width:1116px){
            .dateSE{
                display: none ;
            }
        }
        @media screen and (max-width:650px){
            .dateContent{
            margin-top: 15px ;
            width: 75vw ;
            display: flex ;
            flex-direction: column
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

        @media screen and (max-width: 650px){
            #SearchInput{
            width: 100% !important;
        }
        }
        /* New code  */
        #SearchInputContainer{
            display: flex ;
            max-width: 340px !important;
            position: absolute ;
            z-index: 10000001;
            top: -5.5rem ;
            left: 16rem ;

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

        @media screen and (max-width: 650px){
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
            <input id='searchInput12'   type="search" class="form-control rounded searchDev " placeholder="Search Formateur" aria-label="Search" aria-describedby="search-addon" />

            <select  style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" wire:model="formateurId" id="selectOptions12" class="form-control " name="">
                <option >Formateurs</option>
                @foreach ($formateurs as $formateur)
                   <option class="form-control"  value="{{$formateur->id}}">{{$formateur->user_name}} </option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>

        </div>
      </div>
    </div>
  </div>

{{-- modal Search --}}
<div id="SearchInputContainer" class=" rounded">
    <input id='searchInput'   type="search" class="form-control rounded searchDev hide " placeholder="Search Formateur" aria-label="Search" aria-describedby="search-addon" />

<div class="selectDiv" style="width:360px ;margin-left: 15px">
<select  style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" wire:model="formateurId" id="selectOptions" class="form-control hide" name="">
    <option >Formateurs</option>
    @foreach ($formateurs as $formateur)
       <option class="form-control"  value="{{$formateur->id}}">{{$formateur->user_name}} </option>
    @endforeach
</select>
</div>
</div>
<br>
<br>
    <div class="table-responsive">




        <table  id="tbl_exporttable_to_xls" style="overflow:scroll ;" class="col-md-12 ">

            <div class="dateContent">
                @if ($this->checkValues[0]->modeRamadan)
                <h4 style="marign-top:15px "  class="dateSE">
                    SE1 = 08:30 - 10:20 SE2 = 10:25 - 12:15 SE3 = 12:45 - 14:35 SE4 = 14:40 - 16:30
                </h4>
                @else
                <h4 class="dateSE"> SE1 = 08:30 - 11:20 SE2 = 11:30 - 13:30 SE3 = 13:30 - 16:20 SE4 = 16:30 - 18:30 </h4>
                @endif



                    @if (!$dataEmploi->isEmpty())
                    <h4 style="float: right; ">
                        @foreach ($dataEmploi as $item)
                            Du: {{ $item->datestart }} au {{ $item->dateend }}
                        @endforeach
                    </h4>
                    @else
                    <h4 style="float: right;  padding: 0px 5px 0px 5px;
                     border-radius: 3px; background-color: #dc3545; color: white;">
                        Il faut créer un emploi
                    </h4>
                    @endif


             </div>

             @if($tableEmploi[0]->formateur == '1')
      <thead>

        <tr class="day">

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

            <th >SE1</th>
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
        @php
            $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        @endphp
        <tr>
            @foreach ($dayWeek as $day)
                @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                    @php
                        $sessionFound = false;
                        $groupes = [];
                        $SalleValue ;
                        $Typevalue ;
                        $typeSalle;
                        $formateur;
                        $ModuleValue;
                    @endphp
                    @foreach ($sissions as $sission)
                        @if ($sission->day === $day && $sission->day_part === substr($sessionType, 0, 5)  && $sission->dure_sission === substr($sessionType, 5))
                            @php
                                $groupes[] = $sission->group_name ;
                                $sessionFound = true;
                                $SalleValue = $sission->class_name ;
                                $formateur  =$sission->user_name ;
                                $typeSalle = $sission->typeSalle ;
                                $Typevalue = $sission->sission_type ;
                                $ModuleValue = preg_replace('/^\d+/', '', $sission->module_name);

                            @endphp
                        @endif
                    @endforeach
                    <td
                    style="background-color:{{ $sessionFound ? "rgba(12, 72, 166, 0.3)" :  ''}} ; height: 130px !important"
                    wire:click="updateCaseStatus({{ $sessionFound ? 'false' : 'true' }})"
                    data-bs-toggle="modal"
                    class="tdClass Cases {{$day}}" data-bs-target="#exampleModal" id="{{ $day.$sessionType }}">
                        @if ($sessionFound)
                          <span>  {{$formateur}}</span>
                          <span>  {{ implode(' - ', $groupes) }}</span>
                          <span>
                            @if($SalleValue)
                                {{ $SalleValue }}
                            @else
                                SALLE
                            @endif
                            <br>
                            {{ "\n" . $typeSalle }}
                        </span>
                         <span>   {{$Typevalue}}</span>
                          <span>  {{$ModuleValue}}</span>
                        @endif
                    </td>
                @endforeach
            @endforeach
        </tr>
    </tbody>

@elseif ($tableEmploi[0]->formateur == '2')
        @include('livewire.PourFormateur')
@elseif ($tableEmploi[0]->formateur == '3')
        @include('livewire.PourFormateur3')
@else
        @include('livewire.PourFormateur1')
@endif
        @include('livewire.FormateurModule')
        </table>
    </div>

    <button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5"> télécharger</button>
      <!-- Button trigger modal -->
<button type="button" class="btn btn-danger mt-5 col-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
    Supprimer tout
  </button>
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
  {{-- end Modal for delete  --}}

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


                // input

                document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById("searchInput");
  const selectOptions = document.getElementById("selectOptions");

  // Event listener for input changes in the search input
  searchInput.addEventListener("input", function() {
    const searchValue = searchInput.value.toLowerCase();

    // Loop through all options in the select input
    Array.from(selectOptions.options).forEach(option => {
      const optionText = option.text.toLowerCase();

      // Check if the option text contains the search value
      if (optionText.includes(searchValue)) {
        option.style.display = ""; // Show the option
      } else {
        option.style.display = "none"; // Hide the option
      }
    });
  });
});


               // input

                document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById("searchInput12");
  const selectOptions = document.getElementById("selectOptions12");

  // Event listener for input changes in the search input
  searchInput.addEventListener("input", function() {
    const searchValue = searchInput.value.toLowerCase();

    // Loop through all options in the select input
    Array.from(selectOptions.options).forEach(option => {
      const optionText = option.text.toLowerCase();

      // Check if the option text contains the search value
      if (optionText.includes(searchValue)) {
        option.style.display = ""; // Show the option
      } else {
        option.style.display = "none"; // Hide the option
      }
    });
  });
});
    </script>
</div>
