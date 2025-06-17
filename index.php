<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro de Producto</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <div id="contenedor">
            <h1 id="titulo-formulario">Formulario de Producto</h1>

            <form id="formProducto">
                <div class="fila-doble">
                    <div class="campo">
                        <label for="codigo">Código</label>
                        <input type="text" id="codigo" name="codigo">
                    </div>

                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre">
                    </div>
                </div>

                <div class="fila-doble">
                    <div class="campo">
                        <label for="bodega">Bodega</label>
                        <select id="bodega" name="bodega">
                            <option value="">-- Seleccione --</option>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="sucursal">Sucursal</label>
                        <select id="sucursal" name="sucursal">
                            <option value="">-- Seleccione --</option>
                        </select>
                    </div>
                </div>

                <div class="fila-doble">
                    <div class="campo">
                        <label for="moneda">Moneda</label>
                        <select id="moneda" name="moneda">
                            <option value="">-- Seleccione --</option>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="precio">Precio</label>
                        <input type="text" id="precio" name="precio">
                    </div>
                </div>

                <label class="label-checkbox">Material del Producto</label>
                <input type="checkbox" name="materiales[]" value="Plástico"> Plástico
                <input type="checkbox" name="materiales[]" value="Metal"> Metal
                <input type="checkbox" name="materiales[]" value="Vidrio"> Vidrio
                <input type="checkbox" name="materiales[]" value="Cartón"> Cartón
                <input type="checkbox" name="materiales[]" value="Madera"> Madera
                <br>
    
                <label for="descripcion">Descripción</label><br>
                <textarea id="descripcion" name="descripcion" rows="5" cols="50"></textarea>
                <br><br>

                <div class="contenedor-boton">
                    <button type="submit" id="btn-guardar">Guardar Producto</button>
                </div>
            </form>
        </div>

        <script src="logica.js"></script>
    </body>
</html>