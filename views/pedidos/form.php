<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Cardápio Hospital Dia</h4>
        </div>
        
    </div>
    <div class="row align-items-center">
        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
            <div class="d-md-flex">
                <p>Estamos aqui para garantir que sua experiência seja única e inesquecível. Preparamos um cardápio especial para você. Sinta-se à vontade para escolher os itens de sua preferência, seguindo as instruções de cada categoria.

    O café da manhã será servido para você e seu acompanhante, enquanto as demais refeições devem ser solicitadas separadamente para o acompanhante. Para facilitar, pedimos que você nos retorne com pelo menos 72 horas de antecedência antes da internação.

    Agradecemos pela sua colaboração e estamos à disposição para qualquer dúvida!</p>
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
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=pedidos&acao=salvar">

                        <!-- Id -->
                        <input type="hidden" name="id" value="<?php if( isset($this->agendamento) ) echo $this->agendamento['id'] ?>"/>

                        <!-- Nome Completo -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Nome Completo</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="nome" placeholder="Nome" class="form-control p-0 border-0" required> 
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Email</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="Email" placeholder="Email" class="form-control p-0 border-0" required
                                value=""> 
                            </div>
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Telefone</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="Telefone" placeholder="Telefone" class="form-control p-0 border-0" required
                                value=""> 
                            </div>
                        </div>

                        <!-- Data da Cirurgia -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Data da Cirurgia</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="datetime-local" name="data" placeholder="Data da Cirurgia" class="form-control p-0 border-0" required
                                value=""> 
                            </div>
                        </div>

                        <!-- Alergia -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Tem alguma alergia ou intolerância alimentar? Descreva:</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="alergia" placeholder="Tem alguma alergia ou intolerância alimentar? Descreva" class="form-control p-0 border-0" required
                                value=""> 
                            </div>
                        </div>

                        <?php foreach($this->categorias as $categoria): ?>
                            <!-- Categoria -->
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0"><?php echo utf8_encode($categoria['categoria']) ?> - <?php echo utf8_encode($categoria['descricao']) ?></label>
                            </div>

                            <?php foreach($this->categorias_items as $categoria_item): ?>
                                <!-- Item/Opção -->
                                <div class="form-group mb-4">
                                <?php if($categoria_item['id_categoria'] == $categoria['id']): ?>
                                <label class="col-md-12 p-0"><?php echo utf8_encode($categoria_item['item']) ?></label>
                                    <div class="col-md-12 border-bottom p-0" data-min="<?php echo $categoria_item['min'] ?>" 
                                    data-max="<?php echo $categoria_item['max'] ?>" >
                                        <?php foreach($this->items_opcoes as $item_opcao): ?>
                                            <?php if($item_opcao['id_item'] == $categoria_item['id']): ?>
                                                <label><input type="checkbox" name="opcoes[]" value="<?php echo $categoria['id'] . '|' . $categoria_item['id'] . '|' . utf8_encode($item_opcao['opcao']); ?>"> <?php echo utf8_encode($item_opcao['opcao']) ?></label><br>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                            </br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                        <!-- Sumit -->
                        <div class="form-group">
                            <div class="col-sm-12 p-0">
                                <button onclick="submit" class="btn btn-primary">Enviar</button>
                                <!--<button onclick="history.go(-1)" class="btn btn-danger">Cancelar</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxContainers = document.querySelectorAll('.col-md-12.border-bottom.p-0');

        checkboxContainers.forEach(container => {
            const min = parseInt(container.getAttribute('data-min'));
            const max = parseInt(container.getAttribute('data-max'));

            const checkboxes = container.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;

                    // Desabilitar checkboxes
                    if (checkedCount >= max) {
                        checkboxes.forEach(cb => {
                            if (!cb.checked) {
                                cb.disabled = true;
                            }
                        });
                    } else {
                        checkboxes.forEach(cb => cb.disabled = false);
                    }
                });
            });
        });

        // Validação no envio do formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', (event) => {
            let isValid = true;

            checkboxContainers.forEach(container => {
                const min = parseInt(container.getAttribute('data-min'));
                const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;

                if (checkedCount < min) {
                    isValid = false;
                    container.insertAdjacentHTML(
                        'beforeend',
                        `<p class="text-danger">Selecione pelo menos ${min} opções.</p>`
                    );
                } else {
                    const errorMessage = container.querySelector('.text-danger');
                    if (errorMessage) errorMessage.remove();
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Por favor, corrija os erros antes de enviar o formulário.');
            }
        });
    });
</script>
