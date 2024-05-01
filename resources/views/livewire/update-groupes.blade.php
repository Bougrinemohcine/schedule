
    <div wire:ignore.self  class="modal fade" id="exampleModal99{{$group['group_id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier groupe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">group Name </label>
                            <input id="groupName{{$group['group_id']}}" type="text" wire:model='group_name' class="form-control group_name" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">les Filiéres</label>
                            <select id="branch{{$group['group_id']}}" wire:model="selectedBranch" class="form-control select2 branch">
                                 <option>Filiére</option>
                                 @foreach ($branches as $branche)
                                     <option class="branchOption" value="{{$branche->id}}">{{$branche->name}}</option>
                                 @endforeach
                            </select>

                            <div class="mb-3">
                                <h6 style="margin:10px"> Modules </h6>
                                <div style="width: 100%" class="checkboxContainer  col-lg-9">
                                    @foreach ($modules as $module)
                                    <span>
                                        <input class="modulesoption" type="checkbox" wire:model="selectedModules.{{ $module->id }}" value="{{ $module->id }}">
                                        <label for="module{{$group['group_id']}}_{{ $module->id }}">{{ preg_replace('/^\d+/', '', $module->id) }}</label>
                                    </span>
                                @endforeach

                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="year" class="form-label">Année</label>
                                <input id="year{{$group['group_id']}}"  type="text" wire:model="year" class="form-control yearupdate" >
                            </div>





                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button  data-group-id="{{$group['group_id']}}"  type="submit" id="{{$group['group_id']}}"
                             class="btn btn-success updateButtons">Save changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

