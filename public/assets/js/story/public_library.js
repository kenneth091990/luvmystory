var public_library = {
    settings: {
        ajaxStoryListUrl: '',
        ajaxShareStoryFormUrl: '',
        ajaxArchiveStoryFormUrl: '',
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
        $('#sortByFilter, #filterBy').unbind('change').bind('change', function(){
            public_library.settings.pageListIds = [];
            $('#pageListContainer').html('');
            public_library.getStoryList();

        });

        $('#q').unbind('focusout').bind('focusout', function(){
            public_library.settings.pageListIds = [];
            $('#pageListContainer').html('');
            public_library.getStoryList();

        });
    },
    getStoryList: function(){
        let searchParams = new URLSearchParams(window.location.search)

        public_library.getPageListIds();
        $.ajax({
            url : public_library.settings.ajaxStoryListUrl,
            type: 'POST',
            data: {  'ids': public_library.settings.pageListIds.toString(), 'isPublic': true, page: 'public_library', q: $('#q').val(), filterBy: $('#filterBy').val(), profile:  searchParams.get('profile') ? searchParams.get('profile') : ''  },
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
    }, 
    shareStory: function(){
        
        $.each($('.share-story-btn'), function(){
            var _this = $(this);
            _this.unbind('click').bind('click', function(){
                var modal = $('#modal');

                
                $.ajax({
                    url: public_library.settings.ajaxShareStoryFormUrl,
                    beforeSend: function(){
                        if(_this.hasClass('large')){
                            modal.addClass('large');
                        } else {
                            modal.removeClass('large');

                        }
                    },
                    data: { id: _this.data('id') },
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
    },

    archiveStory: function(){
        $.each($('.archive-story-btn'), function(){
            var _this = $(this);
            _this.unbind('click').bind('click', function(){
                var modal = $('#modal');

                
                $.ajax({
                    url: public_library.settings.ajaxArchiveStoryFormUrl,
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