
<thead>
    <tr>
        <th style="width: 120px !important;">Formateur</th>
        <th style="width: 120px !important;">Groupe</th>
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
    $sessionData = ['Formateur', 'Module', 'Salle'];
    $HORAIRE = ['SE1'=>'08h30-11h' ,"SE2"=>"11h-13h30", 'SE3' => "13h30-16h" , "SE4" =>'16h-18h30' ];
   $count = 0 ;
   @endphp

        @foreach ($abbreviations as $dayName => $abbreviation)
            @foreach ($sissions as $session)
              @foreach ( $HORAIRE as $key => $value )


                @if ($session->user_id === $formateurId && $session->day === $abbreviation && $session->dure_sission ===$key)
                    {{$count +=1}}
                <tr>
                        <td>{{$session->user_name}}</td>
                        <td>{{$session->group_name}}</td>
                        <td>{{$session->class_name}}</td>
                        <td>{{ $session->typeSalle}}</td>
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




