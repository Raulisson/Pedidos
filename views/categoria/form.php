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
                    <form class="form-horizontal form-material" method="post" action="index.php?controle=categoria&acao=salvar">

                        <!-- Id -->
                        <input type="hidden" name="id" value="<?php if( isset($this->categorias_items_categoria) && $this->categorias_items_categoria != '' ) echo $this->categorias_items_categoria['id'] ?>"/>
        
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0">Categoria</label>
                            <div class="col-md-12 border-bottom p-0">
                                <select name="nome" class="form-control p-0 border-0 select2"  required>
                                <option value="">[Selecione]</option>
                                <?php
                                foreach ($this->categorias as $categoria_option): ?>
                                    <option value="<?php echo $categoria_option['id']; ?>" <?php echo $categoria_option['id'] == $this->categorias_items_categoria['id_categoria'] ? 'selected' : ''; ?>>
                                        <?php echo utf8_encode($categoria_option['categoria']); ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                        <label class="col-md-12 p-0"></label>
                        <div class="col-md-12 border-bottom p-0">
                            <div id="items-container">
                                <?php if( isset($this->categorias_items) ): ?>
                                    <?php foreach($this->categorias_items as $index => $categoria_item): ?>
                                        <div class="item-group" data-index="<?php echo $index; ?>">
                                            <label>Item:</label>
                                            <input type="text" name="items[<?php echo $index; ?>]" class="item-name form-control p-2 border-0" value="<?php echo utf8_encode($categoria_item['item']); ?>" required>
                                            
                                            <label>Mínimo:</label>
                                            <input type="number" name="min[<?php echo $index; ?>]" class="form-control p-2 border-0" placeholder="Valor mínimo" value="<?php echo $categoria_item['min']; ?>" required>

                                            <label>Máximo:</label>
                                            <input type="number" name="max[<?php echo $index; ?>]" class="form-control p-2 border-0" placeholder="Valor máximo" value="<?php echo $categoria_item['max']; ?>" required>
                                            
                                            <button type="button" class="btn btn-primary" onclick="addOption(this, <?php echo $index; ?>)">Adicionar Opção</button>
                                            <div class="options-container" data-index="<?php echo $index; ?>">
                                                <?php
                                                if (isset($this->items_opcoes)) {
                                                    foreach($this->items_opcoes as $item_opcao) {
                                                        if ($item_opcao['id_item'] == $categoria_item['id']) {
                                                            echo '<div class="option-group col-lg-9 col-sm-8 col-md-12 col-xs-12">';
                                                            echo '<br><label>Opção:</label>';
                                                            echo '<input type="text" name="options[' . $index . '][]" class="option-name form-control p-2 border-0" value="' . utf8_encode($item_opcao['opcao']) . '" required>';
                                                            echo '<button type="button" class="btn btn-danger" onclick="removeOption(this)">Remover Opção</button>';
                                                            echo '<br><br>';
                                                            echo '</div>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if( !isset($this->categorias_items_categoria)): ?>
                                <button type="button" class="btn btn-primary" onclick="addItem()">Adicionar Item</button>
                            <?php endif; ?>
                            <br><br>
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
        function addItem() {
    const container = document.getElementById("items-container");

    // Define o índice do item
    const itemIndex = container.children.length;

    // Cria o elemento do item
    const itemDiv = document.createElement("div");
    itemDiv.className = "item-group";
    itemDiv.innerHTML = `
        <label>Item:</label>
        <input type="text" name="items[${itemIndex}]" class="item-name form-control p-2 border-0" placeholder="Nome do item (Ex: Bebidas)" required>
        <label>Mínimo:</label>
        <input type="number" name="min[${itemIndex}]" class="form-control p-2 border-0" placeholder="Valor mínimo" required>
        <label>Máximo:</label>
        <input type="number" name="max[${itemIndex}]" class="form-control p-2 border-0" placeholder="Valor máximo" required>
        <button type="button" class="btn btn-primary" onclick="addOption(this, ${itemIndex})">Adicionar Opção</button>
        <div class="options-container" data-index="${itemIndex}"></div>
        <hr>
    `;
    container.appendChild(itemDiv);

    const addButton = document.querySelector("button[onclick='addItem()']");
    if (addButton) {
        addButton.style.display = "none";
    }

}

function addOption(button, itemIndex) {
    const optionsContainer = document.querySelector(`.options-container[data-index='${itemIndex}']`);

    // Cria o elemento da opção
    const optionDiv = document.createElement("div");
    optionDiv.className = "option-group col-lg-9 col-sm-8 col-md-12 col-xs-12";
    optionDiv.innerHTML = `
        <br><label>Opção:</label>
        <input type="text" name="options[${itemIndex}][]" class="option-name form-control p-2 border-0" placeholder="Nome da opção (Ex: Suco de Maracujá)" required>
        <button type="button" class="btn btn-danger" onclick="removeOption(this)">Remover Opção</button>
        <br><br>
    `;
    optionsContainer.appendChild(optionDiv);
}

function removeOption(button) {
    button.parentElement.remove();
}
function debugFormData() {
    const formData = new FormData(document.querySelector('form'));
    for (const [key, value] of formData.entries()) {
        console.log(key, value);
    }
}
document.querySelector('form').addEventListener('submit', debugFormData);

    </script>