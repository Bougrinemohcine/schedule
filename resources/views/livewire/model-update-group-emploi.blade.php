 <div class="modal-dialog  modal-lg  ">
        <div class="modal-content  col-9">
            <div class="modal-header">
                <h1 class="modal-title fs-5" >Create session</h1>
                    @if ($errors->any())
                    @foreach ( $errors->all() as $error)
                    <div id="liveAlertPlaceholder" class="alert alert-danger">
                        {{$error}}
                    </div>
              @endforeach
              @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="UpdateSession">
                <div class="modal-body">
                    <div style="display: flex">
                        {{-- module  content --}}
                        <select wire:model="module" class="form-select "
                            aria-label="Default select example">
                            <option selected>Modules</option>
                            @if ($modules)
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">
                                        {{ $module->module_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div style="display: flex">
                        {{-- Formateur --}}
                        @if($FormateurOrgroup==='Group')
                        <select wire:model='formateur' class="form-select"
                            aria-label="Default select example">

                                <option selected>Formateurs</option>
                                    @foreach ($formateurs as $formateur)
                                        <option value="{{ $formateur->id }}">
                                            {{ $formateur->user_name }}</option>
                                    @endforeach
                        </select>
                        @else
                        <select wire:model='group' class="form-select"
                        aria-label="Default select example">
                        <option selected>Groups</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">
                                        {{ $group->group_name }}</option>
                                @endforeach
                        </select>
                            @endif

                        {{-- salle --}}
                        <select wire:model="salle" class="form-select"
                            aria-label="Default select example">
                            <option selected>les salles</option>
                            @if ($salles)
                                @foreach ($salles as $salle)
                                    <option value="{{ $salle->id }}">
                                        {{ $salle->class_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    {{-- tyope session --}}
                    <div style="display: flex;justify-content: space-between">
                        <select wire:model="salleclassTyp" class="form-select"
                            aria-label="Default select example">
                            <option selected>les Types</option>
                            @if ($classType)
                                @foreach ($classType as $classTyp)
                                    <option value="{{ $classTyp->id }}">
                                        {{ $classTyp->class_room_types }}</option>
                                @endforeach
                            @endif
                        </select>
                        {{-- id case --}}
                        <input type="hidden"   value="{{$receivedVariable}}" >
                    </div>
                    {{-- day part && type sission --}}
                    <div style="display: flex">
                        <select wire:model="TypeSesion" class="form-select"
                            aria-label="Default select example">
                            <option selected>Types</option>
                            <option value="presentielle">Presentielle</option>
                            <option value="teams">Teams</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button data-bs-dismiss="modal" wire:click="DeleteSession" aria-label="Close" type="button"  class="btn btn-danger">supprimer</button>
                    <button data-bs-dismiss="modal" wire:click="UpdateSession" aria-label="Close" type="submit"  class="btn btn-success">Updare</button>
                </div>
            </form>

</div>

</div>



