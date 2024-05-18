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
            width: 80vw ;
            display: flex ;
            position: absolute ;
            justify-content: space-between;
            color: white ;
            z-index: 99912220202;
            margin-top:-32px ;
        }
        @media screen and (max-width:650px){
            .dateContent{
            width: 95vw ;
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
        .SearchContainer {
            display: none ;
        }
        }
        @media screen and (max-width:1116px){
            .dateSE{
                display: none ;
            }
        }

        .SearchContainer{
            max-width: 340px !important;
            z-index:9222;
            position:absolute;
            top :-5rem ;
            left:16rem ;
            display:block;
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

    <div class="table-responsive">
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
                    <input id='searchInput'  type="search" class="form-control rounded  " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <select style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" wire:model="groupID" id="selectOptions" class="form-control col-3" name="">
                                <option > les Groupes</option>
                                @foreach ($groups as $group)
                                      <option class="form-control"  value="{{$group->id}}">{{$group->group_name}} </option>
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
            <div class=" SearchContainer rounded">
                <div style="  display:flex ;">
                    <input id='searchInput12'  type="search" class="form-control rounded searchDev hide " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <div class="selectDiv hide" style=";height: 47px ;width:360px ;margin-left: 15px">
                            <select style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" wire:model="groupID" id="selectOptions12" class="form-control col-3" name="">
                                <option > les Groupes</option>
                                @foreach ($groups as $group)
                                      <option class="form-control"  value="{{$group->id}}">{{$group->group_name}} </option>
                                @endforeach
                            </select>
                    </div>
                </div>

        </div>
        <div class="dateContent">
            @if ($this->checkValues[0]->modeRamadan)
            <h4 class="dateSE" style="marign-top:15px " >
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

        <table id="tbl_exporttable_to_xls" style="overflow:scroll " class="col-md-12 ">

             @if($tableEmploi[0]->groupe == '2')
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
                @php
                    $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                @endphp
                <tr>
                    @foreach ($dayWeek as $day)
                        @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                            @php
                                $sessionFound = false;
                            @endphp
                            @foreach ($sissions as $sission)
                                @if ($sission->day === $day && $sission->group_id === $groupID && $sission->day_part === substr($sessionType, 0, 5) && $sission->dure_sission === substr($sessionType, 5))
                                    <td wire:click='updateCaseStatus(false)' data-bs-toggle="modal"
                                    style="background-color:rgba(12, 72, 166, 0.3) ;"
                                     class="tdClass Cases {{$day}}" data-bs-target="#exampleModal" id="{{ $day . $sessionType }}">
                                       {{$sission->group_name}}<br> {{ $sission->sission_type }}<br> @if($sission->class_name) {{ $sission->class_name }}  @else SALLE @endif <br>{{ $sission->typeSalle }} <br>{{ $sission->user_name }}<br>{{ preg_replace('/^\d+/', '', $sission->module_name) }}
                                    </td>
                                    @php
                                        $sessionFound = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if (!$sessionFound)
                                <td wire:click='updateCaseStatus(true)' data-bs-toggle="modal" class="tdClass Cases {{$day}}" data-bs-target="#exampleModal" id="{{ $day . $sessionType }}"></td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            </tbody>

            @elseif ($tableEmploi[0]->groupe == '1')
            @include('livewire.PourGroupe')
            @elseif ($tableEmploi[0]->groupe == '4')
            @include('livewire.PourGroupe4')
            @else
            @include('livewire.PourGroup3')
            @endif


                     {{-- Model --}}
                     <div style="z-index:999999" wire:ignore.self  class="modal fade col-9" id="exampleModal" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog  modal-lg  ">
                        <div class="modal-content  col-9">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" >
                                    Create session</h1>
                                    @if ($errors->any())
                                    @foreach ( $errors->all() as $error)
                                    <div id="liveAlertPlaceholder" class="alert alert-danger">
                                        {{$error}}
                                    </div>
                              @endforeach
                              @endif

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form wire:submit.prevent="UpdateSession">
                                <div class="modal-body">

                                    <div style="display: flex">


                                           {{-- Formateur --}}
                                           @if (!$checkValues[0]->formateur)
                                           <select wire:model='formateurId' class="form-select"
                                           aria-label="Default select example">
                                           <option selected value="null">Les Formateur</option>
                                           @if ($formateurs)
                                               @foreach ($formateurs as $formateur)
                                                   <option value="{{ $formateur->id }}">
                                                       {{ $formateur->user_name  }}</option>
                                               @endforeach
                                               @endif
                                       </select>
                                       @endif


                                        {{-- module  content --}}
                                        @if (!$checkValues[0]->module)
                                        <select wire:model="moduleID"   class="form-select"
                                        aria-label="Default select example">
                                            <option selected value="null">Modules</option>
                                            @if ($modules)
                                                @foreach ($modules as $module)
                                                <option value="{{ $module->id }}">
                                                    {{ preg_replace('/^\d+/' , '' ,$module->id )}}</option>

                                                @endforeach
                                            @endif
                                        </select>
                                        @endif

                                    </div>
                                    <div style="display: flex">



                                        {{-- salle --}}
                                        @if (!$checkValues[0]->salle)
                                        <select wire:model="salle" class="form-select"
                                            aria-label="Default select example">
                                            <option selected value="null">les salles</option>
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
                                            <option selected value="null"> Type Salle</option>
                                            @if ($classType)
                                                @foreach ($classType as $classTyp)
                                                    <option value="{{ $classTyp->class_room_types }}">
                                                        {{ $classTyp->class_room_types }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @endif


                                    </div>
                                    <div style="display: flex">
                                        @if (!$checkValues[0]->typeSession)
                                        <select wire:model="TypeSesion" class="form-select"
                                            aria-label="Default select example">
                                            <option selected value="null">Type Séance</option>
                                            <option value="PRESENTIEL">Presentielle</option>
                                            <option value="teams">Teams</option>
                                            <option value="EFM">EFM</option>
                                        </select>
                                        @endif
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        @if ($isCaseEmpty)
                                        <button id="SaveAndUpdate" data-bs-dismiss="modal" type="submit" class="btn btn-primary">
                                         Save
                                        </button>
                                     @else
                                        <button id="SaveAndUpdate" data-bs-dismiss="modal" type="submit" class="btn btn-success ">
                                         Update
                                        </button>
                                        <button data-bs-dismiss="modal" wire:click="DeleteSession" aria-label="Close" type="button"  class="btn btn-danger">supprimer</button>

                                     @endif
                                </div>
        </table>


    </div>

    <button onclick="ExportToExcel('xlsx')" class=" btn  btn-primary mt-5">télécharger</button>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-danger mt-5 col-3" data-bs-toggle="modal" data-bs-target="#exampleModal111">
        Supprimer tout
    </button>

    <!-- Modal for delete-->
    <div style="z-index:12121212 ; " wire:ignore class="modal fade" id="exampleModal111" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr(e) de vouloir supprimer toutes les sessions que vous avez créées ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-danger" wire:click='deleteAllSessions'>Oui, Supprimer Tout</button>
                </div>
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
              Livewire.emit('receiveVariable', element.id );
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



// auther input Searsh

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

