<div>
    <style>
        .Container-create-emploi {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(600px, 1fr));
            gap: 10px 15px;
        }
        @media screen and (max-width:700px){
            .Container-create-emploi {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }
    </style>

<div wire:ignore.self class="Container-create-emploi">
    <div class="card text-center">
        <div class="card-header">
          Crée un emploi
        </div>
        <div class="card-body">
            <div style="min-height: 100px">
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
            </div>

            <form method="POST" action="{{ route('createNewSchedule') }}">
                @csrf



                <label style=" float:left " for="dateStart">date </label>
                <div class="col-6 w-50 w-md-100 ">
                    <input name="dateStart" id="dateStart" type="date" class="form-control col-6"
                        placeholder="mm/dd/yyyy" value="{{ session()->get('datestart') }}"
                        data-date-container="#datepicker1" data-provide="datepicker">
                </div>
                <div style="margin:15px 0px 15px 0px" class="form-check">
                    <input  style="width:25px; height:25px;margin-right:10px" class="form-check-input" type="checkbox" value=""
                        id="flexCheckDefault">
                    <label style="font-size:18px;" class="form-check-label" for="flexCheckDefault">
                        base sure emploi
                    </label>
                </div>

                <select id='date-select' class="form-select w-50 w-md-100"  name="selectedValue">
                    <option value="" selected disabled>Select emploi</option>
                    @foreach( $Main_emplois as $Main_emploi)
                        <option value="{{ $Main_emploi->id }}">{{ $Main_emploi->datestart }} to {{ $Main_emploi->dateend }}</option>
                    @endforeach
                </select>

                <button id="createEmploi" {{ session()->get('id_main_emploi') === null ? '' : 'disabled' }}
                    style="margin: 5px 0px 10px" class="btn btn-primary">
                    Créer un nouveau emploi
                </button>

            </form>


            <div class="card-footer text-muted d-flex justify-content-between">

                <form method="post" action="{{route('AddAutherEmploies')}}">
                    @csrf
                    <button type="submit" id="ajouter" style="margin: 0px 0px 5px 0px" {{ session()->get('id_main_emploi') !== null ? '' : 'disabled' }}
                        class="btn  btn-primary">
                        <span class="mdi mdi-plus"></span> Ajouter un autre
                    </button>

                </form>


                    <button id="delete" type="submit" class="btn btn-danger" {{ session()->get('id_main_emploi') !== null ? '' : 'disabled' }}
                        data-bs-toggle="modal" data-bs-target="#exampleModal1">
                        Supprimer
                    </button>

            </div>
        </div>
    </div>

    <div class="card text-center">
        {{-- display formateur --}}
        @if($formateurs->isEmpty())
            <div class="card-header">
                Paramètre
            </div>
            <div class="card-body">
                <div class="alert alert-danger" style="margin-top: 6rem;">
                    <h5>Vous devriez configurer vos paramètres de votre compte</h5>
                    <span>Voulez-vous configurer vos paramètres à l'aide d'un fichier Excel ou manuellement ?</span>
                    <a style="margin-top: 5px" class="btn btn-primary" href="{{route('UploedFileExcelView')}}">fichier excel</a>
                    <a style="margin-top: 5px" class="btn btn-primary" href="{{route('AllSetting')}}">manuellement</a>
                </div>
            </div>
        @else
            <div class="card-header">
                Formateur
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th colspan="2">Matricule</th>
                                <th>État</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formateurs as $key => $formateur)
                                <tr>
                                    <td>{{$formateur->user_name}}</td>
                                    <td colspan="2">{{$formateur->id}}</td>
                                    <td>
                                        <span class="badge {{$formateur->status === 'active' ? 'badge-soft-success' : 'badge-soft-danger'}} font-size-12">{{$formateur->status}}</span>
                                    </td>
                                    <td>
                                        <a id="{{$formateur->id}}" type="button" class="btn btn-primary catchEvent" data-bs-toggle="modal" data-bs-target="#staticBackdrop_{{$formateur->id}}" href="{{route('addFormateur')}}">Voir plus</a>
                                        <a id="{{$formateur->id}}" type="button" class="btn btn-primary catchEvent" data-bs-toggle="modal" data-bs-target="#exampleModal" href="{{route('addFormateur')}}">Modifier</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        {{-- end display formateur --}}
        <a href="{{route('addFormateur')}}" class="btn btn-primary">Voir Formateurs</a>
        <div class="card-footer text-muted">
            Voir toutes les informations des formateurs
        </div>
    </div>



    <script>
        let flexCheckDefault = document.getElementById('flexCheckDefault');
        let dateselect = document.getElementById('date-select')
        dateselect.style.display = 'none'
        flexCheckDefault.addEventListener('click' , function (){
           if(!flexCheckDefault.checked){
            dateselect.style.display = 'none';
            dateselect.value = null
           }else{
            dateselect.style.display = 'block'
           }
        })


    </script>

     <!-- Modal for delete-->


    <form method="post" action="{{route('deleteAllSessions')}}">
        @csrf
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Êtes-vous sûr(e)?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Voulez-vous supprimer toutes les sessions que vous avez créées ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
          <button type="submit"  class="btn btn-danger">Oui Supprimer Tout</button>
        </div>
      </div>
    </div>
  </div>
     </form>
  {{-- end Modal for delete  --}}
</div>
