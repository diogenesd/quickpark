var defaultOptions = {
    sAjaxSource: "",
    order: [],
    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    buttons: [
        {extend: 'copy', className: 'btn-sm'},
        {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
        {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
        {extend: 'print', className: 'btn-sm'}
    ],
    language: {
        url: baseUrl + 'libs/datatables/lang/DataTables-Portuguese-Brasil.json'
    },
    bProcessing: true,
    bServerSide: true,
    fnDestroy: true,
    responsive: true,
    fnPreDrawCallback: function () {

    },
    fnDrawCallback: function (oSettings) {
    },
    aoColumnDefs: [{
            "targets": 'no-sort',
            "orderable": false
        }, {
            "targets": 'no-hidden',
            "className": "all"
        }, {
            "targets": 'hidden',
            "visible": false
        }, {
            "targets": 'column-center',
            "className": "text-center"
        }, {
            "targets": 'no-sort-no-hidden-column-center',
            "className": "all text-center bts",
            "orderable": false
        }, {
            className: 'control',
            orderable: false,
            targets: 0
        }
    ]
};

var defaultOptionsInline = {
    order: [],
    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    buttons: [
        {extend: 'copy', className: 'btn-sm'},
        {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
        {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
        {extend: 'print', className: 'btn-sm'}
    ],
    language: {
        url: baseUrl + 'libs/datatables/lang/DataTables-Portuguese-Brasil.json'
    },
    bProcessing: false,
    bServerSide: false,
    fnDestroy: true,
    responsive: true,
    fnPreDrawCallback: function () {

    },
    fnDrawCallback: function (oSettings) {
    },
    aoColumnDefs: [{
            "targets": 'no-sort',
            "orderable": false
        }, {
            "targets": 'no-hidden',
            "className": "all"
        }, {
            "targets": 'hidden',
            "visible": false
        }, {
            "targets": 'column-center',
            "className": "text-center"
        }, {
            "targets": 'no-sort-no-hidden-column-center',
            "className": "all text-center bts",
            "orderable": false
        }, {
            className: 'control',
            orderable: false,
            targets: 0
        }
    ]
};

$(function () {
    $("table").each(function () {
        var self = $(this);
        if (self.attr('ui-jp') == 'dataTable') {
            var options = eval('[' + self.attr('ui-options') + ']');
            var optionsMerge = defaultOptions;
            optionsMerge['sAjaxSource'] = options[0]['sAjaxSource'];
            optionsMerge['order'] = options[0]['aDataSort'];
            optionsMerge['iDisplayLength'] = options[0]['iDisplayLength']

            self.dataTable(optionsMerge);
        } else if (self.attr('ui-jp') == 'dataTableInline') {
            var options = eval('[' + self.attr('ui-options') + ']');
            var optionsMerge = defaultOptionsInline;
            optionsMerge['order'] = options[0]['aDataSort'];
            self.dataTable(optionsMerge);
        }
    });

});