$(document).ready(function() 
{
    $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');
    $.fn.dataTable.moment('DD/MM/YYYY'); 

    // On clone l'entête de chaque colonne puis on l'y place en-dessous
    $('#dataTable thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#dataTable thead');

    $('#dataTable').DataTable( 
    {
        "order": [[ $('th.colonneDate').index(), "desc" ]],
        "oLanguage": {
            "sUrl": "/datatables/datatables.french.json"
        },
        "aoColumnDefs": [
            { "iDataSort": $('th.colonneDateEtHeure').index(), "aTargets": [ $('th.colonneDate').index() ] },
            { orderable: false, targets: [ $('th.colonneAction').index() ] }
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () 
        {
            var api = this.api();

            // Pour chacune des colonnes de la dataTable
            api.columns().eq(0).each(function (colIdx) 
            {
                if($(api.column(colIdx).header()).index() != $('th.colonneAction').index())
                {
                    // La colonne d'actions n'a pas besoin de champ de recherche

                    // On modifie la cellule clonée pour la remplacer avec un champ de saisie
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    $(cell).html('<input type="text" placeholder="..." size="5" />');

                    // À chaque frappe dans ce champ de saisie
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                    .off('keyup change')
                    .on('keyup change', function (e) {
                        e.stopPropagation();

                        // On récupère la valeur saisie
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})';

                        var cursorPosition = this.selectionStart;
                        // On cherche la valeur saisie dans la colonne en question
                        api
                            .column(colIdx)
                            .search(
                                this.value != ''
                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                    : '',
                                this.value != '',
                                this.value == ''
                            )
                            .draw();

                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
                }
            });
        },
    });
});