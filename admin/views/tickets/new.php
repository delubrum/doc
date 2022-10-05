<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<form method="post" id="Tickets_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Ticket</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Precio</label>
                                <div class="input-group">
                                    <input id="price"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 1, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                        class="form-control" name="price" placeholder="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Fecha Vencimiento</label>
                                <div class="input-group">
                                    <input type='date' class="form-control" name="expiresAt" required>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(":input").inputmask();
});
</script>