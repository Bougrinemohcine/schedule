<x-HeaderMenuAdmin>
<h1>Update branch</h1>

<form action="{{ route('updateBarnch', ['id' => $branche->id]) }}" method="POST">

    @csrf
    <label style="font-size: 19px" for=""> Nome Filiére : </label>
    <input style="width:300px" value="{{$branche->name}}" class="form-control col-3" type="text" name='name'/>
    <label style="font-size: 19px" for=""> code Filiére :</label>
    <input style="width:300px" value="{{$branche->id}}" class="form-control col-3" type="text" name='id'/>
    <button class="btn btn-success my-5" type="submit"> Update</button>
</form>
</x-HeaderMenuAdmin>
