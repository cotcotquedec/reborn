if (jQuery.fn.dataTableExt != undefined) {

    /**
     * Tri le tableau en fonction des valeurs dans les filter
     *
     * @param oSettings
     * @returns {jQuery.fn.dataTableExt.oApi}
     */
    jQuery.fn.dataTableExt.oApi.fnStrainer = function (oSettings) {

        var _that = this;// on conserve l'objet principale

        this.each(function (i) {
            jQuery.fn.dataTableExt.iApiIndex = i;

            //Ajout des evenements
            jQuery(_that).find('th select').each(function () {
                _that.api().columns($(this).attr('name') + ':name').search($(this).val());
            });

            // daterange
            jQuery(_that).find('th > div.input-daterange.date-picker').each(function () {
                search = $($(this).find('input').get(0)).val() + '#' + $($(this).find('input').get(1)).val();
                _that.api().columns($(this).attr('name') + ':name').search(search);
            });

            // input:text
            jQuery(_that).find('th > input').each(function () {
                _that.api().columns($(this).attr('name') + ':name').search($(this).val());
            });

            // jQuery.fn.dataTableExt.iApiIndex = i;
            _that.api().draw();
        });
        return this;
    };


    /**
     * Assignation des evenement de filtre sur les strainer
     *
     * @param oSettings
     * @returns {jQuery.fn.dataTableExt.oApi}
     */
    jQuery.fn.dataTableExt.oApi.fnFilterColumns = function (oSettings) {

        var _that = this;// on conserve l'objet principale

        this.each(function (i) {
            jQuery.fn.dataTableExt.iApiIndex = i;

            //Ajout des evenements
            jQuery(_that).find('th select').each(function () {
                jQuery(this).change(function () {
                    _that.fnStrainer();
                });
            });

            // daterange
            jQuery(_that).find('th > div.input-daterange.date-picker').each(function () {

                jQuery(this).datepicker().on('changeDate', function (e) {
                    _that.fnStrainer();
                });

            });

            // input:text
            jQuery(_that).find('th > input').each(function () {
                jQuery(this).unbind('keyup').unbind('keypress').bind('keypress', function (e) {
                    if (e.which == 13) {
                        _that.fnStrainer();
                    }
                });
            });
        });
        return this;
    };

    /**
     * Clear des strainers
     *
     * @param oSettings
     * @returns {jQuery.fn.dataTableExt.oApi}
     */
    jQuery.fn.dataTableExt.oApi.fnClearFilters = function (oSettings) {

        var _that = this;// on conserve l'objet principale

        this.each(function (i) {
            jQuery.fn.dataTableExt.iApiIndex = i;

            //Ajout des evenements
            jQuery(_that).find('th select').each(function () {
                $(this).val('');
            });

            // daterange
            jQuery(_that).find('th > div.input-daterange.date-picker').each(function () {
                $(this).find('input').val('');
            });

            // input:text
            jQuery(_that).find('th > input').each(function () {
                $(this).val('');
            });

            _that.fnStrainer();
        });
        return this;
    };


    /**
     * This plug-in removes the default behaviour of DataTables to filter on each
     * keypress, and replaces with it the requirement to press the enter key to
     * perform the filter.
     *
     *  @name fnFilterOnReturn
     *  @summary Require the return key to be pressed to filter a table
     *  @author [Jon Ranes](http://www.mvccms.com/)
     *
     *  @returns {jQuery} jQuery instance
     *
     *  @example
     *    $(document).ready(function() {
 *        $('.dataTable').dataTable().fnFilterOnReturn();
 *    } );
     */

    jQuery.fn.dataTableExt.oApi.fnFilterOnReturn = function (oSettings) {
        var _that = this;

        this.each(function (i) {
            $.fn.dataTableExt.iApiIndex = i;
            var $this = this;
            var anControl = $('input', _that.fnSettings().aanFeatures.f);
            anControl
                .unbind('keyup search input')
                .bind('keypress', function (e) {
                    if (e.which == 13) {
                        $.fn.dataTableExt.iApiIndex = i;
                        _that.fnFilter(anControl.val());
                    }
                });
            return this;
        });
        return this;
    };


    $.fn.extend({

        /**
         *
         * Datatable default configuration
         *
         * @param o
         * @returns {*|{serverSide, ajax}|jQuery}
         */
        dtt: function (o) {

            options = {
                pageLength: 25, // default records per page
                lengthChange: false,
                deferRender: false,
                language: {
                    processing: "Traitement en cours...",
                    search: "Rechercher :",
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

                buttons: [],

                orderCellsTop: true,
                order: [],
                searching: false,
                ordering: true,
                retrieve: true,
                pagingType: "full_numbers", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
                autoWidth: false, // disable fixed width and enable fluid table
                processing: false, // enable/disable display message box on record load
                serverSide: false, // enable/disable server side ajax loading
            };

            return $(this).on('draw.dt', function (e) {
                $(this).initialize();
            }).dataTable($.extend(options, o)).fnFilterOnReturn().fnFilterColumns();
        }
    });

}


/**
 *
 *
 * @source https://paulund.co.uk/capitalize-first-letter-string-javascript
 *
 * @param string
 * @returns {string}
 */
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


$.fn.extend({


    /**
     * "prepend event" functionality as a jQuery plugin
     * @link http://stackoverflow.com/questions/10169685/prepend-an-onclick-action-on-a-button-with-jquery
     *
     * @param event
     * @param handler
     * @returns {*}
     */
    prependEvent: function (event, handler) {
        return this.each(function () {
            var events = $(this).data("events"),
                currentHandler;

            if (events && events[event].length > 0) {
                currentHandler = events[event][0].handler;
                events[event][0].handler = function () {
                    handler.apply(this, arguments);
                    currentHandler.apply(this, arguments);
                }
            }
        });
    },


    // INITAILISATION
    initialize: function (callback) {
        // MODAL
        jQuery(this).find('.modal-remote').each(function () {

            jQuery(this).click(function (e) {
                e.preventDefault();

                var target = jQuery(this).data('target');
                var size = jQuery(this).data('size');
                $url = jQuery(this).attr('href');

                $data = {};
                if (jQuery(this).data('method')) {
                    $data = {_method: jQuery(this).data('method')}
                }

                jQuery(target)
                    .find('.modal-content')
                    .empty()
                    .load($url, $data, function () {
                        jQuery(this).initialize();
                        jQuery(this).parent().removeClass('modal-lg modal-sm').addClass(size);
                        jQuery(target).modal('show');
                        jQuery(target).on('hidden.bs.modal', function () {
                            jQuery(this).find('.modal-content').html('');
                        });
                    });
                e.stopImmediatePropagation();
            });
        });

        // TABLE
        jQuery(this).find('.table-remote:empty').each(function () {
            let _that = jQuery(this);
            jQuery.ajax({
                url: jQuery(this).data('url'),
                method: "GET"
            }).done(function (table) {
                _that.html(table);
                _that.initialize();
            });
        });


        // FORM
        if (jQuery.fn.ajaxForm != undefined) {

            // FORM REMOTE
            jQuery(this).find('.form-remote').ajaxForm({

                beforeSubmit: function (a, f) {
                    jQuery(f).find("input[type='submit']")
                        .attr("disabled", "disabled")
                        .attr("value", "En cours ...");
                },

                success: function (html) {
                    jQuery('.modal-content')
                        .empty()
                        .html(html)
                        .initialize();
                }
            });

            // FORM CALLBACK
            jQuery(this).find('.form-callback').ajaxForm({

                beforeSubmit: function (a, f) {
                    jQuery(f).find("input[type='submit']")
                        .attr("disabled", "disabled")
                        .attr("value", "En cours ...");
                },

                success: function (js) {
                    eval(js);
                }
            });
        }

        // ajout du compteur sur le text area
        $('textarea.ff-text-count[maxlength]').each(function () {

            var _this = $(this);
            var _parent = _this.parent();

            // ajout du compteur
            $('<div class="pull-right"><span class="txt-current"></span><span class="txt-max"></span></div>')
                .insertAfter(_this);

            _parent.find('span.txt-max').html(" / " + _this.prop('maxlength'));

            _this.on("click mousedown mouseup focus blur keydown change", function () {
                _parent.find('span.txt-current').text($(this).val().length);
            });

            _this.change();
        });

        // CALLBACK
        jQuery(this).find('.callback-remote').each(function () {
            jQuery(this).click(function (e) {

                if (jQuery(this).data('method')) {

                    $data = {};
                    if (jQuery(this).data('method')) {
                        $data = {_method: jQuery(this).data('method')}
                    }

                    jQuery.post(
                        jQuery(this).attr('href'),
                        $data,
                        function (a) {
                            eval(a);
                        }
                    );
                } else {
                    jQuery.getScript(jQuery(this).attr('href'));
                }

                e.preventDefault();
                e.stopImmediatePropagation();
            });
        });

        // INPUT CALLBACK
        jQuery(this).find('.input-callback').each(function () {
            jQuery(this).change(function (e) {

                if (jQuery(this).data('method')) {
                    jQuery.post(
                        jQuery(this).data('action'),
                        {_method: jQuery(this).data('method'), value: jQuery(this).val()},
                        function (a) {
                            eval(a);
                        }
                    );
                } else {
                    jQuery.getScript(jQuery(this).attr('href'));
                }

                e.preventDefault();
                e.stopImmediatePropagation();
            });
        });

        // SELECT 2
        if (jQuery.fn.select2 != undefined) {

            jQuery(this).find('select.select2').each(function () {
                var _that = jQuery(this);
                _that.select2({
                    allowClear: !_that.prop('required')
                });
            });

            jQuery(this).find('.select2-remote').each(function () {

                jQuery.fn.select2.amd.define('select2/data/customAdapter', [
                        'select2/data/minimumInputLength',
                        'select2/data/ajax',
                        'select2/utils'
                    ],
                    function (MinimumInputLength, AjaxAdapter, Utils) {

                        function CustomDataAdapter($element, options) {
                            CustomDataAdapter.__super__.constructor.call(this, $element, options);
                        }

                        Utils.Extend(CustomDataAdapter, AjaxAdapter);

                        CustomDataAdapter.prototype.current = function (callback) {
                            if (this.$element.find(':selected').length === 0) {
                                var id = this.$element.val();
                                if (id === null) {
                                    id = this.$element.attr('value');
                                }
                                if (id !== "") {
                                    jQuery.ajax(this.$element.data('remote') + '?id=' + id, {dataType: "json"})
                                        .done(function (data) {
                                            if (data.results[0]) {
                                                var result = [];
                                                result.push(data.results[0]);
                                                callback(result);
                                            }
                                        });
                                }
                            } else {
                                var data = [];
                                var self = this;

                                this.$element.find(':selected').each(function () {
                                    var $option = $(this);

                                    var option = self.item($option);

                                    data.push(option);
                                });

                                callback(data);
                            }
                        };

                        return Utils.Decorate(CustomDataAdapter, MinimumInputLength);
                    }
                );

                jQuery(this).select2({
                    minimumInputLength: jQuery(this).data('length'),

                    ajax: {
                        url: jQuery(this).data('remote'),
                        dataType: 'json',
                        delay: 250,
                        data: function (term) {
                            return {
                                q: term // search term
                            };
                        },
                        processResults: function (data) {
                            return data;
                        }
                    },

                    templateResult: function (i) {
                        return i.name || i.text;
                    },
                    templateSelection: function (i) {
                        return i.name || i.text;
                    },

                    escapeMarkup: function (markup) {
                        return markup;
                    },

                    dataAdapter: jQuery.fn.select2.amd.require('select2/data/customAdapter')
                });
            });
        }

        // LIAISON SELECT
        jQuery('.select-remote').each(function () {
            var $that = $(this);
            selector = jQuery(this).data('parent-selector');
            jQuery(selector).change(function (e) {
                url = $that.data('parent-url') + '?value=' + jQuery(this).val();
                jQuery.getJSON(url, function (a) {
                    populate = $that.data('populate');
                    $that.empty();
                    jQuery.each(a, function (i, v) {
                        selected = '';
                        if (populate == i) {
                            selected = 'selected'
                        }
                        $that.append(jQuery("<option " + selected + "/>").val(i).text(v));
                    });
                });
            }).change();
        });

        // UNIFORM
        if (jQuery.fn.uniform != undefined) {
            jQuery(this).find("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)").each(function () {
                jQuery(this).uniform();
            });
        }

        // DATEPICKER
        if (jQuery.fn.datepicker != undefined) {
            jQuery(this).find('.date-picker').datepicker({
                autoclose: true
            });
        }

        // TIMEPICKER
        if (jQuery.fn.timepicker != undefined) {
            jQuery(this).find(".timepicker-24").timepicker({
                autoclose: true,
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        }

        // TOOLTIP
        if (jQuery.fn.tooltip != undefined) {

            jQuery('[data-toggle="tooltip"]').tooltip({container: 'body'});

            jQuery(this).find('.ff-tooltip-left').tooltip({
                container: 'body',
                placement: 'left'
            });

            jQuery(this).find('.ff-tooltip-bottom').tooltip({
                container: 'body',
                placement: 'left'
            });
        }

        // SWITCH
        if (jQuery.fn.bootstrapSwitch !== undefined) {

            /**
             * Table Remote Boolean
             */
            jQuery(this).find('input[type=checkbox].ff-remote-boolean').bootstrapSwitch({
                onSwitchChange: function (event, state) {
                    event.preventDefault();
                    jQuery.ajax({
                        url: jQuery(this).closest('.datatable-remote').DataTable().ajax.url(),
                        type: 'PUT',
                        data: {
                            _id: jQuery(this).data('id'),
                            _column: jQuery(this).data('column')
                        },
                        success: function (result) {
                            eval(result);
                        }
                    });
                }
            });

            jQuery(this).find('input[type=checkbox].make-switch:not(.ff-remote-boolean)').bootstrapSwitch();
        }


        /**
         * Table remote text
         */
        jQuery(this).find('div.ff-remote-text')
            .dblclick(function (e) {

                // if element is active, we disable action
                if (jQuery(this).hasClass('ff-remote-active')) {
                    return jQuery(this);
                }

                // mark element as actiove
                jQuery(this).addClass('ff-remote-active');

                // hide span
                var _that = jQuery(this).find('span').hide();

                // input setting
                jQuery(this).find('input')
                    .on('ff.remote.text', function () {
                        // disable input
                        jQuery(this)
                            .off('focusout')
                            .off('ff.remote.text')
                            .off('ff.remote.process');
                        jQuery(this).hide().prev('span').show();
                        jQuery(this).parent('.ff-remote-active').removeClass('ff-remote-active');
                    })
                    .on('ff.remote.process', function () {
                        // process modifiction
                        e.preventDefault();
                        if (_that.html() != jQuery(this).val()) {
                            _that.html(jQuery(this).val());
                            jQuery.post(jQuery(this).closest('.datatable-remote').DataTable().ajax.url(), {
                                id: jQuery(this).data('id'),
                                column: jQuery(this).data('column'),
                                value: jQuery(this).val()
                            }, function (e, f) {
                                eval(e)
                            });
                        }
                        jQuery(this).trigger('ff.remote.text');
                        return false;
                    })
                    .val(_that.html()) // set value
                    .show()
                    .focus()
                    .focusout(function () {
                        jQuery(this).trigger('ff.remote.text');
                    }).keypress(function (e) {
                    // enable process on enter key
                    if (e.which == 13) {
                        jQuery(this).trigger('ff.remote.process');
                    }
                });
            });

        // TABLE REMOTE SELECT
        jQuery(this).find('select.ff-remote-select').change(
            function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();

                // if element is active, we disable action
                if (jQuery(this).hasClass('ff-remote-active')) {
                    return jQuery(this);
                }

                // mark element as actiove
                jQuery(this).addClass('ff-remote-active');

                jQuery.post(jQuery(this).closest('.datatable-remote').DataTable().ajax.url(), {
                    id: jQuery(this).data('id'),
                    column: jQuery(this).data('column'),
                    value: jQuery(this).val()
                }, function (e, f) {
                    eval(e)
                });
            }
        );

        //DATATABLE DECORATION
        jQuery(this).find('table.table > thead > tr:last-child').children().css('border-bottom', '1px solid #ddd');


        // Edition des datatatable
        jQuery('.ff-edit[data-edit-id]').contextmenu(function () {

            // reécupération des informations
            var $target = jQuery(this).data('target');
            var $url = jQuery(this).data('url');

            $data = {_method: 'get', 'id': jQuery(this).data('edit-id')};

            jQuery($target)
                .find('.modal-content')
                .empty()
                .load($url, $data, function () {
                    jQuery(this).initialize();
                    jQuery($target).modal('show');
                    jQuery($target).on('hidden.bs.modal', function () {
                        jQuery(this).find('.modal-content').html('');
                    });
                });

            return false;
        });

        // SimpleMDE
        if (window.SimpleMDE != undefined) {
            jQuery('textarea.ff-markdown').each(function () {
                new SimpleMDE({element: document.getElementById($(this).attr('id')), forceSync: true});
            });
        }

        // HIGHLIGHT.JS
        if (window.hljs != undefined) {
            jQuery('code.ff-highlight').each(function (i, block) {
                hljs.highlightBlock(block);
            });
        }

        // KNOB
        if (jQuery.fn.knob != undefined) {
            jQuery(this).find('.ff-knob').knob();
        }

        // CALLBACK
        if (typeof callback === 'function') {
            callback(jQuery(this));
        }

    },

    /** Populate a form in javascript */
    populate: function (data) {

        // get the form
        var $form = $(this);

        // for each index we assigen value
        $.each(data, function (i, v) {
            e = $form.find('#' + i);

            // if only one item
            if (e.length == 1) {
                // case switch (boolean)
                if (e.hasClass('make-switch')) {
                    e.bootstrapSwitch('state', v);
                } else {
                    e.val(v);
                }
            }
        });
    },

    // add disabled class to elements
    disable: function (state) {
        return this.each(function () {
            $(this).addClass('disabled');
        });
    },

    // remove class disabled to element
    enable: function (state) {
        return this.each(function () {
            $(this).removeClass('disabled');
        });
    }

});