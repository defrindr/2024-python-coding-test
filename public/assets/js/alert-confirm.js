$(document).ready(function () {
    $(".confirm_approve").click(function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Anda akan melakukan approve.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, approve sekarang!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});