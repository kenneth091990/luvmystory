var archive = {
    settings: {
        ajaxUrl: '',
        storyAjaxArchiveForm: ''
    },
    init: function() {
        archive.initDataTable();
    },
    initDataTable: function() {

        var callBack = function() {
        };

        archive.dataList = $('#archive-datalist').DataTable({
            "searching":false,
            'processing': true,
            'serverSide': true,
            "lengthChange": false,
            "ordering" : false,
            "pageLength": 20,
            "info" :false,
            'ajax': {
                'url': archive.settings.ajaxUrl,
                'data': function(d) {
                    d.url = global.settings.url;
                    d.status = 'archive';
                }
            },
            "language": {
                "paginate": {
                  "previous": " Previous ",
                  "next": "Next ",
                }
              },
            drawCallback: function() {
                callBack();
                archive.bindInput();
            },
            responsive: false
        });

        $('.content-container').removeClass('has-loading');
        $('.content-container-content').removeClass('hide');
    },

    bindInput: function(){
        $.each($('.action-btn'),function(){

            var _this = $(this);

            var _this = $(this);
            _this.unbind('click').bind('click', function(){
                var modal = $('#modal');
                $.ajax({
                    url: archive.settings.storyAjaxArchiveForm,
                    beforeSend: function(){
                        if(_this.hasClass('large')){
                            modal.addClass('large');
                        } else {
                            modal.removeClass('large');

                        }
                    },
                    data: { id: _this.data('id'), action: _this.data('action') },
                    success: function(r){
                        if(r.success){
                            
                            modal.html(r.html).foundation('open');
                        } else {
                            toastr.error(r.msg);
                        }
                    }
                });
                
            });
        });
    }
};