<x-HeaderMenuAdmin>


<div style="display: flex ;margin:20px 0px 0px 20px">

   <div>
    @if($errors->any())
        <div id="liveAlertPlaceholder" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
    <div id="liveAlertPlaceholder" class="alert alert-success">
        {{ session('success') }}
    </div>
      @endif
    <form method='POST' action="{{route('insertClasses')}}">
        @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nom de Salle (number)</label>
          <input type="text"name='class_name' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
      </form>
   {{-- table --}}
   <h3>Les Salles</h3>
   <table class="table table-striped">
    <thead>
        <tr>
          <th scope="col">#</th>
          <th tpscope="col">salle</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
   @if($classes)
   @foreach ($classes as $class )
   <tr>
    <th scope="row">{{$class->id}}</th>
    <td colspan="2">{{$class->class_name}}</td>
    {{-- <td>{{$class->class_room_type}}</td> --}}
    <td>
      <button type="button" class="btn  btn-primary"><a  style="text-decoration: none ;color:black" href="{{url('admin/UpdateClasses/'.$class->id)}}">Edit</a></button>
      <button type="button" class="btn btn-danger"><a href="{{route('delate-class',['id'=>$class->id])}}">Delete</a></button>
    </td>
  </tr>
   @endforeach
   @endif
      </tbody>
  </table>
    </div>
</div>


</x-HeaderMenuAdmin>
