<div >
    <style>
        @media (max-width:600px){
            .flexContainer{
            display: grid ;
            grid-template-columns: repeat(auto-fill, minmax(300px, 2fr));

        }

        }


        .checkboxContainer {
            background-color: white;
            border-radius: 7px;
            border: 1.2px solid #eee;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            max-height: 150px;
            overflow-y: scroll;

        }

        .checkboxContainer span {
            margin: 4px;
            display: block;
        }

        .checkboxContainer span:hover {
            background-color: #eee;
        }

        .checkboxContainer span input {
            width: 35px;
        }

        input[type="checkbox"]:checked + label {
            background-color: #eee;
        }

        #SearchContainer123{
            width: 45% !importent;
        }

    </style>
    {{-- create formateur  --}}
   <!-- Button trigger modal -->
<button style="margin-bottom:8px ; marign-top:20px ;" type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal7">
    Create formateur Account
  </button>
  <div wire:ignore.self  class="modal fade" id="exampleModal7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter formateur </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div style="max-width: 80vw; ">
                <form wire:submit.prevent="create">
                    @csrf
                    <div class="d-flex w-100 justify-content-between">
                        <div style="width: 45%" class="mb-lg-3 ">
                            <label for="formateur_name" class="form-label">Nom  Formateur </label>
                            <input style="border: 1.2px solid #eee;
                            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" wire:model="formateur_name" placeholder="Nom de Formateur " type="text" name="formateur_name" class="form-control" id="formateur_name">
                        </div>
                        <div style="width: 45%"  class="mb-lg-3 ">
                            <label for="idFormateur" class="form-label">Matricule formateur</label>
                            <input style="border: 1.2px solid #eee;
                            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" wire:model="idFormateur" placeholder="Matricule formateur" type="text" name="idFormateur" class="form-control" id="idFormateur">
                        </div>
                    </div>


                <div  class="d-flex w-100 justify-content-between">
                    <div style="width:45%" >
                    <div style="margin:15px 0px 15px 0px" class="form-check">
                        <input  style="width:25px; height:25px;margin-right:10px" class="form-check-input" type="checkbox" value=""
                            id="flexCheckDefault">
                        <label style="font-size:18px;" class="form-check-label" for="flexCheckDefault">
                            base sure les Filiéres
                        </label>
                    </div>
                        <div id="Filier" style="width: 100%" class="checkboxContainer mb-lg-3   col-lg-9">
                            <h6 style="margin:10px">Filiéres</h6>
                            @foreach ($branches as $branch)
                                <span>
                                    <input wire:model="selectedBranches" type="checkbox" id="branch{{ $branch->id }}" name="selectedBranches[]" value="{{ $branch->id }}">
                                    <label for="branch{{ $branch->id }}"> {{ $branch->name }} </label>
                                </span>
                            @endforeach
                        </div>
                    </div>

                <script>
                    let flexCheckDefault = document.getElementById('flexCheckDefault');
                    let dateselect = document.getElementById('Filier')
                    dateselect.style.display = 'none'
                    flexCheckDefault.addEventListener('click' , function (){
                       if(!flexCheckDefault.checked){
                        dateselect.style.display = 'none';
                        dateselect.value = null
                       }else{
                        dateselect.style.display = 'block'
                       }
                    })
                </script>

               <div style=" width:45%">
                    <div style="margin:15px 0px 15px 0px" class="form-check">
                        <input  style="width:25px; height:25px;margin-right:10px" class="form-check-input" type="checkbox" value=""
                            id="flexCheckDefault1">
                        <label style="font-size:18px;" class="form-check-label" for="flexCheckDefault1">
                            base sure les Groupes
                        </label>
                    </div>
                    <div id="group" style="width: 100%"  class="checkboxContainer mb-lg-3  col-lg-9">
                        <h6 style="margin:10px">Les Groupes</h6>
                        @foreach ($groupes as $groupe)
                            <span>
                                <input wire:model="selectedGroupes" type="checkbox" id="group{{ $groupe->id }}" name="selectedGroupes[]" value="{{ $groupe->id }}">
                                <label for="group{{ $groupe->id }}">{{ $groupe->group_name }}</label>
                            </span>
                        @endforeach
                    </div>
                    <script>
                        let flexCheckDefault1 = document.getElementById('flexCheckDefault1');
                        let dateselect1 = document.getElementById('group')
                        dateselect1.style.display = 'none'
                        flexCheckDefault1.addEventListener('click' , function (){
                           if(!flexCheckDefault1.checked){
                            dateselect1.style.display = 'none';
                            dateselect1.value = null
                           }else{
                            dateselect1.style.display = 'block'
                           }
                        })
                    </script>
               </div>
              </div>

            <div>
                <div style="margin:15px 0px 15px 0px" class="form-check">
                    <input  style="width:25px; height:25px;margin-right:10px" class="form-check-input" type="checkbox" value=""
                        id="flexCheckDefault3">
                    <label style="font-size:18px;" class="form-check-label" for="flexCheckDefault3">
                        base sure les Modules
                    </label>
                </div>
                        <div id="module" style="width: 65% ;margin:auto"  class="checkboxContainer mb-lg-3 col-lg-9">
                            <h6 style="margin:10px">Les Modules</h6>
                            @foreach ($modules as $module)
                                <span>
                                    <input wire:model="selectedModules" type="checkbox" id="module{{ $module->id }}" name="selectedModules[]" value="{{ $module->id }}">
                                    <label for="module{{ $module->id }}">{{ preg_replace('/^\d+/', '', $module->id) }}</label>
                                </span>
                            @endforeach
                        </div>

                        <script>
                            let flexCheckDefault3 = document.getElementById('flexCheckDefault3');
                            let dateselect3 = document.getElementById('module')
                            dateselect3.style.display = 'none'
                            flexCheckDefault3.addEventListener('click' , function (){
                               if(!flexCheckDefault3.checked){
                                dateselect3.style.display = 'none';
                                dateselect3.value = null
                               }else{
                                dateselect3.style.display = 'block'
                               }
                            })
                        </script>
            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Create </button>
        </div>
    </form>
      </div>
    </div>
  </div>
    {{-- end create formateur  --}}

    {{-- Display formateur info  --}}
    <div style="max-width: 400px" id="SearchContainer123" class="input-group rounded" wire:ignore>
        <input wire:model='SearchValue'   type="search" class="form-control rounded " placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <span class="input-group-text border-0" id="search-addon">
          <i class="fas fa-search"></i>
        </span>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th colspan="2">Matricule </th>
                                        <th>Mot de passe</th>
                                        <th>état</th>
                                        <th colspan="2">actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($formateurs)
                                        @foreach ($formateurs as $key => $formateur )
                                            <tr>
                                                <th scope="row">{{$key +1}}</th>
                                                <td colspan="">{{$formateur->user_name}}</td>
                                                <td colspan="2">{{$formateur->id}}</td>
                                                <td colspan="">{{$formateur->passwordClone}}</td>
                                                <td>
                                                    <span class="badge {{$formateur->status==='active' ? ' badge-soft-success ' : ' badge-soft-danger '}} font-size-12">{{$formateur->status}}</span>
                                                </td>
                                                <td>

                                                    <button  id='viewBtn_{{$formateur->id}}' type="button" class="btn btn-primary catchEvent" data-bs-toggle="modal" data-bs-target="#staticBackdrop_{{$formateur->id}}" >View plus</button>
                                                    <button  id='editBtn_{{$formateur->id}}' type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal_{{$formateur->id}}" >Modifier</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


 @foreach ($formateurs as $formateur)
    <!-- Modals for detailed group information -->
    <div class="modal fade" id="staticBackdrop_{{ $formateur->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_{{ $formateur->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel_{{ $formateur->id }}">{{ $formateur->user_name }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Table to display detailed information -->
                    <table class="table table-striped" style="font-size: 19px; font-weight: 300;">
                        <thead>
                            <tr>
                                <th scope="col">Code Filiére</th>
                                <th scope="col">Les Modules</th>
                                <th scope="col">Les groupes</th>
                            </tr>
                        </thead>
                        <!-- Data for detailed informateur -->
                        <tbody class="moreDetailes" id="moreDetails_{{$formateur->id}}" style="color: black">

                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="destroy('{{ $formateur->id }}')" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal Edit --}}
    @livewire('update-formateur', [
        'formateur' => $formateur,
        'branches' => $branches,
        'groupes' => $groupes,
        'modules' => $modules
    ], key('update-formateur-' . $formateur->id))
    {{-- End edit formateur --}}
@endforeach
<script>
    const buttons = document.getElementsByClassName('catchEvent');

Array.from(buttons).forEach(button => {
    button.addEventListener('click', function() {
        const IdFormateur = button.getAttribute('id').replace('viewBtn_' , "");
        console.log(IdFormateur);
        fetch('/admin/reserve/' + IdFormateur, { method: "GET" })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 200) {
                    console.log(data.branches);
                    const jsxBranches = data.branches.map(branch => branch.id.replace(/^\d/, '')).join(', ');
                    const jsxGroupes = data.Groupes.map(groupe => groupe.group_name).join(', ');
                    const jsxModules = data.modules.map(module => module.id.replace(/^\d/, '')).join(', ');
                    const moreDetails = document.getElementById(`moreDetails_${IdFormateur}`);
                    moreDetails.innerHTML = `
                        <tr>
                            <td>${jsxBranches}</td>
                            <td>${jsxModules}</td>
                            <td>${jsxGroupes}</td>
                        </tr>
                    `;
                }
            });
    });
});

</script>

</div>

