<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-calendar-alt"></i> IMPORTAR MESAS DE EXAMEN</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <form action="FormImportarMesa.php" enctype="multipart/form-data" 
                  id="formSeleccionarMesa" name="formSeleccionarMesa" 
                  method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Seleccione archivo</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="fileMesas" class="col-sm-2 col-form-label">* Mesas de examen:</label>
                            <div class="col">
                                <div class="input-group">
                                    <div class="custom-file p-4" lang="es">
                                        <input type="file" class="custom-file-input" 
                                               id="fileMesas" name="fileMesas" accept=".csv" 
                                               aria-describedby="inputGroupFileAddon01" required>
                                        <label class="custom-file-label" for="inputGroupFile01" data-browse="Seleccionar">Seleccionar archivo .CSV</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnSeleccionarMesa" title="Procesar archivo">
                            <i class="far fa-save"></i> PROCESAR
                        </button>
                        <a href="FormBuscarMesa.php">
                            <button type="button" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/SeleccionarMesa.js"></script>
<?php
include_once '../../principal/vista/footer.php';