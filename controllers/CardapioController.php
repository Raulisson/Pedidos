<?php

    class CardapioController extends AbstractController {

        /**
         * Lista os cardapios
         */
        public function listar() {
            $db = Database::getConn(true);
        
            // Buscar todos os cardápios
            $this->cardapios = $db->cardapio()->order('id');
        
            // Buscar todas as categorias, itens e opções disponíveis
            $this->categorias = $db->categoria()->order('id');
            $this->itens = $db->categoria_item()->order('id');
            $this->opcoes = $db->item_opcao()->order('id');
        
            // Buscar todas as opções vinculadas aos cardápios
            $this->cardapio_opcoes = $db->cardapio_opcoes()->order('id');
        
            $this->render('cardapio/lista');
        }
        


        /**
         * Formulário de cardapio
         */
        public function formCardapio() {
            $db = Database::getConn();
        
            if (isset($_GET['id'])) {
                // Buscar os dados do cardápio atual
                $this->cardapio = $db->cardapio('id', $_GET['id'])->where('id', $_GET['id'])->fetch();
        
                // Buscar todas as opções vinculadas ao cardápio atual
                $this->cardapio_opcoes = $db->cardapio_opcoes('id_cardapio', $_GET['id'])->fetchPairs('id_opcao', 'id_opcao');
            } else {
                $this->cardapio_opcoes = [];
            }
        
            // Buscar todas as categorias, itens e opções disponíveis
            $this->categorias = $db->categoria()->order('id');
            $this->itens = $db->categoria_item()->order('id');
            $this->opcoes = $db->item_opcao()->order('id');
        
            $this->render('cardapio/form');
        }
        

        /**
         * Salva uma cardapio
         */
        public function salvarcardapio() {
            $db = Database::getConn();
            $cardapio = array();
            
            $cardapio['nome'] = utf8_decode($_POST['cardapio']);
            $cardapio['descricao'] = utf8_decode($_POST['descricao']);

            // Verifica se é um update ou insert
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $cardapioId = $db->cardapio()->where('id', $_POST['id'])->fetch();
                $cardapioId->update($cardapio);
            } else {
                $cardapioId = $db->cardapio()->insert($cardapio);
            }
        
            $id_cardapio = $cardapioId['id'];
        
            // Remover todas as opções antigas associadas ao cardápio
            $db->cardapio_opcoes()->where('id_cardapio', $id_cardapio)->delete();
        
            // Adicionar as novas opções selecionadas
            if (isset($_POST['opcoes']) && is_array($_POST['opcoes'])) {
                foreach ($_POST['opcoes'] as $id_opcao) {
                    $db->cardapio_opcoes()->insert([
                        'id_cardapio' => $id_cardapio,
                        'id_opcao' => $id_opcao
                    ]);
                }
            }
        
            Util::redirect('index.php?controle=cardapio&acao=listar');
        }
        
        
        


        /**
         * Remove uma cardapio
         */
        public function removercardapio() {
            if( isset($_GET['id']) ) {
                $db = Database::getConn();
                $db->cardapio('id', $_GET['id'])->delete();
                Util::redirect('index.php?controle=cardapio&acao=listar');
            }
        }

    }
?>