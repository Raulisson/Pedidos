<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Categorias</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
            <a href="index.php?controle=categoria&acao=formCategoria" class="btn btn-primary ml-auto">
                Adicionar Categoria
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
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="d-md-flex">
                        <a href="index.php?controle=categoria&acao=form" class="btn btn-primary ml-auto">
                            Adicionar Item
                        </a>
                    </div>
                </div>
            <?php
            foreach( $this->categorias as $categoria ): ?>
                <h3 class="text-uppercase"><?php echo utf8_encode($categoria['categoria']) ?></h3>
                <p> <?php echo utf8_encode($categoria['descricao']) ?> </p>
                <a class="btn btn-sm btn-rounded btn-danger text-white pull-left" href="javascript:remove(<?php echo $categoria['id'] ?>)">
                    <i class="ti-trash"></i>
                </a>
                <a class="btn btn-sm btn-rounded btn-primary text-white" href="index.php?controle=categoria&acao=formCategoria&id=<?php echo $categoria['id'] ?>">
                    <i class="ti-pencil-alt" aria-hidden="true"></i>
                </a>
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th class="border-top-0" style="width: 500px;">Item</th>
                                <th class="border-top-0">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop para cada item da categoria
                            foreach( $this->categorias_items as $categoria_item ): ?>
                                <?php if( $categoria_item['id_categoria'] == $categoria['id'] ): ?>
                                    <tr>
                                        <td><?php echo utf8_encode($categoria_item['item']) ?>
                                        </td>
                                        <td>
                                            <ul class="mb-0">
                                                <?php
                                                // Loop para as opções do item
                                                foreach( $this->items_opcoes as $item_opcao ): ?>
                                                    <?php if( $item_opcao['id_item'] == $categoria_item['id'] ): ?>
                                                        <li><?php echo utf8_encode($item_opcao['opcao']) ?></li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?> 
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <a class="btn btn-sm btn-rounded btn-primary text-white" href="index.php?controle=categoria&acao=form&id=<?php echo $categoria_item['id'] ?>">
                                                    <i class="ti-pencil-alt" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-sm btn-rounded btn-danger text-white pull-left" href="javascript:removeItem(<?php echo $categoria_item['id'] ?>)">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?> 
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function remove(id) {
        confirme("Tem certeza que desejar remover esta categoria? Isso irá remover todos os itens vinculados", function(rs) {
            if( rs ) {
                window.location = 'index.php?controle=categoria&acao=removerCategoria&id='+id;
            }
        });
    }
    function removeItem(id) {
        confirme("Tem certeza que desejar remover esse item?", function(rs) {
            if( rs ) {
                window.location = 'index.php?controle=categoria&acao=removerItem&id='+id;
            }
        });
    }
    
</script>