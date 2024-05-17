<x-HeaderMenuFormateur>
    <div class="container-fluid">
        <div class="main-content">
            <div class="page-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Liste Des groupes</h4>

                                <table id="FormateurgroupesTable"
                                    class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Du groupe</th>
                                            <th>Nom Du groupe</th>
                                            <th>Branch</th>
                                            <th>Year</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (isset($groupsList) && $groupsList->count() > 0)
                                            @foreach ($groupsList as $groupList)
                                                @php
                                                    $groupId = substr(
                                                        \App\Models\group::find($groupList['group_id'])->id,
                                                        1,
                                                    );

                                                    $groupName = \App\Models\group::find($groupList['group_id'])
                                                        ->group_name;
                                                    $groupBranch = substr(
                                                        \App\Models\group::find($groupList['group_id'])->barnch_id,
                                                        1,
                                                    );
                                                    $groupYear = \App\Models\group::find($groupList['group_id'])->year;
                                                @endphp
                                                <tr>
                                                    <td>{{ $groupId }}</td>
                                                    <td>{{ $groupName }}</td>
                                                    <td>{{ $groupBranch }}</td>
                                                    <td>{{ $groupYear }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No groups assigned to this formateur</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button class="btn btn-primary" onclick="ExportToExcel('xlsx')">Telecharger</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('FormateurgroupesTable');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });

            // Modifier le style de la feuille Excel
            wb.Sheets['sheet1']['!cols'] = [{
                wch: 30
            }, {
                wch: 15
            }, {
                wch: 15
            }];
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('FormateurgroupesTable.' + (type || 'xlsx')));
        }
    </script>




</x-HeaderMenuFormateur>
