$(function () {

    // Aprobar
    $(document).on("click", ".aprobar", function () {

        let id = $(this).data("id");

        $.post("index.php", {
            option: "aprobar",
            id_solicitud: id
        }, function (res) {

            alert(res.message);

            if (res.success) {
                location.reload(); // puedes cambiar por recarga dinámica si quieres subir nota
            }

        }, "json");

    });

    // Rechazar
    $(document).on("click", ".rechazar", function () {

        let id = $(this).data("id");

        $.post("index.php", {
            option: "rechazar",
            id_solicitud: id
        }, function (res) {

            alert(res.message);

            if (res.success) {
                location.reload();
            }

        }, "json");

    });

    // Logout
    $("#btnLogout").click(function () {
        $.post("index.php", { option: "logout" }, function () {
            window.location = "index.php";
        });
    });

});