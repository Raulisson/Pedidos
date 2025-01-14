<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Cardápio Hospital Dia - Paciente: <?php echo utf8_encode($this->pedidos['nome']) ?></h4>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="d-md-flex">
                Alergia: <?php echo utf8_encode($this->pedidos['alergia']) ?>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="d-md-flex">
                Data da Cirurgia: <?php echo utf8_encode($this->pedidos['data_cirurgia']) ?>
                <a onclick="imprimir()" class="btn btn-primary ml-auto">
                Imprimir
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
                <?php $id_url = isset($_GET['id']) ? $_GET['id'] : null; ?>
                <?php foreach($this->categorias as $categoria): ?>
                <div class="category" style="border-bottom: 1px solid blue; margin-bottom: 20px;">
                    <h2><?php echo utf8_encode($categoria['categoria']) ?></h2>
                    <ul>
                        <?php foreach($this->items as $item): ?>
                            <?php foreach($this->pedidos_opcoes as $opcao): ?>
                                <?php if($opcao['id_item'] == $item['id'] && $opcao['id_categoria'] == $categoria['id'] && $opcao['id_pedido'] == $id_url): ?>
                                    <li>
                                        <strong><?php echo utf8_encode($item['item']) ?>:</strong>
                                    <?php echo utf8_encode($opcao['opcao']) ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>

                
            </div>
        </div>
    </div>
</div>


<script>

    // Impressão
    function imprimir() {
                window.print();
            }
</script>