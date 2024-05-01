<x-HeaderMenuAdmin>



<div style="display: flex">
  
   <div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors as $error)
        {{$error}}
        @endforeach
    </div>
      @endif
    <form method='POST' action="{{route('UpdateClasses')}}">
        @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">class Name (number)</label>
          <input type="text" name='class_name' value="{{$class->class_name}}" class="form-control" >
        </div>
        <input type="text" name='class_id' value="{{$class->id}}" style="display: none"  class="form-control" >

        <button type="submit" class="btn btn-primary"><a style="text-decoration: none ;color:black" >Update</a></button>
      </form>



    </div>
</div>


</x-HeaderMenuAdmin>
