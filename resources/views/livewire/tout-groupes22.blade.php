<style>
    .groupNamecases{
        position: sticky;
                top: 110px ;
                left: 0;
                background-color: #f2f2f2;
                z-index: 1;
    }
</style>
<div style=" height:100vh !important"  >
    <div class="dateContent">

        @if (!$dataEmploi->isEmpty())
        <h4 style="float: right; ">
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
<table id="tbl_exporttable_to_xls"  style="overflow:scroll" class="col-md-12 ">
    <thead>

<tr class="day">
    <th style="width: 200px !important" colspan="2" rowspan="3">Groups Name</th>
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

</tr>
</thead>


<tbody>
    @if ($groups)
        @php
            $dayWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            $sessionData = ['Formateur', 'Module','Salle' ,'type Séance'];
            if ($checkValues[0]->module){
                unset($sessionData[1]);
            }
            elseif ($checkValues[0]->typeSession) {
                unset($sessionData[3]);
            }
        @endphp
        @foreach ($groups as $group)
        <tr>
            <td class="groupNamecases" style="height: 50px !important; overflow: hidden; " rowspan="{{ count($sessionData) }}">{{ $group->group_name }}</td>
            @foreach ($sessionData as $item)
                <td style="height: 50px !important; overflow: hidden">{{ $item }}</td>
                @php
                    $sessionNoteFound = true;
                @endphp
                @foreach ($dayWeek as $day)
                    @foreach (['MatinSE1', 'MatinSE2', 'AmidiSE3', 'AmidiSE4'] as $sessionType)
                        @php
                            $sessionFound = false;
                        @endphp
                        @foreach ($sissions as $sission)
                            @if ($sission->day === $day &&
                                 $sission->group_id === $group->id &&
                                 $sission->day_part === substr($sessionType, 0, 5) &&
                                 $sission->dure_sission === substr($sessionType, 5))
                                <td wire:click="updateCaseStatus(false , true)"

                                style="background-color:{{ $isActive ? 'rgba(12, 72, 166, 0.3)' :  ''}} ; height: 50px !important; overflow: hidden"

                                 colspan="1" rowspan="1" data-bs-toggle="modal" data-bs-target="#exampleModal" class="TableCases {{$day}}" id="{{ $day . $sessionType . $group->id }}">
                                    @if ($item === 'Formateur')
                                        {{ $sission->user_name }}
                                    @elseif ($item === 'Module')
                                        {{ preg_replace('/^\d+/', '', $sission->module_name) }}
                                    @elseif ($item === 'Salle')
                                        {{ $sission->class_name  ."\n" . $sission->typeSalle}}
                                    @elseif ($item === 'type Séance')
                                        {{ $sission->sission_type }}
                                    @endif
                                </td>
                                @php
                                    $sessionFound = true;
                                    break; // Exit the loop once a session is found
                                @endphp
                            @endif
                        @endforeach
                        @if (!$sessionFound)
                            <td wire:click="updateCaseStatus(true , true)" style="height: 50px !important; overflow: hidden" colspan="1" rowspan="1" data-bs-toggle="modal" data-bs-target="#exampleModal" class="TableCases {{$day}}" id="{{ $day . $sessionType . $group->id }}"></td>
                        @endif
                    @endforeach
                @endforeach
            </tr><tr>
        @endforeach

        @endforeach

        @include('livewire.GroupModule')

  @endif
</tbody>
</table>

</div>
</div>



