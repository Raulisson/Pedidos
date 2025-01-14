<?php
    session_start();
    date_default_timezone_set('America/Sao_Paulo');
    
    require_once('./Database.php');
    require_once('./Util.php');
    require_once('./Constants.php');
    require_once('./Security.php');
    require_once('./controllers/AbstractController.php');

    // Ação padrão
    if( !isset($_GET['controle']) ) {
        $_GET['controle'] = 'index';
    }
    if( !isset($_GET['acao']) ) {
        $_GET['acao'] = 'index';
    }

    // Verifica se a ação é pública
    if( !Security::isPublic($_GET['controle'], $_GET['acao']) ) {

        // Verifica a sessão
        if( !isset($_SESSION['usuario']['id']) ) {
            Util::redirect('login.php');
        }
    }
    
    // Seleciona o controle e a ação
    $controller = ( isset($_GET['controle']) ? $_GET['controle'] : 'index' );
    $controller = ucfirst($controller).'Controller';
    $action = ( isset($_GET['acao']) ? $_GET['acao'] : 'index' );

    require_once('./controllers/'.$controller.'.php');
    $objController = new $controller();
    $objController->$action();
?>