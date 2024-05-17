<x-HeaderMenuFormateur>
<div class="container-fluid">
    
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Liste Des modules</h4>

                            <table id="FormateurModulesTable" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>ID Du module</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (isset($modulesList) && $modulesList->count() > 0)
                                        @foreach ($modulesList as $moduleList)
                                        @php
                                        $moduleName = \App\Models\module::find($moduleList['module_id'])->module_name;
                                        $moduleId = substr(\App\Models\Module::find($moduleList['module_id'])->id, 1);
                                        @endphp
                                            <tr>
                                                <td>{{ $moduleId }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="1">No modules assigned to this formateur</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button  class="btn btn-primary" onclick="ExportToExcel('xlsx')">Telecharger</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
 
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('FormateurModulesTable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('FormateurModulesTable.' + (type || 'xlsx')));
    }
    

</script>
</x-HeaderMenuFormateur>
