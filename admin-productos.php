<?php

	require_once 'app/Controllers/ProductController.php';
    require_once 'app/Controllers/ProductCategoryController.php';
    require_once 'app/Controllers/IvaController.php';

	use app\Controllers\ProductController;
    use app\Controllers\ProductCategoryController;
    use app\Controllers\IvaController;

	$producto = new ProductController();
    
    $categoria = new ProductCategoryController();
    $categorias = $categoria->index();
    
    // En el siguiente codigo revisamos si nos llega la categoria con informacion,
    // Si es asi, significa que se ha pulsado el boton de filtrar, por lo tanto,
    // filtramos los productos segun la categoria seleccionada.
    // En caso contrario, mostramos todos los productos.

    $categoria = !empty($_GET['categoria_id']) ? $_GET['categoria_id'] : null;
    $visible = !empty($_GET['visible']) ? $_GET['visible'] : null;

	if (!empty($categoria) || !empty($visible))  {
        $productos = $producto->filtrar($categoria, $visible);
    } else {
        $productos = $producto->index();
    }

    $iva = new IvaController();
    $ivas = $iva->index();

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
                <h1 class="text-center mt-3 border cabecera"><small class="small-admin">PANEL DE ADMINISTRACIÓN</small>PRODUCTOS</h1>
            </div>
            <div class="col-12 mt-5">
                <section>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <div class="excel-button export-table-to-excel me-4 mt-1" data-route="exportProductToExcel">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M21.17 3.25Q21.5 3.25 21.76 3.5 22 3.74 22 4.08V19.92Q22 20.26 21.76 20.5 21.5 20.75 21.17 20.75H7.83Q7.5 20.75 7.24 20.5 7 20.26 7 19.92V17H2.83Q2.5 17 2.24 16.76 2 16.5 2 16.17V7.83Q2 7.5 2.24 7.24 2.5 7 2.83 7H7V4.08Q7 3.74 7.24 3.5 7.5 3.25 7.83 3.25M7 13.06L8.18 15.28H9.97L8 12.06L9.93 8.89H8.22L7.13 10.9L7.09 10.96L7.06 11.03Q6.8 10.5 6.5 9.96 6.25 9.43 5.97 8.89H4.16L6.05 12.08L4 15.28H5.78M13.88 19.5V17H8.25V19.5M13.88 15.75V12.63H12V15.75M13.88 11.38V8.25H12V11.38M13.88 7V4.5H8.25V7M20.75 19.5V17H15.13V19.5M20.75 15.75V12.63H15.13V15.75M20.75 11.38V8.25H15.13V11.38M20.75 7V4.5H15.13V7Z" />
                                </svg>
                            </div>
                            <button type="button" class="filter-form-button btn btn-primary mb-2 me-2" data-bs-toggle="modal" data-bs-target="#filterArticle">Filtrar</button>

                            <button type="button" class="create-form-button btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addArticle">+ Añadir producto</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">IVA</th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach($productos as $producto): ?>
                                        <tr class="table-element" data-element="<?= $producto['id'] ?>">
                                            <td>
                                                <div class="square w-50 m-auto">
                                                    <div class="content">
                                                        <img class="img-cover imagen_url" src="<?= $producto['imagen_url'] ?>" alt="">
                                                    </div>    
                                                </div> 
                                            </td>
                                            <td class="nombre">
                                                <?= $producto['nombre'] ?>
                                            </td>
                                            <td class="categoria">
                                                <?= $producto['categoria'] ?>
                                            </td>
                                            <td class="precio">
                                                <?= $producto['precio'] ?>
                                            </td>
                                            <td class="iva">
                                                <?= $producto['iva'] ?>
                                            </td>
                                            <td class="visible">
                                                <?= $producto['visible'] ?>
                                            </td>
                                            <td class="opciones">
                                                <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="<?= $producto['id'] ?>" data-route="showProducto" data-bs-target="#addArticle">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="delete-table-button btn btn-danger" data-id="<?= $producto['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr class="create-layout table-element d-none" data-element="">
                                        <td>
                                            <div class="square w-50 m-auto">
                                                <div class="content">
                                                    <img class="img-cover imagen_url" src="" alt="">
                                                </div>    
                                            </div>     
                                        </td>
                                        <td class="nombre"></td>
                                        <td class="categoria"></td>
                                        <td class="precio"></td>
                                        <td class="iva"></td>
                                        <td class="visible"></td>
                                        <td class="opciones">
                                            <button type="button" class="edit-table-button btn btn-success" data-bs-toggle="modal" data-id="" data-route="showProducto" data-bs-target="#addArticle">
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
                    <h5 class="modal-title" id="addArticleLabel">AÑADIR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--El campo data-route="storeProducto" es un caso de los que hay en web.php-->
                    <form class="admin-form" data-route="storeProducto">
                        <input type="hidden" name="id" value="">
                        <div class="mb-3">
                            <label for="imagen_url" class="form-label">Imagen producto</label>
                            <input type="file" class="form-control" name="imagen_url" value="">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Producto</label>
                            <input type="text" class="form-control" name="nombre" value="">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" aria-label="Default select example" name="categoria_id">
                                <option selected>Selecciona categoría</option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" value="">
                        </div>
                        <div class="mb-3">
                            <label for="iva" class="form-label">IVA</label>
                            <select class="form-select" aria-label="Default select example" name="iva_id">
                                <option selected>Selecciona Tipo de IVA</option>
                                <?php foreach($ivas as $iva): ?>
                                    <option value="<?= $iva['id'] ?>"><?= $iva['tipo_iva'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="visible" class="form-label">Visible</label>
                            <select class="form-select" aria-label="Default select example" name="visible">
                                <option value="0">0</option>
                                <option value="1" selected>1</option>
                            </select>
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
                    <h5 class="modal-title" id="deleteArticleLabel">ELIMINAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">Está a punto de borrar un producto. ¿Está completamente seguro de realizar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    <button type="button" class="delete-table-modal btn btn-primary" data-bs-dismiss="modal" data-route="deleteProducto">ELIMINAR</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de filtrar productos-->  
    <div>
        <div id="filterArticle" class="modal fade" tabindex="-1" aria-labelledby="filterArticleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterArticleLabel">FILTRAR PRODUCTOS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="admin-productos.php" method="GET">

                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría del producto</label>
                            <select class="form-select" aria-label="Default select example" name="categoria_id">
                                <option value="">Todas</option>
                                <?php foreach($categorias as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="visible" class="form-label">Visible:</label>
                            <select class="form-select" aria-label="Default select example" name="visible">
                                <option value="">Todos</option>
                                <option value="true">Visibles</option>
                                <option value="false">No visibles</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="module" src="dist/main.js"></script>
</body>

</html>