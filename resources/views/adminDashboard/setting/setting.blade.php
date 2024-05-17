<x-HeaderMenuAdmin>
  <style>
    .container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 10px 15px;
    padding: 15px;

}

.rectungle {
    border-radius: 4.5px;
    padding: 20px;
    transition: all 0.5s; /* Define transition effect here */
    min-width: 250px;
    margin-left: 30px;
    display: block;
    background-color: #eee ;
}

.rectungle:hover {
    border: 2.5px solid #ebe8e8;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    cursor: pointer;
    transform: scale(1.05); /* Example transformation on hover */
}

.containerContent {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: center; /* Center items horizontally */
}

.icon {
    max-width: 50px;
    margin: 3px;
}

.iconStyle {
    font-size: 40px;
    color: #1F5EE6;
}

  </style>

<h3 class="menu-title">LES COMPOSANTS</h3>
<div class="container">



    <a href="{{route('showProfileAdmin')}}">
        <div class="rectungle">
            <div class="containerContent">
                <div class="icon"> <span  class="bx bx-shield-quarter iconStyle"></span></div>
                <div style="width: 70%">
                        <span style="color: black">Admin</span>
                        <br>
                        <span style="color: #504f4f"></span>

                </div>
            </div>
        </div>
    </a>



    <a href="{{route('add-class-rooms')}}">
        <div class="rectungle">
            <div class="containerContent">
                <div class="icon"> <span  class="mdi mdi-home-plus iconStyle"></span></div>
                <div style="width: 70%">
                        <span style="color: black">Ajouter les salles</span>
                        <br>
                        <span style="color: #504f4f">Tout les info sur les Salles</span>

                </div>
            </div>
        </div>
    </a>


    <a href="{{route('add-class-type')}}">
        <div class="rectungle">
            <div class="containerContent">
                <div class="icon"> <span  class="mdi mdi-alpha-t-circle iconStyle"></span></div>
                <div style="width: 70%">
                        <span style="color: black">Ajouter les types</span>
                        <br>
                        <span style="color: #504f4f">Tout les info sur les types des salles</span>

                </div>
            </div>
        </div>
    </a>



<a href="{{route('determine-type-class-room')}}">
    <div class="rectungle">
        <div class="containerContent">
            <div style="margin-left:5px " class="icon"> <span  class="mdi mdi-webhook iconStyle"></span></div>
            <div style="width: 70%">
                    <span style="color: black">affectation les types</span>
                    <br>
                    <span style="color: #504f4f">affectation les types à sa salle</span>

            </div>
        </div>
    </div>
</a>











<a href="{{route('addbranch')}}">
    <div class="rectungle">
        <div class="containerContent">
            <div class="icon"> <span  class="mdi mdi-source-branch iconStyle"></span></div>
            <div style="width: 70%">
                    <span style="color: black">Ajouter les Filières</span>
                    <br>
                    <span style="color: #504f4f">Tout les info sur les Filières</span>

            </div>
        </div>
    </div>
</a>






<a href="{{route('modelSetting')}}" >
    <div class="rectungle">
        <div class="containerContent">
            <div class="icon"> <span  class="mdi mdi-google-assistant iconStyle"></span></div>
            <div style="width: 70%">
                    <span style="color: black">Modeles Paramteres</span>
                    <br>
                    <span style="color: #504f4f">Tout les info sur les popapes et autre</span>

            </div>
        </div>
    </div>
</a>





<a href="{{route('addGroups')}}">
<div class="rectungle">
    <div class="containerContent">
        <div class="icon"> <span  class="mdi mdi-lightbulb-group iconStyle"></span></div>
        <div style="width: 70%">
                <span style="color: black">Ajouter les groupes</span>
                <br>
                <span style="color: #504f4f">Tout les info sur groupes</span>

        </div>
    </div>
</div>
</a>




<a  href="{{route('addFormateur')}}">
<div class="rectungle">
 <div class="containerContent">
    <div class="icon"> <span class=" iconStyle mdi mdi-account-plus"></span></div>
    <div style="width: 70%">

            <span style=" color:black ">Ajouter les formateurs </span>
            <br>
                <span style="color: #504f4f">Tout les info sur les formateurs </span>


    </div>
 </div>
</div>
</a>





<a  href="{{route('addModule')}}" >
<div class="rectungle">
    <div class="containerContent">
        <div  class="icon" ><span class="mdi mdi-file-edit-outline iconStyle"></span></div>
        <div style="width: 70%" >
            <span style=" color:black ">Ajouter les modules   </span>
            <br>
            <span style="color: #504f4f">Tout les info sur les Modules</span>
        </div>


</div>
</div>
</a>



<a  href="{{route('UploedFileExcelView')}}">
    <div class="rectungle">
    <div class="containerContent">
            <div  class="icon" ><span class="mdi mdi-cloud-upload iconStyle"></span></div>
            <div style="width: 70%">
                  <span style=" color:black "> Upload Excel </span>
                  <br>
                  <span style="color: #504f4f">mettra à jour tous les paramètres.</span>
            </div>
    </div>
    </div>
    </a>


    <a  href="{{route('EmploiSricture')}}">
        <div class="rectungle">
        <div class="containerContent">
                <div  class="icon iconStyle" ><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-ubuntu" viewBox="0 0 16 16">
                    <path d="M2.273 9.53a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.547Zm9.467-4.984a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.546M7.4 13.108a5.54 5.54 0 0 1-3.775-2.88 3.27 3.27 0 0 1-1.944.24 7.4 7.4 0 0 0 5.328 4.465c.53.113 1.072.169 1.614.166a3.25 3.25 0 0 1-.666-1.9 6 6 0 0 1-.557-.091m3.828 2.285a2.273 2.273 0 1 0 0-4.546 2.273 2.273 0 0 0 0 4.546m3.163-3.108a7.44 7.44 0 0 0 .373-8.726 3.3 3.3 0 0 1-1.278 1.498 5.57 5.57 0 0 1-.183 5.535 3.26 3.26 0 0 1 1.088 1.693M2.098 3.998a3.3 3.3 0 0 1 1.897.486 5.54 5.54 0 0 1 4.464-2.388c.037-.67.277-1.313.69-1.843a7.47 7.47 0 0 0-7.051 3.745"/>
                  </svg></div>
                <div style="width: 70%">
                      <span style=" color:black "> emploi Stricture </span>
                      <br>
                      <span style="color: #504f4f">Voir Plus</span>
                      <br>
                      <br>
                </div>
        </div>
        </div>
        </a>
</div>
</x-HeaderMenuAdmin>
