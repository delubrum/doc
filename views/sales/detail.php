<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Curuba</title>
        <style>
            * {
                font-size: 10px;
                font-family: 'Times New Roman';
            }

            td,
            th,
            tr,
            table {
                border-top: 1px solid black;
                border-collapse: collapse;
            }

            td.description,
            th.description {
                text-align:right;
            }

            td.quantity,
            th.quantity {
                width: 5px;
                max-width: 5px;
                word-break: break-all;
                text-align: right;
            }

            td.price,
            th.price {
                width: 60px;
                max-width: 60px;
                word-break: break-all;
                text-align: right;
            }

            .centered {
                text-align: center;
                align-content: center;
                margin:0;
            }

            .ticket {
                width: 250px;
                max-width: 250px;
            }

            img {
                max-width: inherit;
                width: inherit;
            }

            .text-right {
                border: none;
                text-align:right;
            }

            .noborder {
                border: none;
            }

            @media print {
                .hidden-print,
                .hidden-print * {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="ticket">
            <img src="assets/img/logoprint.png" alt="Logo">
            <p class="centered">
                <br>Calle Capitan Arenas 58
                <br>Barcelona España
            </p>
            <p class="centered">
                <br>FACTURA SIMPLIFICADA
                <br><b>Nro: <?php echo $id->id ?></b>
            </p>
            <br>
            <table style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align:center">Uds</th>
                        <th style="text-align:center">Descripcion</th>
                        <th style="text-align:center">€</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($this->sales->listDetail($id->id) as $r ) {?>
                    <tr>
                        <td class="quantity"><?php echo $r->qty ?></td>
                        <td class="description"><?php echo  mb_convert_case($r->description, MB_CASE_TITLE, "UTF-8") ?></td>
                        <td class="price"><?php echo $r->price ?></td>
                    </tr>
                    <?php } ?>


                    <?php
                    $total = $id->cash+$id->card+$id->ticket; 
                    $discount = (($id->cash+$id->card+$id->ticket) * $id->discount/100); 
                    $iva = ($total-$discount)/1.21 ;
                    $base = ($total-$discount-$iva)


                    ?>


                    <tr class="noborder"><th class="noborder" style="padding:5px"></tr>
                    <tr class="noborder">
                        <th colspan="2" class="text-right noborder">TOTAL: </th>
                        <td class="price noborder"><?php echo number_format($total,2) ?></td>
                    </tr>
                    <tr class="noborder">
                        <th colspan="2" class="text-right noborder">TOTAL CON DESCUENTO (<?php echo $id->discount?>%): </th>
                        <td class="price noborder"><b><?php echo number_format($total-$discount,2) ?></b></td>
                    </tr>
                    <tr class="noborder">
                        <th colspan="2" class="text-right">IVA (21%): </th>
                        <td class="price noborder"><?php  echo number_format($base,2) ?></td>
                    </tr>
                    <tr class="noborder">
                        <th colspan="2" class="text-right">BASE: </th>
                        <td class="price noborder"><?php echo number_format($iva,2) ?></td>
                    </tr>
                </tbody>
            </table>
            <p class="centered">
                <br>curubatienda@hotmail.com
                <br>931 25 31 42 - 26590498Z
            </p>
            <br>
            <p class="centered">
                <b>EL TICKET CADUCA A LOS 15 DIAS</b>
            </p>

            <p class="centered">
                <b>** Gracias por su Compra! **</b>
            </p>

            <p style="text-align:right">
                <?php echo $id->createdAt?>
            </p>
        </div>
        <button id="btnPrint" class="hidden-print">IMPRIMIR</button>
        <script src="script.js"></script>
    </body>
</html>

<script>
  const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});

window.print();
</script>