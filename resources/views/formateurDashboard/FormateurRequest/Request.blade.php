<x-HeaderMenuFormateur>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schedule Table</title>
         @livewireStyles
         <style>
            select#date-select {
                width: 60%;
            }
        </style>
    </head>
    <body>
        <livewire:formateur-requests />
        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
    </body>
    </html>
</x-HeaderMenuFormateur>
