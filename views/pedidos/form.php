<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=pedidos&acao=salvar">
                        <?php $id_cardapio = $this->id_cardapio; ?>
                        
                        <input type="hidden" name="id_cardapio" value="<?php echo htmlspecialchars($id_cardapio); ?>"/>

                        <!-- Campos básicos -->
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Nome Completo</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="nome" class="form-control p-0 border-0" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Email</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="email" name="Email" class="form-control p-0 border-0" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Telefone</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="Telefone" class="form-control p-0 border-0" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Data da Cirurgia</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="datetime-local" name="data" class="form-control p-0 border-0" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Alergias ou Intolerâncias</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="alergia" class="form-control p-0 border-0" required>
                            </div>
                        </div>

                        <?php if ($id_cardapio): ?>
                            <?php foreach ($this->cardapios as $cardapio): ?>
                                <?php if ($cardapio['id'] == $id_cardapio): ?>
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
                                                                $categorias_usadas[$categoria['id']]['id'] = $categoria['id'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['nome'] = $item['item'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['id'] = $item['id'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['min'] = $item['min'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['max'] = $item['max'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['opcoes'][] = $opcao['opcao'];
                                                                $categorias_usadas[$categoria['id']]['itens'][$item['id']]['opcoesId'][] = $opcao['id'];
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
                                    <div class="form-group mb-4">
                                        <label class="col-md-12 p-0"><?php echo utf8_encode($categoria['nome']); ?></label></br>
                                        <?php foreach ($categoria['itens'] as $item): ?>
                                            <label class="col-md-12 p-0"><?php echo utf8_encode($item['nome']); ?> (Selecione entre <?php echo $item['min']; ?> e <?php echo $item['max']; ?> opções)</label>
                                            <div class="form-group" data-min="<?php echo $item['min']; ?>" data-max="<?php echo $item['max']; ?>">
                                                <div class="col-md-12 border-bottom p-0">
                                                <?php foreach ($item['opcoes'] as $key => $opcao): ?>
                                                    <label class="d-block">
                                                        <input type="checkbox" name="opcoes[]" value="<?php echo $categoria['id'] . '|' . $item['id'] . '|' . $item['opcoesId'][$key]; ?>">
                                                        <?php echo htmlspecialchars($opcao); ?>
                                                    </label>
                                                <?php endforeach; ?>
                                                </div></br>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-danger">Nenhum cardápio selecionado. Retorne e escolha um cardápio válido.</p>
                    <?php endif; ?>
                        <div class="form-group">
                            <div class="col-sm-12 p-0">
                                <button type="submit" class="btn btn-primary">Enviar</button>
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
    document.querySelectorAll('[data-min][data-max]').forEach(container => {
        const min = parseInt(container.getAttribute('data-min'));
        const max = parseInt(container.getAttribute('data-max'));
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');

        // Criar elemento para mensagem de erro abaixo do grupo de checkboxes
        const errorMsg = document.createElement('p');
        errorMsg.classList.add('text-danger');
        errorMsg.style.display = 'none';
        container.insertBefore(errorMsg, container.firstChild);

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;

                if (checkedCount >= max) {
                    checkboxes.forEach(cb => { if (!cb.checked) cb.disabled = true; });
                } else {
                    checkboxes.forEach(cb => cb.disabled = false);
                }

                // Remover mensagem de erro
                if (checkedCount >= min) {
                    errorMsg.style.display = 'none';
                }
            });
        });
    });

    // Verificação antes do envio do formulário
    document.querySelector('form').addEventListener('submit', (event) => {
        let valid = true;

        document.querySelectorAll('[data-min][data-max]').forEach(container => {
            const min = parseInt(container.getAttribute('data-min'));
            const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;
            const errorMsg = container.querySelector('.text-danger');

            if (checkedCount < min) {
                valid = false;
                errorMsg.textContent = `Selecione pelo menos ${min} opção(ões).`;
                errorMsg.style.display = 'block';
            } else {
                errorMsg.style.display = 'none';
            }
        });

        if (!valid) {
            event.preventDefault();
        }
    });
});

</script>

