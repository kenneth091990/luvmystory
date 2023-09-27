var telling = {
    settings: {
        id: '',
        commentsListAjaxUrl: '',
        commentFormAjaxUrl: '',
        likeActionUrl: ''
    },
    init: function() {
        telling.copyToClipboard();
        telling.loadComments();
        telling.commentForm();
        telling.bindInput();
    },
    loadComments: function(){
        var commentBox = $('#commentBox');

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
            var commentBox = $('#commentBox');

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
                _this.closest('form').find('button').prop('disabled' , false);
            } else {
                _this.closest('form').find('button').prop('disabled' , true);

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
                        if(r.likeCtr.ctr > 0){
                            var html = r.likeCtr.likers + (r.likeCtr.ctr > 3? ' and ' + (r.likeCtr.ctr - 3) + ' other people ' : '') + ' like this story';

                        }
                        _this.parent().find('.like-ctr').find('span').html(html);
                        _this.toggleClass('liked');

                    } else {
                        $.toaster({ message : r.msg, title : '', priority : 'danger' });
                    }
                }
            });
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
    }
};