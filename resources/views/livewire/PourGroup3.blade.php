
<thead>
    <tr>
        <th style="width: 120px !important;">Groupe</th>
        <th style="width: 120px !important;">Formateur</th>
        <th style="width: 120px !important;">Salle</th>
        <th style="width: 120px !important;">Type de séance</th>
        <th style="width: 120px !important;">Jour</th>
        <th style="width: 120px !important;">Horaire</th>
        <th style="width: 120px !important;">Horaire</th>
        <th style="width: 120px !important;"></th>
    </tr>
</thead>
<tbody>
    @php
    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $abbreviations = [
        'Lundi' => 'Mon',
        'Mardi' => 'Tue',
        'Mercredi' => 'Wed',
        'Jeudi' => 'Thu',
        'Vendredi' => 'Fri',
        'Samedi' => 'Sat'
    ];
    $count = 0 ;
    $sessionData = ['Formateur', 'Module', 'Salle'];
    $HORAIRE = ['SE1'=>'08h30-11h' ,"SE2"=>"11h-13h30", 'SE3' => "13h30-16h" , "SE4" =>'16h-18h30' ];


   @endphp

        @foreach ($abbreviations as $dayName => $abbreviation)
            @foreach ($sissions as $session)
              @foreach ( $HORAIRE as $key => $value )


                @if ($session->group_id === $groupID && $session->day === $abbreviation && $session->dure_sission ===$key)
                     @php
                        $count +=1
                     @endphp
                <tr>
                    <td>{{$session->group_name}}</td>
                        <td>{{$session->user_name}}</td>
                        <td>{{$session->class_name}}</td>
                        <td>{{ $sission->typeSalle }}</td>
                        <td>{{$session->sission_type}}</td>
                        <td>{{$dayName}}</td>
                        <td>{{$session->day_part}}</td>
                        <td>{{$value}}</td>
                        <td>2.5</td>
                </tr>
                @endif
                @endforeach
            @endforeach
    @endforeach
    <tr>
        <td style="font-size: 20px ; font-weight: bold">
            Total :
        </td>
        <td colspan="6"></td>

        <td style="font-size: 20px ; font-weight: bold"> {{2.5*$count}}</td>
    </tr>
</tbody>

<script>

    const elementToRemove = document.querySelector('.element-to-remove');


    function removeElement() {

        elementToRemove.style.display = 'none';

        window.removeEventListener('scroll', handleScroll);

        window.addEventListener('scroll', handleScrollTop);
    }


    function handleScroll() {

        if (window.scrollY > 100) {

            removeElement();
        }
    }

    function handleScrollTop() {
        if (window.scrollY === 0) {
            elementToRemove.style.display = 'block';
            elementToRemove.style.display = 'flex';
            window.removeEventListener('scroll', handleScrollTop);

            window.addEventListener('scroll', handleScroll);
        }
    }
    window.addEventListener('scroll', handleScroll);
</script>





