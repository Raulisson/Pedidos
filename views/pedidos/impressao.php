<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <h4 class="page-title text-uppercase font-medium font-14">Cardápio Hospital Dia</h4>
        </div>
    </div>
    <!-- Botão de Impressão -->
<div class="text-left mt-3">
    <button onclick="imprimir()" class="btn btn-primary">
        Imprimir
    </button>
</div>
</div>

<?php if (!empty($this->pedidos)): ?>
    <div class="container-fluid">
        <?php foreach ($this->pedidos as $pedido): ?>
            <div class="row">
                <div class="col-lg-12 col-xlg-12 col-md-12">
                    <div class="white-box" style="border-bottom: 1px solid blue; margin-bottom: 20px;">
                        <h3 class="text-primary">Paciente: <?php echo utf8_encode($pedido['nome']); ?></h3>
                        <p><strong>Alergia:</strong> <?php echo utf8_encode($pedido['alergia']); ?></p>
                        <p><strong>Data da Cirurgia:</strong> <?php echo utf8_encode($pedido['data_cirurgia']); ?></p>

                        <?php if (!empty($this->data)): ?>
                            <?php foreach ($this->data as $categoria): ?>
                                <div class="category">
                                    <h2><?php echo $categoria['categoria']; ?></h2>
                                    <ul>
                                        <?php foreach ($categoria['items'] as $item): ?>
                                            <li>
                                                <strong><?php echo $item['item']; ?>:</strong>
                                                <?php echo implode(', ', array_map('utf8_encode', $item['opcoes'])); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p><strong>Nenhum item encontrado para este pedido.</strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p><strong>Nenhum pedido foi enviado.</strong></p>
<?php endif; ?>



<script>
    // Função para impressão
    function imprimir() {
        window.print();
    }
</script>
