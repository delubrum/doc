<header>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<!-- Modal -->
<form method="post" id="sale_save">
    <div class="modal-header">
        <h5 class="modal-title">Nueva Venta</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row">
                        <div class="col-12">
                            <input style="padding:5px;width:98%" placeholder="Buscar..." id="product_search">
                        </div>
                        <div class="col-12 mt-3">
                            <div id="items">
                            </div>
                            <div class="row p-1 mt-1">
                                <div class="col-6 font-weight-bold text-right">
                                    TOTAL:
                                </div>
                                <div id="total" class="col-6 font-weight-bold text-right">€ 0</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-toggle='modal' data-target='#sell' onclick='Pay()' class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sell" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="product_add">
                <div class="modal-body">
                    <div class="row" id="payment_info">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Descuento (%)</label>
                                    <div class="input-group">
                                        <input id="discount" type="number" class="form-control text-right" value="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Total A Pagar</label>
                                    <div class="input-group">
                                        <input class="form-control text-right" id="payTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Forma de Pago</label>
                                    <div class="input-group">
                                        <select class="form-control" id="payType">
                                            <option value=""></option>
                                            <option value="1">Efectivo</option>
                                            <option value="2">Tarjeta</option>
                                            <option value="3">Cupones</option>
                                            <option value="4">Efectivo + Tarjeta</option>
                                            <option value="5">Efectivo + Cupones</option>
                                            <option value="6">Tarjeta + Cupones</option>
                                            <option value="7">Efectivo + Tarjeta + Cupones</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Efectivo</label>
                                    <div class="input-group">
                                        <input id="cash"
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                            class="form-control" value="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Tarjeta</label>
                                    <div class="input-group">
                                        <input id="card"
                                            data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                                            class="form-control" value="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Cupón</label>
                                    <div class="input-group">
                                        <button type="button" data-toggle='modal' data-target='#cuponCode' class="btn btn-primary float-right col-12" id="addCupon" disabled>
                                            <i class="fas fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 row" id="cupones">
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Total Cupones</label>
                                    <div class="input-group">
                                        <input class="form-control text-right" id="cuponTotal" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Total Pagado</label>
                                    <div class="input-group">
                                        <input class="form-control text-right" id="payedTotal" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Diferencia</label>
                                    <div class="input-group">
                                        <input class="form-control text-right" id="diference" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>* Cambio</label>
                                    <div class="input-group">
                                        <input class="form-control text-right" id="returned" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3">
                                <div class="form-group">
                                    <label>Observaciones:</label>
                                    <textarea class="form-control" id="obs"></textarea>
                                </div>
                            </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="sale_save_send" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="cuponCode" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="post" id="findCupon">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>* Codigo</label>
                                <div class="input-group">
                                    <input type="number" id="cuponId" class="form-control" pattern="\d*" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

$(document).on("click", "#addCupon", function() { 
    setTimeout(function() { $('#cuponId').focus() }, 300);
});

$(document).on("blur", "#cuponId", function(e) {
    $('#cuponId').val('');
});


function Total(){
    sum = 0;
    $('.productTotal').each(function() {
        sum += parseFloat($(this).val());
    });
    $("#total").html(sum.toFixed(2));
}

$(document).on("input", ".pqty", function(e) {
    iqty = $(this).data('iqty');
    price = $(this).data('price');
    val = $(this).val();
    total = price*val;
    if(iqty < val) {
    toastr.error('la cantidad ingresada es mayor a la disponible');
    $(this).val(1);
        $(this).closest('.removediv').find('.productTotal').val(price.toFixed(2));
    $(this).focus();
    } else {
        $(this).closest('.removediv').find('.productTotal').val(total.toFixed(2));
    }
    Total()
});

$(document).on("input", ".qtyCupon", function(e) {
    price = $(this).data('price');
    val = $(this).val()
    if(price < val) {
    toastr.error('la cantidad ingresada es mayor a la disponible');
    $(this).val(0);
    $(this).focus();
    }
    Calc()
});

$(document).on("keydown", "form", function(event) { 
    return event.key != "Enter";
});

