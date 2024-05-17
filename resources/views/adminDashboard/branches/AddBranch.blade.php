<x-HeaderMenuAdmin>
<h3 style="margin-top:10px ;"> Ajouter les Filières</h3>
@if(session('success'))
<div id="liveAlertPlaceholder" class="alert alert-success w-25">
    {{ session('success') }}
</div>
@endif
@if ($errors->any())
@foreach ($errors->all() as $error )
<div class="alert alert-danger w-25">{{$error}}</div>
@endforeach
@endif


<form action="{{route('createBranch')}}" method="POST">
    @csrf
    <label style="font-size: 19px" for=""> Nome Filiére : </label>
    <input style="width:300px" class="form-control col-3" type="text" name='name'placeholder='Assistant Administratif option Commerce' />
    <label style="font-size: 19px" for=""> code Filiére :</label>
    <input style="width:300px" class="form-control col-3" type="text" name='id' placeholder="Example GC_AA_T" />
    <button class="btn btn-primary my-5" type="submit"> Ajuter Filiéres</button>
</form>

<div>
    <table style="font-saza:19px;font-weight: bold;width:70vw " class="table table-striped">
        <thead>
            <tr>
                <th style="font-weight: bold" scope="col">code Filiére</th>
                <th style="font-weight: bold" scope="col">Filière</th>
                <th style="font-weight: bold" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
    @foreach ( $branches as $branche )
    <tr>

        <td>{{ preg_replace("/^\d+/", '', $branche->id) }}</td>

        <td style="Width: 520px">{{$branche->name}}</td>
        <td style="width: 220px">
            <button type="button" class="btn btn-primary">
                <a style="text-decoration: none ;color:black" href="{{ route('update-branch', ['id' => $branche->id]) }}">Edit</a>
            </button>
            <button type="button" class="btn btn-danger">
                <a href="{{route('delateBranch',['id'=>$branche->id])}}">Delete</a>
            </button>
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
</x-HeaderMenuAdmin>
