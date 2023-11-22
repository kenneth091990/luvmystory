
  var  global = {
        settings: {
            url: '',
            notification_url: ''
        },
        init: function(){
            global.mask();
            global.flash_message();
            global.bindFormSubmitted(); 
            global.check_notification();
            global.init_modal();
            global.resizeHeaderContainer();
            global.toggleClass();
        },
        init_modal: function(){
            
            $.each($('.modalBtn'),function(){

                var _this = $(this);

                _this.unbind('click').bind('click',function(){                    

                    var modal = $('#modal');
                    var id =  typeof _this.data('id') != 'undefined' ?  _this.data('id') : null; 

                    if(_this.data('src')){

                        $.ajax({
                            url: _this.data('src'),
                            beforeSend: function(){
                                if(_this.hasClass('large')){
                                    modal.addClass('large');
                                } else {
                                    modal.removeClass('large');
   
                                }
                            },
                            data: { id: id },
                            success: function(r){

                                if(r.success){
                                    
                                    modal.html(r.html).foundation('open');
                                } else {
                                    toastr.error(r.msg);
                                }
                            }
                        });
                    }
                })
            });
        },
        check_notification: function(){
            setTimeout(
                $.ajax({
                    url : global.settings.notification_url,
                    type: "POST",
                    success: function(d){
                        $('.notification-content').html(d.html);
                        if(d.success){
                            if(d.unreadNoticationCtr){
                                $('.notifCtr').html(d.unreadNoticationCtr).css('display', 'block');
                         
                            }
                        }
                    }
                })
                , 300);
        },
        flash_message(){

            if($('.error').length){
                setTimeout( () => { 
                    $('.error').css('display', 'none');
                } , 3000);
            }

            if($('.success').length){
                setTimeout( () => { 
                    $('.success').css('display', 'none');
                } , 3000);
            }
        },
        mask: function(){

            if($('.datepicker').length){
                $('.datepicker').mask('99/99/9999').datepicker();
            }

            if($('.amt').length){
                $.each($('.amt'), function(){
                    $(this).maskMoney();
                });
            }
        },
        dataTableResponsiveCallBack: function(api, rowIdx, callBack) {

            var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
                var header = jQ( api.column( cell.column ).header() );
                var idx = api.cell( cell ).index();

                if ( header.hasClass( 'control' ) || header.hasClass( 'never' ) ) {
                    return '';
                }

                // Use a non-public DT API method to render the data for display
                // This needs to be updated when DT adds a suitable method for
                // this type of data retrieval
                var dtPrivate = api.settings()[0];
                var cellData = dtPrivate.oApi._fnGetCellData(
                    dtPrivate, idx.row, idx.column, 'display'
                );
                var title = header.text();
                if ( title ) {
                    title = title + ':';
                }

                return '<li data-dtr-index="'+idx.column+'">'+
                    '<span class="dtr-title">'+
                    title+
                    '</span> '+
                    '<span class="dtr-data">'+
                    cellData+
                    '</span>'+
                    '</li>';
            } ).toArray().join('');

            return data ?
            { append: jQ('<ul data-dtr-index="'+rowIdx+'"/>').append( data ), callBack: callBack } :
                false;
        },
        autocomplete: {
            processes: [],
            bind: function(url, el, hidEl, callBacks) {

                // To set additional parameters call $(element).devbridgeAutocomplete('setOptions', {params: {sampleParam: 'sampleParamValue'}});

                $(el).devbridgeAutocomplete({
                    serviceUrl: url,
                    dataType: 'json',
                    noCache: true,
                    showNoSuggestionNotice: true,
                    minChars: 0,
                    onSearchStart: function() {
                        $(this).removeClass('autocomplete-loading').addClass('autocomplete-loading');
                        if(typeof callBacks === 'object' && typeof callBacks.onSearchStart === 'function') {
                            callBacks.onSearchStart();
                        }
                        $(hidEl).val('');
                        global.autocomplete.processes.push(el);
                        global.autocomplete.checkProcesses();
                    },
                    onSearchComplete: function() {
                        $(this).removeClass('autocomplete-loading');
                        if($(this).val() === '') {
                          
                            if(hidEl !== null) {
                                $(hidEl).val('');
                            }
                            if(!$(this).data('on-focus')) {
                                $(el).devbridgeAutocomplete('hide');
                            }
                        }
                        if(typeof callBacks === 'object' && typeof callBacks.onSearchComplete === 'function') {
                            callBacks.onSearchComplete();
                        }
                        global.autocomplete.removeProcess(el);
                    },
                    onSearchError: function() {
                        if($(this).val() === '' && hidEl !== null) {
                            $(hidEl).val('');
                        }
                        if(typeof callBacks === 'object' && typeof callBacks.onSearchError === 'function') {
                            callBacks.onSearchError();
                        }
                        global.autocomplete.removeProcess(el);
                    },
                    onSelect: function(s) {
                        if(hidEl !== null) {
                            $(hidEl).val(s.id);
                        }
                        if(typeof callBacks === 'object' && typeof callBacks.onSelect === 'function') {
                            callBacks.onSelect(s);
                        }
                        global.autocomplete.removeProcess(el);
                    }
                });

                $(el).unbind('keyup.checkEmpty').bind('keyup.checkEmpty', function(){
                    if($(this).val() === '') {
                        $(this).removeClass('autocomplete-loading');
                        if(hidEl !== null) {
                            $(hidEl).val('');
                        }
                        $(el).devbridgeAutocomplete('hide');
                        global.autocomplete.removeProcess(el);
                        if(typeof callBacks === 'object' && typeof callBacks.checkEmpty === 'function') {
                            callBacks.checkEmpty();
                        }
                    }
                }).unbind('focus.checkFocus').bind('focus.checkFocus', function(){
                    $(this).data('onFocus', true);
                }).unbind('keydown.checkFocus').bind('keydown.checkFocus', function(){
                    $(this).data('onFocus', false);
                });
            },
            removeProcess: function(el) {

                for(var i=0; i < global.autocomplete.processes.length; i++) {
                    if(global.autocomplete.processes[i] === el) {
                        global.autocomplete.processes.splice(i, 1);
                    }
                }

                global.autocomplete.checkProcesses();
            },
            checkProcesses: function() {

                if(global.autocomplete.processes.length > 0) {
                    global.formSubmitted();
                } else {
                    global.formSubmittedReverse();
                }
            }
        },   
         formSubmitted: function() {
            if($('.button-container').length > 0) {
                $('.button-container').children().each(function() {
                    if($(this).is('a')) {
                        $(this).data('href', $(this).attr('href')).removeAttr('href').addClass('disabled');
                    } else {
                        $(this).prop('disabled', true).addClass('disabled');
                    }
                });
            }
        },
        formSubmittedReverse: function() {
            if($('.button-container').length > 0) {
                $('.button-container').children().each(function() {
                    if($(this).is('a')) {
                        $(this).attr('href', $(this).data('href')).removeClass('disabled');
                    } else {
                        $(this).prop('disabled', false).removeClass('disabled');
                    }
                });
            }
        },

        askContinue: function() {
            if($('.ask-continue').length > 0) {
                $('.ask-continue').unbind('click.askContinue').bind('click.askContinue', function(e) {
                    if(!confirm($(this).data('message'))) {
                        e.preventDefault();
                    } else {
                        if($('.form-action').length > 0) $('.form-action').val($(this).val());
                        $('input, select, textarea').each(function() {
                            $(this).removeAttr('required');
                        });
                    }
                });
            }
        },
        bindFormSubmitted: function() {
            if($('form').length > 0) {
                $('form').unbind('submit.submitted').bind('submit.submitted', global.formSubmitted());
                global.askContinue();
                global.justContinue();
            }
        },
        justContinue: function() {
            if($('.just-continue').length > 0) {
                $('.just-continue').unbind('click.justContinue').bind('click.justContinue', function() {
                    if($('.form-action').length > 0) $('.form-action').val($(this).val());
                });
            }
        },

        resizeHeaderContainer: function(){

            var headerScrollHeight = $('.header-container')[0].scrollHeight;
            var  windowHeight = $(window).height();
            
            $('#header-subd').css('padding-top', headerScrollHeight);

            if($('#main-banner').length){
                $('#main-banner .content-container').css('height' , windowHeight - headerScrollHeight);
            }

            if($('.index-content').length){

                var addHeightOnMobile = 0; 
                if ($(window).width() < 1023){
                    addHeightOnMobile = 120;
                }

                $('.content-container').css('height' ,(( windowHeight - headerScrollHeight) / 2) + addHeightOnMobile);

            }

            $(window).resize(function() {

                 headerScrollHeight = $('.header-container')[0].scrollHeight - ($('.dashboard-menu-device').length > 0 ? $('.dashboard-menu-device')[0].scrollHeight : 0);
                 windowHeight = $(window).height() -  ($('.dashboard-menu-device').length > 0 ? $('.dashboard-menu-device')[0].scrollHeight : 0);
                 


                $('#header-subd').css('padding-top', headerScrollHeight );

                if($('#main-banner').length){
                    $('#main-banner .content-container').css('height' , windowHeight - headerScrollHeight);
                }

                if($('.index-content').length){

                   var addHeightOnMobile = 0; 
                    if ($(window).width() < 1023){
                        addHeightOnMobile = 120;
                    }

                    $('.content-container').css('height' ,(( windowHeight - headerScrollHeight) / 2) + addHeightOnMobile);
    
                }
            });
        }, 
        toggleClass: function(){
          
            $(".notification-bell").click(function(){
                $(".notification").toggle(500);
            });

            $(".burger-menu").click(function(){
                $(".menu-device").toggle(500);
            });

            $(".notification-bell").blur(function(){

                if($('.notification').is(':visible')){
                    $(".notification").toggle(500);

                }
            });
            
            $(".burger-menu").blur(function(){
                console.log('dd');

                if( $(".menu-device").is(':visible')){
                    $(".menu-device").toggle(500);

                }
              
            });
        }
    };