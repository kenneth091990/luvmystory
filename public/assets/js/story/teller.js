var teller = {
    settings: {
        ajaxStoryListUrl: '',
        pageListIds : [],
        id: ''
    },
    init: function() {
        teller.getStoryList();
        teller.reRenderList();
        teller.toggleStoryOption();

        $('#dashboardConntentContainer').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
               teller.getStoryList();
            }
        })

    },

    reRenderList: function(){
        $('#sortByFilter').unbind('change').bind('change', function(){
            teller.settings.pageListIds = [];
            $('#pageListContainer').html('');
            teller.getStoryList();

        });

        $('#q').unbind('focusout').bind('focusout', function(){
            teller.settings.pageListIds = [];
            $('#pageListContainer').html('');
            teller.getStoryList();

        });
    },
    getStoryList: function(){
        teller.getPageListIds();

        $.ajax({
            url : teller.settings.ajaxStoryListUrl,
            type: 'POST',
            data: { 'orderBy': $('#sortByFilter').val(), 'ids': teller.settings.pageListIds.toString(), 'isPublic': true, page: 'teller', 'profile': teller.settings.id, filterBy: $('#filterBy').val() },
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

            if( $.inArray($(this).data('id'), teller.settings.pageListIds) == -1 ){
                teller.settings.pageListIds.push($(this).data('id'));
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
                    url: teller.settings.ajaxShareStoryFormUrl,
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
                    url: teller.settings.ajaxArchiveStoryFormUrl,
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
    }
};