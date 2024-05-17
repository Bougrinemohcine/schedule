<x-HeaderMenuAdmin>





            <form method="post" action="{{route('insert-class-with-types')}}">
                  <div style="margin: 20px 0px 0px 20px">
                     @if($errors->any())
                    <div class="alert alert-danger w-5">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                  @endif
                @csrf
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Select class
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li>
                        <input class="form-check-input"  type="checkbox" value="" id="option1">
                        <label class="form-check-label" for="option1">
                         All
                        </label>
                      </li>
                      @if($classes)
                      @foreach ($classes as $class)
                      <li>
                        <input class="form-check-input" type="checkbox" name="classes[]" value="{{$class->id}}" id="option1">
                        <label class="form-check-label" for="option1">
                          {{$class->class_name}}
                        </label>
                      </li>
                      @endforeach
                      @endif
                    </ul>
                    <br>
                    <button class="btn btn-primary my-5 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Select types
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <input class="form-check-input" type="checkbox" value="" id="option1">
                          <label class="form-check-label" for="option1">
                           All
                          </label>
                        </li>
                        @if($types)
                      @foreach ($types as $type)
                      <li>
                        <input class="form-check-input" type="checkbox"  name="types[]" value="{{$type->id}}" id="option1">
                        <label class="form-check-label" for="option1">
                          {{$type->class_room_types}}
                        </label>
                      </li>
                      @endforeach
                      @endif

                      </ul>
                      <br/>
                      <button  type="submit"  class="btn  btn-success">save</button>
                  </div>

            </form>
            {{-- table --}}
       <table class="table table-striped">
                <thead>
                    <tr>

                      <th scope="col">Nom de Salle</th>
                      <th scope="col">Salle type</th>
                      <th scope="col">actions</th>

                    </tr>
                  </thead>
                  <tbody>
            @foreach ($classes_with_types as $key => $classe)
    <tr>
        <th scope="row">{{ $key }}</th>
        <td colspan="2">{{ implode(', ', $classe) }}</td>
        <td>

            <button type="button" class="btn btn-danger"><a href="{{route('delateClassWithType',['classNAme'=>$key])}}">Delete</a></button>
        </td>



    </tr>
@endforeach

        </tbody>
    </table>

    {{-- {{$classes_with_types['class_name']}} --}}

        </div>


</x-Headers>
