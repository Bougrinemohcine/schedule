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


        @media screen  and (max-width : 700px){
            .ResponceUI{
            flex-direction: column ;

        }
        .searchDev{
            width: 100vw ;
        }
        .selectDiv{
            width: 70vw !important;
            margin-left:0px !important ;
        }

    }


    </style>


    @php

@endphp
    <h2>Schedule Table</h2>


    <div class="table-responsive">
        <div class="ResponceUI element-to-remove" style="max-width:60rem ;  display:flex; justify-content:flex-start ; position: fixed">

            <div   class="input-group rounded">
                <input id='searchInput'   type="search" class="form-control rounded searchDev " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon">
                  <i class="fas fa-search"></i>
                </span>
            </div>
            <div class="selectDiv" style=";height: 47px ;width:360px ;margin-left: 15px">

            <select  style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" wire:model="formateurId" id="selectOptions" class="form-control " name="">
                <option >Formateur</option>
                @foreach ($formateurs as $formateur)
                   <option class="form-control"  value="{{$formateur->id}}">{{$formateur->user_name}} </option>
                @endforeach
            </select>
            </div>
      </div>
      <br/>
      <br/>
      <br/>
      <br></br>

        <table  id="tbl_exporttable_to_xls" style="overflow:scroll ;" class="col-md-12 ">

            <div style="display: flex ;justify-content:space-between ;marign-top:50px ;width:70rem">
                @if ($this->checkValues[0]->modeRamadan)
                    <h4 style="marign-top:15px " >
                        SE1 = 08:30 - 10:20 SE2 = 10:25 - 12:15 SE3 = 12:45 - 14:35 SE4 = 14:40 - 16:30
                    </h4>
                @else
                    <h4> SE1 = 08:30 - 11:20 SE2 = 11:30 - 13:30 SE3 = 13:30 - 16:20 SE4 = 16:30 - 18:30 </h4>
                @endif
                    @if (!$dataEmploi->isEmpty())
                    <h4 >
                        @foreach ($dataEmploi as $item)
                            Du: {{ $item->datestart }} au {{ $item->dateend }}
                        @endforeach
                    </h4>
                    @else
                    <h4 style="float: right; margin-top: 15px; padding: 0px 5px 0px 5px; border-radius: 3px; background-color: #dc3545; color: white;">
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
                        $ModuleValue;
                    @endphp
                    @foreach ($sissions as $sission)
                        @if ($sission->day === $day && $sission->day_part === substr($sessionType, 0, 5)  && $sission->dure_sission === substr($sessionType, 5))
                            @php
                                $groupes[] = $sission->group_name ;
                                $sessionFound = true;
                                $SalleValue = $sission->class_name ;
                                $Typevalue = $sission->sission_type ;
                                $ModuleValue = preg_replace('/^\d+/', '', $sission->module_name);
                              
                            @endphp
                        @endif
                    @endforeach
                    <td
                    style="background-color:{{ $sessionFound ? "rgba(12, 72, 166, 0.3)" :  ''}} ; height: 130px !important"
                    wire:click="updateCaseStatus({{ $sessionFound ? 'false' : 'true' }})"
                    data-bs-toggle="modal"
                    class="tdClass Cases" data-bs-target="#exampleModal" id="{{ $day.$sessionType }}">
                        @if ($sessionFound)
                            {{ implode(' - ', $groupes) }}<br/>
                            {{$SalleValue}}<br/>
                            {{$Typevalue}} <br/>
                            {{$ModuleValue}}
                        @endif
                    </td>
                @endforeach
            @endforeach
        </tr>
    </tbody>

@elseif ($tableEmploi[0]->formateur == '2')
        @include('livewire.PourFormateur')
@else
        @include('livewire.PourFormateur3')
@endif
        @include('livewire.FormateurModule')
        </table>
    </div>

    <button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5">
        telecharger</button>
<button class="btn  btn-primary mt-5" wire:click='AddAutherEmploi'> <span class="mdi mdi-plus"></span> Ajouter un autre</button>
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
    </script>
</div>