function Calc() {
    var cuponPrice = $("input[name='cuponPrice[]']").map(function(){return $(this).val();}).get();
    price = cuponPrice.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
    total = parseFloat($('#total').html());
    discount = parseFloat($('#discount').val());
    payTotal = (total - (total * (discount/100))).toFixed(2);
    $('#payTotal').val(payTotal);
    cash = parseFloat($('#cash').val());
    card = parseFloat($('#card').val());
    returned = cash-payTotal;
    payedTotal = cash+card+price;
    diference = payTotal-payedTotal;
    $('#cuponTotal').val(price.toFixed(2));
    $('#payedTotal').val(payedTotal.toFixed(2));
    $('#diference').val((diference).toFixed(2));
    if(diference != 0) { $('#diference').css("background-color", "red");}
    if(diference == 0) { $('#diference').css("background-color", "#69c58d");}
    if ($('#payType').val() == 2) {
        $('#card').val($('#payTotal').val());
    }
    if ($('#payType').val() == 1) {
        $('#returned').val(returned.toFixed(2));
    } else {
        $('#returned').val(0);
    }
}

$(document).on('input', '#cash,#card,#discount', function() {
    Calc();
});

function Pay() {
    total = parseFloat($('#total').html());
    $('#payTotal').val(total);
    $('#discount').val(0);
    $('#cash').val(0);
    $('#card').val(0);
    $('#cupon').val(0);
    $('#returned').val(0);
    $(":input").inputmask();
}

$(document).on('click', '.btx', function() {
    Swal.fire({
        title: 'Deseas Borrar el item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.isConfirmed) {
            $(this).closest('.removediv').remove();
            Total();
        }
    })
});

$(document).on("input", "#cuponId", function(e) {
    var values = $("input[name='cuponId[]']").map(function(){return $(this).val();}).get();
    if($(this).val().length < 7 ) {
        return
    }
    e.preventDefault();
    e.stopImmediatePropagation();
    id = $('#cuponId').val();
    $.post( "?c=Tickets&a=Get", { id }).done(function( res ) {
        var res = $.parseJSON(res);
        if (res.status != 'ok') {
        toastr.error(res.status);
        return;       
        }
        if (values.includes(res.id)) {
        toastr.error('El código ya fue agregado');
        return;       
        }
        div = `
        <div class="col-sm-12 row removediv">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Código</label>
                    <div class="input-group">
                        ${res.code}
                        <input type="hidden" name="cuponId[]" value="${res.id}">
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label>Disponible</label>
                    <div class="input-group">
                        ${res.price}
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>* Cantidad a Usar</label>
                    <div class="input-group">
                        <input data-price='${res.price}'
                            data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                            class="form-control form-control-sm qtyCupon" name="cuponPrice[]" value="0" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-1">
                <div class="form-group mt-1">
                    <button type="button" class="btn btn-danger btx mt-4 float-right"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
        `;
        $("#cupones").append(div);
        $('#cuponCode').modal('toggle');
        $('#cuponId').val('');
        $(":input").inputmask();
        Calc()
    });
});

$(document).on('input', '#product_search', function(e) {
    var products = $("input[name='productId[]']").map(function(){return $(this).val();}).get();
    if($(this).val().length < 7 ) {
        return
    }
    e.preventDefault();
    e.stopImmediatePropagation();
    id = $(this).val();
    $.post("?c=Products&a=Search", {id}, function(res) {
        var res = $.parseJSON(res);
        if (res.status != 'ok') {
        toastr.error(res.status);
        return;       
        }
        if (products.includes(res.id)) {
        toastr.error('El producto ya fue agregado');
        return;       
        }
        div = `
        <div class="row p-1 bg-light removediv">
            <div class="col-1">
                <span style="cursor:pointer" class="h5 text-danger btx">&times;</span>
            </div>
            <div class="col-5" title="Talla:${res.size}\nColor:${res.color}\nPrecio:${res.price}">
                <input type="hidden" name="productId[]" value="${res.id}">
                ${res.code} / ${res.description} [En inventario: <b>${res.qty}</b>]
            </div>
            <div class="col-1" title="Código: ${res.code} /n ">
                <input style="width:60px" type="number" min='1' step='1' class="pqty" name="qty[]" data-price='${res.price}' data-iqty='${res.qty}' value='1'>
            </div>
            <div class="col-5 text-right font-weight-bold">
                <div class="input-group">
                    <input value='${res.price}'
                        data-inputmask="'alias': 'numeric', 'groupSeparator': '', 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': '0'"
                        class="form-control form-control-sm productTotal text-right" name="price[]" style="width:100px !important;border:none;background:none;font-weight:bold" readonly>
                </div>
            </div>
        </div>
        `;
        $(":input").inputmask();
        $('#product_search').val('');
        $('#product_search').focus();
        $('#items').append(div);
        setTimeout(function() { Total(); }, 200);
    });
});

