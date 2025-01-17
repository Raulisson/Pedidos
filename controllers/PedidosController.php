<?php

    class PedidosController extends AbstractController {

       /**
        * Lista
        */
        public function listar() {
            $db = Database::getConn(true);

            $this->pedidos = $db->pedido()->order('data_cirurgia DESC');
            $this->render('pedidos/lista');
        }

        /**
         * Formulário de Pedidoss
         */
        public function form() {
            $db = Database::getConn();
            $this->categorias = $db->categoria()->order('id');
            $this->categorias_items = $db->categoria_item()->order('id');
            $this->items_opcoes = $db->item_opcao()->order('id');
            $this->render('pedidos/form');
        }
        

        public function impressao() {
            $db = Database::getConn(true);
            $id_pedido = isset($_GET['id']) ? $_GET['id'] : null;
            $this->pedidos = $db->pedido('id', $_GET['id'])->where('id', $_GET['id'])->fetch();
            if ($id_pedido) {
                // Buscar categorias
                $categorias_result = $db->categoria()->order('id');
        
                $data = [];
                foreach ($categorias_result as $categoria) {
                    $items_result = $db->categoria_item()->where('id_categoria', $categoria['id']);
        
                    $items_data = [];
                    foreach ($items_result as $item) {
                        $opcoes_result = $db->pedido_opcao()
                            ->where('id_item', $item['id'])
                            ->where('id_pedido', $id_pedido);
        
                        $opcoes_data = [];
                        foreach ($opcoes_result as $opcao) {
                            $opcoes_data[] = utf8_encode($opcao['opcao']);
                        }
        
                        $items_data[] = [
                            'item' => utf8_encode($item['item']),
                            'opcoes' => $opcoes_data,
                        ];
                    }
        
                    
                    $temOpcoes = false;
                    foreach ($items_data as $itemData) {
                        if (!empty($itemData['opcoes'])) {
                            $temOpcoes = true;
                            break;
                        }
                    }

                    if ($temOpcoes) {
                        $data[] = [
                            'categoria' => utf8_encode($categoria['categoria']),
                            'descricao' => utf8_encode($categoria['descricao']),
                            'items' => $items_data,
                        ];
                    }
                }
        
                $this->data = $data;
                $this->render('pedidos/impressao');
            }
        }
        

        /**
         * Salva um Pedido
         */
        public function salvar() {
            $db = Database::getConn();
            $pedido = array();
        
            $pedido['nome'] = utf8_decode($_POST['nome']);
            $pedido['email'] = utf8_decode($_POST['Email']);
            $pedido['telefone'] = utf8_decode($_POST['Telefone']);
            $pedido['data_cirurgia'] = $_POST['data'];
            $pedido['alergia'] = utf8_decode($_POST['alergia']);
        
            
            $pedidoId = $db->pedido()->insert($pedido);
        
            // Processar as opções selecionadas
            if (!empty($_POST['opcoes'])) {
                foreach ($_POST['opcoes'] as $opcao) {
                    list($id_categoria, $id_item, $opcaoValor) = explode('|', $opcao);
        
                    $pedido_opcao = [
                        'id_pedido' => $pedidoId,
                        'id_categoria' => $id_categoria,
                        'id_item' => $id_item,
                        'opcao' => utf8_decode($opcaoValor),
                    ];
                    $db->pedido_opcao()->insert($pedido_opcao);
                }
            }
        
            Util::redirect('finalizado.php');
        }
        
        

        /**
         * Remove um Pedido
         */
        public function remover() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();
                $db->pedido('id', $_GET['id'])->delete();
                Util::redirect('index.php?controle=pedidos&acao=listar');
            }
        }


        /**
         * Realiza a troca de status do pedido
         */
        public function ativar() {
            $db = Database::getConn();
            $pedido = $db->pedido('id', $_GET['id'])->fetch();
            $pedido['ativo'] = 1;
            $pedido->update();
            Util::redirect('index.php?controle=pedidos&acao=listar');
        }
        public function inativar() {
            $db = Database::getConn();
            $pedido = $db->pedido('id', $_GET['id'])->fetch();
            $pedido['ativo'] = 0;
            $pedido->update();
            Util::redirect('index.php?controle=pedidos&acao=listar');
        }
    }
?>