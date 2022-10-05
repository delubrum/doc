<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Cerrar Caja</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
            <form method="post" id="cashbox_close_form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="nav-icon fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input id="amount"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 0, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                        class="form-control" name="amount" placeholder="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cerrar Caja</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(":input").inputmask();
});

$('#cashbox_close_form').on('submit', function(e) {
    if (document.getElementById("cashbox_close_form").checkValidity()) {
        e.preventDefault();
        Swal.fire({
            title: 'Deseas Cerrar la Caja?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loading").fadeIn();
                $.post("?c=Cashbox&a=CloseSave", {
                        amount: $("#amount").val()
                    },
                    function(data) {
                        $("#loading").fadeOut();
                        Swal.fire({
                            title: "Resumen",
                            html: data,
                            confirmButtonText: "OK",
                        }).then((result) => {
                            window.location = "?c=Login&a=Logout";
                        })
                    });
            }
        })
    }
});
</script>