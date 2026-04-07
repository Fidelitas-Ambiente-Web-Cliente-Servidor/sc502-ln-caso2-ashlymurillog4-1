$(function () {

    cargarSolicitudes();

    function cargarSolicitudes() {

        $.get("index.php?option=solicitudes_json", function (data) {

            let tbody = $("#solicitudes-body");
            tbody.html("");

            if (data.data.length === 0) {
                tbody.html(`<tr><td colspan="6">No hay solicitudes</td></tr>`);
                return;
            }

            data.data.forEach(sol => {
                tbody.append(`
                    <tr>
                        <td>${sol.id}</td>
                        <td>${sol.taller}</td>
                        <td>${sol.usuario}</td>
                        <td>${sol.fecha_solicitud}</td>
                        <td>
                            <button class="aprobar" data-id="${sol.id}">Aprobar</button>
                            <button class="rechazar" data-id="${sol.id}">Rechazar</button>
                        </td>
                    </tr>
                `);

            });

        }, "json");
    }

});