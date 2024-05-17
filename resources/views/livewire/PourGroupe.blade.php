
<thead>
    <tr>
        <th colspan="2">Jours</th>
        <th style="width: 120px !important;">SE1</th>
        <th style="width: 120px !important;">SE2</th>
        <th style="width: 120px !important;">SE3</th>
        <th style="width: 120px !important;">SE4</th>
    </tr>
</thead>
<tbody>
    @php
    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $abbreviations = ['Lundi' => 'Mon',
    'Mardi' => 'Tue',
    'Mercredi' => 'Wed',
    'Jeudi' => 'Thu',
    'Vendredi' => 'Fri',
    'Samedi' => 'Sat'];
    $sessionData = ['Groupe', 'Module', 'Salle' ,'type Séance','formateur'];
    if ($checkValues[0]->module){
                unset($sessionData[1]);
            }
            if ($checkValues[0]->typeSessionCase) {
                unset($sessionData[3]);
            }
            if ($checkValues[0]->group) {
                unset($sessionData[0]);
            }
            if ($checkValues[0]->module) {
                unset($sessionData[1]);
            }
            if ($checkValues[0]->formateur) {
                unset($sessionData[4]);
            }

    @endphp

    @foreach ($days as $day)
    @foreach ($sessionData as $item)
    <tr>
        @if ($loop->first)
            <td rowspan="{{ count($sessionData) }}">{{ $day }}</td>
        @endif
        <td>{{ $item }}</td>
        @foreach (['SE1', 'SE2', 'SE3', 'SE4'] as $dure)
            @php
                $sessionFound = false;
            @endphp
            @foreach ($sissions as $sission)
                @if ($sission->day === $abbreviations[$day] && $sission->dure_sission === $dure)
                    <td wire:click='updateCaseStatus(false)'
                    style="background-color:rgba(12, 72, 166, 0.3) ;" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    class="Cases casesNewtamplate {{ $abbreviations[$day]}}"
                    id="{{ $abbreviations[$day] . (in_array($dure, ['SE1', 'SE2']) ? 'Matin' : 'Amidi') . $dure }}">
                        @if ($item === 'Groupe')
                            {{ $sission->group_name }}
                        @elseif ($item === 'Module')
                            {{ preg_replace('/^\d+/' , '' , $sission->module_name) }}
                        @elseif ($item === 'Salle')
                            {{ $sission->class_name ."\n" . $sission->typeSalle}}
                        @elseif ($item === 'type Séance')
                            {{ $sission->sission_type }}
                            @elseif ($item === 'formateur')
                            {{ $sission->user_name }}
                        @endif
                    </td>
                    @php
                        $sessionFound = true;
                        break;
                    @endphp
                @endif
            @endforeach
            @if (!$sessionFound)
                <td wire:click='updateCaseStatus(true)' data-bs-toggle="modal" data-bs-target="#exampleModal" class="Cases casesNewtamplate {{$abbreviations[$day]}}" id="{{ $abbreviations[$day] . (in_array($dure, ['SE1', 'SE2']) ? 'Matin' : 'Amidi') . $dure }}">
                </td>
            @endif
        @endforeach
    </tr>


    @endforeach
    <!-- end {{ $day }} -->
    @endforeach









</tbody>
