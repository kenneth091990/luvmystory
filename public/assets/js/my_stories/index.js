var schedules = {
    settings: {
        ajaxUrl: ''
    },
    init: function() {
        schedules.initDataTable();
    },
    initDataTable: function() {

        var callBack = function() {
        };

        schedules.dataList = $('#schedules-datalist').DataTable({
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            "ordering" : false,
            "pageLength": 20,
            'ajax': {
                'url': schedules.settings.ajaxUrl,
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