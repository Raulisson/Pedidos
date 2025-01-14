<?php

    class MidiaController extends AbstractController {

        /**
         * Lista os midias
         */
        public function listar() {
            $db = Database::getConn();

            $this->midias = $db->midia()->order('nome');
            $this->render('midia/lista');
        }

        /**
         * Formulário de midias
         */
        public function form() {
            $db = Database::getConn();
            
            if( isset($_GET['id']) ) {
                $this->midia = $db->midia('id', $_GET['id'])->fetch();
            }
            
            $this->render('midia/form');
        }

        /**
         * Salva uma midia
         */
        public function salvar() {
            $db = Database::getConn();
         
            if( $_POST['id'] ) {
                $midia = $db->midia('id', $_POST['id'])->fetch();
            } else {
                $midia = array();
            }

            // Upload
            if( $_FILES['arquivo']['name'] ) {

                // Apaga o arquivo antigo
                if( isset($midia['endereco']) && is_file(".".$midia['endereco']) ) {
                    @unlink(".".$midia['endereco']);
                }

                // Salva o arquivo novo
                $pos = strrpos($_FILES['arquivo']['name'], ".");
                $ext = substr($_FILES['arquivo']['name'], $pos);
                $arquivo = "/upload/midias/".time().$ext;
            
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], ".".$arquivo)) {
                    $_POST['endereco'] = $arquivo;
                } else {
                    echo "Falha no upload";
                    die;
                }
            }
       
            $midia['nome']      = utf8_decode($_POST['nome']);
            $midia['tipo']      = $_POST['tipo'];
            $midia['duracao']   = $_POST['duracao'];
            $midia['endereco']  = utf8_decode($_POST['endereco']);

            if( $_POST['id'] ) {
                $midia->update();
            } else {
                $db->midia()->insert($midia);
            }

            Util::redirect('index.php?controle=midia&acao=listar');
        }

        /**
         * Remove um midia
         */
        public function remover() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();
                $midia = $db->midia('id', $_GET['id'])->fetch();

                // Apaga o arquivo antigo
                if( isset($midia['endereco']) && @is_file(".".$midia['endereco']) ) {
                    @unlink(".".$midia['endereco']);
                }
                $midia->delete();
                Util::redirect('index.php?controle=midia&acao=listar');
            }
        }

        /**
         * Carrega a playlist como Json
         */
        public function playlist() {
            $db = Database::getConn();
            $midiasDb = $db->midia();
            $midias = array();
            foreach( $midiasDb as $midiaDb ) {
                $midias[] = array(
                    "id" => $midiaDb['id'],
                    "nome" => utf8_encode($midiaDb['nome']),
                    "tipo" => $midiaDb['tipo'],
                    "duracao" => $midiaDb['duracao'],
                    "volume" => 30,
                    "endereco" => utf8_encode($midiaDb['endereco'])
                );
            }

            echo json_encode($midias);
        }
    }
?>