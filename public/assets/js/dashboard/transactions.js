var transaction = {
    settings: {
        ajaxUrl: ''
    },
    init: function() {
        transaction.initDataTable();
    },
    initDataTable: function() {

        var callBack = function() {
        };

        transaction.dataList = $('#transaction-datalist').DataTable({
            "searching":false,
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            "ordering" : false,
            "pageLength": 20,
            'ajax': {
                'url': transaction.settings.ajaxUrl,
                'data': function(d) {
                    d.url = global.settings.url;
                }
            },
           
            drawCallback: function() {
                callBack();
            },
            responsive: true
        });

        $('.content-container').removeClass('has-loading');
        $('.content-container-content').removeClass('hide');
    }
};