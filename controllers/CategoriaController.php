<?php

    class CategoriaController extends AbstractController {

        /**
         * Lista os categoria
         */
        public function listar() {
            $db = Database::getConn(true);

            $this->categorias = $db->categoria()->order('id');
            $this->categorias_items = $db->categoria_item()->order('id');
            $this->items_opcoes = $db->item_opcao()->order('id');
            $this->render('categoria/lista');
        }

        /**
         * Formulário de item
         */
        public function form() {
            $db = Database::getConn();
            
            if( isset($_GET['id']) ) {
                $this->categorias_items = $db->categoria_item('id', $_GET['id'])->where('id', $_GET['id']);
                $this->items_opcoes = $db->item_opcao('id_item', $_GET['id'])->where('id_item', $_GET['id']);
                $this->categorias_items_categoria = $db->categoria_item('id', $_GET['id'])->where('id', $_GET['id'])->fetch();
            }else{
                $this->categorias_items_categoria = null;
            }
            
            $this->categorias = $db->categoria()->order('id');
            $this->render('categoria/form');
        }

        /**
         * Formulário de categoria
         */
        public function formCategoria() {
            $db = Database::getConn();
            if( isset($_GET['id']) ) {
                $this->categoria = $db->categoria('id', $_GET['id'])->where('id', $_GET['id'])->fetch();
            }
            $this->render('categoria/form_categoria');
        }

        /**
         * Salva um item
         */
        public function salvar()
        {
            $db = Database::getConn();

            // Verifica se a categoria foi selecionada
            if (empty($_POST['nome'])) {
                Util::redirect('index.php?controle=categoria&acao=listar&erro=selecione_categoria');
                return;
            }

            $idCategoria = $_POST['nome'];
            

            if (!isset($_POST['items']) || !is_array($_POST['items'])) {
                Util::redirect('index.php?controle=categoria&acao=listar&erro=nenhum_item_adicionado');
                return;
            }

            foreach ($_POST['items'] as $index => $item) {
                if (empty(trim($item))) {
                    continue;
                }

                $min = isset($_POST['min'][$index]) ? intval($_POST['min'][$index]) : null;
                $max = isset($_POST['max'][$index]) ? intval($_POST['max'][$index]) : null;

                // Edição
                if (isset($_POST['id']) && $_POST['id'] != '') {
                    $idItem = $_POST['id'];
                    $db->categoria_item()->where('id', $idItem)->update([
                        'id_categoria' => $idCategoria,
                        'item' => utf8_decode($item),
                        'min' => $min,
                        'max' => $max,
                    ]);
                } else {
                    // Criação
                    $dataItem = [
                        'id_categoria' => $idCategoria,
                        'item' => utf8_decode($item),
                        'min' => $min,
                        'max' => $max,
                    ];
                    $inserted = $db->categoria_item()->insert($dataItem);
                    $idItem = $inserted['id'];
                    
                }

                if ($idItem && isset($_POST['options'][$index]) && is_array($_POST['options'][$index])) {
                    $db->item_opcao()->where('id_item', $idItem)->delete();
                    
                    foreach ($_POST['options'][$index] as $option) {
                        if (!empty(trim($option))) {
                            $dataOption = [
                                'id_item' => $idItem,
                                'opcao' => utf8_decode($option),
                            ];
                            $db->item_opcao()->insert($dataOption);
                        }
                    }
                }
            }

            Util::redirect('index.php?controle=categoria&acao=listar&sucesso=salvo');
        }

        /**
         * Salva uma categoria
         */
        public function salvarCategoria() {
            $db = Database::getConn();
         
            if( $_POST['id'] ) {
                $categoria = $db->categoria('id', $_POST['id'])->fetch();
            } else {
                $categoria = array();
            }

            $categoria['categoria']        = utf8_decode($_POST['categoria']);
            $categoria['descricao']        = utf8_decode($_POST['descricao']);

            if( $_POST['id'] ) {
                $categoria->update();
            } else {
                $db->categoria()->insert($categoria);
            }
            Util::redirect('index.php?controle=categoria&acao=listar');
        }
        
        


        /**
         * Remove uma categoria
         */
        public function removerCategoria() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();
                $db->categoria('id', $_GET['id'])->delete();
                Util::redirect('index.php?controle=categoria&acao=listar');
            }
        }

        /**
         * Remove um item
         */
        public function removerItem() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();
                $db->categoria_item('id', $_GET['id'])->delete();
                Util::redirect('index.php?controle=categoria&acao=listar');
            }
        }
    }
?>