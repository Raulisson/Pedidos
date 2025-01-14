<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Usuários</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
            <a href="index.php?controle=usuario&acao=form" class="btn btn-primary ml-auto">
                Adicionar
            </a>
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="white-box">
                <div class="table-responsive">

                <?php Constants::get('PERFIL', 1) ?>

                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th class="border-top-0">Id</th>
                                <th class="border-top-0">Nome</th>
                                <th class="border-top-0">Usuário</th>
                                <th class="border-top-0">Perfil</th>
                                <th class="border-top-0" width="90"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $this->usuarios as $usuario ): ?>
                                <tr>
                                    <td><?php echo $usuario['id'] ?></td>
                                    <td><?php echo utf8_encode($usuario['nome']) ?></td>
                                    <td><?php echo utf8_encode($usuario['usuario']) ?></td>
                                    <td><?php echo Constants::get('PERFIL', $usuario['perfil']) ?></td>
                                    <td>
                                        <div>
                                            <a class="btn btn-sm btn-rounded btn-primary text-white" href="index.php?controle=usuario&acao=form&id=<?php echo $usuario['id'] ?>">
                                                <i class="ti-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-sm btn-rounded btn-danger text-white pull-left" href="javascript:remove(<?php echo $usuario['id'] ?>)">
                                                <i class="ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function remove(id) {
        confirme("Tem certeza que desejar remover esse registro?", function(rs) {
            if( rs ) {
                window.location = 'index.php?controle=usuario&acao=remover&id='+id;
            }
        });
    }
</script>