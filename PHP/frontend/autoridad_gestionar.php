<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    header('Location: /VialBarinas/login.php');
    exit();
}

include_once('../../Templates/header_4.php');
require_once '../../database.php';

$query = "SELECT r.id, r.titulo, r.descripcion, r.tipo_incidente, r.fecha_reporte,
                 r.latitud, r.longitud, r.imagen, r.estado, r.estatus,
                 u.nombre AS ciudadano, u.cedula AS cedula
          FROM reportes r
          JOIN usuarios u ON r.usuario_id = u.id
          WHERE r.estado = 'pendiente'
          ORDER BY r.fecha_reporte DESC";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-clipboard-check"></i> Reportes</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden">
            <thead class="table-dark text-center">
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= $row['tipo_incidente'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['fecha_reporte'])) ?></td>
                    <td><?= $row['ciudadano'] ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imgModal<?= $row['id'] ?>">
                            <img src="<?= $row['imagen'] ?>" alt="Reporte" style="width: 60px; height: 45px; object-fit: cover; border-radius: 5px;" class="shadow-sm">
                        </a>

                        <!-- Modal de imagen -->
                        <div class="modal fade" id="imgModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Imagen del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="<?= $row['imagen'] ?>" class="img-fluid rounded shadow">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a href="#" class="btn btn-outline-info btn-sm" title="Ver en mapa" data-bs-toggle="modal" data-bs-target="#mapModal<?= $row['id'] ?>">
                            <i class="bi bi-geo-alt-fill"></i>
                        </a>
                        <!-- Modal de mapa -->
                        <div class="modal fade" id="mapModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ubicación del Reporte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="https://www.google.com/maps?q=<?= $row['latitud'] ?>,<?= $row['longitud'] ?>&output=embed"
                                                width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-secondary"><?= ucfirst($row['estado']) ?></span>
                    </td>
                    <td>
                        <span class="badge bg-<?= $row['estatus'] === 'activo' ? 'success' : 'dark' ?>">
                            <?= ucfirst($row['estatus']) ?>
                        </span>
                    </td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-2">
                                <!-- Aprobar -->
                                <form method="POST" action="/VialBarinas/PHP/backend/actualizar_estado.php" class="accion-form">
                                    <input type="hidden" name="reporte_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="accion" value="aprobar">

                                    <select name="prioridad" class="form-select form-select-sm rounded-pill mb-1" required>
                                        <option value="" selected disabled>-- Seleccionar --</option>
                                        <option value="alta">Alta</option>
                                        <option value="media">Media</option>
                                        <option value="baja">Baja</option>
                                    </select>

                                    <button type="button" class="btn btn-success btn-sm rounded-pill w-100" onclick="confirmarAccion(this)">
                                        Aprobar
                                    </button>
                                </form>

                                <!-- Rechazar -->
                                <form method="POST" action="/VialBarinas/PHP/backend/actualizar_estado.php" class="accion-form">
                                    <input type="hidden" name="reporte_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="accion" value="rechazar">
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill w-100" onclick="confirmarAccion(this)">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_GET['error']) && $_GET['error'] === 'sin_prioridad'): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'warning',
        title: 'Debe seleccionar una prioridad al aprobar.',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    // Limpiar la URL sin recargar
    const url = new URL(window.location);
    url.searchParams.delete('error');
    window.history.replaceState({}, document.title, url);
});
</script>
<?php endif; ?>


<script>
function confirmarAccion(button) {
    const form = button.closest('form');
    const accion = form.querySelector('input[name="accion"]').value;

    const mensajes = {
        aprobar: {
            titulo: '¿Aprobar reporte?',
            texto: 'Este reporte pasará a estado aprobado.'
        },
        rechazar: {
            titulo: '¿Rechazar reporte?',
            texto: 'Este reporte será marcado como rechazado.'
        }
    };

    Swal.fire({
        icon: 'question',
        title: mensajes[accion].titulo,
        text: mensajes[accion].texto,
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

<?php if (isset($_GET['exito'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let mensaje = '';
    if ('<?= $_GET['exito'] ?>' === 'aprobado') {
        mensaje = 'Reporte aprobado correctamente.';
    } else if ('<?= $_GET['exito'] ?>' === 'rechazado') {
        mensaje = 'Reporte rechazado correctamente.';
    }

    if (mensaje) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: mensaje,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        const url = new URL(window.location);
        url.searchParams.delete('exito');
        window.history.replaceState({}, document.title, url);
    }
});
</script>
<?php endif; ?>



<?php include_once('../../Templates/footer.php'); ?>
