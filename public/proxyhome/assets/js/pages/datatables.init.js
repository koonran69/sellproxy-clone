$(document).ready(function () {
    $("#datatable").DataTable(),
        $("#datatable-buttons")
            .DataTable({
                lengthChange: true,
                buttons: ["copy", "excel", "pdf", "colvis"],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 75, 100]
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
        $(".dataTables_length select").addClass("form-select form-select-sm");
});
