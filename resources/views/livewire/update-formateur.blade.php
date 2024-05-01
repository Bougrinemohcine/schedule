
    <div wire:ignore.self class="modal fade" id="exampleModal_{{$formateur->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$formateur->user_name}}</h5>
                    <button id='{{$formateur->id}}' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form wire:submit.prevent='update'>
                            @csrf
                            <div class="d-flex flexContainer w-100 justify-content-between">
                                <div class="mb-lg-3 " style="width: 45%">
                                    <label  for="New_formateur_name" class="form-label">Formateur Name</label>
                                    <input wire:model="name" style="border: 1.2px solid #eee;  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"   type="text"  class="form-control" id="New_formateur_name">
                                </div>
                                <div class="mb-lg-3 " style="width: 45%">
                                    <label for="New_idFormateur" class="form-label">Matricule formateur</label>
                                    <input  style="border: 1.2px solid #eee; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"
                                     type="text" class="form-control" wire:model="New_idFormateur">
                                </div>
                             </div>
                             <div class="d-flex flexContainer w-100 justify-content-between">

                                <div class="mb-lg-3 " style="width: 45%">
                                    <h6 style="margin:10px">les Filiére</h6>
                                        <div class="checkboxContainer ">
                                            @foreach ($branches as $branch)
                                                <span>
                                                    <input id="New_branch{{ $branch->id }}" class="Branchesoption"  type="checkbox"
                                                          wire:model="selectedBranches.{{$branch->id}}" >
                                                    <label for="New_branch{{ $branch->id }}">{{ $branch->name }}</label>
                                                </span>
                                            @endforeach
                                        </div>
                                </div>
                                <div class="mb-lg-3 " style="width: 45%">
                                    <h6 style="margin:10px">Les Groupes</h6>
                                    <div class="checkboxContainer">
                                        @foreach($groupes as $groupe)
                                        <span>
                                            <input class="Groupesoptions" type="checkbox" id="groupe_{{ $groupe->id }}"
                                                   wire:model="selectedGroupes.{{ $groupe->id }}">
                                            <label for="groupe_{{ $groupe->id }}">{{ $groupe->group_name }}</label>
                                        </span>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flexContainer w-100 justify-content-between">

                                <div class="mb-lg-3 " style="width: 45%">
                                    <h6>Les Modules</h6>
                                    <div class="checkboxContainer">
                                        @foreach ($modules as $module)
                                            <span>
                                                <input  class="modulesoptoins" type="checkbox" id="{{ $module->id }}"
                                                   wire:model="selectedModules.{{$module->id}}">
                                                <label for="New_module{{ $module->id }}">{{ preg_replace('/^\d+/', '', $module->id) }}</label>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-lg-3 " style="width: 45%">
                                    <div>
                                        <label for="New_Password" class="form-label">Mot de passe</label>
                                        <input style="border: 1.2px solid #eee;
                                        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" type="text" placeholder="Mot de passe"
                                         wire:model="password" class="form-control" id="New_Password">
                                    </div>
                                    <span>status</span>
                                    <div style="margin-top: 19px  ;  border: 1.2px solid #eee;
                                    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; heigth:130px">

                                    <br>
                                        <!-- In your Blade view -->
                                        <label>
                                            <input type="radio" wire:model="status" value="active" id="active" checked>
                                            <span class="checkmark"></span>
                                            Active
                                        </label><br>
                                        <label>
                                            <input type="radio" wire:model="status" value="desactive" id="desactive">
                                            <span class="checkmark"></span>
                                            desactive
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button idFormateur="{{$formateur->id}}" id="updateButton" type="submit" class="btn btn-success" aria-label="Close">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

