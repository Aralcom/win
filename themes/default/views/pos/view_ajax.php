<?php
// var_dump($customer_group_percent);
// var_dump($rows);
//var_dump($biller);
foreach($rows as $row)
{
    $product_id = $row->product_id;
    //echo $product_id;
    $query = $this->db->query("SELECT price FROM `sma_products` WHERE id='$product_id'");
    $product_price = $query->result_array();
    foreach($product_price as $prod)
    {
       // echo $prod['price'];
    }
   // echo $row->item_discount;
    
}
$box_products = array();
$sub_box_number = 0;
foreach($rows as $row){
    $product_id = $row->product_id;
    $query = $this->db->query("SELECT box_status,breadth,box_quantity FROM `sma_products` WHERE id='$product_id'");
    $product_detail = $query->row_array();
    $dt_quantity = $row->quantity;
	//var_dump($row->quantity);
	
	$dt_quantity = str_replace(',','',$dt_quantity);
    if($product_detail){
        if($product_detail['box_status'] == 1 && $dt_quantity >= $product_detail['box_quantity']){
        	
			
            $box_number = $dt_quantity/$product_detail['box_quantity'];
            $extra_number = 0;
            if(strpos($box_number,'.') !== false){
                $box_number = explode('.',$box_number)[0];
                $extra_number = $dt_quantity - ($box_number*$product_detail['box_quantity']);
                //var_dump($extra_number);
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
//echo $order_type_setting;
if(!empty($customer->active_field)){
	$active_field = json_decode($customer->active_field);
	
	$hide_email = $active_field->hide_email;
	$hide_phone = $active_field->hide_phone;
	$bar_code = $active_field->bar_code;
}else{
	$hide_email = 0;
	$hide_phone = 0;
	$bar_code = 0;
}
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="all">
    body { color: #000; }
    #wrapper { max-width: 480px; margin: 0 auto; padding-top: 20px; }
    .btn { border-radius: 0; margin-bottom: 5px; }
    .bootbox .modal-footer { border-top: 0; text-align: center; }
    h3 { margin: 5px 0; }
    .order_barcodes img { float: none !important; margin-top: 5px; }
    @media print {
        .no-print { display: none; }
        #wrapper { max-width: 480px; width: 100%; min-width: 250px; margin: 0 auto; }
        .no-border { border: none !important; }
        .border-bottom { border-bottom: 1px solid #ddd !important; }
    }
</style>
    <div id="wrapper">
        <div id="receiptData">
            <div class="no-print">
                <?php 
                if ($message) { 
                    ?>
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?=is_array($message) ? print_r($message, true) : $message;?>
                    </div>
                    <?php 
                } ?>
            </div>

            <div id="receipt-data">
                <div class="text-center">
                    <?php //= !empty($biller->logo) ? '<img src="'.base_url('assets/uploads/logos/'.$biller->logo).'" alt="">' : ''; ?>
           <?= !empty($biller->logo) ? '<img src="'.base_url('assets/uploads/logos/'.$biller->logo).'" alt="">' : ''; ?>

                    <h3 style="text-transform:uppercase;"><?=$biller->company != '-' ? $biller->company : $biller->name;?></h3>
                    <?php

                    echo "<p>" . $biller->address . " " . $biller->city . " " . $biller->postal_code . " " . $biller->state . " " . $biller->country .
                    "<br>" . lang("tel") . ": " . $biller->phone;
                    // echo $biller->address;
                    // comment or remove these extra info if you don't need

                    if (!empty($biller->cf1) && $biller->cf1 != "-") {
                        echo "<br>" . lang("bcf1") . ": " . $biller->cf1;
                    }
                    if (!empty($biller->cf2) && $biller->cf2 != "-") {
                        echo "<br>" . lang("bcf2") . ": " . $biller->cf2;
                    }
                    if (!empty($biller->cf3) && $biller->cf3 != "-") {
                        echo "<br>" . lang("bcf3") . ": " . $biller->cf3;
                    }
                    if (!empty($biller->cf4) && $biller->cf4 != "-") {
                        echo "<br>" . lang("bcf4") . ": " . $biller->cf4;
                    }
                    if (!empty($biller->cf5) && $biller->cf5 != "-") {
                        echo "<br>" . lang("bcf5") . ": " . $biller->cf5;
                    }
                    if (!empty($biller->cf6) && $biller->cf6 != "-") {
                        echo "<br>" . lang("bcf6") . ": " . $biller->cf6;
                    }
                    // end of the customer fields

                  //  echo "<br>";
                    if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") {
                        echo $pos_settings->cf_title1 . ": " . $pos_settings->cf_value1 . "<br>";
                    }
                    if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") {
                        echo $pos_settings->cf_title2 . ": " . $pos_settings->cf_value2 . "<br>";
                    }
                    echo '</p>';
                    ?>
                </div>

                <?php
//echo '<pre>';
//var_dump($customer);
                if ($Settings->invoice_view == 1) {
                    ?>
                    <div class="col-sm-12 text-center">
                        <h4 style="font-weight:bold;"><?=lang('tax_invoice');?></h4>
                    </div>
                    <?php 
                }
                echo "<p>";
                if($table){
                        echo lang("table") . ": " . $table->table_name.'<br>';
                    }
                echo lang("date") . " : " . $this->sma->hrld($inv->date) . "<br>";
                echo lang("sale_no_ref") . " : " . $inv->reference_no . "<br>";
                if (!empty($inv->return_sale_ref)) {
                    echo '<p>'.lang("return_ref").' : '.$inv->return_sale_ref;
                    if ($inv->return_id) {
                        echo ' <a data-target="#myModal2" data-toggle="modal" href="'.site_url('sales/modal_view/'.$inv->return_id).'"><i class="fa fa-external-link no-print"></i></a><br>';
                    } else {
                        echo '</p>';
                    }
                }
               
                echo lang("sales_person") . ": " . $created_by->first_name." ".$created_by->last_name . "</p>";
                echo "<p>";
                echo lang("customer") . ": " . ($customer->company && $customer->company != '-' ? $customer->company : $customer->name) . "<br>";
                if ($pos_settings->customer_details) {
                    if ($customer->vat_no != "-" && $customer->vat_no != "") {
                        echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                    }
                    echo lang("tel") . ": " . $customer->phone . "<br>";
                    echo lang("address") . ": " . $customer->address . "<br>";
                    echo $customer->city ." ".$customer->state." ".$customer->country ."<br>";
                    if (!empty($customer->cf1) && $customer->cf1 != "-") {
                        echo "<br>" . lang("ccf1") . ": " . $customer->cf1;
                    }
                    if (!empty($customer->cf2) && $customer->cf2 != "-") {
                        echo "<br>" . lang("ccf2") . ": " . $customer->cf2;
                    }
                    if (!empty($customer->cf3) && $customer->cf3 != "-") {
                        echo "<br>" . lang("ccf3") . ": " . $customer->cf3;
                    }
                    if (!empty($customer->cf4) && $customer->cf4 != "-") {
                        echo "<br>" . lang("ccf4") . ": " . $customer->cf4;
                    }
                    if (!empty($customer->cf5) && $customer->cf5 != "-") {
                        echo "<br>" . lang("ccf5") . ": " . $customer->cf5;
                    }
                    if (!empty($customer->cf6) && $customer->cf6 != "-") {
                        echo "<br>" . lang("ccf6") . ": " . $customer->cf6;
                    }
                }
                echo "</p>";
                ?>
                <!--end  -->

                <div style="clear:both;"></div>
<?php
//echo '<pre>';
//var_dump($rows);
?>
                <table class="table table-striped table-condensed">
                    <tbody>
                        <?php

                        $r = 1; 
                    $category = 0;
                    $tax_summary = array();
                    $totalQuantity = 0;
$calculated_full_total_price = 0;
                    foreach ($rows as $row) {
                        $total_calculated_unit_price = $row->net_unit_price;
if($customer_group_percent){
$total_calculated_unit_price = (100 / ( 100 + $customer_group_percent )) * $row->net_unit_price;
}else{
$total_calculated_unit_price = $row->net_unit_price;
}
                        if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                            $category = $row->category_id;
                            echo '<tr><td colspan="100%" class="no-border"><strong>'.$row->category_name.'</strong></td></tr>';
                        }
                        if (isset($tax_summary[$row->tax_code])) {
                            $tax_summary[$row->tax_code]['items'] += $row->quantity;
                            $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                            $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                        } else {
                            $tax_summary[$row->tax_code]['items'] = $row->quantity;
                            $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                            $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                            $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                            $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                            $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                        }
                        $totalQuantity += $row->quantity;
                        echo '<tr><td colspan="2" class="no-border">
						<div style="width:40%;float: left;">#' . $r . ': &nbsp;&nbsp;' . product_name($row->product_name) . ($row->variant ? ' (' . $row->variant . ')' : '') . '</div>
						<div style="width:30%;float: left; text-align:right;">' . $this->sma->formatQuantity($row->quantity) . ' x ';
	if ($row->item_discount != 0) {
		echo '<del>' . $this->sma->formatMoney($row->net_unit_price + ($row->item_discount / $row->quantity) + ($row->item_tax / $row->quantity)) . '</del> ';
	}
                        echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity));
                        $dis_total_price = ($row->net_unit_price + ($row->item_tax / $row->quantity)) * $row->quantity;
						$full_total_price = ($total_calculated_unit_price + ($row->item_tax / $row->quantity)) * $row->quantity;
						echo '</div>
						<div style="width:10%;float: left;"></div>
						<div style="width:30%;float: left;"><span class="pull-right">'. $this->sma->formatMoney($dis_total_price) .' ' . ($row->tax_code ? '*'.$row->tax_code : '') . '</span>
						</div></td></tr>';
                      /*  echo '<tr><td class="no-border border-bottom">' . $this->sma->formatQuantity($row->quantity) . ' x ';
                        if ($row->item_discount != 0) {
                            echo '<del>' . $this->sma->formatMoney($row->net_unit_price + ($row->item_discount / $row->quantity) + ($row->item_tax / $row->quantity)) . '</del> ';
                        }
                        //echo $this->sma->formatMoney($total_calculated_unit_price + ($row->item_tax / $row->quantity));
                        echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity));
                            //echo '('.$this->sma->formatMoney($total_calculated_unit_price).' + '.$this->sma->formatMoney($row->item_tax / $row->quantity) . ')';
                            //echo '</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
                        $dis_total_price = ($row->net_unit_price + ($row->item_tax / $row->quantity)) * $row->quantity;
$full_total_price = ($total_calculated_unit_price + ($row->item_tax / $row->quantity)) * $row->quantity;
echo '</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($dis_total_price) . '</td></tr>';
*/
		if($customer_group_percent){
		$calculated_full_total_price += $full_total_price;
		} 
                        $r++;
                    }
                    if ($return_rows) {
                        echo '<tr class="warning"><td colspan="100%" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
                        foreach ($return_rows as $row) {
                            if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                                $category = $row->category_id;
                                echo '<tr><td colspan="100%" class="no-border"><strong>'.$row->category_name.'</strong></td></tr>';
                            }
                            if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                            } else {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                            }
                            echo '<tr><td colspan="2" class="no-border">#' . $r . ': &nbsp;&nbsp;' . product_name($row->product_name) . ($row->variant ? ' (' . $row->variant . ')' : '') . '<span class="pull-right">' . ($row->tax_code ? '*'.$row->tax_code : '') . '</span></td></tr>';
                            echo '<tr><td class="no-border border-bottom">' . $this->sma->formatQuantity($row->quantity) . ' x ';

                            if ($row->item_discount != 0) {
                                echo '<del>' . $this->sma->formatMoney($row->net_unit_price + ($row->item_discount / $row->quantity) + ($row->item_tax / $row->quantity)) . '</del> ';
                            }
                            echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)) . '</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';

                           
