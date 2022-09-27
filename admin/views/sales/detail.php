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
                font-size: 12px;
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
                width: 75px;
                max-width: 75px;
            }

            td.quantity,
            th.quantity {
                width: 40px;
                max-width: 40px;
                word-break: break-all;
                text-align: left;
            }

            td.price,
            th.price {
                width: 40px;
                max-width: 40px;
                word-break: break-all;
                text-align: right;
            }

            .centered {
                text-align: center;
                align-content: center;
                margin:0;
            }

            .ticket {
                width: 155px;
                max-width: 155px;
            }

            img {
                max-width: inherit;
                width: inherit;
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
            <img src="assets/img/logo.jpg" alt="Logo">
            <p class="centered">
                <br>Calle Capitan Arenas 58
                <br>Barcelona España
            </p>
            <p class="centered">
                <br>FACTURA SIMPLIFICADA
                <br><b>Nro: <?php echo $id->id ?></b>
            </p>
            <br>
            <table>
                <thead>
                    <tr>
                        <th >Uds</th>
                        <th>Descripcion</th>
                        <th>$</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($this->sales->listDetail($id->id) as $r ) {?>
                    <tr>
                        <td class="quantity"><?php echo $r->qty ?></td>
                        <td class="description"><?php echo $r->description ?></td>
                        <td class="price"><?php echo $r->price ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="2">TOTAL</th>
                        <td class="price"><?php echo $id->cash ?></td>
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
        <button id="btnPrint" class="hidden-print">Print</button>
        <script src="script.js"></script>
    </body>
</html>

<script>
  const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});
</script>