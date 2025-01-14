<?php

    class Util {

        /**
         * Redireciona a página
         */
        public static function redirect($url) {
            echo "<script>window.location='{$url}';</script>";
        }

        /**
         * Volta para a página anterior
         */
        public static function back() {
            echo "<script>history.go(-1);</script>";
        }

        /**
         * Converte a data para o padrão nacional
         */
        public static function dataBr($dt) {
            if( $dt ) {
                $params = explode('-', $dt);
                return implode('/', array_reverse($params));
            } else {
                return "";
            }
        }
        
    }

    /**
     * Paginação das grids
     */
    class Pagination {

        public $tableName;
        public $limit   = 20;
        public $total   = 0;
        public $pages   = 0;
        public $filters = array();
        public $order   = '';
        public $rows;

        // Construtor
        function Pagination($tableName, $order = null, $filters = array()) {
            $this->tableName    = $tableName;
            $this->filters      = $filters;
            $this->order        = ( !$order ) ? "{$tableName}.id DESC" : $order;
            if( isset($_GET['limite']) ) {
                $this->limit = $_GET['limite'];
            }
            $this->load();
        }

        // Carrega os registros
        function load() {
            $db = Database::getConn(true);
            $this->total = $db->{$this->tableName}()->where($this->filters)->count();
            $this->pages = ceil($this->total / $this->limit);
            $offset = ( isset($_GET['pagina']) ) ? ( $_GET['pagina'] - 1 ) * $this->limit : 0;

            // Carrega os registros
            $this->rows =  $db->{$this->tableName}()
                ->order($this->order)
                ->limit($this->limit, $offset);

            // Filtros
            if( count($this->filters) ) {
                $this->rows->where($this->filters);
            }
        }

        // Exibe a paginação
        function show() {
            $_GET['pagina'] = ( isset($_GET['pagina']) ) ? $_GET['pagina'] : 1;
            $params = $_GET;

            // Anterior
            $pagAnterior = ( $_GET['pagina'] > 1 ) ? $_GET['pagina'] - 1 : 1;
            $params['pagina'] = $pagAnterior;
            $link = http_build_query($params);
            $liPages = "
                <li class='paginate_button page-item previous'><a href='?{$link}' class='page-link'>Anterior</a></li>
            ";

            // Limites de Páginas
            $paginas = array();
            $pAnt = 0;
            $pPos = 0;
            for( $i = 1; $i <= $this->pages; $i++ ) {
                $paginas[] = $i;
                if( $i < $_GET['pagina'] ) {
                    $pAnt ++;
                    if( $pAnt > 3 ) {
                        array_shift($paginas);   
                    }
                } else {
                    $pPos ++;
                    if( $pPos > 5 ) {
                        break;
                    }   
                }
            }

            // Páginas
            foreach( $paginas as $i ) {
                $active = ( isset($_GET['pagina']) && $_GET['pagina'] == $i ) ? 'active' : '';
                $params['pagina'] = $i;
                $link = http_build_query($params);
                $liPages .= "<li class='paginate_button page-item {$active}'><a href='?{$link}' class='page-link'>{$i}</a></li>";
            }

            // Próxima
            $pagProx = ( $_GET['pagina'] < $this->pages ) ? $_GET['pagina'] + 1 : $_GET['pagina'];  
            $params['pagina'] = $pagProx;
            $link = http_build_query($params);
            $liPages .= "
                <li class='paginate_button page-item previous'><a href='?{$link}' class='page-link'>Próxima</a></li>
            ";

            // Html
            $init = ($_GET['pagina'] - 1) * $this->limit + 1;
            $end = ( $_GET['pagina'] * $this->limit );
            if( $_GET['pagina'] == $this->pages ) {
                $end = $this->total;
            }
            $params['limite'] = '99999';
            $params['pagina'] = '1';
            $link = http_build_query($params);
            echo "
                <div class='row mt-4'>
                    <div class='col-md-4'>
                        <div>Exibindo {$init} à {$end} (Total de <a href='?{$link}'>{$this->total}</a>)</div>
                    </div>
                    <div class='col-md-8'>
                        <div class='d-flex'>
                            <ul class='pagination ml-auto'>{$liPages}</ul>
                        </div>
                    </div>
                </div>
            ";
        }
    }

?>