$r++;
                        }
                    }
                        ?>
                    </tbody>
                    <tfoot>
<?php
if($customer_group_percent){
$total_without_discount = $return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax);
?>
                        <tr>
                            <th><?php  echo lang("Discount");?></th>
                            <?php
//echo $calculated_full_total_price;

                            
                            ?>
                            <th class="text-right"><?php echo ($calculated_full_total_price - $total_without_discount); ?></th>
                        </tr>
<?php
}
?>
                        <tr>
                            <th><?=lang("total");?></th>
                            <th class="text-right"><?=$this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax));?></th>
                        </tr>
                        <?php
                        if ($inv->order_tax != 0) {
                            echo '<tr><th>' . lang("tax") . '</th><th class="text-right">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
                        }
                        if ($inv->order_discount != 0) {
                            echo '<tr><th>' . lang("order_discount") . '</th><th class="text-right">' . $this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                        }

                        if ($inv->shipping != 0) {
                            echo '<tr><th>' . lang("shipping") . '</th><th class="text-right">' . $this->sma->formatMoney($inv->shipping) . '</th></tr>';
                        }

                        if ($return_sale) {
                            if ($return_sale->surcharge != 0) {
                                echo '<tr><th>' . lang("order_discount") . '</th><th class="text-right">' . $this->sma->formatMoney($return_sale->surcharge) . '</th></tr>';
                            }
                        }

                        if ($pos_settings->rounding || $inv->rounding > 0) {
                            ?>
                            <tr>
                                <th><?=lang("rounding");?></th>
                                <th class="text-right"><?= $this->sma->formatMoney($inv->rounding);?></th>
                            </tr>
                           
                            <tr>
                                <th><?=lang("grand_total");?></th>
                                <th class="text-right" id="gTotal"><?=$this->sma->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));?></th>
                            </tr>
                            <?php 
                        } else {
                            ?>
 <tr>
                        <th><?=lang("quantity");?></th>
                        <th class="text-right" id="qTotal"><?= $totalQuantity;?></th>
                    </tr>
                            <tr>
                                <th><?=lang("grand_total");?></th>
                                <th class="text-right" id="gTotal"><?=$this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);?></th>
                            </tr>
                            <?php 
                        } 
                        if ($inv->paid < $inv->grand_total) {
                            ?>
                            <tr>
                                <th><?=lang("paid_amount");?></th>
                                <th class="text-right"><?=$this->sma->formatMoney($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid);?></th>
                            </tr>
                            <tr>
                                <th><?=lang("due_amount");?></th>
                                <th id="current_due" class="text-right"><?=$this->sma->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid));?></th>
                            </tr>
                            <?php 
                        } ?>
                        
