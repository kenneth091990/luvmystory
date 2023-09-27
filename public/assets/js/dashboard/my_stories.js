var stories = {
    settings: {
        ajaxUrl: ''
    },
    init: function() {
        stories.initDataTable();
    },
    initDataTable: function() {

        var callBack = function() {
        };

        stories.dataList = $('#stories-datalist').DataTable({
            "searching":false,
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            "ordering" : false,
            "pageLength": 20,
            'ajax': {
                'url': stories.settings.ajaxUrl,
                'data': function(d) {
                    d.url = global.settings.url;
                }
            },
           
            drawCallback: function() {
                callBack();
            },
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });

        $('.content-container').removeClass('has-loading');
        $('.content-container-content').removeClass('hide');
    }
};