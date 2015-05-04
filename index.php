<?php
ob_start();


//define('INC_PATH','./inc/');

//require_once(INC_PATH."ind_pomocne_funkce.php");
// exception handler
require_once 'Bootstrap.php';
// zajištění autoload pro Projektor
require_once 'Projektor2/Autoloader.php';
Projektor_Autoloader::register();
require_once 'Classes/PHPExcel.php';  // uvnitř v Classes/PHPExcel.php se provede PHPExcel_Autoloader::Register();

$request = new Projektor2_Request();
$response = new Projektor2_Response();
//$app = new Projektor2_Application($request, $response);

// zjištění, zda je uživatel přihlášen
// pokud ano nastaví proměnnou $userid, pokud ne, dojde k přesměrování na login
try {
    $authCookie = new Projektor2_Auth_Cookie($response);
    $authCookie->validate();
    $userid = $authCookie->get_userid();

    // nastavení statusu aplikace z cookies a proměnných v requestu
    Projektor2_SessionStatus::setUserId($userid);
    //zde se příjímá proměnná beh z formuláře vyber_beh
    if ($request->post('beh')) Projektor2_SessionStatus::setBehId($request->post('beh'));  //je nově vybrán běh
    if ($request->get('id_zajemce')) Projektor2_SessionStatus::setZajemceId($request->get('id_zajemce'));  //vybrané tlačítko - zobrazení některé flat table ve formuláři
    if ($request->get('id_ucastnik')) Projektor2_SessionStatus::setUcastnikId($request->get('id_ucastnik'));  //vybrané tlačítko - zobrazení některé flat table ve formuláři
    $sessionStatus = Projektor2_SessionStatus::createSessionStatus();
}
catch (Projektor2_Auth_Exception $e) {
    header("Location: ./login.php?originating_uri=".$_SERVER['REQUEST_URI']);
    $response->send();
    exit;
}


// kontrolery do šablony stránky - volají se vždy
$headController = new Projektor2_Controller_Head($sessionStatus, $request, $response);
$contextController = new Projektor2_Controller_Context($sessionStatus, $request, $response);
$logoutController = new Projektor2_Controller_Logout($sessionStatus, $request, $response);
$logoController = new Projektor2_Controller_Logo($sessionStatus, $request, $response);

$messageController = new Projektor2_Controller_Message($sessionStatus, $request, $response);
$footerController = new Projektor2_Controller_Footer($sessionStatus, $request, $response);

// chybové hlášení - pokud není chybové hlášení, povolím zobrazení obsahu 
$htmlMessageCode = $messageController->getResult();

// když nenastala chyba - pokračuji routováním a generováním obsahu
if ($htmlMessageCode == "") {
    $router = new Projektor2_Router_Akce($sessionStatus, $request, $response);
    $contentController = $router->getController();
} else {
    $contentController = NULL;
}

// šablona stránky
/** HTML **/
$response->setBody("
        <!DOCTYPE html>
        <html class='no-js'>
            {$headController->getResult()}
            <body onload = 'Zobraz_pdf();'     
                <div class='header'>
                    <div id='logout-ie'>
                    {$contextController->getResult()}
                        <div id='logout'>
                        {$logoutController->getResult()}
                        </div>
                    </div>
                    {$logoController->getResult()}
                </div>
                <div class='container'>
                    {$messageController->getResult()}
                 ");

if ($contentController) $response->appendToBody($contentController->getResult());
        $response->appendToBody("
                </div>
            {$footerController->getResult()}
        </body>
        </html>");
/** /HTML **/
$response->send();
?>
