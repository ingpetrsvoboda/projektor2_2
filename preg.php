<?php
// exception handler
require_once 'Bootstrap.php';
// zajištění autoload pro Projektor
require_once 'Projektor2/Autoloader.php';
Projektor_Autoloader::register();

$html[] = 
            "<head>
                <meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
                <meta content='IE=edge' http-equiv='X-UA-Compatible'>
                <title>| Projektor test |</title>
                <link rel='stylesheet' type='text/css' href='css/styles.css'>
                <link rel='stylesheet' type='text/css' href='css/form.css'>
                <link rel='stylesheet' type='text/css' href='css/test.css'>
                <link rel='stylesheet' type='text/css' href='css/highlight.css' />
                <script src='js/modernizr.custom.77712.js'></script>
                <script>
                Modernizr.load(
                    {
                        test: Modernizr.inputtypes.date,
                        nope: ['js/jquery-1.11.0.js', 'js/jquery-ui.min.js', 'css/jquery-ui.css'],
                        complete: function () {
                            if (window.jQuery) {
                                jQuery('input[type=date]').datepicker({
                                    dateFormat: 'd.m.yy', altFormat: 'yy-mm-dd'
                                }); 
                                }
                            }
                    }
                );
                </script>
            </head>
        <body>            
        ";

$skurz = Projektor2_Model_SKurzMapper::findById(743);
$html[] = '<pre>'.var_export($skurz, TRUE);
$html[] = '<form method="POST" action="preg.php" name="preg">';
$html[] = '<p><input ID="datum" type="date" name="datum" size="10" maxlength="10" value="'.$_POST["datum"].'" required></p>';


$html[] = '<p><input type="submit" value="Posli" name="posli"></p>';

$html[] = '</form>';
$date = $_POST['datum'];
$html[] = '<p>Došlo: '.$date.'</p>';
$html[] =  '<p>'.var_dump(preg_match('/^(\d\d\d\d)-(\d\d)-(\d\d)$/', $date, $regs) AND checkdate($regs[2], $regs[3], $regs[1])).'</p>';
$html[] = var_dump($regs);
if (preg_match('/^\d\d\d\d-\d\d-\d\d$/', $date)) {
    $dd = explode('-', $date);
    krsort($dd);
    $datum_varchar = implode('.', $dd);
}
$html[] = '<p>'.$date.'</p>';

$skurz->date_zacatek = $date;
$html[] = '<pre>'.var_export($skurz, TRUE);
//$skurz->

echo implode(PHP_EOL, $html);

echo "</body></html>";