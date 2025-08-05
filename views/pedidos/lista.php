<div class="page-breadcrumb bg-white p-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title text-uppercase font-medium font-14">Pedidos Feitos</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
            </div>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="container-fluid">
    <form method="GET" action="index.php">
        <input type="hidden" name="controle" value="pedidos">
        <input type="hidden" name="acao" value="listar">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="date" name="search" class="form-control"value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Buscar Data</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="white-box">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th class="border-top-0">Id</th>
                                <th class="border-top-0">Nome do paciente</th>
                                <th class="border-top-0">Alergia?</th>
                                <th class="border-top-0">Email</th>
                                <th class="border-top-0">Telefone</th>
                                <th class="border-top-0">Data/Hora da Cirurgia</th>
                                <th class="border-top-0">Ações</th>
                                <th class="border-top-0">Status</th>
                                <th></th>
                                <th class="border-top-0" width="120"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

use Random\Engine\Secure;
                            echo '<button id="selecionarMultiplos" class="btn btn-sm btn-rounded btn-primary text-white">Selecionar Impressões</button>';
                            echo '<form id="formImprimir" action="index.php?controle=pedidos&acao=impressao" method="POST" target="_blank">';
 foreach( $this->pedidos as $pedido ): ?>
                                <tr id="tr-<?php echo $pedido['id'] ?>">
                                    
                                    <td><?php echo $pedido['id'] ?></td>
                                    <td class="func"><?php echo utf8_encode($pedido['nome']) ?></td>
                                    <td class="func"><?php echo utf8_encode($pedido['alergia']) ?></td>
                                    <td class="func"><?php echo utf8_encode($pedido['email']) ?></td>
                                    <td class="func"><?php echo utf8_encode($pedido['telefone']) ?></td>
                                    <td class="func"><?php echo date('d/m/Y H:i', strtotime($pedido['data_cirurgia'])); ?></td>
                                    <td>
                                        <div>
                                            <?php if( Security::usuario()['perfil'] == Constants::$PERFIL["ADMINISTRADOR"]["id"] ): ?>
                                                <a class="btn btn-sm btn-rounded btn-danger text-white pull-left" href="javascript:remove(<?php echo $pedido['id'] ?>)">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                        </div>
                                    </td>
                                    <td class="func">
                                        <?php if( $pedido['ativo'] == '1' ): ?>
                                            <a class="" title="Confirmar presença" href="javascript:checkin(<?php echo $pedido['id'] ?>, <?php echo $pedido['ativo']; ?>);">
                                                <i class=""><span class="badge bg-success text-white">Ativo</span></i>
                                            </a>
                                        <?php else: ?>
                                            <a class="" title="Confirmar presença" href="javascript:checkin(<?php echo $pedido['id'] ?>, <?php echo $pedido['ativo']; ?>);">
                                                <i class=""><span class="badge bg-secondary text-white">Inativo</span></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="checkbox-container" style="display: none;">
                                        <input type="checkbox" class="custom-checkbox" name="pedidos[]" value="<?php echo $pedido['id'] ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>                
                        </tbody>
                        <?php
                        echo '</br></br><button type="submit" id="btnImprimir" class="btn btn-sm btn-rounded btn-secondary text-white" style="display: none;">Imprimir Selecionados</button>';
                        echo '</form>';
                        ?>
                    </table>
                </div>
                <!-- Pagination -->
                <?php $this->pagination->show() ?>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('selecionarMultiplos').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.checkbox-container');
        let btnImprimir = document.getElementById('btnImprimir');

        // Verifica se as checkboxes estão visíveis
        let isVisible = checkboxes[0].style.display === 'table-cell';

        checkboxes.forEach(el => el.style.display = isVisible ? 'none' : 'table-cell');
        btnImprimir.style.display = isVisible ? 'none' : 'block';
    });
    function remove(id) {
        confirme("Tem certeza que desejar remover esse registro?", function(rs) {
            if( rs ) {
                window.location = 'index.php?controle=pedidos&acao=remover&id='+id;
            }
        });
    }

    function checkin(id, ativo) {
        if(ativo == 1){
            confirme("Deseja inativar o pedido?", function(rs) {
                if( rs ) {
                    window.location = 'index.php?controle=pedidos&acao=inativar&id='+id;
                }
            });
            return false;
        }else if(ativo == 0){
            confirme("Deseja ativar o pedido?", function(rs) {
                if( rs ) {
                    window.location = 'index.php?controle=pedidos&acao=ativar&id='+id;
                }
            });
            return false;
        } else{
            alert("Erro! Tente novamente");
            location.reload();
        }
    }
    
</script>

<style>
    .custom-checkbox {
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

    .custom-checkbox:checked {
        background-color: #007bff;
        border: 2px solid #007bff;
    }

    .custom-checkbox:checked::after {
        content: '\2713';
        font-size: 14px;
        color: white;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .custom-checkbox:hover {
        border-color: #0056b3;
    }
</style>