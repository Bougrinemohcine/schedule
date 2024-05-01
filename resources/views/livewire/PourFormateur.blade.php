
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
    $sessionData = ['Formateur', 'Module', 'Salle' ,'type Séance' ,'Groupe'];

    if ($checkValues[0]->module){
                unset($sessionData[1]);
            }
    if ($checkValues[0]->typeSessionCase) {
                unset($sessionData[3]);
        }
    if ($checkValues[0]->group) {
                unset($sessionData[4]);
    }
    @endphp

    @foreach ($days as $day)
    @foreach ($sessionData as $item)
    <tr style="border: 1px solid black" >
        @if ($loop->first)
        <td rowspan="{{ count($sessionData) }}">{{ $day }}</td>
        @endif
        <td>{{ $item }}</td>
        @foreach (['SE1', 'SE2', 'SE3', 'SE4'] as $dure)
            @php
                $moduleValue ;
                $sessionFound = false ;
                $SalleValue ;
                $Sessiontype ;
                $GroupName = [] ;
                $FormateurName ;
            @endphp
            @foreach ($sissions as $sission)
                @if ($sission->day === $abbreviations[$day] && $sission->dure_sission === $dure)
                    @php
                        $sessionFound = true ;
                        $moduleValue =  preg_replace('/^\d+/', '', $sission->module_name );
                        $SalleValue = $sission->class_name  ;
                        $SessionType = $sission->sission_type ;
                        $GroupName[] = $sission->group_name ;
                        $FormateurName = $sission->user_name ;
                    @endphp
                @endif
            @endforeach
            @if ($sessionFound)
            <td data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click = 'updateCaseStatus(false)'
            style="background-color: {{$sessionFound ? 'rgba(12, 72, 166, 0.3)' : ''}}"
            class="Cases casesNewtamplate" id="{{ $abbreviations[$day] . (in_array($dure, ['SE1', 'SE2']) ? 'Matin' : 'Amidi') . $dure }}">
                        @if ($item === 'Formateur')
                            {{$FormateurName}}
                        @elseif ($item === 'Module')
                             {{  $moduleValue }}
                        @elseif ($item === 'Salle')
                            {{ $SalleValue}}
                        @elseif ($item === 'type Séance')
                            {{$SessionType}}
                        @elseif ($item === 'Groupe')
                            {{implode(' - ' , $GroupName)}}
                        @endif
            </td>
            @else
            <td data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click = 'updateCaseStatus(true)'
            class="Cases casesNewtamplate" id="{{ $abbreviations[$day] . (in_array($dure, ['SE1', 'SE2']) ? 'Matin' : 'Amidi') . $dure }}"></td>
            @endif


        </td>

        @endforeach
    </tr>

    @endforeach
    <!-- end {{ $day }} -->
    @endforeach


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
</tbody>