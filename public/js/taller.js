$(function () {

    cargarTalleres();

    function cargarTalleres() {
        $.get("index.php?option=talleres_json", function (data) {

            let tbody = $("#tabla-talleres");
            tbody.html("");

            data.forEach(taller => {

                tbody.append(`
                    <tr>
                        <td>${taller.nombre}</td>
                        <td>${taller.descripcion}</td>
                        <td>${taller.cupo_disponible}</td>
                        <td>
                            <button class="btnSolicitar" data-id="${taller.id}">
                                Solicitar
                            </button>
                        </td>
                    </tr>
                `);
            });

        }, "json");
    }

    // solicitar taller
    $(document).on("click", ".btnSolicitar", function () {

        let tallerId = $(this).data("id");

        $.ajax({
            url: "index.php",
            type: "POST",
            dataType: "json",
            data: {
                option: "solicitar",
                taller_id: tallerId
            },
            success: function (res) {

                alert(res.message);

                if (res.success) {
                    cargarTalleres(); // refresca sin recargar
                }
            }
        });

    });

    // logout
    $("#btnLogout").click(function () {
        $.post("index.php", { option: "logout" }, function () {
            window.location = "index.php";
        });
    });

});