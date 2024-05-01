<x-HeaderMenuAdmin>


    <div style="width:80%;margin-x:auto">
        <form method='POST' action="{{route("update-module" , ['id'=>$module->id])}}">
            @if(session('success'))
            <div id="liveAlertPlaceholder" class="alert alert-success">
                {{ session('success') }}
            </div>
      @endif

            @csrf
            <div class="mb-3 col-9">
              <label for="exampleInputEmail1" class="form-label">Module Name </label>
              <input type="text" name='module_name' value="{{$module->module_name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <button type="submit" class="btn btn-success">update</button>
        </form>
        {{-- table --}}



    </div>



</x-HeaderMenuAdmin>
