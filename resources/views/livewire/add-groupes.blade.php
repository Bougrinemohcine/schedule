<div style="margin:20px 0px 0px 20px">
    <style>
        .checkboxContainer {
            background-color: white;
            border-radius: 7px;
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
    </style>

    <div style="width:50%;margin-x:auto">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal1">
            Ajouter groupe
        </button>
        <!-- Modal create groupes -->
        <div wire:ignore.self class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter groupe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="create">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label"> Nom group  </label>
                                <input style="border: 1.2px solid #eee; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" placeholder="Nom groupe" wire:model='group_name' type="text" name='group_name' class="form-control mb-lg-3 col-lg-9" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">les Filiéres</label>
                                <select style="border: 1.2px solid #eee; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"
                                 wire:model='selectedBranch' class="form-control select2 mb-lg-3 col-lg-9">
                                    <option>Filiére</option>
                                    @foreach ($branches as $branche)
                                    <option value="{{ $branche->id }}">{{ $branche->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div wire:ignore class="mb-3">
                                <h6 style="margin:10px">Modules</h6>
                                <div style="border: 1.2px solid #eee; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" class="checkboxContainer mb-lg-3 col-lg-9">
                                    @foreach ($modules as $module)
                                    <span>
                                        <input wire:model="selectedModules.{{ $module->id }}" type="checkbox" id="module{{ $module->id }}" name="selectedModules[]" value="{{ $module->id }}">
                                        <label for="module{{ $module->id }}">{{ preg_replace('/^\d+/', '', $module->id) }}</label>
                                    </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="year" class="form-label">Année</label>
                                <input style="border: 1.2px solid #eee; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" placeholder="Année" wire:model.defer="year" type="text" name="year" class="form-control mb-lg-3 col-lg-9" >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- table --}}
        <div wire:ignore.self>
            <h3>Groupes</h3>
            <table class="table table-striped" style="font-size: 19px; font-weight:300; width: 70vw;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Groupe</th>
                        <th scope="col">Code Filiére</th>
                        <th colspan="">Filière</th>
                        <th scope="col">Niveau</th>
                        <th style="width: 300px ;overflow: hidden;" colspan="4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($groups)
                    @foreach ($groups as $key => $group )
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $group['group_name'] }}</td>
                        <td>{{ preg_replace('/^\d+/' , "" ,$group['branch_id'])}}</td>
                        <td>{{ $group['branch'] }}</td>
                        <td>{{ $group['year'] }}</td>
                        <td style="display: flex ;overflow: hidden ;">
                            <!-- Modal trigger button for viewing more details -->
                            {{-- <button wire:ignore.self type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop_{{$group['group_id'] }}">Voir plus</button> --}}
                             <button wire:ignore.self type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop_{{ $group['group_id'] }}">Voir plus</button>
                            <!-- Modal trigger button for editing -->
                            <button wire:ignore.self type="button" id="EditButton_{{$group['group_id']}}" class="btn btn-primary EditButton"
                            data-bs-toggle="modal" data-bs-target="#exampleModal99{{$group['group_id']}}">Modifier</button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>


            {{--start Edit Model  --}}
            @foreach ($groups as $group)
            <!-- Modal -->
            @livewire('update-groupes', ['group' => $group , 'branches'=>$branches ,
            'modules'=>$modules ], key($group['group_id']))
            {{-- end Edit model  --}}


            <!-- Modals for detailed group information -->

            <div class="modal fade" id="staticBackdrop_{{ $group['group_id'] }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_{{ $group['group_id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel_{{ $group['group_id'] }}">{{ $group['group_name'] }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <!-- Table to display detailed information -->
                            <table class="table table-striped" style="font-size: 19px; font-weight:300;">
                                <thead>
                                    <tr>
                                        <th scope="col">Les Modules</th>
                                    </tr>
                                </thead>
                                <tbody style="color: black">
                                    <tr>
                                        <td colspan="9">
                                            @foreach ($group['modules'] as $module)
                                            {{ preg_replace('/^\d+/' , '' , $module) }},
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- Delete button -->
                            <button wire:click='delete("{{ $group['group_id'] }}")' data-bs-dismiss="modal" type="button" class="btn btn-danger">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    let EditButton = document.querySelectorAll('.EditButton');

    EditButton.forEach(button => {
        button.addEventListener('click', function () {
            const groupId = button.id;
            fetch('GetdataGroupe/' + groupId, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                if (data.status === 200) {

                    let modulesoption = document.querySelectorAll('.modulesoption');
                    // let modulesoption = document.getElementsByClassName('modulesoption')
                    document.getElementById('groupName' + groupId).value = data.data.group_name;
                    document.getElementById('year' + groupId).value = data.data.year;
                    document.getElementById('branch' + groupId).value = data.data.branch_id

                    let groupModules = data.data.modules;
                    Array.from(modulesoption).forEach(module => {
                                    let isChecked = false;
                                    data.data.modules.forEach(item => {
                                if (module.value.toLowerCase() === item.toLowerCase()) {
                                    isChecked = true;
                                    return;
                                    }
                                });
                                module.checked = isChecked;
                        })

                    console.log(data);
                } else {
                    console.error('Error: Unexpected status code received from server');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        });
    });



});











</script>
</div>