$('#sale_save_send').on('click', function(e) {
    var cuponPrice = $("input[name='cuponPrice[]']").map(function(){return $(this).val();}).get();
    var cupons = $("input[name='cuponId[]']").map(function(){return $(this).val();}).get();
    payTotal = $('#payTotal').val();
    cash = parseFloat($('#cash').val());
    card = parseFloat($('#card').val());
    if (payTotal == 0) {
        toastr.error('No ha ingresado ningún producto');
        return;       
    }
    if ($('#diference').val() != 0) {
        toastr.error('La cantidad ingresada no corresponde al valor total');
        return;       
    }
    returned = parseFloat($("#returned").val());
    discount = parseFloat($("#discount").val());
    obs = $("#obs").val();
    if (document.getElementById("sale_save").checkValidity()) {
        e.preventDefault();
        Swal.fire({
            title: 'Deseas Guardar la Venta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loading").fadeIn("slow");
                var data = $("#sale_save").serializeArray();
                data.push({
                    name: 'returned',
                    value: returned
                });
                data.push({
                    name: 'discount',
                    value: discount
                });
                data.push({
                    name: 'obs',
                    value: obs
                });
                data.push({
                    name: 'cupons',
                    value: cupons
                });
                data.push({
                    name: 'cuponPrice',
                    value: cuponPrice
                });
                data.push({
                    name: 'card',
                    value: card
                });
                data.push({
                    name: 'cash',
                    value: cash
                });
                $.post("?c=Sales&a=Save", data, function(data) {
                    id = data.trim();
                    window.open("http://aei-sigma.com/curuba/admin/?c=Sales&a=Detail&id=" + id);
                    location.reload();
                });
            }
        })
    }
});

$(document).on("change", "#payType", function(e) {
    if ($(this).val() == 1) {
        $('#cash').prop('readonly', false);
        $('#cash').prop('required', true);

        $('#card').prop('readonly', true);
        $('#card').prop('required', false);
        $('#card').val(0);

        $('#addCupon').prop('disabled', true);

        $('#cupones').html('');
    }
    if ($(this).val() == 2) {
        $('#cash').prop('readonly', true);
        $('#cash').prop('required', false);
        $('#cash').val(0);

        $('#card').prop('readonly', true);
        $('#card').prop('required', true);
        $('#card').val($('#payTotal').val());

        $('#addCupon').prop('disabled', true);

        $('#cupones').html('');
    }
    if ($(this).val() == 3) {
        $('#cash').prop('readonly', true);
        $('#cash').prop('required', false);
        $('#cash').val(0);

        $('#card').prop('readonly', true);
        $('#card').prop('required', false);
        $('#card').val(0);

        $('#addCupon').prop('disabled', false);
    }

    if ($(this).val() == 4) {
        $('#cash').prop('readonly', false);
        $('#cash').prop('required', true);
        $('#cash').val(0);

        $('#card').prop('readonly', false);
        $('#card').prop('required', true);
        $('#card').val(0);

        $('#addCupon').prop('disabled', true);

        $('#cupones').html('');
    }
    if ($(this).val() == 5) {
        $('#cash').prop('readonly', false);
        $('#cash').prop('required', true);
        $('#cash').val(0);

        $('#card').prop('readonly', true);
        $('#card').prop('required', false);
        $('#card').val(0);

        $('#addCupon').prop('disabled', false);
    }
    if ($(this).val() == 6) {
        $('#cash').prop('readonly', true);
        $('#cash').prop('required', false);
        $('#cash').val(0);

        $('#card').prop('readonly', false);
        $('#card').prop('required', true);
        $('#card').val(0);

        $('#addCupon').prop('disabled', false);
    }
    if ($(this).val() == 7) {
        $('#cash').prop('readonly', false);
        $('#cash').prop('required', true);
        $('#cash').val(0);

        $('#card').prop('readonly', false);
        $('#card').prop('required', true);
        $('#card').val(0);

        $('#addCupon').prop('disabled', false);
    }
    $(":input").inputmask();
    Calc();
});
</script>