<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" sizes="192x192" href="assets/img/logo.png">
    <title>Curuba</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Header -->
    <link rel="stylesheet" href="assets/css/header.css">
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/adminlte.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<style>
    body {
        background:white !important;
    }
</style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <center>
                <img src="assets/img/logo.jpg" class="mt-5 pt-5" style="width:300px">
                <br>
                <div class="login">
                    <br>
                    <form method="post" id="Open_Form" class="p-3">

                        <div class="row">
                            <div class="col-sm-6 offset-md-3">
                                <div class="form-group">
                                    <label>Apertura de caja, ingrese el monto:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="nav-icon fas fa-archive"></i></span>
                                        </div>
                                        <input id="amount"
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 1, 'digitsOptional': false, 'prefix': ' ', 'placeholder': '0'"
                                            class="form-control" name="amount" placeholder="0" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>


                    </form>
                </div>
        </div>
</body>


<script>
$(document).ready(function() {
    $(":input").inputmask();
});

$(document).on('submit', '#Open_Form', function(e) {
    e.preventDefault();
    if (document.getElementById("Open_Form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Cashbox&a=OpenSave", $("#Open_Form").serialize()).done(function(res) {
            window.location = "?c=Init&a=Index";
        });
    }
});
</script>