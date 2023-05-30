<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

?>

<div class="container-fluid pt-4">

    <div class="row">
        <div class="col-12">

            <form method="POST" id="form-busca-produto">
                <div class="modal-body">

                    <?php

                    if (@$_GET['funcao'] == "get") {
                        $query = $pdo->query("SELECT * FROM produtos WHERE id = '$_GET[id]'");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                        $total_reg = @count($res);
                        if ($total_reg > 0) {

                            $id_busca = $res[0]['id'];
                            $nome_busca = $res[0]['nome'];
                            $apresentacao_busca = $res[0]['apresentacao'];
                        }
                    }

                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Produto</label>
                                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" id="nome_busca" name="nome_busca" value="<?php echo @$nome_busca ?>" disabled="disabled">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Apresentação</label>
                                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm  text-uppercase" style="border: 1px solid #ccc;" id="apresentacao_busca" name="apresentacao_busca" value="<?php echo @$apresentacao_busca ?>" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">
                                <label class="form-label">Qntd.</label>
                                <input type="number" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="quantidade_busca" name="quantidade_busca" required>

                                <input name="id_busca" type="hidden" value="<?php echo @$id_busca ?>">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">
                                <br>
                                <a href="index.php?pagina=<?php echo $pagina ?>&funcao=buscar" type="button" class="btn btn-primary btn-sm mb-0 mt-2">Buscar</a>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">
                                <br>
                                <button id="check" name="check" type="submit" class="btn btn-info btn-sm mb-0 mt-2">Check</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
                        <h6 class="text-white ps-3">Balanço por Itens</h6>
                        <a href="index.php?pagina=<?php echo $pagina ?>&funcao=finalizar" type="button" class="btn btn-outline-light btn-sm mb-0">Confrontar</a>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">

                        <?php

                        //PUXAR DADOS DO BANCO
                        $query = $pdo->query("SELECT * FROM itens_balanco ORDER BY id DESC");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                        $total_reg = @count($res);
                        if ($total_reg > 0) {


                        ?>

                            <table id="table" class="table table-hover align-items-center mb-0">

                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nome</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Apresentação</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qntd. Antiga</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qntd. Conferida</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    for ($i = 0; $i < $total_reg; $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }

                                        $id_produto = $res[$i]['id_produto'];
                                        $qntd_conferida = $res[$i]['qntd_conferida'];
                                        
                                        $query_p = $pdo->query("SELECT * from produtos where id = $id_produto");
                                        $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);

                                        $codigo_produto = $res_p[0]['codigo'];
                                        $nome_produto = $res_p[0]['nome'];
                                        $apresentacao = $res_p[0]['apresentacao'];
                                        $qntd_antiga = $res_p[0]['quantidade'];
                                      
                                    ?>

                                        <tr>


                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $codigo_produto ?></p>
                                            </td>

                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $nome_produto ?></p>
                                            </td>

                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $apresentacao ?></p>
                                            </td>

                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0"><?php echo $qntd_antiga ?></p>
                                            </td>


                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $qntd_conferida ?></p>
                                            </td>


                                            <td>


                                                <a href="index.php?pagina=<?php echo $pagina ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Alterar Custo / Quantidade"><i class="fas fa-edit"></i></a>

                                                <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Deletar Item"><i class="fas fa-trash-alt mx-3"></i></a>


                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>

                        <?php } else {
                            echo '<p class="mx-4" >Nenhum produto conferido!</p>';
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

if (@$_GET['funcao'] == "editar") {

    $query = $pdo->query("SELECT * from itens_balanco where id = '$_GET[id]'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {

        $titulo_modal = $res[0]['nome'];
        $custo = $res[0]['custo'];
        $qntd = $res[0]['qntd_conferida'];
    }
}

?>



<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
                <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="form-editar">
                <div class="modal-body">

                    <div class="row">


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Quantidade</label>
                                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="quantidade" name="quantidade" value="<?php echo @$qntd ?>" required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Confirmar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="form-excluir">
                <div class="modal-body">

                    <p>Deseja excluir o item dessa conferência?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input type="hidden" name="id" value="<?php echo @$_GET['id'] ?>">

                </div>
            </form>

        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modalFinalizar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confrontar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="form-finalizar">
                <div class="modal-body">

                    <p>Confirma a alteração de estoque desses produtos?</p>

                    

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-finalizar" id="btn-finalizar" type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="buscarProduto" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Produto</h5>
                <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body min-height-400 max-height-400" style="overflow: scroll;">

                <div class="w-100">
                    <input type="text" class="w-100 border-radius-lg px-2" style="border: 1px solid #ccc;" name="busca" id="busca" autofocus>
                </div>

                <table id="table" class="table align-items-center mt-3 table-striped table-hover">

                    <thead>
                        <tr>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;"></th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Código</th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Nome</th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Apresentação</th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Estoque</th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Categoria</th>
                            <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Fabricante</th>
                        </tr>
                    </thead>

                    <tbody id="result"></tbody>

                </table>

            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        document.getElementById('quantidade_busca').value = '1';
    })
</script>


<!-- ABRIR MODAL BUSCAR PRODUTO -->
<?php
if (@$_GET['funcao'] == "buscar") {  ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('buscarProduto'), {
            backdrop: 'static'
        });
        myModal.show();
    </script>
<?php } ?>


<!-- ABRIR MODAL CADASTRAR -->
<?php
if (@$_GET['funcao'] == "finalizar") {  ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalFinalizar'), {
            backdrop: 'static'
        });
        myModal.show();
    </script>
<?php } ?>


<!-- ABRIR MODAL EDITAR -->
<?php
if (@$_GET['funcao'] == "editar") {  ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        });
        myModal.show();
    </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php
if (@$_GET['funcao'] == "deletar") {  ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {
            backdrop: 'static'
        });
        myModal.show();
    </script>
<?php } ?>



<!-- EXIBIR RESULTADO DA BUSCA -->
<script type="text/javascript">
    $('#busca').keyup(function() {
        var busca = $('#busca').val();
        $.post('buscar-produto-balanco.php', {
            busca: busca
        }, function(data) {
            $('#result').html(data);
        });
    });
</script>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form-busca-produto").submit(function() {
        var pag = "<?= $pagina ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                if (mensagem.trim() == "Check") {

                    window.location = "index.php?pagina=" + pag;

                } else {

                    $.notify(mensagem, "error");

                }
            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form-editar").submit(function() {
        var pag = "<?= $pagina ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/editar.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $.notify(mensagem, "error");

                }
            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>



<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
    $("#form-excluir").submit(function() {
        var pag = "<?= $pagina ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/excluir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                if (mensagem.trim() == "Excluido com Sucesso!") {

                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $.notify(mensagem, "error");

                }
            },

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form-finalizar").submit(function() {
        var pag = "<?= $pagina ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/finalizar.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $.notify(mensagem, "error");

                }
            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>