<x-HeaderMenuAdmin>
<style>
.input-group{
    width: 75%;

}
.input-group-text{
    width: 100px
}
@media screen and (max-width:600px){
    .input-group{
    width: 100%;

}
}
</style>


<div class="card text-center">
 <form method="POST" action="{{route('updateAdmindata')}}">
    @csrf
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if ($Obj)
    {{-- @foreach ( $admin as $data) --}}

    <div class="card-header">
        Mon compte
    </div>
    <div class="card-body">
        {{-- role --}}
        <div class="input-group mb-3 ">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default"><span class="mdi mdi-police-badge" style="margin;5px"></span> Role</span>
            </div>
            <input name="role" value="Admin" disabled type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>

      {{-- name --}}
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span  class="input-group-text" id="inputGroup-sizing-default"><span class="mdi mdi-account-lock" style=""></span> Nome</span>
        </div>
        <input name="user_name" value="{{$Obj->name}}" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
      </div>

      {{-- email --}}
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default"><span style="" class="mdi mdi-email-edit "> </span> Email</span>
        </div>
        <input name="email" value="{{$Obj->email}}" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
      </div>

      {{-- pasword --}}
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default"><span class="mdi mdi-lock-open-variant" style="5px"></span> Password</span>
        </div>
        <input name="password" type="text" class="form-control" placeholder="******" aria-label="Default" aria-describedby="inputGroup-sizing-default">
      </div>

      {{-- Matricule --}}
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroup-sizing-default"><span class="mdi mdi-lock-open-variant" style="5px"></span> Matricule</span>
        </div>
        <input  name="id" value="{{$Obj->id}}" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
      </div>

    </div>
    <div class="card-footer text-muted">
     <button type="submit " class="btn btn-primary" href=""> save</button>
    </div>

    {{-- @endforeach --}}
    @endif
</form>
  </div>

</x-HeaderMenuAdmin>
