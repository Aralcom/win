<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    @media print {
        #myModal .modal-content {
            display: none !important;
        }
    }
</style>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <!--<button onclick="return printReceipt()" class="btn btn-block btn-primary">Print</button>-->
        <div style="padding:5px; margin-top: 7px; margin-bottom: 21px; margin-right: 40px;">
        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="return printReceipt()"><i class="fa fa-print"></i> Print</button>
            </div>
                
        <div class="modal-body print" style="position: relative; padding: 15px;">
            <button style="float: right;" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
            <?php if ($logo) { ?>
                <!--<div class="text-center" style="margin-bottom:20px;">-->
                <img style="vertical-align: middle;" src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                     alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                <!--</div>-->
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10" style="margin-right: -15px; margin-left: -15px; padding: 10px 0 !important; width: 100%; display: table;">
                <div class="col-xs-5" style="width: 41.66666667%; float: left; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">
                    <?php echo $this->lang->line("to"); ?>:<br/>
                    <h2 style="font-size: 16px; line-height: 16px;     font-weight: bold;" class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                    <?= $customer->company ? "" : "Attn: " . $customer->name ?>
                    <?php
                    echo $customer->address . "<br />" . $customer->city . " " . $customer->postal_code . " " . $customer->state . "<br />" . $customer->country;
                    echo "<p>";
                    if ($customer->cf1 != "-" && $customer->cf1 != "") {
                        echo "<br>" . lang("ccf1") . ": " . $customer->cf1;
                    }
                    if ($customer->cf2 != "-" && $customer->cf2 != "") {
                        echo "<br>" . lang("ccf2") . ": " . $customer->cf2;
                    }
                    if ($customer->cf3 != "-" && $customer->cf3 != "") {
                        echo "<br>" . lang("ccf3") . ": " . $customer->cf3;
                    }
                    if ($customer->cf4 != "-" && $customer->cf4 != "") {
                        echo "<br>" . lang("ccf4") . ": " . $customer->cf4;
                    }
                    if ($customer->cf5 != "-" && $customer->cf5 != "") {
                        echo "<br>" . lang("ccf5") . ": " . $customer->cf5;
                    }
                    if ($customer->cf6 != "-" && $customer->cf6 != "") {
                        echo "<br>" . lang("ccf6") . ": " . $customer->cf6;
                    }
                    echo "</p>";
                    echo lang("tel") . ": " . $customer->phone . "<br />" . lang("email") . ": " . $customer->email;
                    ?>

                </div>
                <div class="col-xs-5" style="width: 41.66666667%; float: left; position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px;">
                    <?php echo $this->lang->line("from"); ?>:<br/>
                    <h2 style="font-size: 16px; line-height: 16px; font-weight: bold;" class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                    <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                    <?php
                    echo $biller->address . "<br />" . $biller->city . " " . $biller->postal_code . " " . $biller->state . "<br />" . $biller->country;
                    echo "<p>";
                    if ($biller->cf1 != "-" && $biller->cf1 != "") {
                        echo "<br>" . lang("bcf1") . ": " . $biller->cf1;
                    }
                    if ($biller->cf2 != "-" && $biller->cf2 != "") {
                        echo "<br>" . lang("bcf2") . ": " . $biller->cf2;
                    }
                    if ($biller->cf3 != "-" && $biller->cf3 != "") {
                        echo "<br>" . lang("bcf3") . ": " . $biller->cf3;
                    }
                    if ($biller->cf4 != "-" && $biller->cf4 != "") {
                        echo "<br>" . lang("bcf4") . ": " . $biller->cf4;
                    }
                    if ($biller->cf5 != "-" && $biller->cf5 != "") {
                        echo "<br>" . lang("bcf5") . ": " . $biller->cf5;
                    }
                    if ($biller->cf6 != "-" && $biller->cf6 != "") {
                        echo "<br>" . lang("bcf6") . ": " . $biller->cf6;
                    }
                    echo "</p>";
                    echo lang("tel") . ": " . $biller->phone . "<br />" . lang("email") . ": " . $biller->email;
                    ?>
                    <div class="clearfix"></div>
                </div>

            </div>
            <hr>
            <div class="row" style="margin-right: -15px;     margin-left: 10px;">
                <div class="col-sm-12">
                    <p style="font-weight:bold;"><?= lang("date"); ?>: <?= $this->sma->hrsd($payment->date); ?></p>
                    <p style="font-weight:bold;"><?= lang("sale").' '.lang('ref'); ?>: <?= $inv->reference_no; ?></p>
                    <p style="font-weight:bold;"><?= lang("payment_reference"); ?>: <?= $payment->reference_no; ?></p>
                </div>
            </div>
            <div class="well" style="border: 1px solid #ddd; background-color: #f6f6f6; box-shadow: none; border-radius: 0px; min-height: 20px; padding: 19px; margin-bottom: 20px;">
                <table class="table table-borderless" style="margin-bottom:0;">
                    <tbody>
                    <tr>
                        <td>
                            <strong><?= $payment->type == 'returned' ? lang("payment_returned") : lang("payment_received"); ?></strong>
                        </td>
                        <td class="text-right">
                            <strong class="text-right"><?php echo $this->sma->formatMoney($payment->amount); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("paid_by"); ?></strong></td>
                        <td class="text-right"><strong class="text-right"><?php echo lang($payment->paid_by);
                                if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe' || $payment->paid_by == 'authorize') {
                                    echo ' (' . substr($payment->cc_no, -4) . ')';
                                } elseif ($payment->paid_by == 'Cheque') {
                                    echo ' (' . $payment->cheque_no . ')';
                                }
                                ?></strong></td>
                    </tr>
                    <?php if ($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe' || $payment->paid_by == 'authorize') { ?>
                    <tr>
                        <td>
                            <strong><?= lang("name"); ?></strong>
                        </td>
                        <td class="text-right">
                            <strong class="text-right"><?= $payment->cc_holder; ?></strong>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if ($payment->paid_by == 'ppp' || $payment->paid_by == 'stripe' || $payment->paid_by == 'authorize') { ?>
                    <tr>
                        <td>
                            <strong><?= lang("transaction_id"); ?></strong>
                        </td>
                        <td class="text-right">
                            <strong class="text-right"><?= $payment->transaction_id; ?></strong>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2"><?= html_entity_decode($payment->note); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="clear: both;"></div>
            <div class="row">
                <div class="col-sm-4 pull-left">
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p style="border-bottom: 1px solid #666;">&nbsp;</p>

                    <p><?= lang("stamp_sign"); ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<script>
function printReceipt() 
{

  var divToPrint= $('.print').html(); 

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
    function printDiv() {
                var receipt_data = $('.print').html(); 
                var socket_data = {
                    'printer': <?= json_encode($printer); ?>,
                    'logo': '<?= !empty($biller->logo) ? $biller->logo : ''; ?>',
                    'text': receipt_data,
                    'cash_drawer': <?= isset($modal) ? 0 : 1; ?>, 'drawer_code': '<?= $pos_settings->cash_drawer_codes; ?>'
                };
                $.get('<?= site_url('pos/p'); ?>', {data: JSON.stringify(socket_data)});
                return false;
            }
</script>
<?php include 'remote_printing.php'; ?>