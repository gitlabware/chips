<div class="with-padding">
    <div class="columns">
        <div class="twelve-columns">
            <table class="simple-table responsive-table">
                <tbody>
                    <tr>
                        <th scope="row">Id</th>
                        <td><?php echo $chip['Chip']['id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha</th>
                        <td><?php echo $chip['Chip']['fecha']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Numero Telefono</th>
                        <td><?php echo $chip['Chip']['telefono']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Factura</th>
                        <td><?php echo $chip['Chip']['factura']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Caja</th>
                        <td><?php echo $chip['Chip']['caja']?></td>
                    </tr>
                    <tr>
                        <th scope="row">SIM</th>
                        <td><?php echo $chip['Chip']['sim']?></td>
                    </tr>
                    <tr>
                        <th scope="row">IMSI</th>
                        <td><?php echo $chip['Chip']['imsi']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tipo SIM</th>
                        <td><?php echo $chip['Chip']['tipo_sim']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Distribuidor</th>
                        <td><?php echo $chip['Chip']['distribuidor']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha de entrega distribuidor</th>
                        <td><?php echo $chip['Chip']['fecha_entrega_d']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Subdealer</th>
                        <td><?php echo $chip['Cliente']['cod_dealer'].'-'.$chip['Cliente']['nombre']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Mercado</th>
                        <td><?php echo $chip['Cliente']['mercado']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha entrega Cliente</th>
                        <td><?php echo $chip['Chip']['modified']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Fecha Activacion</th>
                        <td><?php echo $activacion['Activado']['fecha_act']?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>