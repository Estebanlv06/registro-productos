document.addEventListener("DOMContentLoaded", () => {
    cargarSelect('bodegas', 'bodega');
    cargarSelect('monedas', 'moneda');

    document.getElementById("bodega").addEventListener("change", (e) => {
        cargarSucursales(e.target.value);
    });

    document.getElementById("formProducto").addEventListener("submit", function (e) {
        e.preventDefault();
        if (!validarFormulario()) return;

        const materiales = Array.from(document.querySelectorAll('input[name="materiales[]"]:checked'))
            .map(c => c.value);

        const datos = {
            accion: "guardar",
            codigo: document.getElementById("codigo").value.trim(),
            nombre: document.getElementById("nombre").value.trim(),
            bodega: document.getElementById("bodega").value,
            sucursal: document.getElementById("sucursal").value,
            moneda: document.getElementById("moneda").value,
            precio: document.getElementById("precio").value.trim(),
            descripcion: document.getElementById("descripcion").value.trim(),
            materiales: materiales
        };

        fetch("controlador.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
        .then(res => res.json())
        .then(respuesta => {
            if (respuesta.success) {
                alert(respuesta.success);
                document.getElementById("formProducto").reset();
            } else {
                alert(respuesta.error || "Error al guardar el producto.");
            }
        });
    });
});

function cargarSelect(accion, idSelect) 
{
    fetch("controlador.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ accion: accion })
    })
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById(idSelect);
        select.innerHTML = '<option value=""></option>';
        data.forEach(op => {
            const option = document.createElement("option");
            option.value = op.id;
            option.textContent = op.nombre;
            select.appendChild(option);
        });
    });
}

function cargarSucursales(idBodega) 
{
    fetch("controlador.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ accion: "sucursales", id_bodega: idBodega })
    })
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById("sucursal");
        select.innerHTML = '<option value=""></option>';
        data.forEach(op => {
            const option = document.createElement("option");
            option.value = op.id;
            option.textContent = op.nombre;
            select.appendChild(option);
        });
    });
}

function validarFormulario() 
{
    const codigo = document.getElementById("codigo").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const bodega = document.getElementById("bodega").value;
    const sucursal = document.getElementById("sucursal").value;
    const moneda = document.getElementById("moneda").value;
    const precio = document.getElementById("precio").value.trim();
    const descripcion = document.getElementById("descripcion").value.trim();
    const materiales = document.querySelectorAll('input[name="materiales[]"]:checked');

    const regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/;
    const regexNombre = /^.{2,50}$/;
    const regexPrecio = /^\d+(\.\d{1,2})?$/;
    const regexDescripcion = /^.{10,1000}$/s;

    if (!codigo) return alert("El código del producto no puede estar en blanco.");
    if (!regexCodigo.test(codigo)) return alert("El código debe contener letras y números, entre 5 y 15 caracteres.");

    if (!nombre) return alert("El nombre del producto no puede estar en blanco.");
    if (!regexNombre.test(nombre)) return alert("El nombre debe tener entre 2 y 50 caracteres.");

    if (bodega === "") return alert("Debe seleccionar una bodega.");

    if (sucursal === "") return alert("Debe seleccionar una sucursal para la bodega seleccionada.");

    if (moneda === "") return alert("Debe seleccionar una moneda para el producto.");

    if (!precio) return alert("El precio del producto no puede estar en blanco.");
    if (!regexPrecio.test(precio)) return alert("El precio debe ser un número positivo con hasta dos decimales.");

    if (materiales.length < 2) return alert("Debe seleccionar al menos dos materiales para el producto.");

    if (!descripcion) return alert("La descripción del producto no puede estar en blanco.");
    if (!regexDescripcion.test(descripcion)) return alert("La descripción debe tener entre 10 y 1000 caracteres.");

    return true;
}