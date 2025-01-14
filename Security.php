<?php

    class Security {

        // Ações públicas
        private static $public = array(
            'usuario' => array('entrar', 'sair'),
            'pedidos' => array('form', 'salvar'),
        );

        // Permissões
        private static $acl = array(
            'agendamento' => array(
                //'listar'        => array(USUARIO_PERFIL_RECEPCIONISTA, USUARIO_PERFIL_MEDICO)
            ),
        );

        /**
         * Recupera o usuário da sessão
         */
        public static function usuario() {
            if( isset($_SESSION['usuario']) ) {
                return $_SESSION['usuario'];
            }
        }

        /**
         * Verifica se um usuário possui a permissão
         */
        public static function check($controle, $acao, $perfil = '') {
            if( !$perfil ) {
                $perfil = self::usuario()['perfil'];
            }

            // Permissão total para adminsitrador
            if( $perfil == USUARIO_PERFIL_ADMINISTRADOR ) {
                return true;
            }

            // Verifica se a ação é pública
            if( self::isPublic($controle, $acao) ) {
                return true;
            }

            // Checa o perfil
            if( isset(self::$acl[$controle][$acao]) ) {
                if( in_array($perfil, self::$acl[$controle][$acao]) != false ) {
                    return true;
                }
            }

            // Sem permissão
            return false;
        }

        /**
         * Verifica se a ação é pública
         */
        public static function isPublic($controle, $acao) {
            if( isset(self::$public[$controle]) && in_array($acao, self::$public[$controle]) !== false ) {
                return true;
            } else {
                return false;
            }
        }
    }
?>