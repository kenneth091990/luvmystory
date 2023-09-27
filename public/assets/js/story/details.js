var details = {
    settings: {
        ajaxUrl: '',
        removeShareStoryAjaxUrl:''
    },
    init: function() {
        details.initInput();
        details.shareStory();
    },

    initInput: function(){
        $("#storyPic").change(function(){
            details.readURL(this);
        });

        $('#copyToClipBoard').unbind('click').bind('click',function(){
            var temp = $("<input>");
           $("body").append(temp);
           temp.val($('#clipboard').text()).select();
           document.execCommand("copy");
           temp.remove();
   
       });

       details.sharedBox();

       $(document).click(function(e){
            if(!$(e.target).parent().hasClass('shared-box')){
                if($('.shared-person').length){
                    $('.shared-person').remove();
                }
    
            }

       });

       
    },
    sharedBox: function(){
        $.each($('.shared-box'),function(){
            var _this = $(this);

            if(_this.find('.shared-person').length){
                _this.find('.shared-person').remove();
            }

            _this.unbind('click').bind('click',function(){
                
                details.sharedBox();
             
                var html = "<div class='shared-person'><div>"+_this.data('name')+"</div><div class='remove-share-box' data-id='"+_this.data('id')+"'>Remove</div></div>";
                _this.append(html);
                details.removeShareBox();
                
            });
        });
    },

    removeShareBox(){
        $.each($('.remove-share-box'),function(){
            var _this = $(this);

            _this.unbind('click').bind('click',function(){
                $.ajax({
                    url : details.settings.removeShareStoryAjaxUrl,
                    type: 'POST',
                    data: { id: _this.data('id' )},
                    success: function(r){
                        if(r.success){
                            
                            $('#shared-box-'+r.id).remove();
                            toastr.success(r.msg);
                        } else {

                            toastr.error(r.msg);
                        }
                    }
                })
            });
        });

    },
    readURL: function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgStoryPic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    },
    shareStory: function(){
    }

    


};