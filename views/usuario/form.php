<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Usuários</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=usuario&acao=salvar">

                        <!-- Id -->
                        <input type="hidden" name="id" value="<?php if( isset($this->usuario) ) echo $this->usuario['id'] ?>"/>

                        <div class="row">

                            <!-- Nome -->
                            <div class="col-md-6">
                                <div class="form-group mb-6">
                                    <label class="col-md-12 p-0">Nome</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" name="nome" placeholder="Nome" class="form-control p-0 border-0" required
                                            value="<?php if( isset($this->usuario) ) echo utf8_encode($this->usuario['nome']) ?>"> 
                                    </div>
                                </div>
                            </div>

                            <!-- Perfil -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Perfil</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <select name="perfil" class="form-control p-0 border-0" >
                                            <?php foreach( Constants::$PERFIL as $perfil ): ?>
                                                <?php $selected = (isset($this->usuario) && $perfil['id'] == $this->usuario['perfil']) ? 'SELECTED' : ''; ?>
                                                <option value="<?php echo $perfil['id'] ?>" <?php echo $selected; ?>><?php echo $perfil['nome'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Usuário -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Usuário</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" placeholder="Usuário" class="form-control p-0 border-0" name="usuario" required
                                            value="<?php if( isset($this->usuario) ) echo utf8_encode($this->usuario['usuario']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Senha -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Senha</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="password" name="senha" value="" class="form-control p-0 border-0" placeholder="<?php if( isset($this->usuario) ) echo "(Sem alteração)" ?>">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Sumit -->
                        <div class="form-group">
                            <div class="col-sm-12 p-0">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <button onclick="history.go(-1)" class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var PERFIL_MEDICO = <?php echo Constants::$PERFIL['MEDICO']['id']; ?>;

    $('[name=perfil]').on('change', function() {
        if( $(this).val() == PERFIL_MEDICO ) {
            $('#dv-consultorio').show();
        } else {
            $('#dv-consultorio').hide();
        }
    });

    $(function() {
        $('[name=perfil]').trigger('change');
    });

</script>