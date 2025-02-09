<?php

use Jairo\ConcesionarioEspacial\Models\SpaceShipModel;
use Jairo\ConcesionarioEspacial\Models\UserModel;

// Obtener los parámetros de la página y límite
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

// Si tiene el id de un usuario puesto pues le mostramos solo de ese usuario, sino pues les mostramos el paginado total
if (isset($_GET['id'])) {
    $idUser = (int) $_GET['id'];
    // Obtener las naves espaciales desde la base de datos
    $userM = new UserModel();
    $ships = $userM->obtenerSpaceShips($idUser, $page, $limit);

    // Obtener el número total de páginas
    $totalPages = $userM->obtenerTotalNaves($limit, $idUser);

    // Preparar la respuesta JSON
    $response = [
        'ships' => $ships,
        'totalPages' => $totalPages
    ];

    // Enviar la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Obtener las naves espaciales desde la base de datos
    $naveM = new SpaceShipModel();
    $ships = $naveM->cargarTodosDatosPaginado($page, $limit);

    // Obtener el número total de páginas
    $totalPages = $naveM->obtenerTotalPaginas($limit);

    // Preparar la respuesta JSON
    $response = [
        'ships' => $ships,
        'totalPages' => $totalPages
    ];

    // Enviar la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
