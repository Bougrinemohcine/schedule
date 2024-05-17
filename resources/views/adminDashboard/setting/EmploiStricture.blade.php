<x-HeaderMenuAdmin>
    <style>
        img {
            width: 130px;
            border: 1px solid black;
            margin: 5px;
            cursor: pointer;
        }

        img:hover {
            width: 75vw;
            z-index: 100;
            margin: auto;
            transition: 0.7s all;
        }

        input[type='radio'] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        /* Create custom check mark */
        input[type='radio']::before {
            content: '\2713';
            display: inline-block;
            font-size: 16px;
            line-height: 20px;
            text-align: center;
            color: white;
            background-color: rgb(180, 224, 180);
            border-radius: 3px;
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        input[type='radio']:checked::before {
            content: '\2713'; /* Unicode for check mark symbol */
            background-color: rgb(69, 69, 218); /* Change color of the check mark when checked */
        }

        /* Hide checkbox when hovering over image */
        img:hover + input[type='radio'] {
            visibility: hidden;
        }
    </style>
<h4 style="margin-top: 20px;">les Strictures des emplois</h4>
<form style="margin:0px  0px 0px 40px" action="">
    @csrf
    <div>
        <h5>Pour Chaque Groupe</h5>
        <div>
            <img src="{{ asset('assets/images/Emploi/groupEmploi4.png') }}" >
            <input name="groupe" value="4" type="radio">
        </div>
        <div>
            <img src="{{ asset('assets/images/Emploi/formaGroup1.png') }}" >
            <input name="groupe" value="1" type="radio">
        </div>

        <div>
            <img src="{{ asset('assets/images/Emploi/formaGroup2.png') }}" >
            <input name="groupe" value="2" type="radio">
        </div>

        <div>
            <img src="{{ asset('assets/images/Emploi/formaGroup3.png') }}" >
            <input name="groupe" value="3" type="radio">
        </div>
    </div>

    {{-- for each formateur --}}
    <div>
        <h5>Pour Chaque Formateur</h5>

        <div>
            <img src="{{ asset('assets/images/Emploi/strictrureFormateur4.png') }}" >
            <input name="formateur" value="4" type="radio">
        </div>
        <div>
            <img src="{{ asset('assets/images/Emploi/formaFormateur1.png') }}" >
            <input name="formateur" value="1" type="radio">
        </div>


        <div>
            <img src="{{ asset('assets/images/Emploi/formaFormateur2.png') }}" >
            <input name="formateur" value="2" type="radio">
        </div>
        <div>
            <img src="{{ asset('assets/images/Emploi/formaFormateur3.png') }}" >
            <input name="formateur" value="3" type="radio">
        </div>
    </div>

    {{-- Tout Les groupes --}}
    <div>
        <h5>Pour Tout Les Groupes</h5>
        <div>
            <img src="{{ asset('assets/images/Emploi/toutGroupes1.png') }}" >
            <input name="toueGroupe" value="1" type="radio">
        </div>

        <div>
            <img src="{{ asset('assets/images/Emploi/formatoutgroupes2.png') }}" >
            <input name="toueGroupe" value="2" type="radio">
        </div>
    </div>

    {{-- tout les formateurs --}}
    <div>
        <h5>Pour Tout les Formateurs</h5>
        <div>
            <img src="{{ asset('assets/images/Emploi/toutFormateur1.png') }}" >
            <input name="toutFormateur" value="1" type="radio">
        </div>

        <div>
            <img src="{{ asset('assets/images/Emploi/toutFormateur2.png') }}" >
            <input name="toutFormateur" value="2" type="radio">
        </div>
    </div>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        let radioGroups = document.querySelectorAll('input[type="radio"]');

    fetch('/admin/Emplois-Stracture')
        .then(resp => resp.json())
        .then(data => {
            radioGroups.forEach(item => {
                switch (item.name) {
                    case 'groupe':
                        if (item.value == data[0].groupe) {
                            item.checked = true;
                        }
                        break;
                    case 'formateur':
                        if (item.value == data[0].formateur) {
                            item.checked = true;
                        }
                        break;
                    case 'toutFormateur':
                        if (item.value == data[0].toutFormateur) {
                            item.checked = true;
                        }
                        break;
                    case 'toueGroupe':
                        if (item.value == data[0].toueGroupe) {
                            item.checked = true;
                        }
                        break;
                    default:
                        break;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });






    radioGroups.forEach(radio => {
        radio.addEventListener('change', function() {
            let checkboxData = {};
            let groupName = radio.name;

    let checkedRadio = document.querySelectorAll('input[type="radio"]:checked');
    let array = {};

    checkedRadio.forEach(item => {
        array[item.name] = item.value;
    });
    console.log(array)





            if (checkedRadio) {

                fetch('/admin/Emplois-Stracture', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(array)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
});


</script>
</x-HeaderMenuAdmin>
