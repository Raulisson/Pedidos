<?php

    // Tipos de mídias
    DEFINE('TIPO_MIDIA_ARQUIVO',   1);
    DEFINE('TIPO_MIDIA_YOUTUBE',   2);

    class Constants {

        // Perfil de usuário
        public static $PERFIL = array(
            'ADMINISTRADOR'=>array('id'=>'1','nome'=>'Administrador'),
            'COLABORADOR'=>array('id'=>'2','nome'=>'Colaborador')
        );

        // Recupera o texto da constante
        public static function get($key, $id) {
            $list = self::$$key;
            foreach( $list as $item ) {
                if( $item['id'] == $id ) {
                    return $item['nome'];
                }
            }
        }

        public static $TIPO_MIDIA_LISTA = array(
            TIPO_MIDIA_ARQUIVO => "Arquivo (.jpg, .mp4)"
        );
    }

?>