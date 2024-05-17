<x-HeaderMenuAdmin>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schedule Table</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                /* margin: 0px !important;
                padding: 0px !important;
                box-sizing: border-box !important; */
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                table-layout: fixed;
                /* float: left !important; */
                word-wrap: break-word;
            }

            th,
            td {

                height: 70px;
                width: 400px !important;
                border: 1.5px solid #3a3a3a;
                color:#3a3a3a  ;
                text-align: center;
            }
            td span {
                display: block ;
                color: black;
            }

            th {
                background-color: #f2f2f2;
            }
            thead tr.day{
                font-size: 18px;
                padding:30px ;
                color: black;
            }
          thead tr.se-row {
                height: 30px !important;
                width: 30px;
                margin: 0px;
                padding: 0px;
                font-size: 16px
            }




        </style>
         @livewireStyles
    </head>
    <body>
        <livewire:pour-chaque-group />
        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
    </body>
    </html>
</x-Headers>


