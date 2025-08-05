<?php

    class PedidosController extends AbstractController {

       /**
        * Lista
        */
        public function listar() {
            $db = Database::getConn(true);
        
            // Captura o filtro
            $filters = array();
            if (!empty($_GET['search'])) {
                $filtro = $_GET['search'];
                $filters['data_cirurgia LIKE ?'] = "%" . $filtro . "%";
            }
        
            $this->pagination = new Pagination('pedido', 'data_cirurgia DESC', $filters);
            $this->pedidos = $this->pagination->rows;
            $this->render('pedidos/lista');
        }
        

        /**
         * Formulário de Pedidoss
         */
        public function form() {
            $db = Database::getConn();
        
            // Buscar todos os cardápios
            $this->cardapios = $db->cardapio()->order('id');
        
            // Buscar todas as categorias, itens e opções disponíveis
            $this->categorias = $db->categoria()->order('id');
            $this->itens = $db->categoria_item()->order('id');
            $this->opcoes = $db->item_opcao()->order('id');
        
            // Buscar todas as opções vinculadas aos cardápios
            $this->cardapio_opcoes = $db->cardapio_opcoes()->order('id');
            if(!empty($_GET['id_cardapio'])){
                $this->id_cardapio = $_GET['id_cardapio'];
            }else{
                $this->id_cardapio = '';
            }
            $this->render('pedidos/form');
        }
        
        

        public function impressao() {
            $db = Database::getConn(true);
            $id_pedidos = isset($_POST['pedidos']) ? $_POST['pedidos'] : [];
        
            if (empty($id_pedidos)) {
                return;
            }
        
            $this->pedidos = [];
            foreach ($db->pedido()->where('id', $id_pedidos) as $pedido) {
                $this->pedidos[] = $pedido;
            }

            // Buscar categorias
            $categorias_result = $db->categoria()->order('id');
        
            $data = [];
            foreach ($categorias_result as $categoria) {
                $items_result = $db->categoria_item()
                    ->select("id")
                    ->where('id_categoria', $categoria['id'])
                    ->where('id', $db->pedido_opcao()->select("DISTINCT id_item")->where('id_pedido', $id_pedidos))
                    ->fetchPairs('id', 'id');
        
                if (!empty($items_result)) {
                    $items_data = [];
        
                    foreach ($items_result as $id_item) {
                        $item = $db->categoria_item('id', $id_item)->fetch();
                        if (!$item) continue;
        
                        $opcoes_result = $db->pedido_opcao()
                            ->where('id_item', $id_item)
                            ->where('id_pedido', $id_pedidos)
                            ->fetchPairs('id_opcao', 'id_opcao'); 
        
                        $opcoes_data = [];
                        if (!empty($opcoes_result)) {
                            $opcoes_nomes = $db->item_opcao()
                                ->where('id', array_keys($opcoes_result))
                                ->fetchPairs('id', 'opcao'); 
        
                            $opcoes_data = array_values($opcoes_nomes);
                        }
        
                        if (!empty($opcoes_data)) {
                            $items_data[] = [
                                'item' => utf8_encode($item['item']),
                                'opcoes' => $opcoes_data,
                            ];
                        }
                    }
        
                    if (!empty($items_data)) {
                        $data[] = [
                            'categoria' => utf8_encode($categoria['categoria']),
                            'descricao' => utf8_encode($categoria['descricao']),
                            'items' => $items_data,
                        ];
                    }
                }
            }
        
            $this->data = $data;
            $this->render('pedidos/impressao');
        }
        
        
        

        /**
         * Salva um Pedido
         */
        public function salvar() {
            $db = Database::getConn();
            
            $pedido = [
                'nome' => utf8_decode($_POST['nome']),
                'email' => utf8_decode($_POST['Email']),
                'telefone' => utf8_decode($_POST['Telefone']),
                'data_cirurgia' => $_POST['data'],
                'alergia' => utf8_decode($_POST['alergia'])
            ];
        
            $pedidoId = $db->pedido()->insert($pedido);
        
            if (!empty($_POST['opcoes'])) {
                foreach ($_POST['opcoes'] as $opcao) {
                    list($id_categoria, $id_item, $opcaoValor) = explode('|', $opcao);
        
                    $pedido_opcao = [
                        'id_pedido' => $pedidoId,
                        'id_categoria' => $id_categoria,
                        'id_item' => $id_item,
                        'id_opcao' => utf8_decode($opcaoValor),
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