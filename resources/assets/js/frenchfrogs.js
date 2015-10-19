
$.fn.extend({

    /**
     *
     * Datatable default configuration
     *
     * @param o
     * @returns {*|{serverSide, ajax}|jQuery}
     */
    dtt : function(o) {

        options = {
            //"dom": "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'pi><'col-md-4 col-sm-12'>>", // datatable layout
            pageLength: 25, // default records per page
            lengthChange: false,
            deferRender : false,
            language: {
                processing: "Traitement en cours...",
                search: "Rechercher&nbsp;:",
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "_START_ &agrave; _END_ | _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty: "0 &agrave; 0 | 0 &eacute;l&eacute;ments",
                infoFiltered: "( _MAX_ )",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "<<",
                    previous: "<",
                    next: ">",
                    last: ">>",
                    page: "Page",
                    pageOf: "de"
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },

            //"orderCellsTop": true,
            /*
             "columnDefs": [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
             'orderable': false,
             'targets': [0]
             }],
             */

            searching : false,
            ordering: false,
            pagingType: "bootstrap_extended", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
            autoWidth: false, // disable fixed width and enable fluid table
            processing: false, // enable/disable display message box on record load
            serverSide: false, // enable/disable server side ajax loading
        };

        return $(this).on('draw.dt', function(e) {$(this).initialize();}).dataTable($.extend(options, o));
    },

    initialize : function() {

        console.log('initialize : ' + this.selector);

        jQuery(this).find('.modal-remote').each(function() {

            jQuery(this).click(function(e) {
                e.preventDefault();

                var target = jQuery(this).data('target');
                $url = jQuery(this).attr('href');

                jQuery(target)
                    .find('.modal-content')
                    .empty()
                    .load($url, function(){
                        jQuery(this).initialize();
                        jQuery(target).modal('show');
                    });
            });

        });

        jQuery(this).find('.form-remote').ajaxForm({

            success : function(html) {
                jQuery('.modal-content')
                    .empty()
                    .html(html)
                    .initialize();
            }
        });


        jQuery(this).find("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)").each(function() {
            jQuery(this).uniform();
        });


        // decoration datatable
        jQuery(this).find('table.table > thead > tr:last-child').children().css('border-bottom', '1px solid #ddd');
    }
});
