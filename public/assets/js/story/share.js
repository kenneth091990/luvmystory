var share = {
    settings: {
        ajaxUrl: '',
        ajaxDeleteUrl: ''

    },
    init: function() {
        share.initDataTable();
        share.bindInput();
    },
    initDataTable: function() {

        var callBack = function() {
            share.bindInput();
        };

        share.dataList = $('#share-stories-datalist').DataTable({
            "searching":false,
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            "ordering" : false,
            "pageLength": 20,
            'ajax': {
                'url': share.settings.ajaxUrl,
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
    },
    bindInput: function(){
       
        $.each( $('.btn-delete'), function(){

            var _this = $(this);
            _this.unbind('click').bind('click',function(){
                var sconfirm = confirm('Are you sure you want to delete this story');

                if(sconfirm){
                    $.ajax({
                        url: share.settings.ajaxDeleteUrl,
                        type: "POST",
                        data: { id: _this.data('id')},
                        success: function(r){
                            if(r.success){
                                toastr.success(r.msg);
                                share.dataList.draw();
                            } else {
                                toastr.error(r.msg);
                            }
                        }
                    })
                }
                
            });
        });
    }
};