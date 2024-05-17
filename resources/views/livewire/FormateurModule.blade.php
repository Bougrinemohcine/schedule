  {{-- Model --}}
  <div style="z-index: 9999099983" wire:ignore.self  class="modal fade col-9"  id="exampleModal"
  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        {{-- <form wire:submit.prevent="createSession"> --}}
            <form wire:submit.prevent='UpdateSession'>
            <div class="modal-body">
                <div style="display: flex">
                    {{-- branches --}}
                    @if (!$checkValues[0]->branch)
                    <select wire:model='brancheId'  class="form-select "  aria-label="Default select example">
                        <option > Filiére</option>
                        @if ($baranches)
                        @foreach ($baranches as $baranche)
                        <option value="{{ $baranche->id }}">{{ $baranche->name }}</option>
                        @endforeach
                        @endif
                        </select >
                        @endif
                        {{-- year --}}

                        @if (!$checkValues[0]->year)
                        <select wire:model='selectedYear'  class="form-select "  aria-label="Default select example">
                            <option > année </option>
                            @if ($yearFilter)
                            @foreach ($yearFilter as $item)
                            <option value="{{ $item }}">{{ $item}}</option>
                            @endforeach
                            @endif
                        </select >
                        @endif
                           {{-- module  content --}}
                     @if (!$checkValues[0]->module)
                     <select wire:model="module" class="form-select "
                     aria-label="Default select example">
                     <option selected>Modules</option>
                     @if ($modules)
                         @foreach ($modules as $module)
                             <option value="{{ $module->id }}">
                                 {{ preg_replace('/^\d+/' , '' ,$module->id )}}</option>
                         @endforeach
                     @endif
                 </select>
                 @endif

                </div>
                <div style="display: block">

                  {{-- Groupes --}}
                  @if ($groups)
                  <div class="mb-3">
                    <h6 style="margin: 10px;">Groupes</h6>
                    <div style="width: 100%;" style="" class="checkboxContainer ">
                        @foreach ($groups as $group)
                            <span style="display: block">
                                <input class="modulesoption" type="checkbox" wire:model="selectedGroups.{{ $group->id }}" value="{{ $group->id }}">
                                <label>{{ $group->group_name }}</label>
                            </span>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mb-3">
                    <h6 style="margin: 10px;">Groupes</h6>
                    <div style="width: 100%;" style="" class="checkboxContainer ">
                       No groupe trouver !
                    </div>
                </div>
                @endif
                <br>

                    {{-- salle --}}
                    @if (!$checkValues[0]->salle)
                    <select wire:model="salle" class="form-select"
                        aria-label="Default select example">
                        <option selected>les salles</option>
                        @if (!empty($salles))
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
                        <option value="" selected> Type Salle</option>
                        @if ($classType)
                            @foreach ($classType as $classTyp)
                                <option value="{{ $classTyp->class_room_types }}">
                                    {{ $classTyp->class_room_types }}</option>
                            @endforeach
                        @endif
                    </select>
                    @endif

                    {{-- id case --}}
                    <input type="hidden"   value="{{$receivedVariable}}" >
                </div>
                {{-- day part && type sission --}}
                <div style="display: flex">
                    @if (!$checkValues[0]->typeSession)
                    <select wire:model="TypeSesion" class="form-select"
                        aria-label="Default select example">
                        <option value="null" selected>Type  Séance</option>
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
        </form>
</div>
    </div>
