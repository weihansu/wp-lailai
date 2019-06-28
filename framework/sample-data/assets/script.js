(function ($) {
    "use strict";
    $(document).ready(function(){
        function runImport(datatype, percent){
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'sampledata',
                    'datatype':  datatype,
                },
                success: function(data, textStatus, XMLHttpRequest){
                    $('.sns-importprocess-width').css({
                        'width' : percent + '%',
                        '-moz-transition' : 'width 1s',
                        '-o-transition' : 'width 1s',
                        '-webkit-transition' : 'width 1s',
                        'transition' : 'width 1s'
                    });
                    $('#sns-importmsg .status').html(' Importing: ' + percent + '%');
                    if ( datatype == 'theme' ){
                        $('#sns-import-tablecontent ul li.theme-cfg i').attr('class', 'fa fa-check');
                        percent = percent + 20;
                        runImport("slider", percent);
                        $('#sns-import-tablecontent ul li.revslider-cfg i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'slider' ){
                        $('#sns-import-tablecontent ul li.revslider-cfg i').attr('class', 'fa fa-check');
                        percent = percent + 20;
                        runImport("content", percent);
                        $('#sns-import-tablecontent ul li.all-content i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'content' ){
                        $('#sns-import-tablecontent ul li.all-content i').attr('class', 'fa fa-check');
                        percent = percent + 20;
                        runImport("widget", percent);
                        $('#sns-import-tablecontent ul li.widget-cfg i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'widget' ){
                        $('#sns-import-tablecontent ul li.widget-cfg i').attr('class', 'fa fa-check');
                        runImport("media1", percent);
                        $('#sns-import-tablecontent ul li.media1-files i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'media1' ){
                        $('#sns-import-tablecontent ul li.media1-files i').attr('class', 'fa fa-check');
                        runImport("media2", percent);
                        $('#sns-import-tablecontent ul li.media2-files i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'media2' ){
                        $('#sns-import-tablecontent ul li.media2-files i').attr('class', 'fa fa-check');
                        percent = percent + 20;
                        runImport("media3", percent);
                        $('#sns-import-tablecontent ul li.media3-files i').attr('class', 'fa fa-spin fa-circle-o-notch');
                    }
                    if ( datatype == 'media3' ){
                        $('#sns-importmsg').html('Import done!');
                        $('#sns-import-tablecontent ul li.media3-files i').attr('class', 'fa fa-check');
                    }
                }
            });
        }
        $('#btn_sampledata').on('click', function() {
            var c = confirm("Are you want import demo content?");
            if (c == true) {
                $('.sns-importprocess').show();
                $(this).attr('disabled','true');
                $('#sns-importmsg .status').html('Importing');
                runImport("theme", 20);
            }
        });
    });
})(jQuery);