<tr>
                                    <th><?= $Settings->text_total_bal; ?><? //= lang('total') . ' ' . lang("balance"); ?></th>
                                    <th class="text-right"> <p id="total_blanceV"></p></th>
                                </tr>
                                <tr>
                                    <th><?= $Settings->text_grand_total; ?><? //= lang("grand_total"); ?> </th>
                                    <th class="text-right">
                                        <p id="oCurrency"></p>
                                    </th>
                                </tr>
                    </tfoot>
                </table>
<?php if(empty($connect_jquery)): ?>

           <!-- <script type="text/javascript" src="<?=$assets?>pos/js/jquery-1.7.2.min.js"></script>-->
            <?php endif; ?>
 
                <?php
                if ($payments) {
                    echo '<table class="table table-striped table-condensed"><tbody>';
                    foreach ($payments as $payment) {
                        echo '<tr>';
                        if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                        } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                            echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                        } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                        } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("no") . ': ' . $payment->cc_no . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                        } elseif ($payment->paid_by == 'other' && $payment->amount) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                        }
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }

                if ($return_payments) {
                    echo '<strong>'.lang('return_payments').'</strong><table class="table table-striped table-condensed"><tbody>';
                    foreach ($return_payments as $payment) {
                        $payment->amount = (0-$payment->amount);
                        echo '<tr>';
                        if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                        } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                            echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                        } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                        } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("no") . ': ' . $payment->cc_no . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                        } elseif ($payment->paid_by == 'other' && $payment->amount) {
                            echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                            echo '<td>' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                            echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                        }
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }

                if ($Settings->invoice_view == 1) {
                    if (!empty($tax_summary)) {
                        echo '<h4 style="font-weight:bold;">' . lang('tax_summary') . '</h4>';
                        echo '<table class="table table-condensed"><thead><tr><th>' . lang('name') . '</th><th>' . lang('code') . '</th><th>' . lang('qty') . '</th><th>' . lang('tax_excl') . '</th><th>' . lang('tax_amt') . '</th></tr></td><tbody>';
                        foreach ($tax_summary as $summary) {
                            echo '<tr><td>' . $summary['name'] . '</td><td class="text-center">' . $summary['code'] . '</td><td class="text-center">' . $this->sma->formatQuantity($summary['items']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['amt']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
                        }
                        echo '</tbody></tfoot>';
                        echo '<tr><th colspan="4" class="text-right">' . lang('total_tax_amount') . '</th><th class="text-right">' . $this->sma->formatMoney($return_sale ? $inv->product_tax+$return_sale->product_tax : $inv->product_tax) . '</th></tr>';
                        echo '</tfoot></table>';
                    }
                }
                ?>

                <?= $customer->award_points != 0 && $Settings->each_spent > 0 ? '<p class="text-center">'.lang('this_sale').': '.floor(($inv->grand_total/$Settings->each_spent)*$Settings->ca_point)
                .'<br>'.
                lang('total').' '.lang('award_points').': '. $customer->award_points . '</p>' : ''; ?>
                <?= $inv->note ? '<p class="text-center">' . $this->sma->decode_html($inv->note) . '</p>' : ''; ?>
                <?= $inv->staff_note ? '<p class="no-print"><strong>' . lang('staff_note') . ':</strong> ' . $this->sma->decode_html($inv->staff_note) . '</p>' : ''; ?>

                <?= $biller->invoice_footer ? '<p class="text-center">'.$this->sma->decode_html($biller->invoice_footer).'</p>' : ''; ?>
            </div>
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
			<?php
			if($bar_code == 0){
			?>
            <div class="order_barcodes text-center">
                <?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>
                <br>
                <?= $this->sma->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
            </div>
            <?php
			}
			?>
            <div style="clear:both;"></div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#email').click(function () {
                bootbox.prompt({
                    title: "<?= lang("email_address"); ?>",
                    inputType: 'email',
                    value: "<?= $customer->email; ?>",
                    callback: function (email) {
                        if (email != null) {
                            $.ajax({
                                type: "post",
                                url: "<?= site_url('pos/email_receipt') ?>",
                                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: <?= $inv->id; ?>},
                                dataType: "json",
                                success: function (data) {
                                    bootbox.alert({message: data.msg, size: 'small'});
                                },
                                error: function () {
                                    bootbox.alert({message: '<?= lang('ajax_request_failed'); ?>', size: 'small'});
                                    return false;
                                }
                            });
                        }
                    }
                });
                return false;
            });
        });

        <?php
        if ($pos_settings->remote_printing == 1) {
            ?>
            $(window).load(function () {
               // window.print();
                return false;
            });
            <?php
        }
        ?>

    </script>
    <?php /* include FCPATH.'themes'.DIRECTORY_SEPARATOR.$Settings->theme.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pos'.DIRECTORY_SEPARATOR.'remote_printing.php'; */ ?>
    <?php include 'remote_printing.php'; ?>
    <?php
    if($modal) {
        ?>
    </div>
</div>
</div>
<?php 
} else {
    ?>
<script>
                            $(document).ready(function () {
                                    

                                $.ajax({url: "<?= site_url('reports/getSalesReport/?customer=' . $customer->id) ?>", success: function (result) {
                                        var rSult = JSON.parse(result);
                                        if (result) {
                                            var len = rSult.aaData.length;
                                            var txt = 0;
                                            if (len > 0) {
                                                for (var i = 0; i < len; i++) {
                                                    txt += Number(rSult.aaData[i][7]);
                                                }
                                                $("#total_blanceV").html(format_num(txt));
                                                var ele = $('#current_due');

                                                // if(ele.length)
                                                // {
                                                    var current_due = ele.length ? parseFloat(ele.html().replace(',','')) : 0;
                                                    var previous_due = format_num(txt - current_due);
                                                    $("#total_blanceV").closest('tr').before('<tr><th><?=lang("previous_due")?></th><th class="text-right">'+previous_due+'</th></tr>');
                                                //$("#previous_due").html();    
                                                // }
                                                
                                            }
                                        }
                                    }
                                });
                                        var gTotala=$('#gTotal').text();
                                        var gTotal=parseFloat(gTotala.replace(',','').replace(' ',''))
                                       // alert(gTotal);

                                $.ajax({url: "<?= site_url('reports/restCurrency/') ?>", success: function (result) {
                                        var oCur = JSON.parse(result);
                                        //console.log(JSON.stringify(oCur));
                                        if (result) {
                                            var len = oCur.length;
                                            var oCurT = '';

                                            if (len > 0) {
                                                for (var i = 0; i < len; i++) {

                 oCurT +='<div style="float:right; margin-left:10px;">'+oCur[i].code+': '+parseFloat( oCur[i].rate * gTotal ).toFixed(2)+'</div>';
                                                }
                                                $('#oCurrency').html(oCurT);
                                                     window.print();
                                              //  $("#total_blanceV").html(format_num(txt));
                                            }
                                        }
                                    }
                                });

                            });

                            function format_num(yourNumber) {
                                yourNumber = yourNumber.toFixed(2);
                                //Seperates the components of the number
                                var n = yourNumber.toString().split(".");
                                //Comma-fies the first part
                                n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                //Combines the two sections
                                return n.join(".");
                            }
                        </script>

<script type="text/javascript">
    function sendSMS(obj){
        var sale_id = '<?php echo $sid;?>';
        $.ajax({
                    type: "get",
                    url: "<?=site_url('pos3/sendSMS/')?>" + sale_id,
                    dataType: "json",
                    success: function (data) {
                        
                    }
                });

    }

</script>

<?php
}
?>
</body>
</html>
