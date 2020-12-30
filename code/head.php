<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Grenade">
    <meta name="generator" content="">
    <title>LOGOS POLYTECHNIKOS</title>
    <link rel="shortcut icon" href="obr/favicon.ico" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $(document).ready(function() {
            $('table.table').DataTable( {
                "order": [],
                "language": {
                    "lengthMenu": "Zobrazit _MENU_ záznamů na stránku",
                    "zeroRecords": "Nenalezeny žádné záznamy",
                    "info": "Zobrazena stránka _PAGE_ z _PAGES_",
                    "infoEmpty": "Nenalezeny žádné záznamy",
                    "infoFiltered": "(filtrováno z celkem _MAX_ záznamů)",
                    "paginate": {
                        "previous": "Předchozí",
                        "next": "Další"
                    },
                    "search": "Filtrovat záznamy:"
                },
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Vše"]],
                "pageLength": 10,
                columnDefs: [
                    // číslování zprava pomocí záporných čísel => -1 = poslední sloupec
                    { orderable: false, targets: -1 },  //  nebo data-orderable="false" na konkrétní th
                    { searchable: false, targets: -1 }  // nebo data-searchable="false" na konkrétní th
                ]
            } );
        } );
    </script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" type="text/css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
    <!-- Custom styles for this template -->
    <link href="styles.css" rel="stylesheet">
</head>