<x-HeaderMenuAdmin>


    <div style="margin-top:20px ;">

        @if ($errors->any())
        @foreach ($errors->all() as $error )
        <div class=" alert alert-danger">{{$error}}</div>
        @endforeach
        @endif
        <form class="" method='POST' action="{{route('insertmodule')}}">
            @if(session('success'))
            <div id="liveAlertPlaceholder" class="alert alert-success">
                {{ session('success') }}
            </div>
      @endif

            @csrf

            <div class="mb-3 col-9">
                <label for="exampleInputEmail1" class="form-label ">Code Module  </label>
                <input placeholder=" Example  EGT101" type="text"name='id' class="form-control w-25" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>

            <button type="submit" class="btn btn-success">save</button>
        </form>
        {{-- table --}}

        <h3>modules</h3>
   <table style="width: 70vw ; font-weight: bold;" class="table table-striped">
    <thead>
        <tr>
          <th scope="col">#</th>
          <th > Code Modules</th>
          <th tpscope="col">Moduls</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
   @if($modules)
   @foreach ($modules as $key => $module )
   <tr>
    <th scope="row">{{$key +1}}</th>
    <th>{{preg_replace('/^\d+/' , '' , $module->id) }}</th>
    <td colspan="">{{$module->module_name}}</td>
    <td colspan="2">
      <button type="button" class="btn  btn-primary">
        <a style="text-decoration: none ;color:black" href="{{route("display_update_page" ,["id"=>$module->id])}}">Edit</a>
    </button>
      <button type="button" class="btn btn-danger">
        <a href="{{route("delateModule",['id'=>$module->id])}}">Delete</a>
    </button>
    </td>
  </tr>
   @endforeach
   @endif
      </tbody>
  </table>


    </div>



</x-HeaderMenuAdmin>
