<form method="post" id="Inventory_Form">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo Documento</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Autor(es):</label>
                        <div class="input-group">
                            <input class="form-control" name="author" value="<?php echo isset($id) ? $id->author : '' ?>" required>
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id->id : '' ?>">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Título:</label>
                        <div class="input-group">
                            <input class="form-control" name="title" value="<?php echo isset($id) ? $id->title : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Nombre Publicación Seriada:</label>
                        <div class="input-group">
                            <input class="form-control" name="name" value="<?php echo isset($id) ? $id->name : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Editores o compiladores:</label>
                        <div class="input-group">
                            <input class="form-control" name="publisher" value="<?php echo isset($id) ? $id->publisher : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Ciudad: Editorial:</label>
                        <div class="input-group">
                            <input class="form-control" name="city" value="<?php echo isset($id) ? $id->city : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Número Publicación Seriada:</label>
                        <div class="input-group">
                            <input class="form-control" name="num" value="<?php echo isset($id) ? $id->num : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Año de Publicación:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="year" value="<?php echo isset($id) ? $id->year : '' ?>" required>
                        </div>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Páginas:</label>
                        <div class="input-group">
                            <input class="form-control" name="pages" value="<?php echo isset($id) ? $id->pages : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Formato:</label>
                        <div class="input-group">
                            <input class="form-control" name="format" value="<?php echo isset($id) ? $id->format : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Cantidad:</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="qty" value="<?php echo isset($id) ? $id->qty : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Localización:</label>
                        <div class="input-group">
                            <input class="form-control" name="location" value="<?php echo isset($id) ? $id->location : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Tema:</label>
                        <div class="input-group">
                            <input class="form-control" name="subject" value="<?php echo isset($id) ? $id->subject : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 1</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Sede:</label>
                                <div class="input-group">
                                    <input class="form-control" name="site1" value="<?php echo isset($id) ? $id->site1 : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Signatura:</label>
                                <div class="input-group">
                                    <input class="form-control" name="signature1" value="<?php echo isset($id) ? $id->signature1 : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 2</h3>
                    </div>
                    <div class="card-body row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Sede:</label>
                                <div class="input-group">
                                    <input class="form-control" name="site2" value="<?php echo isset($id) ? $id->site2 : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Signatura:</label>
                                <div class="input-group">
                                    <input class="form-control" name="signature2" value="<?php echo isset($id) ? $id->signature2 : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación 3</h3>
                    </div>
                    <div class="card-body row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Sede:</label>
                                <div class="input-group">
                                    <input class="form-control" name="site3" value="<?php echo isset($id) ? $id->site3 : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>* Signatura:</label>
                                <div class="input-group">
                                    <input class="form-control" name="signature3" value="<?php echo isset($id) ? $id->signature3 : '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>* Palabras Clave:</label>
                        <div class="input-group">
                            <select class="form-control select2_tags" style="width:100%" name="keywords[]" multiple="multiple" required>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Fondo:</label>
                        <div class="input-group">
                            <input class="form-control" name="fondo" value="<?php echo isset($id) ? $id->fondo : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Rollo:</label>
                        <div class="input-group">
                            <input class="form-control" name="roll" value="<?php echo isset($id) ? $id->roll : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>* Folios:</label>
                        <div class="input-group">
                            <input class="form-control" name="foil" value="<?php echo isset($id) ? $id->foil : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="card card-info col-12">
                    <div class="card-header">
                        <h3 class="card-title">Observaciones</h3>
                    </div>
                    <div class="card-body row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                                <textarea class="form-control" name="notes"><?php echo isset($id) ? $id->notes : '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

        </div>





    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>

<script>
$('.select2_tags').select2({tags:true,<?php echo isset($id) ? "data: " . $id->keywords : '' ?>});
<?php if(isset($id)) { ?>
$('.select2_tags').val(<?php echo $id->keywords ?>).trigger('change')
<?php } ?>
</script>