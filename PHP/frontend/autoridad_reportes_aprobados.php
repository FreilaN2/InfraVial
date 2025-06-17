<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    header('Location: /VialBarinas/login.php');
    exit();
}

require_once '../../database.php';
include_once('../../Templates/header_4.php');

$query = "SELECT r.id, r.titulo, r.descripcion, r.tipo_incidente, r.fecha_reporte, 
                 r.latitud, r.longitud, r.imagen, r.estado, r.estatus, r.prioridad, 
                 u.nombre AS ciudadano, u.cedula AS cedula
          FROM reportes r
          JOIN usuarios u ON r.usuario_id = u.id
          WHERE r.estado = 'aprobado' AND r.estatus = 'activo'
          ORDER BY r.fecha_reporte DESC";

$result = $conn->query($query);
?>

<div class="container mt-5">
    <h2 class="mb-4">Reportes Aprobados</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Ciudadano</th>
                    <th>Cédula</th>
                    <th>Imagen</th>
                    <th>Ubicación</th>
                    <th>Estado</th>
                    <th>Estatus</th>
                    <th>Prioridad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= $row['tipo_incidente'] ?></td>
                    <td><?= $row['fecha_reporte'] ?></td>
                    <td><?= $row['ciudadano'] ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalImg<?= $row['id'] ?>">Ver</a>
                        <div class="modal fade" id="modalImg<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <img src="<?= $row['imagen'] ?>" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalMapa<?= $row['id'] ?>">Mapa</a>
                        <div class="modal fade" id="modalMapa<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://maps.google.com/maps?q=<?= $row['latitud'] ?>,<?= $row['longitud'] ?>&hl=es&z=16&output=embed"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= $row['estado'] ?></td>
                    <td><?= $row['estatus'] ?></td>
                    <td><?= ucfirst($row['prioridad']) ?></td>
                    <td>
                        <form action="/VialBarinas/PHP/backend/actualizar_estado.php" method="POST">
                            <input type="hidden" name="reporte_id" value="<?= $row['id'] ?>">
                            <button name="accion" value="resolver" class="btn btn-warning btn-sm">Marcar como Resuelto</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once('../../Templates/footer.php'); ?>
