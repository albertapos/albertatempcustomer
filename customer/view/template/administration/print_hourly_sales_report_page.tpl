<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<table border="0" width = "100%;">
    <thead>
        <tr>
            <th>
                <p><b>Date :</b><?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?></p>
                <div class="col-md-4">
                    <p><b>Store Name: </b><?php echo $storename; ?></p>
                </div>
                <div class="col-md-4">
                    <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
                </div>
                <div class="col-md-4">
                    <p><b>Store Phone: </b><?php echo $storephone; ?></p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Hourly Sales</td>
                            <td class="text-right"><b>Amount</b></td>
                        </tr>
                        <?php foreach($report_hourly as $r) { ?>
                            <tr>
                                <td><?php echo isset($r['Hours']) ? $r['Hours']: 0; ?></td>
                                <td class='text-right'><?php echo isset($r['Amount']) ? $r['Amount']: 0; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </td>

        </tr>

    </tbody>
</table>

<style type="text/css">

table {            
    page-break-after: always;
    page-break-inside: avoid;
    break-inside: avoid;
}

tr{border:1pt solid;}

</style>
