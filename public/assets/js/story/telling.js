var telling = {
    settings: {
        id: '',
        commentsListAjaxUrl: '',
        commentFormAjaxUrl: '',
        likeActionUrl: '',
        audioFileUrl: '',
        speedRate: 1,
        ajaxShareStoryFormUrl: '',
        ajaxArchiveStoryFormUrl: '',
        ajaxLikeInfoUrl: ''
    },
    init: function() {
        telling.copyToClipboard();
        telling.loadComments();
        telling.commentForm();
        telling.bindInput();
        telling.initAudio();
        telling.archiveStory();
        telling.shareStory();
        telling.initLikeInfo();


    },
    loadComments: function(){
        var commentBox = $('.comments-container');

        $.ajax({
            url: telling.settings.commentsListAjaxUrl,
            type: 'POST',
            data: { id: telling.settings.id },
            success: function(r){

                if(r.success){
                    commentBox.removeClass('linear-background');
                    commentBox.html(r.html);

                }
            }
        })
    },
    copyToClipboard: function(){
        
        $('#copyToClipBoard').unbind('click').bind('click',function(){
            var temp = $("<input>");
           $("body").append(temp);
           temp.val($('#clipboard').text()).select();
           document.execCommand("copy");
           temp.remove();

       });
    },
    commentForm: function(){
        $('#commentForm').submit(function(e){
            e.preventDefault();
            _this = $(this);
            _this.find(':input[type=submit]').prop('disabled', true);
            var formData = $(this).serialize();
            var commentBox = $('.comments-container');

            $.ajax({
                url: telling.settings.commentFormAjaxUrl,
                data: formData, 
                type: "post",
                dataType: "JSON",
                success: function(r){
                    if(r.success){
                        telling.loadComments();
                        $('#commentForm')[0].reset()
                        _this.find(':input[type=submit]').prop('disabled', true);
                    } else {
                       // $.toaster({ message : r.msg, title : '', priority : 'danger' });
                    }
                }
            });
        });
    },
    bindInput:function(){

        $('#commentInput').unbind('change').bind('change',function(){
            var _this = $(this);

            if(_this.val() != ''){
                _this.closest('form').find('.send-btn').prop('disabled' , false);
            } else {
                _this.closest('form').find('send-btn').prop('disabled' , true);

            }
        });

        $('.button-like').unbind('click').bind('click',function(){
            var _this = $(this);

            $.ajax({
                url: telling.settings.likeActionUrl,
                beforeSend: function(){

                },
                type: 'POST',
                dataType: "JSON",
                data: { id: telling.settings.id},
                success: function(r){
                    
                    if(r.success){

                        var html = '';
                        // if(r.likeCtr.ctr > 0){
                        //     var html = r.likeCtr.likers + (r.likeCtr.ctr > 3? ' and ' + (r.likeCtr.ctr - 3) + ' other people ' : '') + ' like this story';

                        // }
                        // _this.parent().find('.like-counter').html(html);
                        _this.toggleClass('liked');
                        telling.initLikeInfo();


                    } else {
                        $.toaster({ message : r.msg, title : '', priority : 'danger' });
                    }
                }
            });
        });

        $(".card-option-holder").click(function(){
            $(".card-options").toggle();
        });
    },
    getStoryLikeDetails: function(){
        
        $.ajax({
            url: telling.settings.likeActionUrl,
            beforeSend: function(){

            },
            type: 'POST',
            dataType: "JSON",
            data: { id: telling.settings.id},
            success: function(r){
                if(r.success){
                    _this.parent().find('.like-ctr').find('span').html(r.likeCtr.ctr);
                    _this.toggleClass('liked');

                } else {
                    $.toaster({ message : r.msg, title : '', priority : 'danger' });
                }
            }
        });
    },
    initAudio: function(){

        var audio  = new Audio(telling.settings.audioFileUrl);
        
        audio.addEventListener("loadeddata", function() {
            var duration = parseInt(audio.duration); 
            var dm = parseInt(audio.duration / 60, 10);
            var ds = parseInt(audio.duration % 60);

            if (dm < 10) {
                dm = '0' + dm;
            }
            if (ds < 10) {
                ds = '0' + ds;
            }
            
            $('.audio-counter').html(dm + ':' + ds);	
    
            $('.play-btn').unbind('click').bind('click',function(){
                audio.play();
    
                
            
            });
    
            $('.pause-btn').unbind('click').bind('click',function(){
                audio.pause();
            });

            $('.audio-replay-btn').unbind('click').bind('click',function(){
                audio.currentTime = 0;
                audio.play();
            });

            

            $('.speed-rate-btn').unbind('click').bind('click',function(){
                

                if(telling.settings.speedRate < 4){
                    telling.settings.speedRate += 1;
                } else{
                    telling.settings.speedRate = 1;
                }

                $(this).find('span').html(telling.settings.speedRate != 1 ?   telling.settings.speedRate + 'x' :  '');
                audio.playbackRate =  telling.settings.speedRate;
            });

            $('.volume-btn').unbind('click blur').bind('click blur',function(e){
                
                var _this = $(this);

                var volumeControl =_this.parent().find('.volume-control');
                if(volumeControl.is(':visible')){
                    volumeControl.css('display','none')
                } else {
                    volumeControl.css('display','block')

                }
            });
            

            $('.volume-control').unbind('input change').bind('input change',function(){
                var _this = $(this);

                audio.volume = _this.val();
            });
       

            $(audio).bind('pause',function(){
                $('.play-btn').find('img').removeClass('is-active');
                $('.pause-btn').find('img').addClass('is-active');
                $(audio).unbind('timeupdate');
            });

            $(audio).bind('play',function(){

                $('.pause-btn').find('img').removeClass('is-active');
                $('.play-btn').find('img').addClass('is-active');

                $(audio).bind('timeupdate', function(){
                    var s = parseInt(audio.currentTime % 60);
                    var m = parseInt((audio.currentTime / 60) % 60);
                    if (s < 10) {
                        s = '0' + s;
                    }
                     $('.audio-counter').html(m + ':' + s);	
                    if (audio.currentTime > 0) {
                        $('.audio-flow').val( (100 / duration) * audio.currentTime);
                    }
                });
            });

            $('.audio-flow').bind('input change', function(){
                var _this = $(this);

                audio.currentTime = Math.floor(($(this).val() / 100) * duration); 
                audio.play();

           });

        });

       
       
    },
    shareStory: function(){
        
        $.each($('.share-story-btn'), function(){
            var _this = $(this);
            _this.unbind('click').bind('click', function(){
                var modal = $('#modal');

                
                $.ajax({
                    url: telling.settings.ajaxShareStoryFormUrl,
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
                    url: telling.settings.ajaxArchiveStoryFormUrl,
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
    },
    initLikeInfo: function(){
      
        $.ajax({
            url: telling.settings.ajaxLikeInfoUrl,
            data: { id: telling.settings.id },
            success: function(r){
                console.log(r);
                if(r.success){
                    $('.like-counter').html(r.html);

                }
            }
        });
    }
};