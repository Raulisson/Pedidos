<?php

    class UsuarioController extends AbstractController {

        /**
         * Login
         */
        public function entrar() {
            if( isset($_POST['usuario']) && isset($_POST['senha']) ) {
                $db = Database::getConn();
                $usuario = $db->usuario()
                    ->where(array('usuario' => $_POST['usuario'], 'senha' => sha1(md5($_POST['senha']))))
                    ->fetch();
                if( $usuario ) {
                    $_SESSION['usuario']['id']          = $usuario['id'];
                    $_SESSION['usuario']['nome']        = $usuario['nome'];
                    $_SESSION['usuario']['perfil']      = $usuario['perfil'];
                    Util::redirect("index.php?controle=pedidos&acao=listar");
                } else {
                    Util::redirect("login.php");
                }
            }
        }

        /**
         * Lista os usuários
         */
        public function listar() {
            $db = Database::getConn(true);

            $this->usuarios = $db->usuario()->order('nome');
            $this->render('usuario/lista');
        }

        /**
         * Sair
         */
        public function sair() {
            session_destroy();
            Util::redirect('login.php');
        }

        /**
         * Formulário de usuário
         */
        public function form() {
            $db = Database::getConn();
            
            if( isset($_GET['id']) ) {
                $this->usuario = $db->usuario('id', $_GET['id'])->fetch();
            }
            
            $this->render('usuario/form');
        }

        /**
         * Salva um usuário
         */
        public function salvar() {
            $db = Database::getConn();
         
            if( $_POST['id'] ) {
                $usuario = $db->usuario('id', $_POST['id'])->fetch();
            } else {
                $usuario = array();
            }

            $usuario['nome']            = utf8_decode($_POST['nome']);
            $usuario['usuario']         = utf8_decode($_POST['usuario']);
            $usuario['perfil']          = $_POST['perfil'];
            if( $_POST['senha'] ) {
                $usuario['senha']       = sha1(md5(utf8_decode($_POST['senha'])));
            }
            
            if( $_POST['id'] ) {
                $usuario->update();
            } else {
                $db->usuario()->insert($usuario);
            }
            Util::redirect('index.php?controle=usuario&acao=listar');
        }

        /**
         * Remove um usuário
         */
        public function remover() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();

                $usuario = $db->usuario('id', $_GET['id'])->fetch();
                
                $db->usuario('id', $_GET['id'])->delete();
                Util::redirect('index.php?controle=usuario&acao=listar');
            }
        }
    }
?>