<style>
    .groupNamecases{
        position: sticky;
                top: 110px ;
                left: 0;
                background-color: #f2f2f2;
                z-index: 1;
    }
</style>
<div style=" height:90vh ; "  >
    <div class="dateContent">

        @if (!$dataEmploi->isEmpty())
        <h4 style="float: right; margin-top: 15px;">
            @foreach ($dataEmploi as $item)
                Du: {{ $item->datestart }} au {{ $item->dateend }}
            @endforeach
        </h4>
        @else
        <h4 style="float: right; margin-top: 15px; padding: 0px 5px 0px 5px; border-radius: 3px; background-color: #dc3545; color: white;">
            Il faut créer un emploi
        </h4>
        @endif


</div>
    <div  class="tableContainer">
<table id="tbl_exporttable_to_xls"  style="overflow:scroll" class="col-md-12 table-primary">
    <thead>

<tr class="day">
    <th style="width: 200px !important" colspan="2" rowspan="3">Nom  de Formateur </th>
    <th colspan="4">Lundi</th>
    <th colspan="4">Mardi</th>
    <th colspan="4">Mercredi</th>
    <th colspan="4">Jeudi</th>
    <th colspan="4">Vendredi</th>
    <th colspan="4">Samedi</th>
</tr>
<tr>

  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
  <th colspan="2">Matin </th>
  <th colspan="2">A.midi </th>
</tr>
<tr class="se-row">
    @if (!$this->checkValues[0]->modeRamadan)
    <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>


    <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>

    <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>

     <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>

     <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>

     <th>08h30-11h</th>
    <th>11h-13h30</th>
    <th>13h30-16h</th>
    <th>16h-18h30</th>
    @else
    <th>  08:30 - 10:20</th>
    <th>  10:25 - 12:15</th>
    <th>  12:45 - 14:35</th>
    <th>  14:40 - 16:30</th>

    <th>  08:30 - 10:20</th>
    <th>  10:25 - 12:15</th>
    <th>  12:45 - 14:35</th>
    <th>  14:40 - 16:30</th>

    <th>  08:30 - 10:20</th>
    <th>  10:25 - 12:15</th>
    <th>  12:45 - 14:35</th>
    <th>  14:40 - 16:30</th>

    <th>  08:30 - 10:20</th>
    <th>  10:25 - 12:15</th>
    <th>  12:45 - 14:35</th>
    <th>  14:40 - 16:30</th>

    <th>  08:30 - 10:20</th>
    <th>  10:25 - 12:15</th>
    <th>  12:45 - 14:35</th>
    <th>  14:40 - 16:30</th>







    @endif

</tr>
</thead>


<tbody>
    @if ($formateurs)
        @php
            $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            $sessionData = ['Groupe', 'Module','Salle' ,'type Séance' ];
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

        @endphp
        @foreach ($formateurs as $formateur)
        <tr>
            <td class="groupNamecases" style="height: 50px !important; overflow: hidden;" rowspan="{{ count($sessionData) }}">{{ $formateur->user_name }}</td>
            @foreach ($sessionData as $item)
                <td style="height: 50px !important; overflow: hidden">{{ $item }}</td>
                @php
                    $sessionNoteFound = true;
                @endphp
                @foreach ($dayWeek as $day)
                    @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                        @php
                            $sessionFound = false;
                            $groupesValue = [];
                            $typeValue ;
                            $SalleValue ;
                            $moduleValue ;

                        @endphp
                        @foreach ($sissions as $sission)
                            @if ($sission->day === $day &&
                                 $sission->user_id === $formateur->id &&
                                 $sission->day_part === substr($sessionType, 0, 5) &&
                                 $sission->dure_sission === substr($sessionType, 5))
                                 @php
                                    $groupesValue[] = $sission->group_name ;
                                    $sessionFound = true;
                                    $typeValue = $sission->sission_type ;
                                    $SalleValue = $sission->class_name ;
                                    $typeSalle = $sission->typeSalle ;
                                    $moduleValue = preg_replace('/^\d+/', '', $sission->module_name);

                                @endphp
                            @endif
                        @endforeach
                        @if (!$sessionFound)
                            <td wire:click="updateCaseStatus(true , true)" style="height: 50px !important; overflow: hidden" colspan="1" rowspan="1" data-bs-toggle="modal" data-bs-target="#exampleModal" class="TableCases {{$day}}" id="{{ $day . $sessionType . $formateur->id }}"></td>
                            @else
                            <td wire:click="updateCaseStatus(false , true)"
                            style="!important;height: 50px !important; overflow: hidden ; "
                            colspan="1" rowspan="1" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="TableCases {{$day}}" id="{{ $day . $sessionType . $formateur->id }}">
                                @if ($item === 'Groupe')
                                    {{ implode(' - ' , $groupesValue) }}
                                @elseif ($item === 'Module')
                                    {{ $moduleValue }}
                                @elseif ($item === 'Salle')
                                {{ $SalleValue ."\n" . $typeSalle}}
                                @elseif ($item === 'type Séance')
                                    {{ $typeValue }}

                                @endif
                            </td>
                        @endif
                    @endforeach
                @endforeach
            </tr><tr>
        @endforeach
        @endforeach
       @include('livewire.FormateurModule')
  @endif
</tbody>

</table>
</div>
</div>

