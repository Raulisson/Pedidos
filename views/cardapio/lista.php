<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Cardápios</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
                <a href="index.php?controle=cardapio&acao=formcardapio" class="btn btn-primary ml-auto">
                    Adicionar cardápio
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="white-box">
                <?php foreach ($this->cardapios as $cardapio): ?>
                    <h3 class="text-uppercase">CARDÁPIO: <?php echo utf8_encode($cardapio['nome']); ?></h3>
                    <p>Descrição: <?php echo utf8_encode($cardapio['descricao']); ?></p>

                    <a class="btn btn-sm btn-rounded btn-danger text-white" href="javascript:remove(<?php echo $cardapio['id']; ?>)">
                        <i class="ti-trash"></i>
                    </a>
                    <a class="btn btn-sm btn-rounded btn-primary text-white" href="index.php?controle=cardapio&acao=formcardapio&id=<?php echo $cardapio['id']; ?>">
                        <i class="ti-pencil-alt" aria-hidden="true"></i>
                    </a>

                    <a class="btn btn-sm btn-rounded btn-primary text-white" href="index.php?controle=pedidos&acao=form&id_cardapio=<?php echo $cardapio['id']; ?>" target="_blank" class="btn btn-primary">
                        Gerar Link
                    </a>
        
                    <!-- Listagem de Categorias e Itens -->
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th class="border-top-0" style="width: 300px;">Categoria</th>
                                    <th class="border-top-0">Itens e Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $categorias_usadas = [];
                                foreach ($this->cardapio_opcoes as $cardapio_opcao): 
                                    if ($cardapio_opcao['id_cardapio'] == $cardapio['id']):
                                        $id_opcao = $cardapio_opcao['id_opcao'];                                
                                        foreach ($this->opcoes as $opcao): 
                                            if ($opcao['id'] == $cardapio_opcao['id_opcao']):
                                                foreach ($this->itens as $item): 
                                                    if ($item['id'] == $opcao['id_item']):
                                                        foreach ($this->categorias as $categoria): 
                                                            if ($categoria['id'] == $item['id_categoria']):
                                                                $categorias_usadas[$categoria['id']]['nome'] = $categoria['categoria'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['nome'] = $item['item'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['opcoes'][] = $opcao['opcao'];
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                endforeach;
                                            endif;
                                        endforeach;
                                    endif;
                                endforeach;
                                ?>

                                <?php foreach ($categorias_usadas as $categoria): ?>
                                    <tr>
                                        <td><strong><?php echo utf8_encode($categoria['nome']); ?></strong></td>
                                        <td>
                                            <ul class="mb-0" style="list-style: none; padding: 0;">
                                                <?php foreach ($categoria['itens'] as $item): ?>
                                                    <li>
                                                        <strong><?php echo utf8_encode($item['nome']); ?></strong>
                                                        <ul style="list-style: none; padding-left: 20px;">
                                                            <?php foreach ($item['opcoes'] as $opcao): ?>
                                                                <li>- <?php echo utf8_encode($opcao); ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
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
        confirme("Tem certeza que deseja remover este cardápio? Isso irá remover todos os itens vinculados.", function(rs) {
            if (rs) {
                window.location = 'index.php?controle=cardapio&acao=removercardapio&id=' + id;
            }
        });
    }

</script>
