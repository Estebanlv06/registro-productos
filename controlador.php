<?php
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'registro_productos';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) 
{
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

//SOLO ACEPTA METODOS POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo se permiten peticiones POST']);
    exit;
}

$datos = json_decode(file_get_contents("php://input"), true);

$accion = $datos['accion'] ?? '';
$id_bodega = $datos['id_bodega'] ?? 0;

if (!$accion) {
    echo json_encode(['error' => 'No se recibió ninguna acción.']);
    exit;
}

switch ($accion) 
{
    case 'bodegas':
        echo json_encode(obtenerBodegas($conn));
        break;

    case 'monedas':
        echo json_encode(obtenerMonedas($conn));
        break;

    case 'sucursales':
        echo json_encode(obtenerSucursales($conn, $id_bodega));
        break;

    case 'guardar':
        $datos = json_decode(file_get_contents("php://input"), true);
        echo json_encode(guardarProducto($conn, $datos));
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function obtenerBodegas($conn) 
{
    $resultado = $conn->query("SELECT id, nombre FROM bodegas");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtenerMonedas($conn) 
{
    $resultado = $conn->query("SELECT id, nombre FROM monedas");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function obtenerSucursales($conn, $id_bodega) 
{
    $sql = $conn->prepare("SELECT id, nombre FROM sucursales WHERE id_bodega = ?");
    $sql->bind_param("i", $id_bodega);
    $sql->execute();
    $resultado = $sql->get_result();
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function guardarProducto($conn, $datos) 
{
    $codigo = $conn->real_escape_string($datos['codigo']);
    $nombre = $conn->real_escape_string($datos['nombre']);
    $id_bodega = intval($datos['bodega']);
    $id_sucursal = intval($datos['sucursal']);
    $id_moneda = intval($datos['moneda']);
    $precio = floatval($datos['precio']);
    $descripcion = $conn->real_escape_string($datos['descripcion']);
    $materiales = $conn->real_escape_string(implode(',', $datos['materiales'] ?? []));

    $verifica = $conn->query("SELECT id FROM productos WHERE codigo = '$codigo'");
    if ($verifica->num_rows > 0) {
        return ['error' => 'El código del producto ya está registrado.'];
    }

    $sql = "INSERT INTO productos (codigo, nombre, id_bodega, id_sucursal, id_moneda, precio, descripcion, materiales)
            VALUES ('$codigo', '$nombre', $id_bodega, $id_sucursal, $id_moneda, $precio, '$descripcion', '$materiales')";

    if ($conn->query($sql)) {
        return ['success' => 'Producto guardado correctamente'];
    } else {
        return ['error' => 'Error al guardar el producto'];
    }
}