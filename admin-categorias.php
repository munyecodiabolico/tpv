<?php

	require_once 'app/Controllers/ProductCategoryController.php';

	use app\Controllers\ProductCategoryController;

	$categoria = new ProductCategoryController();
	$categorias = $categoria->index();

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
                <h1 class="text-center mt-3 border cabecera"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>CATEGORÍAS</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir Categoría</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($categorias as $categoria): ?>
                                        <tr class="table-element" data-element="<?= $categoria['id'] ?>">
                                            <td>
                                                <div class="square w-25 m-auto">
                                                    <div class="content">
                                                        <img class="img-cover imagen_url" src="<?= $categoria['imagen_url'] ?>" alt="">
                                                    </div>    
                                                </div>    
                                            </td>    
                                            <td scope="row" class="nombre">
                                                <?= $categoria['nombre'] ?>
                                            </td>
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $categoria['id'] ?>" data-route="showProductCategory" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $categoria['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr class="create-layout table-element d-none" data-element="">
                                        <td><img class="imagen_url" src=""></td>
                                        <th scope="row" class="nombre"></th>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showProductCategory" data-bs-target="#addArticle">
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
                    <h5 class="modal-title" id="addArticleLabel">AÑADIR CATEGORÍA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--El campo data-route="storeProductCategory" es un caso de los que hay en web.php-->
                    <form class="admin-form" data-route="storeProductCategory">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="imagen_url" class="form-label">Imagen producto</label>
                            <input type="file" class="form-control" name="imagen_url" value="">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Categoría</label>
                            <input type="text" class="form-control" name="nombre" value="">
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
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR CATEGORÍA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar una categoría. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteProductCategory">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>