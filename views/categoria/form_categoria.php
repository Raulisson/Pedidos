<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Categorias</h4>
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
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=categoria&acao=salvarCategoria">

                        <!-- Id -->
                        <input type="hidden" name="id" value="<?php if( isset($this->categoria) ) echo $this->categoria['id'] ?>"/>
        
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Categoria</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="categoria" placeholder="Nome da Categoria" class="form-control p-0 border-0" required
                                    value="<?php if( isset($this->categoria) ) echo utf8_encode($this->categoria['categoria']) ?>"> 
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Descrição</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="descricao" placeholder="Descrição da Categoria" class="form-control p-0 border-0" required
                                    value="<?php if( isset($this->categoria) ) echo utf8_encode($this->categoria['descricao']) ?>"> 
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

</script>