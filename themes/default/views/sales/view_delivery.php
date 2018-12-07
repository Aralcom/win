<?php defined('BASEPATH') OR exit('No direct script access allowed');
$box_products = array();
$sub_box_number = 0;
foreach($rows as $row){
    $product_id = $row->product_id;
    $query = $this->db->query("SELECT box_status,breadth,box_quantity FROM `sma_products` WHERE id='$product_id'");
    $product_detail = $query->row_array();
    $dt_quantity = $row->quantity;
	$dt_quantity = str_replace(',','',$dt_quantity);
    if($product_detail){
        if($product_detail['box_status'] == 1 && $dt_quantity >= $product_detail['box_quantity']){
            
            $box_number = $dt_quantity/$product_detail['box_quantity'];
            $extra_number = 0;
            if(strpos($box_number,'.') !== false){
                $box_number = explode('.',$box_number)[0];
                $extra_number = $dt_quantity - ($box_number*$product_detail['box_quantity']);
                if($product_detail['breadth'] && $product_detail['breadth'] != 0){
                    $sub_box_number = $extra_number/$product_detail['breadth'];
                    if(strpos($sub_box_number,'.') !== false){
                        $sub_box_number = explode('.',$sub_box_number)[0];
                        $extra_number = $extra_number - ($sub_box_number*$product_detail['breadth']);
                    }
                    else {
                        $extra_number = 0;
                    }
                }
            }
            $data_box = array(
                'name'=>$row->product_name,
                'box_number'=>$box_number,
                'sub_box_number'=>$sub_box_number,
                'extra_number'=>$extra_number
                );
            array_push($box_products, $data_box);
        }
        
    }
}
?>

<div class="modal-dialog modal-lg no-modal-header">

    <div class="modal-content">

        <div class="modal-body">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                <i class="fa fa-2x">&times;</i>

            </button>

            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">

                <i class="fa fa-print"></i> <?= lang('print'); ?>

            </button>

            <?php if ($logo) { ?>

                <div class="text-center" style="margin-bottom:20px;">

                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"

                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">

                </div>

            <?php } ?>

            <div class="table-responsive">

                <table class="table table-bordered">



                    <tbody>

                    <tr>

                        <td width="30%"><?= lang("date"); ?></td>

                        <td width="70%"><?= $this->sma->hrld($delivery->date); ?></td>

                    </tr>

                    <tr>

                        <td><?= lang("do_reference_no"); ?></td>

                        <td><?= $delivery->do_reference_no; ?></td>

                    </tr>

                    <tr>

                        <td><?= lang("sale_reference_no"); ?></td>

                        <td><?= $delivery->sale_reference_no; ?></td>

                    </tr>

                    <tr>

                        <td><?= lang("customer"); ?></td>

                        <td><?= $delivery->customer; ?></td>

                    </tr>

                    <tr>

                        <td><?= lang("address"); ?></td>

                        <td><?= $delivery->address; ?></td>

                    </tr>

                    <tr>

                        <td><?= lang("status"); ?></td>

                        <td><?= lang($delivery->status); ?></td>

                    </tr>

                    <?php if ($delivery->note) { ?>

                        <tr>

                            <td><?= lang("note"); ?></td>

                            <td><?= $this->sma->decode_html($delivery->note); ?></td>

                        </tr>

                    <?php } ?>

                    </tbody>



                </table>

            </div>

            <h3><?= lang("items"); ?></h3>

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-striped">

                    <thead>

                        <tr>

                            <th style="text-align:center; vertical-align:middle;"><?= lang("no"); ?></th>

                            <th style="vertical-align:middle;"><?= lang("description"); ?></th>

                            <th style="text-align:center; vertical-align:middle;"><?= lang("quantity"); ?></th>

                        </tr>

                    </thead>



                    <tbody>



                    <?php $r = 1;

                    foreach ($rows as $row): ?>

                        <tr>

                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>

                            <td style="vertical-align:middle;">

                                <?= $row->product_code ." - " .$row->product_name .($row->variant ? ' (' . $row->variant . ')' : '');

                                if ($row->details) {

                                    echo '<br><strong>' . lang("product_details") . '</strong> ' .

                                    html_entity_decode($row->details);

                                }

                                ?>

                            </td>

                            <td style="width: 150px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>

                        </tr>

                        <?php

                        $r++;

                    endforeach;

                    ?>

                    </tbody>

                </table>

            </div>

            <div class="clearfix"></div>



            <?php if ($delivery->status == 'delivered') { ?>

            <div class="row">

                <div class="col-xs-4">

                    <p><?= lang("prepared_by"); ?>:<br> <?= $user->first_name . ' ' . $user->last_name; ?> </p>

                </div>

                <div class="col-xs-4">

                    <p><?= lang("delivered_by"); ?>:<br> <?= $delivery->delivered_by; ?></p>

                </div>

                <div class="col-xs-4">

                    <p><?= lang("received_by"); ?>:<br> <?= $delivery->received_by; ?></p>

                </div>

            </div>

            <?php } else { ?>

            <div class="row">

                <div class="col-xs-4">

                    <p style="height:80px;"><?= lang("prepared_by"); ?>

                        : <?= $user->first_name . ' ' . $user->last_name; ?> </p>

                    <hr>

                    <p><?= lang("stamp_sign"); ?></p>

                </div>

                <div class="col-xs-4">

                    <p style="height:80px;"><?= lang("delivered_by"); ?>: </p>

                    <hr>

                    <p><?= lang("stamp_sign"); ?></p>

                </div>

                <div class="col-xs-4">

                    <p style="height:80px;"><?= lang("received_by"); ?>: </p>

                    <hr>

                    <p><?= lang("stamp_sign"); ?></p>

                </div>

            </div>

            <?php } ?>
            <div>
                <?php if(count($box_products)>0):?>
                    <table class="table table-striped table-condensed table-boxes">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Box(es)</th>
                                <th>Breadth</th>
                                <th>Extra Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($box_products as $box_product):?>
                            <tr>
                                <td><?php echo $box_product['name'];?></td>
                                <td align="center"><?php echo $box_product['box_number'];?></td>
                                <td align="center"><?php echo $box_product['sub_box_number'];?></td>
                                <td align="center"><?php echo $box_product['extra_number'];?></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>



        </div>

    </div>

</div>



