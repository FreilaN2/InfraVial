<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'superadmin') {
    header("Location: ../../index.php");
    exit();
}

require_once '../../database.php';

// Obtener filtro si existe
$rol_filtro = $_GET['rol'] ?? '';

if (!empty($rol_filtro)) {
    $stmt = $conn->prepare("SELECT id, nombre, apellido, cedula, telefono, correo, rol, creado_en FROM usuarios WHERE rol = ? ORDER BY creado_en DESC");
    $stmt->bind_param("s", $rol_filtro);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, nombre, apellido, cedula, telefono, correo, rol, creado_en FROM usuarios ORDER BY creado_en DESC");
}
?>

<?php include_once('../../Templates/header_3.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-people-fill"></i> Usuarios Registrados</h2>

    <!-- Filtro por rol -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-auto">
            <select name="rol" class="form-select">
                <option value="">-- Todos los roles --</option>
                <option value="superadmin" <?= $rol_filtro === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                <option value="autoridad" <?= $rol_filtro === 'autoridad' ? 'selected' : '' ?>>Autoridad</option>
                <option value="ciudadano" <?= $rol_filtro === 'ciudadano' ? 'selected' : '' ?>>Ciudadano</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-filter"></i> Filtrar
            </button>
        </div>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Registrado el</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></td>
                            <td><?= htmlspecialchars($user['cedula']) ?></td>
                            <td><?= htmlspecialchars($user['telefono']) ?></td>
                            <td><?= htmlspecialchars($user['correo']) ?></td>
                            <td>
                                <?php
                                $color = ($user['rol'] === 'superadmin') ? 'danger' :
                                        (($user['rol'] === 'autoridad') ? 'primary' : 'secondary');
                                ?>
                                <span class="badge bg-<?= $color ?>">
                                    <?= ucfirst($user['rol']) ?>
                                </span>
                            </td>
                            <td><?= date("d/m/Y H:i", strtotime($user['creado_en'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay usuarios registrados con ese rol.</div>
    <?php endif; ?>
</div>

<?php include_once('../../Templates/footer.php'); ?>
