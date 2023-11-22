var public_library = {
    settings: {
        ajaxStoryListUrl: '',
        pageListIds : []
    },
    init: function() {
        public_library.getStoryList();
        public_library.reRenderList();
        public_library.toggleStoryOption();

        $('#dashboardConntentContainer').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
               public_library.getStoryList();
            }
        })

    },

    reRenderList: function(){
        $('#sortByFilter').unbind('change').bind('change', function(){
            public_library.settings.pageListIds = [];
            $('#pageListContainer').html('');
            public_library.getStoryList();

        });
    },
    getStoryList: function(){
        public_library.getPageListIds();

        $.ajax({
            url : public_library.settings.ajaxStoryListUrl,
            type: 'POST',
            data: { 'orderBy': $('#sortByFilter').val(), 'ids': public_library.settings.pageListIds.toString()},
            success: function(r){
                if(r.success){
                    
                    var container = $('#pageListContainer');
                    var html = '';

                    container.append(r.html);
                } else {

                }
            }
        });

    },
    getPageListIds: function(){
        $('.page-list-card').each(function () {

            if( $.inArray($(this).data('id'), public_library.settings.pageListIds) == -1 ){
                public_library.settings.pageListIds.push($(this).data('id'));
             }
        });
    }, 
    toggleStoryOption: function(){

        $.each($('.card-option-holder'),function(){
            var _this = $(this);

            _this.click(function(e){    
                var target = e.target;
                $.each($('.card-options'), function(){
                    var _cardOption = $(this);
                    if(target.dataset.id != _cardOption.parent().data('id')){
                        _cardOption.css('display', 'none');

                    }
                });
               
                _this.find(".card-options").toggle();
            });

        });     
        
        $(window).unbind('click').bind('click',function(e){
            var targetClassList = e.target.classList;


            if(!targetClassList.contains('card-option-holder')){
                $.each($('.card-options'), function(){
                    var _cardOption = $(this);
                    if(e.target.dataset.id != _cardOption.parent().data('id')){
                        _cardOption.css('display', 'none');

                    }

                });
            } 
        });
    }
};