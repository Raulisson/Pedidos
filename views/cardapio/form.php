<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Cardapios</h4>
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
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=cardapio&acao=salvarcardapio">
                        <!-- Id -->
                        <input type="hidden" name="id" value="<?php if (isset($this->cardapio)) echo $this->cardapio['id']; ?>"/>

                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Nome do Cardápio</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="cardapio" placeholder="Nome do cardápio" class="form-control p-0 border-0" required
                                       value="<?php if (isset($this->cardapio)) echo utf8_encode($this->cardapio['nome']); ?>">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Descrição</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="text" name="descricao" placeholder="Descrição do cardápio" class="form-control p-0 border-0" required
                                       value="<?php if (isset($this->cardapio)) echo utf8_encode($this->cardapio['descricao']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 p-0">Selecione os alimentos, dentro de cada categoria, desejados no cardápio:</label>
                            <div class="col-md-12 border-bottom p-0">
                                <?php foreach ($this->categorias as $categoria): ?>
                                    <h4>
                                        <input type="checkbox" class="categoria-checkbox" data-categoria="<?php echo $categoria['id']; ?>">
                                        <?php echo utf8_encode($categoria['categoria']); ?>
                                    </h4>
                                    <p><?php echo utf8_encode($categoria['descricao']); ?></p>
                                    <ul>
                                        <?php foreach ($this->itens as $item): ?>
                                            <?php if ($item['id_categoria'] == $categoria['id']): ?>
                                                <li>
                                                    <input type="checkbox" class="item-checkbox" data-item="<?php echo $item['id']; ?>" data-categoria="<?php echo $categoria['id']; ?>">
                                                    <?php echo utf8_encode($item['item']); ?>
                                                    <ul>
                                                        <?php foreach ($this->opcoes as $opcao): ?>
                                                            <?php if ($opcao['id_item'] == $item['id']): ?>
                                                                <li>
                                                                    <input type="checkbox" class="opcao-checkbox" name="opcoes[]" value="<?php echo $opcao['id']; ?>"
                                                                        data-item="<?php echo $item['id']; ?>" data-categoria="<?php echo $categoria['id']; ?>"
                                                                        <?php echo isset($this->cardapio_opcoes[$opcao['id']]) ? 'checked' : ''; ?>>
                                                                    <?php echo utf8_encode($opcao['opcao']); ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endforeach; ?>
                            </div>
                        </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Seleção por Categoria
        document.querySelectorAll(".categoria-checkbox").forEach(categoriaCheckbox => {
            categoriaCheckbox.addEventListener("change", function() {
                let categoriaId = this.getAttribute("data-categoria");
                let checked = this.checked;
                document.querySelectorAll(`.item-checkbox[data-categoria="${categoriaId}"], .opcao-checkbox[data-categoria="${categoriaId}"]`).forEach(checkbox => {
                    checkbox.checked = checked;
                });
            });
        });

        // Seleção por Item
        document.querySelectorAll(".item-checkbox").forEach(itemCheckbox => {
            itemCheckbox.addEventListener("change", function() {
                let itemId = this.getAttribute("data-item");
                let checked = this.checked;

                
                document.querySelectorAll(`.opcao-checkbox[data-item="${itemId}"]`).forEach(checkbox => {
                    checkbox.checked = checked;
                });

                
                if (checked) {
                    let categoriaId = this.getAttribute("data-categoria");
                    document.querySelector(`.categoria-checkbox[data-categoria="${categoriaId}"]`).checked = true;
                }
            });
        });

        
        document.querySelectorAll(".opcao-checkbox").forEach(opcaoCheckbox => {
            opcaoCheckbox.addEventListener("change", function() {
                let itemId = this.getAttribute("data-item");
                let categoriaId = this.getAttribute("data-categoria");

                if (!this.checked) {
                    // Se alguma opção for desmarcada, o item não pode estar marcado
                    document.querySelector(`.item-checkbox[data-item="${itemId}"]`).checked = false;
                    
                    // Se nenhuma opção do item estiver marcada, desmarcar a categoria
                    if (!document.querySelector(`.opcao-checkbox[data-item="${itemId}"]:checked`)) {
                        document.querySelector(`.categoria-checkbox[data-categoria="${categoriaId}"]`).checked = false;
                    }
                }
            });
        });
    });
</script>

<style>
    .opcao-checkbox{
        width: 18px;
        height: 18px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #007bff;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: white;
        transition: all 0.2s ease-in-out;
    }

    .opcao-checkbox:checked {
        background-color: #007bff;
        border: 2px solid #007bff;
    }

    .opcao-checkbox:checked::after {
        content: '\2713';
        font-size: 14px;
        color: white;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .opcao-checkbox:hover {
        border-color: #0056b3;
    }


    .item-checkbox{
        width: 18px;
        height: 18px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #007bff;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: white;
        transition: all 0.2s ease-in-out;
    }

    .item-checkbox:checked {
        background-color: #007bff;
        border: 2px solid #007bff;
    }

    .item-checkbox:checked::after {
        content: '\2713';
        font-size: 14px;
        color: white;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .item-checkbox:hover {
        border-color: #0056b3;
    }

    .categoria-checkbox{
        width: 18px;
        height: 18px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #007bff;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: white;
        transition: all 0.2s ease-in-out;
    }

    .categoria-checkbox:checked {
        background-color: #007bff;
        border: 2px solid #007bff;
    }

    .categoria-checkbox:checked::after {
        content: '\2713';
        font-size: 14px;
        color: white;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .categoria-checkbox:hover {
        border-color: #0056b3;
    }
</style>