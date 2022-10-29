<?php

	require_once 'app/Controllers/EmpresaController.php';

	use app\Controllers\EmpresaController;

	$empresa = new EmpresaController();
	$empresas = $empresa->index();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Abel.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <?php include('menu.php') ?>
    
    <div class="container admins">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-3 border cabecera"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>EMPRESAS</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir Empresa</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Nombre comercial</th>
                                    <th scope="col">CIF</th>
                                    <th scope="col">domicilio</th>
                                    <th scope="col">teléfono</th>
                                    <th scope="col">correo_electronico</th>
                                    <th scope="col">web</th>
                                    <th scope="col">Opciones</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($empresas as $empresa): ?>
                                        <tr class="table-element" data-element="<?= $empresa['id'] ?>">
                                            <td scope="row" class="razon_social">
                                                <?= $empresa['razon_social'] ?>
                                            </td>
                                            <td class="nombre_comercial"><?= $empresa['nombre_comercial'] ?></td>
                                            <td class="cif"><?= $empresa['cif'] ?></td>
                                            <td class="domicilio"><?= $empresa['domicilio'] ?></td>
                                            <td class="telefono"><?= $empresa['telefono'] ?></td>
                                            <td class="correo_electronico"><?= $empresa['correo_electronico'] ?></td>
                                            <td class="web"><?= $empresa['web'] ?></td>
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $empresa['id'] ?>" data-route="showEmpresa" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $empresa['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr class="create-layout table-element d-none" data-element="">
                                        <th scope="row" class="razon_social"></th>
                                        <td class="nombre_comercial"></td>
                                        <td class="cif"></td>
                                        <td class="domicilio"></td>
                                        <td class="telefono"></td>
                                        <td class="correo_electronico"></td>
                                        <td class="web"></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showEmpresa" data-bs-target="#addArticle">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="delete-table-button btn btn-danger" data-id="" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
    <!-- Modal ADD ARTICLE-->
    <div>
        <div id="addArticle" class="modal fade" tabindex="-1" aria-labelledby="addArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleLabel">AÑADIR EMPRESA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--El campo data-route="storeEmpresa" es un caso de los que hay en web.php-->
                    <form class="admin-form" data-route="storeEmpresa">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón social</label>
                            <input type="text" class="form-control" name="razon_social" value="">
                        </div>
                        <div class="mb-3">
                            <label for="nombre_comercial" class="form-label">Nombre comercial</label>
                            <input type="text" class="form-control" name="nombre_comercial" value="">
                        </div>
                        <div class="mb-3">
                            <label for="cif" class="form-label">CIF</label>
                            <input type="text" class="form-control" name="cif" value="">
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" value="">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" value="">
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo electróncio</label>
                            <input type="text" class="form-control" name="correo_electronico" value="">
                        </div>
                        <div class="mb-3">
                            <label for="web" class="form-label">Web</label>
                            <input type="text" class="form-control" name="web" value="">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-dismiss="modal">CERRAR</button>
                            <button type="submit" class="send-form-button btn btn-primary mt-3" data-bs-dismiss="modal">CONFIRMAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal DELETE ARTICLE-->
    <div>
        <div id="deleteArticle" class="modal fade" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR EMPRESA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar una empresa. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteEmpresa">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>