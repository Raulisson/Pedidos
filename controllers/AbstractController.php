<?php

    abstract class AbstractController {

        /**
         * Carrega a camada de visão
         */
        public function render($page) {
            $this->page = $page;
            require_once('views/layout.php');
        }
    }
?>