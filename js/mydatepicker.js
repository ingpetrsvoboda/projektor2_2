//
//                                 jQuery('input[type=date]').datepicker({dateFormat: 'yy.mm.dd'}); 

//jQuery(function($) {
//      $('input.datetimepicker').datepicker(
//      {
//        duration: '',
//        changeMonth: false,
//        changeYear: false,
//        yearRange: '2010:2020',
//        showTime: false,
//        time24h: true
//      });
//
//    $.datepicker.regional['cs'] = {
//        closeText: 'Zavřít',
//        prevText: '&#x3c;Dříve',
//        nextText: 'Později&#x3e;',
//        currentText: 'Nyní',
//        monthNames: ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen',
//            'září', 'říjen', 'listopad', 'prosinec'],
//        monthNamesShort: ['led', 'úno', 'bře', 'dub', 'kvě', 'čer', 'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
//        dayNames: ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
//        dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
//        dayNamesMin: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
//        weekHeader: 'Týd',
//        dateFormat: 'dd/mm/yy',
//        firstDay: 1,
//        isRTL: false,
//        showMonthAfterYear: false,
//        yearSuffix: ''
//    };
//    $.datepicker.setDefaults($.datepicker.regional['cs']);
    
//<head>
//    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//    <meta http-equiv="Content-Language" content="cs" />
//
//    <title>TITLE</title>
//    <script type="text/javascript" src="{$baseUri}js/jquery-1.4.min.js"></script>
//    <script type="text/javascript" src="{$baseUri}js/jquery.nette.js"></script>
//    <script type="text/javascript" src="{$baseUri}js/jquery.ajaxform.js"></script>
//    {* TinyMce *}
//    <script type="text/javascript" src="{$baseUri}js/tiny_mce/tiny_mce.js"></script>
//    <script type="text/javascript" src="{$baseUri}js/tiny_mce/tiny_mce_init.js"></script>
//    {* DatePicker *}
//    <link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" />
//<script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.core.js"></script>
//<script type="text/javascript" src="http://jqueryui.com/latest/ui/ui.datepicker.js"></script>
//<script type="text/javascript" src="http://jqueryui.com/latest/ui/i18n/ui.datepicker-cs.js"></script>
//<script type="text/javascript">
//$(document).ready(function(){
//    $('input.datepicker').datepicker({ duration: 'fast' });
//});
////</script>

//    <link rel="stylesheet" type="text/css" media="screen" href="{$baseUri}css/site.css" />
//</head>    

    
//                                $.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
//                                $.datepicker.setDefaults({ parseDate: 'yy/mm/dd' });    
    
    
//$.datepicker.formatDate( 'DD, MM d, yy', new Date( 2007, 7 - 1, 14 ), {
//dayNamesShort: $.datepicker.regional[ 'cs' ].dayNamesShort,
//dayNames: $.datepicker.regional[ 'cs' ].dayNames,
//monthNamesShort: $.datepicker.regional[ 'cs' ].monthNamesShort,
//monthNames: $.datepicker.regional[ 'cs' ].monthNames
//});    


function myDatepicker() {
    if (window.jQuery) {
        $.datepicker.regional['cs'] = {
            closeText: 'Zavřít',
            prevText: '&#x3c;Dříve',
            nextText: 'Později&#x3e;',
            currentText: 'Nyní',
            monthNames: ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen',
                'září', 'říjen', 'listopad', 'prosinec'],
            monthNamesShort: ['led', 'úno', 'bře', 'dub', 'kvě', 'čer', 'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
            dayNames: ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
            dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
            dayNamesMin: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
            weekHeader: 'Týd',
            dateFormat: 'dd.mm.yy',
            formatDare: 'dd.mm.yy',
            parseDade: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['cs']);
        $.datepicker.setDefaults({changeYear: true});
     $.datepicker.setDefaults({
        onSelect: function(dateText, inst) {
                var date = $.datepicker.parseDate(inst.settings.dateFormat || $.datepicker._defaults.dateFormat, dateText, inst.settings);
                var dateText1 = $.datepicker.formatDate("D, d M yy", date, inst.settings)
            }
        });
        jQuery('input[type=date]').datepicker(); 
    }
}