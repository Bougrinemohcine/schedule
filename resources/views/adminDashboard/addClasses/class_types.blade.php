<x-HeaderMenuAdmin>




        <div style="margin: 20px 0px 0px 20px">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form method="post" action="{{route('insert-class-type')}}">
                @csrf
                <label for=""> Les types des Salles</label>
                 <input class="form-control w-25" type="text" name="add_class_type" >

                 <button type="submit" class="btn btn-success">Enregistrer</button>
            </form>

            <h3> les Types des Salles</h3>
   <table class="table table-striped">
    <thead>
        <tr>

          <th scope="col">les types</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
   @if($classTypes)
   @foreach ($classTypes as $classType )
 <tr>

     <td colspan="">{{$classType->class_room_types}}</td>
    <td>

      <button type="button" class="btn btn-danger"><a href="{{route('delate-class-type',['id'=>$classType->id])}}">Delete</a></button>
    </td>
 </tr>
    @endforeach
    @endif

      </tbody>
  </table>
        </div>


</x-HeaderMenuAdmin>
