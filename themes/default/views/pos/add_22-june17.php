<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>
<?=lang('pos_module') . " | " . $Settings->site_name;?>
</title>
<script type="text/javascript">if(parent.frames.length !== 0){top.location = '<?=site_url('pos')?>';}</script>
<base href="<?=base_url()?>"/>
<meta http-equiv="cache-control" content="max-age=0"/>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="expires" content="0"/>
<meta http-equiv="pragma" content="no-cache"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?=$assets?>images/icon.png"/>
<link rel="stylesheet" href="<?=$assets?>styles/theme.css" type="text/css"/>
<link rel="stylesheet" href="<?=$assets?>styles/style.css" type="text/css"/>
<link rel="stylesheet" href="<?=$assets?>pos/css/posajax.css" type="text/css"/>
<link rel="stylesheet" href="<?=$assets?>pos/css/print.css" type="text/css" media="print"/>
<!-- <script type="text/javascript" src="<?=$assets?>js/jquery-2.0.3.min.js"></script> -->
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="<?=$assets?>js/jquery-migrate-1.2.1.min.js"></script>
<!--[if lt IE 9]>
        <script src="<?=$assets?>js/jquery.js"></script>
        <![endif]-->
<?php if ($Settings->user_rtl) {?>
<link href="<?=$assets?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
<link href="<?=$assets?>styles/style-rtl.css" rel="stylesheet"/>
<script type="text/javascript">
                $(document).ready(function () {
                    $('.pull-right, .pull-left').addClass('flip');
                });
            </script>
<?php }
        ?>
        <link type="text/css" rel="stylesheet" href="http://layout.jquery-dev.net/lib/css/layout-default-latest.css" />
<style>

 
 /* div#container {

    background:  #000;

    height:    100%;

    margin:    0 auto;

    width:    100%;

    max-width:  900px;

    min-width:  700px;

    _width:    700px; 

  }*/
  .pane {

   /*display:  none;  will appear when layout inits */

  }
</style>
<script type="text/javascript" src="http://layout.jquery-dev.net/lib/js/jquery-ui-latest.js"></script>
      <script type="text/javascript" src="<?=$assets?>/jquery.layout-latest.js"></script>
      <script type="text/javascript">
 $(document).ready(function(){
                
                //resize_able
                $('#container').layout();
              });
                </script>
</head>
<body>
<noscript>
<div class="global-site-notice noscript">
  <div class="notice-inner">
    <p><strong>JavaScript seems to be disabled in your browser.</strong><br>
      You must have JavaScript enabled in
      your browser to utilize the functionality of this website.</p>
  </div>
</div>
</noscript>
<div id="wrapper"> 
  <!-- <header id="header" class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?=site_url()?>"><span class="logo"><span class="pos-logo-lg"><?=$Settings->site_name?></span><span class="pos-logo-sm"><?=lang('pos')?></span></span></a>

            <div class="header-nav">
                

                

                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown">
                        <a class="btn bblack" style="cursor: default;"><span id="display_time"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </header> -->
  <div id="content">
    <div class="c1">
      <div class="pos">
        <?php
                        if ($error) {
                            echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>";
                        }
                    ?>
        <?php
                        if ($message) {
                            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
                        }
                    ?>
        <div id="pos">
          <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form');
                        echo form_open("pos", $attrib);?>
          <div class="row" id="container">
            <?php /*<div class="col-sm-4" id="leftdiv2" class="pos-box">*/ ?>
            <div class="col-sm-4 pos-box pane ui-layout-west" id="leftdiv2" >
            <!-- <div class="row"> -->
            <div class="col-sm-12" id="calculator">
              <h1><a href="<?=site_url()?>" class="pos-header">
                <?=$Settings->site_name?>
                </a> <small><a href="<?= site_url('logout'); ?>"> <i class="fa fa-sign-out"></i>
                <?= lang('logout'); ?>
                </a></small></h1>
              <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading"> <a href="#calulatorBox" data-toggle="collapse">
                    <h4 class="panel-title">
                      <?=lang('product_list')?>
                    </h4>
                    </a> </div>
                  <div id="calulatorBox" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <div id="item-list"> <?php echo $products; ?> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end #calculator -->
            
            <div class="col-sm-12" id="customerDetail">
              <div class="panel-group" id="detailGroup">
                  <ul id="sortable">
                  <li class="ui-state-default" id="short_left_1">
                    <div class="panel panel-default">
                      <div class="panel-heading"> <a href="#customerInfo" data-toggle="collapse" data-parent="#detailGroup">
                        <h4 class="panel-title">
                          <?=lang('customer_detail')?>
                        </h4>
                        </a> </div>
                      <div id="customerInfo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="media">
                            <div class="media-body">
                              <h4 class="media-heading" id="gkClientName"></h4>
                              <h4>
                                <?=lang('id')?>
                              </h4>
                              <p class="" id="gkId"><strong></strong></p>
                              <h4>
                                <?=lang('address')?>
                              </h4>
                              <p class="" id="gkAddress"><strong></strong></p>
                              <h4>
                                <?=lang('phone')?>
                              </h4>
                              <p class="" id="gkPhone"><strong></strong></p>
                              <h4>
                                <?=lang('mail')?>
                              </h4>
                              <p class="" id="gkMail"><strong></strong></p>
                            </div>
                            <div class="media-right"> <img id="customerImage" src="<?=site_url('assets/uploads/no_image.png')?>" class="media-object" style="width: 100px;"> </div>
                          </div>
                            <div class="form-group">
                              <?php
                                                                         echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ""), 'id="poscustomer" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("customer") . '" required="required" class="form-control pos-input-tip" style="width:100%;" value="'.$customer->id.'"');
                                                                  ?>
                            </div>
                          <div class="row">
                            <div class="col-xs-6">
                              <button type="button" id="toogle-customer-read-attr" class="btn btnicon fullWidth" title="<?=lang('change_customer')?>"> <i class="fa fa-pencil"></i> </button>
                            </div>
                            <?php if ($Owner || $Admin || $GP['customers-add']) { ?>
                            <div class="col-xs-6"> <a href="<?=site_url('customers/add');?>" id="add-customer" class="btn btnicon fullWidth" data-toggle="modal" data-target="#myModal" title="<?=lang('add_new_customer')?>"> <i class="fa fa-user-plus"></i> </a> </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="ui-state-default">  
                    <!--select table  start-->
                    <div class="panel panel-default" id="short_left_2">
                      <div class="panel-heading"> <a href="#tableInfo" data-toggle="collapse" data-parent="#detailGroup">
                        <h4 class="panel-title">
                          <?=lang('table_detail')?>
                        </h4>
                        </a> </div>
                      <div id="tableInfo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="media">
                            <div class="media-body">
                            <!--
                            -->
                              <div id="tableId">
                              <p id=""><strong>Table not selected yet</strong></p>
                              </div>
                              <div style="display: none;" id="tableId_view">
                              <!--
                            -->
                                  <h4 class="media-heading" id="gkTableName"><strong></strong></h4>
                                  <h4>
                                    
                                  </h4>
                                  <p class="" id="gkno_of_guest"><strong></strong></p>
                                  <h4>
                                    
                                  </h4>
                                  <p class="" id="gkTableAddress"><strong></strong></p>
                                  <h4>
                                    
                                  </h4>
                                  <p class="" id="gkTablePhone"><strong></strong></p>
                                  <h4>
                                    
                                  </h4>
                                  <p class="" id="gkTableMail"><strong></strong></p>
                              </div>
                            </div>
                            <div class="media-right"> <img id="tableImage" src="<?=site_url('assets/uploads/no_image.png')?>" class="media-object" style="width: 100px;"> </div>
                          </div>
                            <div class="form-group">
                              <?php
                              echo form_input('table', (isset($_POST['table']) ? $_POST['table'] : ""), 'id="postable" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("table") . '" required="required" class="form-control pos-input-tip" style="width:100%;" value=""');
                                                                  ?>
                            </div>
                          <div class="row">
                            <div class="col-xs-6">
                              <button type="button" id="toogle-table-read-attr" class="btn btnicon fullWidth" title="<?=lang('change_customer')?>"> <i class="fa fa-pencil"></i> </button>
                            </div>
                            <?php if ($Owner || $Admin || $GP['customers-add']) { ?>
                            <div class="col-xs-6"> <a href="<?=site_url('customers/add');?>" id="add-customer" class="btn btnicon fullWidth" data-toggle="modal" data-target="#myModal" title="<?=lang('add_new_customer')?>"> <i class="fa fa-user-plus"></i> </a> </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="ui-state-default" id="short_left_3">  
                    <!-- select table end-->
                    <div class="panel panel-default">
                      <div class="panel-heading"> <a href="#productInfo" data-toggle="collapse" data-parent="#detailGroup">
                        <h4 class="panel-title">
                          <?=lang('product_detail')?>
                        </h4>
                        </a> </div>
                      <div id="productInfo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="media">
                            <div class="media-left media-top"> <img id="productImage" src="<?=site_url('assets/uploads/no_image.png')?>" class="media-object" style="width:100px" > </div>
                            <div class="media-body">
                              <h3 class="media-heading" id="productQuantity"></h3>
                              <p><strong id="productName"></strong></p>
                              <p id="productId"><strong>Product not added yet</strong></p>
                              <p>Net Unit Rate: <strong id="productPrice"></strong></p>
                            </div>
                          </div>
                        </div>
                        <!-- end .panel-body --> 
                      </div>
                      <!-- end #productInfo --> 
                    </div>
                  </li>  
                <!-- end .panel --> 
                  </ul>
              </div>
              <!-- end .panel-group --> 
            </div>
            <!-- end #customerDetail --> 
            
            <!-- </div> --> 
            <!-- end .row --> 
          </div>
          <!-- end #leftdiv2 --> 
          
          <!--left strat-->
          <?php /*<div class="col-sm-5" id="leftdiv" class="pos-box">*/?>
          <div class="col-sm-5 pos-box pane ui-layout-center" id="leftdiv" >
          
          <div id="printhead">
            <h4 style="text-transform:uppercase;"><?php echo $Settings->site_name; ?></h4>
            <?php
                                echo "<h5 style=\"text-transform:uppercase;\">" . $this->lang->line('order_list') . "</h5>";
                                echo $this->lang->line("date") . " " . $this->sma->hrld(date('Y-m-d H:i:s'));
                            ?>
          </div>
          <div id="left-top">
            <div style="position: absolute; <?=$Settings->user_rtl ? 'right:-9999px;' : 'left:-9999px;';?>"> <?php echo form_input('test', '', 'id="test" class="kb-pad"'); ?> </div>
            <div class="no-print">
              <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) {
                                ?>
              <div class="form-group">
                <?php
                                    $wh[''] = '';
                                    foreach ($warehouses as $warehouse) {
                                        $wh[$warehouse->id] = $warehouse->name;
                                    }
                                    echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse), 'id="poswarehouse" class="form-control pos-input-tip" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" style="width:100%;" ');
                                ?>
              </div>
              <?php } else {
                                    $warehouse_input = array(
                                        'type' => 'hidden',
                                        'name' => 'warehouse',
                                        'id' => 'poswarehouse',
                                        'value' => $this->session->userdata('warehouse_id'),
                                    );
                                    echo form_input($warehouse_input);
                                }
                                ?>
              <div class="form-group" id="ui">
                <?php if ($Owner || $Admin || $GP['products-add']) { ?>
                <div class="input-group"> <?php echo form_input('add_item', '', 'class="form-control pos-tip" id="add_item" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("search_product_by_name_code") . '" title="' . $this->lang->line("au_pr_name_tip") . '"'); ?>
                  <div class="input-group-addon" style="padding: 2px 8px;"> <a href="#" id="addManually"> <i class="fa fa-plus-circle" id="addIcon" style="font-size: 1.5em;"></i> </a> </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <!-- end #left-top -->
          <div id="print">
            <div id="left-middle">
              <div id="product-list">
                <table class="table items table-striped table-bordered table-condensed table-hover sortable_table"
                                               id="posTable" style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th width="40%"><?=lang("product");?></th>
                      <th width="15%"><?=lang("price");?></th>
                      <th width="15%"><?=lang("qty");?></th>
                      <th width="20%"><?=lang("subtotal");?></th>
                      <th style="width: 5%; text-align: center;"> <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i> </th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <div style="clear:both;"></div>
              </div>
            </div>
            <div style="clear:both;"></div>
            <div id="left-bottom" class="table-responsive">
              <table id="totalTable"
                                           style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                <tr id="customer_group_discount_view" style="">
                  <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Group Name</td>
                  <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;"><span id="customer_group_name"></span></td>
                  <td style="padding: 5px 10px;border-top: 1px solid #DDD;">Group Discount</td>
                  <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;"><span id="customer_group_discount">0.00</span></td>
                </tr>
                <tr>
                  <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('items');?></td>
                  <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;"><span id="titems">0</span></td>
                  <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('total');?></td>
                  <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;"><span id="total">0.00</span></td>
                </tr>
                <tr>
                  <td style="padding: 5px 10px;"><?=lang('order_tax');?>
                    <a href="#" id="pptax2"> <i class="fa fa-edit"></i> </a></td>
                  <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;"><span id="ttax2">0.00</span></td>
                  <td style="padding: 5px 10px;"><?=lang('discount');?>
                    <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
                    <a href="#" id="ppdiscount"> <i class="fa fa-edit"></i> </a>
                    <?php } ?></td>
                  <td class="text-right" style="padding: 5px 10px;font-weight:bold;"><span id="tds">0.00</span></td>
                </tr>
                <tr>
                  <td style="padding: 5px 4px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2"><?=lang('total_payable');?></td>
                  <td class="text-right" style="padding:5px 2px 5px 5px; font-size: 38px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2"><span id="gtotal">0.00</span></td>
                </tr>
              </table>
              <div class="clearfix"></div>
              <div style="clear:both; height:5px;"></div>
              <div id="num">
                <div id="icon"></div>
              </div>
              <span id="hidesuspend"></span>
              <input type="hidden" name="pos_note" value="" id="pos_note">
              <input type="hidden" name="staff_note" value="" id="staff_note">
              <div id="payment-con">
                <?php for ($i = 1; $i <= 5; $i++) {?>
                <input type="hidden" name="amount[]" id="amount_val_<?=$i?>" value=""/>
                <input type="hidden" name="balance_amount[]" id="balance_amount_<?=$i?>" value=""/>
                <input type="hidden" name="paid_by[]" id="paid_by_val_<?=$i?>" value="cash"/>
                <input type="hidden" name="cc_no[]" id="cc_no_val_<?=$i?>" value=""/>
                <input type="hidden" name="paying_gift_card_no[]" id="paying_gift_card_no_val_<?=$i?>" value=""/>
                <input type="hidden" name="cc_holder[]" id="cc_holder_val_<?=$i?>" value=""/>
                <input type="hidden" name="cheque_no[]" id="cheque_no_val_<?=$i?>" value=""/>
                <input type="hidden" name="cc_month[]" id="cc_month_val_<?=$i?>" value=""/>
                <input type="hidden" name="cc_year[]" id="cc_year_val_<?=$i?>" value=""/>
                <input type="hidden" name="cc_type[]" id="cc_type_val_<?=$i?>" value=""/>
                <input type="hidden" name="cc_cvv2[]" id="cc_cvv2_val_<?=$i?>" value=""/>
                <input type="hidden" name="payment_note[]" id="payment_note_val_<?=$i?>" value=""/>
                <?php }
                                        ?>
              </div>
              <input name="order_tax" type="hidden" value="<?=$suspend_sale ? $suspend_sale->order_tax_id : $Settings->default_tax_rate2;?>" id="postax2">
              <input name="discount" type="hidden" value="<?=$suspend_sale ? $suspend_sale->order_discount_id : '';?>" id="posdiscount">
              <input type="hidden" name="rpaidby" id="rpaidby" value="cash" style="display: none;"/>
              <input type="hidden" name="total_items" id="total_items" value="0" style="display: none;"/>
              <input type="hidden" name="today_peruse" id="today_peruse_elec" value="0" style="display: none;"/>
              <input type="hidden" name="today_peruse_date" id="today_peruse_date_elec" value="0" style="display: none;"/>
              <input type="hidden" name="quick_pay_action" id="quick_pay_action" value="0" />
              <input type="submit" id="submit_sale" value="Submit Sale" style="display: none;"/>
            </div>
          </div>
          <!-- #print --> 
        </div>
        <!-- end #leftdiv --> 
        <!--left end-->
        
     <?php /*<div class="col-sm-3" id="" class="pos-box">*/ ?>
      <div class="pane ui-layout-north">North</div>

  <div class="pane ui-layout-south">South</div>
        <div class="col-sm-3 pos-box pane ui-layout-east" id="rightBox">  
        
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading"> <a href="#moreOptions" data-toggle="collapse">
              <h4 class="panel-title">
                <?=lang('payment_options')?>
              </h4>
              </a> </div>
            <div id="moreOptions" class="panel-collapse collapse in">
              <div class="panel-body">
                <input type="hidden" name="biller" id="biller" value="<?= ($Owner || $Admin || !$this->session->userdata('biller_id')) ? $pos_settings->default_biller : $this->session->userdata('biller_id')?>"/>
                <button type="button" class="btn pos-tip btnicon3" id="suspend" title="<?=lang('suspend'); ?>"> <img src="<?=$assets?>images/suspend.png" > </button>
                <button type="button" class="btn pos-tip btnicon3" id="print_order" title="<?=lang('order');?>"> <img src="<?=$assets?>images/order.png" > </button>
                <button type="button" class="btn pos-tip btnicon3" id="print_bill" title="<?=lang('bill');?>"> <img src="<?=$assets?>images/bill.png" > </button>
                <?php if ($Owner || $Admin || $GP['sales-add_gift_card']) {?>
                <button class="btn pos-tip btnicon3 fullWidth" type="button" id="sellGiftCard" title="<?=lang('sell_gift_card')?>"> <img src="<?=$assets?>images/Gift_card.png" >
                <?//=lang('sell_gift_card')?>
                </button>
                <?php } ?>
                <button type="button" class="btn pos-tip btnicon3" id="payment" title="<?=lang("payment")?>" style="width:64%;"> <i class="fa fa-money" style="margin-right: 5px;"></i>
                <?=lang('payment');?>
                </button>
                <button type="button" class="btn pos-tip btnicon3" id="reset" title="<?= lang('cancel'); ?>" style="width:33.3%; background: red;"> <img src="<?=$assets?>images/cancel.png" > </button>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-heading"> <a href="#settingsButtons" data-toggle="collapse">
              <h4 class="panel-title">
                <?=lang('settings')?>
              </h4>
              </a> </div>
            <div id="settingsButtons" class="panel-collapse collapse in">
              <div class="panel-body"> 
                <!-- #1 --> 
                <a class="btn pos-tip btnicon" title="<?=lang('dashboard')?>" data-placement="bottom" href="<?=site_url('welcome')?>" target="_blank"> <i class="fa fa-tachometer" aria-hidden="true"></i> </a> 
                
                <!-- #2 --> 
                <a class="btn pos-tip btnicon" id="add_expense" title="<?=lang('add_expense')?>" data-placement="bottom" data-html="true" href="<?=site_url('purchases/add_expense')?>" data-toggle="modal" data-target="#myModal"> <i class="fa fa-dollar"></i> </a> 
                
                <!-- #3 --> 
                <a class="btn pos-tip btnicon" title="<?=lang('shortcuts')?>" data-placement="bottom" href="#" data-toggle="modal" data-target="#sckModal"> <i class="fa fa-key"></i> </a> 
                
                <!-- #4 --> 
                <a class="btn pos-tip btnicon" title="<?=lang('view_bill_screen')?>" data-placement="bottom" href="<?=site_url('pos/view_bill')?>" target="_blank"> <i class="fa fa-laptop"></i> </a> 
                
                <!-- #5 --> 
                <a class="btn pos-tip btnicon" id="opened_bills" title="<?=lang('suspended_sales')?>" data-placement="bottom" data-html="true" href="<?=site_url('pos/opened_bills')?>" data-toggle="ajax"> <i class="fa fa-th"></i> </a> 
                
                <!-- #6 --> 
                <a class="btn pos-tip btnicon" id="register_details" title="<?=lang('register_details')?>" data-placement="bottom" data-html="true" href="<?=site_url('pos/register_details')?>" data-toggle="modal" data-target="#myModal"> <i class="fa fa-check-circle"></i> </a> 
                
                <!-- #7 --> 
                <a class="btn pos-tip btnicon" id="close_register" title="<?=lang('close_register')?>" data-placement="bottom" data-html="true" href="<?=site_url('pos/close_register')?>" data-toggle="modal" data-target="#myModal"> <i class="fa fa-times-circle"></i> </a>
                <?php if ($Owner) {?>
                <!-- #8 --> 
                <a class="btn pos-tip btnicon" title="<?=lang('pos_settings')?>" data-placement="bottom" href="<?=site_url('pos/settings')?>" data-html="true" data-toggle="ajax"> <i class="fa fa-cogs"></i> </a> 
                
                <!-- #9 --> 
                <a class="btn pos-tip btnicon" id="today_profit" title="<?=lang('today_profit')?>" data-placement="bottom" data-html="true" href="<?=site_url('reports/profit')?>" data-toggle="modal" data-target="#myModal"> <i class="fa fa-hourglass-half"></i> </a>
                <?php } ?>
                
                <!-- #10 -->
                <button type="button" id="open-brands" class="btn pos-tip open-brands btnicon " style="font-size:13px; padding-top:7px;" title="<?= lang('brands'); ?>"> <img src="<?=$assets?>images/brand.png" class="open-pic"> </button>
                
                <!-- #11 -->
                <button type="button" id="open-subcategory" class="btn pos-tip open-subcategory btnicon" style="font-size:13px; padding-top:7px;" title="<?= lang('sub_cat'); ?>"> <img src="<?=$assets?>images/subcategory.png" class="open-pic"> </button>
                
                <!-- #12 -->
                <button type="button" id="open-category" class="btn pos-tip open-category btnicon" style="font-size:13px; padding-top:7px;" title="<?=lang('cate'); ?>"> <img src="<?=$assets?>images/category.png" class="open-pic"> </button>
                <?php if ($Owner || $Admin) {?>
                <!-- #13 --> 
                <a class="btn bdarkGreen pos-tip btnicon" id="today_sale" title="<?=lang('today_sale')?>" data-placement="bottom" data-html="true" href="<?=site_url('pos/today_sale')?>" data-toggle="modal" data-target="#myModal"> <i class="fa fa-heart"></i> </a> 
                <!-- #14 --> 
                <a class="btn bblue pos-tip btnicon" title="<?=lang('list_open_registers')?>" data-placement="bottom" href="<?=site_url('pos/registers')?>" data-html="true" data-toggle="ajax"> <i class="fa fa-list"></i> </a> 
                <!-- #15 --> 
                <a class="btn bred pos-tip btnicon" title="<?=lang('clear_ls')?>" data-placement="bottom" id="clearLS" href="#"> <i class="fa fa-eraser"></i> </a>
                <?php } ?>
                
                <!-- #16 --> 
                <a class="btn pos-tip btnicon fullWidth" title="<?=lang('calculator')?>" data-placement="bottom" href="#" data-toggle="dropdown" > <i class="fa fa-calculator"></i> </a>
                <div class="dropdown-menu calc">
                  <div class="dropdown-content"> <span id="inlineCalc"></span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end #rightbox --> 
    </div>
    <!-- end .row -->
    
    </form>
    <!-- form close --> 
    
  </div>
  <!-- end #pos --> 
  
</div>
<!-- end .pos -->
</div>
<!-- end .c1 -->
</div>
<!-- end #content -->
</div>
<!-- end #wrapper -->

<div id="brands-slider">
  <div id="brands-list">
    <?php
                foreach ($brands as $brand) {
                    echo "<button id=\"brand-" . $brand->id . "\" type=\"button\" value='" . $brand->id . "' class=\"btn-prni brand\" ><img src=\"assets/uploads/thumbs/" . ($brand->image ? $brand->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $brand->name . "</span></button>";
                }
            ?>
  </div>
</div>
<div id="category-slider">
  <div id="category-list">
    <?php
                
                foreach ($categories as $category) {
                    echo "<button id=\"category-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni category\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
                }
            
            ?>
  </div>
</div>
<div id="subcategory-slider">
  <div id="subcategory-list">
    <?php
                if (!empty($subcategories)) {
                    foreach ($subcategories as $category) {
                        echo "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
                    }
                }
            ?>
  </div>
</div>
<div class="modal" id="cmModal" tabindex="-1" role="dialog" aria-labelledby="cmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span> <span class="sr-only">
        <?=lang('close');?>
        </span> </button>
        <h4 class="modal-title" id="cmModalLabel"></h4>
      </div>
      <div class="modal-body" id="pr_popover_content">
        <div class="form-group">
          <?= lang('comment', 'icomment'); ?>
          <?= form_textarea('comment', '', 'class="form-control" id="icomment" style="height:80px;"'); ?>
        </div>
        <div class="form-group">
          <?= lang('ordered', 'iordered'); ?>
          <?php
                    $opts = array(0 => lang('no'), 1 => lang('yes'));
                    ?>
          <?= form_dropdown('ordered', $opts, '', 'class="form-control" id="iordered" style="width:100%;"'); ?>
        </div>
        <input type="hidden" id="irow_id" value=""/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editComment">
        <?=lang('submit')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
         aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></span><span class="sr-only">
        <?=lang('close');?>
        </span></button>
        <h4 class="modal-title" id="payModalLabel">
          <?=lang('finalize_sale');?>
        </h4>
      </div>
      <div class="modal-body" id="payment_content">
        <div class="row">
          <div class="col-md-10 col-sm-9">
            <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
            <div class="form-group">
              <?=lang("biller", "biller");?>
              <?php
                                        foreach ($billers as $biller) {
                                           $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                        }
                                        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $pos_settings->default_biller), 'class="form-control" id="posbiller" required="required"');
                                    ?>
            </div>
            <?php } else {
                                    $biller_input = array(
                                        'type' => 'hidden',
                                        'name' => 'biller',
                                        'id' => 'posbiller',
                                        'value' => $this->session->userdata('biller_id'),
                                    );

                                    echo form_input($biller_input);
                                }
                            ?>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <?=form_textarea('sale_note', '', 'id="sale_note" class="form-control kb-text skip" style="height: 100px;" placeholder="' . lang('sale_note') . '" maxlength="250"');?>
                </div>
                <div class="col-sm-6">
                  <?=form_textarea('staffnote', '', 'id="staffnote" class="form-control kb-text skip" style="height: 100px;" placeholder="' . lang('staff_note') . '" maxlength="250"');?>
                </div>
              </div>
            </div>
            <div class="clearfir"></div>
            <div id="payments">
              <div class="well well-sm well_1">
                <div class="payment">
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <?=lang("amount", "amount_1");?>
                        <input name="amount[]" type="text" id="amount_1"
                                                           class="pa form-control kb-pad1 amount"/>
                      </div>
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                      <div class="form-group">
                        <?=lang("paying_by", "paid_by_1");?>
                        <select name="paid_by[]" id="paid_by_1" class="form-control paid_by">
                          <?= $this->sma->paid_opts(); ?>
                          <?=$pos_settings->paypal_pro ? '<option value="ppp">' . lang("paypal_pro") . '</option>' : '';?>
                          <?=$pos_settings->stripe ? '<option value="stripe">' . lang("stripe") . '</option>' : '';?>
                          <?=$pos_settings->authorize ? '<option value="authorize">' . lang("authorize") . '</option>' : '';?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-11">
                      <div class="form-group gc_1" style="display: none;">
                        <?=lang("gift_card_no", "gift_card_no_1");?>
                        <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1"
                                                           class="pa form-control kb-pad gift_card_no"/>
                        <div id="gc_details_1"></div>
                      </div>
                      <div class="pcc_1" style="display:none;">
                        <div class="form-group">
                          <input type="text" id="swipe_1" class="form-control swipe"
                                                               placeholder="<?=lang('swipe')?>"/>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <input name="cc_no[]" type="text" id="pcc_no_1"
                                                                       class="form-control"
                                                                       placeholder="<?=lang('cc_no')?>"/>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input name="cc_holer[]" type="text" id="pcc_holder_1"
                                                                       class="form-control"
                                                                       placeholder="<?=lang('cc_holder')?>"/>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <select name="cc_type[]" id="pcc_type_1"
                                                                        class="form-control pcc_type"
                                                                        placeholder="<?=lang('card_type')?>">
                                <option value="Visa">
                                <?=lang("Visa");?>
                                </option>
                                <option
                                                                        value="MasterCard">
                                <?=lang("MasterCard");?>
                                </option>
                                <option value="Amex">
                                <?=lang("Amex");?>
                                </option>
                                <option
                                                                        value="Discover">
                                <?=lang("Discover");?>
                                </option>
                              </select>
                              <!-- <input type="text" id="pcc_type_1" class="form-control" placeholder="<?=lang('card_type')?>" />--> 
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input name="cc_month[]" type="text" id="pcc_month_1"
                                                                       class="form-control"
                                                                       placeholder="<?=lang('month')?>"/>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input name="cc_year" type="text" id="pcc_year_1"
                                                                       class="form-control"
                                                                       placeholder="<?=lang('year')?>"/>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input name="cc_cvv2" type="text" id="pcc_cvv2_1"
                                                                       class="form-control"
                                                                       placeholder="<?=lang('cvv2')?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="pcheque_1" style="display:none;">
                        <div class="form-group">
                          <?=lang("cheque_no", "cheque_no_1");?>
                          <input name="cheque_no[]" type="text" id="cheque_no_1"
                                                               class="form-control cheque_no"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <?=lang('payment_note', 'payment_note');?>
                        <textarea name="payment_note[]" id="payment_note_1"
                                                              class="pa form-control kb-text payment_note"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="multi-payment"></div>
            <button type="button" class="btn btn-primary col-md-12 addButton"><i
                                    class="fa fa-plus"></i>
            <?=lang('add_more_payments')?>
            </button>
            <div style="clear:both; height:15px;"></div>
            <div class="font16">
              <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                <tbody id="finalize_sale_total">
                  <tr class="nonRemovable">
                    <td width="25%"><?=lang("total_items");?></td>
                    <td width="25%" class="text-right"><span id="item_count">0.00</span></td>
                    <td width="25%"><?=lang("total_payable");?></td>
                    <td width="25%" class="text-right"><span id="twt">0.00</span></td>
                  </tr>
                  <tr class="nonRemovable">
                    <td><?=lang("total_paying");?></td>
                    <td class="text-right"><span id="total_paying">0.00</span></td>
                    <td><?=lang("balance");?></td>
                    <td class="text-right"><span id="balance">0.00</span></td>
                  </tr>
                </tbody>
              </table>
              <div class="clearfix"></div>
            </div>
            <!-- <div class='clearfix  add-curr curr' id="oCurrency" style="">
                                        </div> --> 
          </div>
          <div class="col-md-2 col-sm-3 text-center hidden-xs"> <span style="font-size: 1.2em; font-weight: bold;">
            <?=lang('quick_cash');?>
            </span>
            <div class="btn-group btn-group-vertical">
              <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00 </button>
              <?php
                                    foreach (lang('quick_cash_notes') as $cash_note_amount) {
                                        echo '<button type="button" class="btn btn-lg btn-warning quick-cash">' . $cash_note_amount . '</button>';
                                    }
                                ?>
              <button type="button" class="btn btn-lg btn-danger"
                                        id="clear-cash-notes">
              <?=lang('clear');?>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-block btn-lg btn-primary" id="submit-sale">
        <?=lang('submit');?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></span><span class="sr-only">
        <?=lang('close');?>
        </span></button>
        <h4 class="modal-title" id="prModalLabel"></h4>
      </div>
      <div class="modal-body" id="pr_popover_content">
        <form class="form-horizontal" role="form">
          <?php if ($Settings->tax1) {
                            ?>
          <div class="form-group">
            <label class="col-sm-4 control-label">
              <?=lang('product_tax')?>
            </label>
            <div class="col-sm-8">
              <?php
                                        $tr[""] = "";
                                            foreach ($tax_rates as $tax) {
                                                $tr[$tax->id] = $tax->name;
                                            }
                                            echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                        ?>
            </div>
          </div>
          <?php } ?>
          <?php if ($Settings->product_serial) { ?>
          <div class="form-group">
            <label for="pserial" class="col-sm-4 control-label">
              <?=lang('serial_no')?>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-text" id="pserial">
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="pquantity" class="col-sm-4 control-label">
              <?=lang('quantity')?>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="pquantity">
            </div>
          </div>
          <div class="form-group">
            <label for="punit" class="col-sm-4 control-label">
              <?= lang('product_unit') ?>
            </label>
            <div class="col-sm-8">
              <div id="punits-div"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="poption" class="col-sm-4 control-label">
              <?=lang('product_option')?>
            </label>
            <div class="col-sm-8">
              <div id="poptions-div"></div>
            </div>
          </div>
          <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
          <div class="form-group">
            <label for="pdiscount" class="col-sm-4 control-label">
              <?=lang('product_discount')?>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="pdiscount">
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="pprice" class="col-sm-4 control-label">
              <?=lang('unit_price')?>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="pprice" <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly'; ?>>
            </div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th style="width:25%;"><?=lang('net_unit_price');?></th>
              <th style="width:25%;"><span id="net_price"></span></th>
              <th style="width:25%;"><?=lang('product_tax');?></th>
              <th style="width:25%;"><span id="pro_tax"></span></th>
            </tr>
          </table>
          <input type="hidden" id="punit_price" value=""/>
          <input type="hidden" id="old_tax" value=""/>
          <input type="hidden" id="old_qty" value=""/>
          <input type="hidden" id="old_price" value=""/>
          <input type="hidden" id="row_id" value=""/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editItem">
        <?=lang('submit')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></button>
        <h4 class="modal-title" id="myModalLabel">
          <?=lang('sell_gift_card');?>
        </h4>
      </div>
      <div class="modal-body">
        <p>
          <?=lang('enter_info');?>
        </p>
        <div class="alert alert-danger gcerror-con" style="display: none;">
          <button data-dismiss="alert" class="close" type="button">×</button>
          <span id="gcerror"></span> </div>
        <div class="form-group">
          <?=lang("card_no", "gccard_no");?>
          *
          <div class="input-group"> <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"> <a href="#" id="genNo"><i class="fa fa-cogs"></i></a> </div>
          </div>
        </div>
        <input type="hidden" name="gcname" value="<?=lang('gift_card')?>" id="gcname"/>
        <div class="form-group">
          <?=lang("value", "gcvalue");?>
          * <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?> </div>
        <div class="form-group">
          <?=lang("price", "gcprice");?>
          * <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?> </div>
        <div class="form-group">
          <?=lang("customer", "gccustomer");?>
          <?php echo form_input('gccustomer', '', 'class="form-control" id="gccustomer"'); ?> </div>
        <div class="form-group">
          <?=lang("expiry_date", "gcexpiry");?>
          <?php echo form_input('gcexpiry', $this->sma->hrsd(date("Y-m-d", strtotime("+2 year"))), 'class="form-control date" id="gcexpiry"'); ?> </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="addGiftCard" class="btn btn-primary">
        <?=lang('sell_gift_card')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></span><span class="sr-only">
        <?=lang('close');?>
        </span></button>
        <h4 class="modal-title" id="mModalLabel">
          <?=lang('add_product_manually')?>
        </h4>
      </div>
      <div class="modal-body" id="pr_popover_content">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label for="mcode" class="col-sm-4 control-label">
              <?=lang('product_code')?>
              *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-text" id="mcode">
            </div>
          </div>
          <div class="form-group">
            <label for="mname" class="col-sm-4 control-label">
              <?=lang('product_name')?>
              *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-text" id="mname">
            </div>
          </div>
          <?php if ($Settings->tax1) {
                            ?>
          <div class="form-group">
            <label for="mtax" class="col-sm-4 control-label">
              <?=lang('product_tax')?>
              *</label>
            <div class="col-sm-8">
              <?php
                                        $tr[""] = "";
                                            foreach ($tax_rates as $tax) {
                                                $tr[$tax->id] = $tax->name;
                                            }
                                            echo form_dropdown('mtax', $tr, "", 'id="mtax" class="form-control pos-input-tip" style="width:100%;"');
                                        ?>
            </div>
          </div>
          <?php }
                        ?>
          <div class="form-group" style="display:none">
            <label for="mquantity" class="col-sm-4 control-label">
              <?=lang('quantity')?>
              *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="mquantity">
            </div>
          </div>
          <div class="form-group">
            <label for="mquantity" class="col-sm-4 control-label">Today Peruse No. *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" name="today_peruse_temp" id="today_peruse_temp" onblur="calculateTotalQuantity()">
              <p class="help-block">Previous Peruse No. : <?php echo $previouseSaleDetail->today_peruse?></p>
            </div>
          </div>
          <div class="form-group">
            <label for="mquantity" class="col-sm-4 control-label">Today Peruse Date </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" value="" id="today_peruse_date">
            </div>
          </div>
          <div class="form-group" style="display:none">
            <label for="mquantity" class="col-sm-4 control-label">Previous Peruse No. </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" value="<?php echo $previouseSaleDetail->today_peruse?>" id="previous_peruse_temp">
            </div>
          </div>
          <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {?>
          <div class="form-group">
            <label for="mdiscount"
                                       class="col-sm-4 control-label">
              <?=lang('product_discount')?>
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="mdiscount">
            </div>
          </div>
          <?php }
                        ?>
          <div class="form-group">
            <label for="mprice" class="col-sm-4 control-label">
              <?=lang('unit_price')?>
              *</label>
            <div class="col-sm-8">
              <input type="text" class="form-control kb-pad" id="mprice">
            </div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th style="width:25%;"><?=lang('net_unit_price');?></th>
              <th style="width:25%;"><span id="mnet_price"></span></th>
              <th style="width:25%;"><?=lang('product_tax');?></th>
              <th style="width:25%;"><span id="mpro_tax"></span></th>
            </tr>
          </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addItemManually">
        <?=lang('submit')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="sckModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"> <i class="fa fa-2x">&times;</i></span><span class="sr-only">
        <?=lang('close');?>
        </span> </button>
        <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();"> <i class="fa fa-print"></i>
        <?= lang('print'); ?>
        </button>
        <h4 class="modal-title" id="mModalLabel">
          <?=lang('shortcut_keys')?>
        </h4>
      </div>
      <div class="modal-body" id="pr_popover_content">
        <table class="table table-bordered table-striped table-condensed table-hover"
                           style="margin-bottom: 0px;">
          <thead>
            <tr>
              <th><?=lang('shortcut_keys')?></th>
              <th><?=lang('actions')?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?=$pos_settings->focus_add_item?></td>
              <td><?=lang('focus_add_item')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->add_manual_product?></td>
              <td><?=lang('add_manual_product')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->customer_selection?></td>
              <td><?=lang('customer_selection')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->add_customer?></td>
              <td><?=lang('add_customer')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->toggle_category_slider?></td>
              <td><?=lang('toggle_category_slider')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->toggle_subcategory_slider?></td>
              <td><?=lang('toggle_subcategory_slider')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->cancel_sale?></td>
              <td><?=lang('cancel_sale')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->suspend_sale?></td>
              <td><?=lang('suspend_sale')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->print_items_list?></td>
              <td><?=lang('print_items_list')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->finalize_sale?></td>
              <td><?=lang('finalize_sale')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->today_sale?></td>
              <td><?=lang('today_sale')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->open_hold_bills?></td>
              <td><?=lang('open_hold_bills')?></td>
            </tr>
            <tr>
              <td><?=$pos_settings->close_register?></td>
              <td><?=lang('close_register')?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-2x">&times;</i> </button>
        <h4 class="modal-title" id="dsModalLabel">
          <?=lang('edit_order_discount');?>
        </h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?=lang("order_discount", "order_discount_input");?>
          <?php echo form_input('order_discount_input', '', 'class="form-control kb-pad" id="order_discount_input"'); ?> </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="updateOrderDiscount" class="btn btn-primary">
        <?=lang('update')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="txModal" tabindex="-1" role="dialog" aria-labelledby="txModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></button>
        <h4 class="modal-title" id="txModalLabel">
          <?=lang('edit_order_tax');?>
        </h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?=lang("order_tax", "order_tax_input");?>
          <?php
        $tr[""] = "";
        foreach ($tax_rates as $tax) {
            $tr[$tax->id] = $tax->name;
        }
        echo form_dropdown('order_tax_input', $tr, "", 'id="order_tax_input" class="form-control pos-input-tip" style="width:100%;"');
    ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="updateOrderTax" class="btn btn-primary">
        <?=lang('update')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade in" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></button>
        <h4 class="modal-title" id="susModalLabel">
          <?=lang('suspend_sale');?>
        </h4>
      </div>
      <div class="modal-body">
        <p>
          <?=lang('type_reference_note');?>
        </p>
        <div class="form-group">
          <?=lang("reference_note", "reference_note");?>
          <?php echo form_input('reference_note', $reference_note, 'class="form-control kb-text" id="reference_note"'); ?> </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="suspend_sale" class="btn btn-primary">
        <?=lang('submit')?>
        </button>
      </div>
    </div>
  </div>
</div>
<div id="order_tbl"><span id="order_span"></span> <span style="text-align:center">
  <h4>Invoice No: <?php echo ($totalSaleCount->id + 1);?> <br/>
    Reference No: S/POS/00<?php echo ($totalSaleCount->id + 1);?></h4>
  </span>
  <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%">
  </table>
</div>
<div id="bill_tbl"><span id="bill_span"></span> <span style="text-align:center">
  <h4>Invoice No: <?php echo ($totalSaleCount->id + 1);?> <br/>
    Reference No: S/POS/00<?php echo ($totalSaleCount->id + 1);?></h4>
  </span>
  <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;">
  </table>
  <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%">
  </table>
</div>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true"></div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
         aria-hidden="true"></div>
<div id="modal-loading" style="display: none;">
  <div class="blackbg"></div>
  <div class="loader"></div>
</div>
<?php //var_dump($suspended_sale); ?>
<script>
        window.BASE_URL = '<?= site_url() ?>'
    </script>
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code);?>
<script type="text/javascript">
    var site = <?=json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats))?>, pos_settings = <?=json_encode($pos_settings);?>;
    var lang = {unexpected_value: '<?=lang('unexpected_value');?>', select_above: '<?=lang('select_above');?>', r_u_sure: '<?=lang('r_u_sure');?>', bill: '<?=lang('bill');?>', order: '<?=lang('order');?>'};
    </script> 
<script type="text/javascript">
        var product_variant = 0, shipping = 0, p_page = 0, per_page = 0, tcp = "<?=$tcp?>", pro_limit = <?= $pos_settings->pro_limit; ?>,
            brand_id = 0, obrand_id = 0, cat_id = "<?=$pos_settings->default_category?>", ocat_id = "<?=$pos_settings->default_category?>", sub_cat_id = 0, osub_cat_id,
            count = 1, an = 1, DT = <?=$Settings->default_tax_rate?>,
            product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0, total_discount = 0, total = 0, total_paid = 0, grand_total = 0,
            KB = <?=$pos_settings->keyboard?>, tax_rates =<?php echo json_encode($tax_rates); ?>;
        var protect_delete = <?php if (!$Owner && !$Admin) {echo $pos_settings->pin_code ? '1' : '0';} else {echo '0';} ?>
        //var audio_success = new Audio('<?=$assets?>sounds/sound2.mp3');
        //var audio_error = new Audio('<?=$assets?>sounds/sound3.mp3');
        var lang_total = '<?=lang('total');?>', lang_items = '<?=lang('items');?>', lang_discount = '<?=lang('discount');?>', lang_tax2 = '<?=lang('order_tax');?>', lang_total_payable = '<?=lang('total_payable');?>';
        var java_applet = <?=$pos_settings->java_applet?>, order_data = '', bill_data = '';
        function widthFunctions(e) {
            var wh = $(window).height(),
                lth = $('#left-top').height(),
                lbh = $('#left-bottom').height();
            
            $('#left-middle').css("height", wh - lth - lbh - 30);
            $('#left-middle').css("min-height", 265);
            $('#product-list').css("height", wh - lth - lbh - 37);
            $('#product-list').css("min-height", 265);
            
            // if($(window).width() <= 768)
            // {
            //     $('.panel-collapse:not(#calulatorBox)').removeClass('in').addClass('collapse');
            // }
            //var ch = $('#customerDetail').outerHeight(true),
                
                $('#calulatorBox').css("min-height", wh/2 - 50);
            
            $('#leftdiv2, #rightBox').css('height',wh);
        }
        
        $(document).ready(function () {
            $('#view-customer').click(function(){
                $('#myModal').modal({remote: site.base_url + 'customers/view/' + $("input[name=customer]").val()});
                $('#myModal').modal('show');
            });
            $('textarea').keydown(function (e) {
                if (e.which == 13) {
                   var s = $(this).val();
                   $(this).val(s+'\n').focus();
                   e.preventDefault();
                   return false;
                }
            });
            <?php if ($sid) {?>
            localStorage.setItem('positems', JSON.stringify(<?=$items;?>));
            <?php }
            ?>
    <?php if ($this->session->userdata('remove_posls')) {?>
            if (localStorage.getItem('positems')) {
                localStorage.removeItem('positems');
            }
            if (localStorage.getItem('posdiscount')) {
                localStorage.removeItem('posdiscount');
            }
            if (localStorage.getItem('postax2')) {
                localStorage.removeItem('postax2');
            }
            if (localStorage.getItem('posshipping')) {
                localStorage.removeItem('posshipping');
            }
            if (localStorage.getItem('poswarehouse')) {
                localStorage.removeItem('poswarehouse');
            }
            if (localStorage.getItem('posnote')) {
                localStorage.removeItem('posnote');
            }
            if (localStorage.getItem('poscustomer')) {
                localStorage.removeItem('poscustomer');
            }
            if (localStorage.getItem('postable')) {
                localStorage.removeItem('postable');
            }
            
            if (localStorage.getItem('posbiller')) {
                localStorage.removeItem('posbiller');
            }
            if (localStorage.getItem('poscurrency')) {
                localStorage.removeItem('poscurrency');
            }
            if (localStorage.getItem('posnote')) {
                localStorage.removeItem('posnote');
            }
            if (localStorage.getItem('staffnote')) {
                localStorage.removeItem('staffnote');
            }
            <?php $this->sma->unset_data('remove_posls');}
            ?>
            //widthFunctions();
            <?php if ($suspend_sale) {?>
            localStorage.setItem('postax2', '<?=$suspend_sale->order_tax_id;?>');
            localStorage.setItem('posdiscount', '<?=$suspend_sale->order_discount_id;?>');
            localStorage.setItem('poswarehouse', '<?=$suspend_sale->warehouse_id;?>');
            localStorage.setItem('poscustomer', '<?=$suspend_sale->customer_id;?>');
            localStorage.setItem('postable', '<?=$suspend_sale->customer_id;?>');
            localStorage.setItem('posbiller', '<?=$suspend_sale->biller_id;?>');
            <?php }
            ?>
           <?php if ($this->input->get('customer')) {?>
        
            if (!localStorage.getItem('positems')) {
                localStorage.setItem('poscustomer', <?=$this->input->get('customer');?>);
            } else if (!localStorage.getItem('poscustomer')) {
                localStorage.setItem('poscustomer', <?=$customer->id;?>);
            }
            <?php } else {?>
            if (!localStorage.getItem('poscustomer')) {
                localStorage.setItem('poscustomer', <?=$customer->id;?>);
            }
            <?php }
            ?>
            if (!localStorage.getItem('postax2')) {
                localStorage.setItem('postax2', <?=$Settings->default_tax_rate2;?>);
            }
            $('.select').select2({minimumResultsForSearch: 7});
           
            $('#poscustomer').val(localStorage.getItem('poscustomer')).select2({
                disabled : true,
                minimumInputLength: 1,
                data: [],
                initSelection: function (element, callback) {
                    $.ajax({
                        type: "get", async: false,
                        url: "<?=site_url('customers/getCustomer')?>/" + $(element).val(),
                        dataType: "json",
                        success: function (data) {
                            callback(data[0]);
                           $.ajax({
                                url : site.base_url + 'customers/customerDetail/' + $("input[name=customer]").val(),
                                type : 'get',
                                dataType : 'json',
                                success: function(res){
                                   // console.log(res);
                                    $('#gkClientName strong').html(res.customer.name);
                                    $('#gkPhone strong').html(res.customer.phone);
                                    $('#gkMail strong').html(res.customer.email);
                                    $('#gkId strong').html(res.customer.id);
                                    $('#gkAddress strong').html(res.customer.address + ', ' + res.customer.city + ', ' + res.customer.state + ', ' + res.customer.country + ', Pin - ' + res.customer.postal_code);
                                    $('#customerImage').attr('src','<?=site_url("assets/uploads/")?>' + res.customer.image);
                                    widthFunctions();
                                }
                            });
                        }
                    });
                },
                ajax: {
                    url: site.base_url + "customers/suggestions",
                    dataType: 'json',
                    quietMillis: 15,
                    data: function (term, page) {
                        return {
                            term: term,
                            limit: 10
                        };
                    },
                    results: function (data, page) {
                        if (data.results != null) {
                            return {results: data.results};
                        } else {
                            return {results: [{id: '', text: 'No Match Found'}]};
                        }
                    }
                }
            });

           

            $('#poscustomer').on('select2-close', function () {
                // $('.select2-input').removeClass('kb-text');
                // $('#test').click();
                $('select, .select').select2('destroy');
                $('select, .select').select2({minimumResultsForSearch: 7});
                if($('input[name=customer]').val() != '')
                    {
                        $.ajax({
                            url : site.base_url + 'customers/customerDetail/' + $("input[name=customer]").val(),
                            type : 'get',
                            dataType : 'json',
                            success: function(res){
                                //console.log(res);
                                $('#gkClientName strong').html(res.customer.name);
                                $('#gkPhone strong').html(res.customer.phone);
                                $('#gkMail strong').html(res.customer.email);
                                $('#gkId strong').html(res.customer.id);
                                $('#gkAddress strong').html(res.customer.address + ', ' + res.customer.city + ', ' + res.customer.state + ', ' + res.customer.country + ', Pin - ' + res.customer.postal_code);
                                $('#customerImage').attr('src','<?=site_url("assets/uploads/")?>' + res.customer.image);
                            }
                        });
                    }
            });
            
            // table  start
           // console.log(localStorage.getItem('postable'));
          // alert(localStorage.getItem('postable'));
           //alert(localStorage.getItem('poscustomer'));
            $('#postable').val(localStorage.getItem('postable')).select2({
                disabled : true,
                minimumInputLength: 1,
                data: [],
                initSelection: function (element, callback) {
                  //alert($(element).val());
                    $.ajax({
                        type: "get", async: false,
                        url: "<?=site_url('restaurant/getTable')?>/" + $(element).val(),
                        dataType: "json",
                        success: function (data) {

                            callback(data[0]);
                           $.ajax({
                                url : site.base_url + 'restaurant/tableDetail/' + $("input[name=table]").val(),
                                type : 'get',
                                dataType : 'json',
                                success: function(res){
                                    console.log(res);
                                    $('#tableId').hide();
                                    $('#tableId_view').show();
                                    $('#gkTableName strong').html('Name : '+res.table.table_name);
                                    $('#gkno_of_guest strong').html('No Of Guest : '+res.table.no_of_guest);
                                    
                                    //gkno_of_guest
                                    $('#gkTablePhone strong').html('Phone : '+res.table.phone);
                                    $('#gkTableMail strong').html('Email : '+res.table.email);
                                    //$('#gkId strong').html(res.table.id);
                                    $('#gkTableAddress strong').html('Address : '+res.table.address );
                                    $('#tableImage').attr('src','<?=site_url("assets/uploads/avatars/thumbs/")?>' + res.table.avatar);
                                    widthFunctions();
                                }
                            });
                        }
                    });
                },
                ajax: {
                    url: site.base_url + "restaurant/suggestions",
                    dataType: 'json',
                    quietMillis: 15,
                    data: function (term, page) {
                        return {
                            term: term,
                            limit: 10
                        };
                    },
                    results: function (data, page) {
                        if (data.results != null) {
                            return {results: data.results};
                        } else {
                            return {results: [{id: '', text: 'No Match Found'}]};
                        }
                    }
                }
            });

           

            $('#postable').on('select2-close', function () {
                
                $('select, .select').select2('destroy');
                $('select, .select').select2({minimumResultsForSearch: 7});
                if($('input[name=customer]').val() != '')
                    {
                        $.ajax({
                            url : site.base_url + 'restaurant/tableDetail/' + $("input[name=table]").val(),
                            type : 'get',
                            dataType : 'json',
                            success: function(res){
                                console.log(res);
                                $('#tableId').hide();
                                $('#tableId_view').show();
                                $('#gkTableName strong').html('Name : '+res.table.table_name);
                                 $('#gkno_of_guest strong').html('No Of Guest : '+res.table.no_of_guest);
                                $('#gkTablePhone strong').html('Phone : '+res.table.phone);
                                $('#gkTableMail strong').html('Email : '+res.table.email);
                                //$('#gkId strong').html(res.table.id);
                                $('#gkTableAddress strong').html('Address : '+res.table.address);
                                $('#tableImage').attr('src','<?=site_url("assets/uploads/avatars/thumbs/")?>' + res.table.avatar);
                            }
                        });
                    }
            });

            //table end
               

            $(document).on('change', '#posbiller', function () {
                $('#biller').val($(this).val());
            });

            <?php for ($i = 1; $i <= 5; $i++) {?>
            $('#paymentModal').on('change', '#amount_<?=$i?>', function (e) {
                $('#amount_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('blur', '#amount_<?=$i?>', function (e) {
                $('#amount_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('select2-close', '#paid_by_<?=$i?>', function (e) {
                $('#paid_by_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_no_<?=$i?>', function (e) {
                $('#cc_no_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_holder_<?=$i?>', function (e) {
                $('#cc_holder_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#gift_card_no_<?=$i?>', function (e) {
                $('#paying_gift_card_no_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_month_<?=$i?>', function (e) {
                $('#cc_month_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_year_<?=$i?>', function (e) {
                $('#cc_year_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_type_<?=$i?>', function (e) {
                $('#cc_type_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#pcc_cvv2_<?=$i?>', function (e) {
                $('#cc_cvv2_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#cheque_no_<?=$i?>', function (e) {
                $('#cheque_no_val_<?=$i?>').val($(this).val());
            });
            $('#paymentModal').on('change', '#payment_note_<?=$i?>', function (e) {
                $('#payment_note_val_<?=$i?>').val($(this).val());
            });
            <?php }
            ?>


            $('#payment').click(function () {
                <?php if ($sid) {?>
                suspend = $('<span></span>');
                suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" />');
                suspend.appendTo("#hidesuspend");
                <?php }
                ?>
                var twt = formatDecimal((total + invoice_tax) - order_discount);
                if (count == 1) {
                    bootbox.alert('<?=lang('x_total');?>');
                    return false;
                }


                $.ajax({url: BASE_URL+"/reports/restCurrenciesAll", success: function (result) {
                    var oCur = JSON.parse(result);

                    //$('#oCurrency').html(result);

                    var gTotala=$('#gtotal').text();
                    var gTotal=parseFloat(gTotala.replace(',','').replace(' ',''))


                    if (result) {
                        var len = oCur.length;
                        // alert(len);
                        var oCurT = '';

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                //oCurT +='<div class="curr_'+oCur[i].code+'"> <h2>'+oCur[i].code+': '+parseFloat(oCur[i].rate*gTotal).toFixed(2)+'</h2></div>';
                                oCurT += '<tr class="curr_'+oCur[i].code+'"><td colspan="3">'+oCur[i].code+'</td><td align="right">'+parseFloat(oCur[i].rate*gTotal).toFixed(2)+'</td></tr>';
                            }
                            //$('#oCurrency').html(oCurT);
                            $('#finalize_sale_total tr:not(.nonRemovable)').remove();
                            $('#finalize_sale_total tr:first-child').after(oCurT);

                            //  $("#total_blanceV").html(format_num(txt));
                        }
                    }
                }
                });





                gtotal = formatDecimal(twt);
                <?php if ($pos_settings->rounding) {?>
                round_total = roundNumber(gtotal, <?=$pos_settings->rounding?>);
                var rounding = formatDecimal(0 - (gtotal - round_total));
                $('#twt').text(formatMoney(round_total) + ' (' + formatMoney(rounding) + ')');
                $('#quick-payable').text(round_total);
                <?php } else {?>
                $('#twt').text(formatMoney(gtotal));
                $('#quick-payable').text(gtotal);
                <?php }
                ?>
                $('#item_count').text(count - 1);
                $('#paymentModal').appendTo("body").modal('show');
                $('#amount_1').focus();
            });
            $('#paymentModal').on('show.bs.modal', function(e) {
                $('#submit-sale').text('<?=lang('submit');?>').attr('disabled', false);
            });
            $('#paymentModal').on('shown.bs.modal', function(e) {
                $('#amount_1').focus();
            });
            var pi = 'amount_1', pa = 2;
            $(document).on('click', '.quick-cash', function () {
                var $quick_cash = $(this);
                var amt = $quick_cash.contents().filter(function () {
                    return this.nodeType == 3;
                }).text();
                var th = ',';
                var $pi = $('#' + pi);
                amt = formatDecimal(amt.split(th).join("")) * 1 + $pi.val() * 1;
                $pi.val(formatDecimal(amt)).focus();
                var note_count = $quick_cash.find('span');
                if (note_count.length == 0) {
                    $quick_cash.append('<span class="badge">1</span>');
                } else {
                    note_count.text(parseInt(note_count.text()) + 1);
                }
            });

          

            $(document).on('click', '#clear-cash-notes', function () {
                $('.quick-cash').find('.badge').remove();
                $('#' + pi).val('0').focus();
            });

            $(document).on('change', '.gift_card_no', function () {

                var cn = $(this).val() ? $(this).val() : '';
                var payid = $(this).attr('id'),
                    id = payid.substr(payid.length - 1);
                if (cn != '') {
                    cn = encodeURIComponent(cn);

                    $.ajax({
                        type: "get", async: false,
                        url: site.base_url + "pos/validate_gift_card/" + cn,
                        dataType: "json",
                        success: function (data) {
                            if (data === false) {
                                $('#gift_card_no_' + id).parent('.form-group').addClass('has-error');
                                bootbox.alert('<?=lang('incorrect_gift_card')?>');
                            } else if (data.customer_id !== null && data.customer_id !== $('#poscustomer').val()) {
                                $('#gift_card_no_' + id).parent('.form-group').addClass('has-error');
                                bootbox.alert('<?=lang('gift_card_not_for_customer')?>');
                            } else {
                                $('#gc_details_' + id).html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + data.balance + '</small>');
                                $('#gift_card_no_' + id).parent('.form-group').removeClass('has-error');
                                //calculateTotals();
                                $('#amount_' + id).val(gtotal >= data.balance ? data.balance : gtotal).focus();
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.addButton', function () {
                if (pa <= 5) {
                    $('#paid_by_1, #pcc_type_1').select2('destroy');
                    var phtml = $('#payments').html(),
                        update_html = phtml.replace(/_1/g, '_' + pa);
                    pi = 'amount_' + pa;
                    $('#multi-payment').append('<button type="button" class="close close-payment" style="margin: -10px 0px 0 0;"><i class="fa fa-2x">&times;</i></button>' + update_html);
                    $('#paid_by_1, #pcc_type_1, #paid_by_' + pa + ', #pcc_type_' + pa).select2({minimumResultsForSearch: 7});
                    read_card();
                    pa++;
                } else {
                    bootbox.alert('<?=lang('max_reached')?>');
                    return false;
                }
                display_keyboards();
                $('#paymentModal').css('overflow-y', 'scroll');
            });

            $(document).on('click', '.close-payment', function () {
                $(this).next().remove();
                $(this).remove();
                pa--;
            });

            $(document).on('focus', '.amount', function () {
                pi = $(this).attr('id');
                calculateTotals();
            }).on('blur', '.amount', function () {
                calculateTotals();
            });

            function calculateTotals() {
                var total_paying = 0;
                var ia = $(".amount");
                $.each(ia, function (i) {
                    var this_amount = formatCNum($(this).val() ? $(this).val() : 0);
                    total_paying += parseFloat(this_amount);
                });
                $('#total_paying').text(formatMoney(total_paying));
                <?php if ($pos_settings->rounding) {?>
                $('#balance').text(formatMoney(total_paying - round_total));
                $('#balance_' + pi).val(formatDecimal(total_paying - round_total));
                total_paid = total_paying;
                grand_total = round_total;
                <?php } else {?>
                $('#balance').text(formatMoney(total_paying - gtotal));
                $('#balance_' + pi).val(formatDecimal(total_paying - gtotal));
                total_paid = total_paying;

                grand_total = gtotal;
                <?php }
                ?>
            }

            $("#add_item").autocomplete({
                source: function (request, response) {
                    if (!$('#poscustomer').val()) {
                        $('#add_item').val('').removeClass('ui-autocomplete-loading');
                        bootbox.alert('<?=lang('select_above');?>');
                        //response('');
                        $('#add_item').focus();
                        return false;
                    }
                    $.ajax({
                        type: 'get',
                        url: '<?=site_url('sales/suggestions');?>',
                        dataType: "json",
                        data: {
                            term: request.term,
                            warehouse_id: $("#poswarehouse").val(),
                            customer_id: $("#poscustomer").val()
                        },
                        success: function (data) {
                           // console.log(data);
                            response(data);
                        }
                    });
                },
                minLength: 1,
                autoFocus: false,
                delay: 250,
                response: function (event, ui) {
                    if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                        bootbox.alert('<?=lang('no_match_found')?>', function () {
                            $('#add_item').focus();
                        });
                        $(this).val('');
                    }
                    else if (ui.content.length == 1 && ui.content[0].id != 0) {
                        ui.item = ui.content[0];
                        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    }
                    else if (ui.content.length == 1 && ui.content[0].id == 0) {
                        bootbox.alert('<?=lang('no_match_found')?>', function () {
                            $('#add_item').focus();
                        });
                        $(this).val('');

                    }
                },
                select: function (event, ui) {

                    event.preventDefault();
                    if (ui.item.id !== 0) {
                        var row = add_invoice_item(ui.item);
                        if (row)
                            $(this).val('');
                    } else {
                        bootbox.alert('<?=lang('no_match_found')?>');
                    }
                }
            });

            <?php if ($pos_settings->tooltips) {echo '$(".pos-tip").tooltip();';}
            ?>
            // $('#posTable').stickyTableHeaders({fixedOffset: $('#product-list')});
            $('#posTable').stickyTableHeaders({scrollableArea: $('#product-list')});
            $('#category-list, #subcategory-list').perfectScrollbar({suppressScrollX: true});
            $('select, .select').select2({minimumResultsForSearch: 7});

            $(document).on('click', '.product', function (e) {
                $('#modal-loading').show();
                code = $(this).val(),
                    wh = $('#poswarehouse').val(),
                    cu = $('#poscustomer').val();
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/getProductDataByCode')?>",
                    data: {code: code, warehouse_id: wh, customer_id: cu},
                    dataType: "json",
                    success: function (data) {
                        e.preventDefault();
                        if (data !== null) {
                            add_invoice_item(data);
                            $('#modal-loading').hide();
                        } else {
                            bootbox.alert('<?=lang('no_match_found')?>');
                            $('#modal-loading').hide();
                        }
                    }
                });
            });

            $(document).on('click', '.category', function () {
                if (cat_id != $(this).val()) {
                    $('#open-category').click();
                    $('#modal-loading').show();
                    cat_id = $(this).val();
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/ajaxcategorydata');?>",
                        data: {category_id: cat_id},
                        dataType: "json",
                        success: function (data) {
                            $('#item-list').empty();
                            var newPrs = $('<div></div>');
                            newPrs.html(data.products);
                            newPrs.appendTo("#item-list");
                            $('#subcategory-list').empty();
                            var newScs = $('<div></div>');
                            newScs.html(data.subcategories);
                            newScs.appendTo("#subcategory-list");
                            tcp = data.tcp;
                            nav_pointer();
                        }
                    }).done(function () {
                        p_page = 'n';
                        $('#category-' + cat_id).addClass('active');
                        $('#category-' + ocat_id).removeClass('active');
                        ocat_id = cat_id;
                        $('#modal-loading').hide();
                        nav_pointer();
                    });
                }
            });
            $('#category-' + cat_id).addClass('active');

            $(document).on('click', '.brand', function () {
                if (brand_id != $(this).val()) {
                    $('#open-brands').click();
                    $('#modal-loading').show();
                    brand_id = $(this).val();
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/ajaxbranddata');?>",
                        data: {brand_id: brand_id},
                        dataType: "json",
                        success: function (data) {
                            $('#item-list').empty();
                            var newPrs = $('<div></div>');
                            newPrs.html(data.products);
                            newPrs.appendTo("#item-list");
                            tcp = data.tcp;
                            nav_pointer();
                        }
                    }).done(function () {
                        p_page = 'n';
                        $('#brand-' + brand_id).addClass('active');
                        $('#brand-' + obrand_id).removeClass('active');
                        obrand_id = brand_id;
                        $('#category-' + cat_id).removeClass('active');
                        $('#subcategory-' + sub_cat_id).removeClass('active');
                        cat_id = 0; sub_cat_id = 0;
                        $('#modal-loading').hide();
                        nav_pointer();
                    });
                }
            });

            $(document).on('click', '.subcategory', function () {
                if (sub_cat_id != $(this).val()) {
                    $('#open-subcategory').click();
                    $('#modal-loading').show();
                    sub_cat_id = $(this).val();
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/ajaxproducts');?>",
                        data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                        dataType: "html",
                        success: function (data) {
                            $('#item-list').empty();
                            var newPrs = $('<div></div>');
                            newPrs.html(data);
                            newPrs.appendTo("#item-list");
                        }
                    }).done(function () {
                        p_page = 'n';
                        $('#subcategory-' + sub_cat_id).addClass('active');
                        $('#subcategory-' + osub_cat_id).removeClass('active');
                        $('#modal-loading').hide();
                    });
                }
            });

            $('#next').click(function () {
                if (p_page == 'n') {
                    p_page = 0
                }
                p_page = p_page + pro_limit;
                if (tcp >= pro_limit && p_page < tcp) {
                    $('#modal-loading').show();
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/ajaxproducts');?>",
                        data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                        dataType: "html",
                        success: function (data) {
                            $('#item-list').empty();
                            var newPrs = $('<div></div>');
                            newPrs.html(data);
                            newPrs.appendTo("#item-list");
                            nav_pointer();
                        }
                    }).done(function () {
                        $('#modal-loading').hide();
                    });
                } else {
                    p_page = p_page - pro_limit;
                }
            });

            $('#previous').click(function () {
                if (p_page == 'n') {
                    p_page = 0;
                }
                if (p_page != 0) {
                    $('#modal-loading').show();
                    p_page = p_page - pro_limit;
                    if (p_page == 0) {
                        p_page = 'n'
                    }
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/ajaxproducts');?>",
                        data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                        dataType: "html",
                        success: function (data) {
                            $('#item-list').empty();
                            var newPrs = $('<div></div>');
                            newPrs.html(data);
                            newPrs.appendTo("#item-list");
                            nav_pointer();
                        }

                    }).done(function () {
                        $('#modal-loading').hide();
                    });
                }
            });

            $(document).on('change', '.paid_by', function () {

                var p_val = $(this).val(),
                    id = $(this).attr('id'),
                    pa_no = id.substr(id.length - 1);
                $('#rpaidby').val(p_val);
                if (p_val == 'cash' || p_val == 'other') {
                    $('.pcheque_' + pa_no).hide();
                    $('.pcc_' + pa_no).hide();
                    $('.pcash_' + pa_no).show();
                    $('#payment_note_' + pa_no).focus();
                } else if (p_val == 'CC' || p_val == 'stripe' || p_val == 'ppp' || p_val == 'authorize') {
                    $('.pcheque_' + pa_no).hide();
                    $('.pcash_' + pa_no).hide();
                    $('.pcc_' + pa_no).show();
                    $('#swipe_' + pa_no).focus();
                } else if (p_val == 'Cheque') {
                    $('.pcc_' + pa_no).hide();
                    $('.pcash_' + pa_no).hide();
                    $('.pcheque_' + pa_no).show();
                    $('#cheque_no_' + pa_no).focus();
                } else {
                    $('.pcheque_' + pa_no).hide();
                    $('.pcc_' + pa_no).hide();
                    $('.pcash_' + pa_no).hide();
                }
                if (p_val == 'gift_card') {
                    $('.gc_' + pa_no).show();
                    $('.ngc_' + pa_no).hide();
                    $('#gift_card_no_' + pa_no).focus();
                } else {
                    $('.ngc_' + pa_no).show();
                    $('.gc_' + pa_no).hide();
                    $('#gc_details_' + pa_no).html('');
                }
            });

            $(document).on('click', '#submit-sale', function () {
                if (total_paid == 0 || total_paid < grand_total) {
                    bootbox.confirm("<?=lang('paid_l_t_payable');?>", function (res) {
                        if (res == true) {
                            $('#pos_note').val(localStorage.getItem('posnote'));
                            $('#staff_note').val(localStorage.getItem('staffnote'));
                            $('#submit-sale').text('<?=lang('loading');?>').attr('disabled', true);
                            $('#pos-sale-form').submit();
                        }
                    });
                    return false;
                } else {
                    $('#pos_note').val(localStorage.getItem('posnote'));
                    $('#staff_note').val(localStorage.getItem('staffnote'));
                    $(this).text('<?=lang('loading');?>').attr('disabled', true);
                    $('#pos-sale-form').submit();
                }
            });
            $('#suspend').click(function () {
                if (count <= 1) {
                    bootbox.alert('<?=lang('x_suspend');?>');
                    return false;
                } else {
                    $('#susModal').modal();
                }
            });
            $('#suspend_sale').click(function () {
                ref = $('#reference_note').val();
                if (!ref || ref == '') {
                    bootbox.alert('<?=lang('type_reference_note');?>');
                    return false;
                } else {
                    suspend = $('<span></span>');
                    <?php if ($sid) {?>
                    suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" /><input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
                    <?php } else {?>
                    suspend.html('<input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
                    <?php }
                    ?>
                    suspend.appendTo("#hidesuspend");
                    $('#total_items').val(count - 1);
                    $('#pos-sale-form').submit();

                }
            });
        });
        <?php if ($pos_settings->java_applet) {?>
        $(document).ready(function () {
            $('#print_order').click(function () {
                //alert('hi');
                printBill(order_data);
            });
            $('#print_bill').click(function () {
                printBill(bill_data);
            });
        });
        <?php } else {?>
        $(document).ready(function () {
            $('#print_order').click(function () {
                //alert($('#order_tbl').html());
                Popup($('#order_tbl').html());
            });
            $('#print_bill').click(function () {
                Popup($('#bill_tbl').html());
            });
        });
        <?php }
        ?>
        $(function () {
            $(".alert").effect("shake");
            setTimeout(function () {
                $(".alert").hide('blind', {}, 500)
            }, 15000);
            <?php if ($pos_settings->display_time) {?>
            var now = new moment();
            $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
            setInterval(function () {
                var now = new moment();
                $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
            }, 1000);
            <?php }
            ?>
        });
        <?php if (!$pos_settings->java_applet) {?>
        function Popup(data) {
            var mywindow = window.open('', 'sma_pos_print', 'height=500,width=300');
            mywindow.document.write('<html><head><title>Print</title>');
            //mywindow.document.write('<link rel="stylesheet" href="<?=$assets?>styles/helpers/bootstrap.min.css" type="text/css" />');
            mywindow.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />');
            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');
            mywindow.print();
            mywindow.close();
            return true;
        }
        <?php }
        ?>
    </script>
<?php
        $s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
        foreach (lang('select2_lang') as $s2_key => $s2_line) {
            $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
        }
        $s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
    ?>
<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --> 
<script type="text/javascript" src="<?=$assets?>js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/jquery-ui.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/perfect-scrollbar.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/select2.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/custom.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/jquery.calculator.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>js/bootstrapValidator.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>pos/js/plugins.min.js"></script> 
<script type="text/javascript" src="<?=$assets?>pos/js/parse-track-data.js"></script> 
<script type="text/javascript" src="<?=$assets?>pos/js/pos.ajax.js"></script>
<?php if ($pos_settings->java_applet) {
        ?>
<script type="text/javascript" src="<?=$assets?>pos/qz/js/deployJava.js"></script> 
<script type="text/javascript" src="<?=$assets?>pos/qz/qz-functions.js"></script> 
<script type="text/javascript">
            deployQZ('themes/<?=$Settings->theme?>/assets/pos/qz/qz-print.jar', '<?=$assets?>pos/qz/qz-print_jnlp.jnlp');
            function printBill(bill) {
                usePrinter("<?=$pos_settings->receipt_printer;?>");
                printData(bill);
            }
            <?php
                $printers = json_encode(explode('|', $pos_settings->pos_printers));
                    echo $printers . ';';
                ?>
            function printOrder(order) {
                for (index = 0; index < printers.length; index++) {
                    usePrinter(printers[index]);
                    printData(order);
                }
            }
        </script>
<?php }
    ?>
<script type="text/javascript">
    $('.sortable_table tbody').sortable({
        containerSelector: 'tr'
    });
    function calculateTotalQuantity(){
        $("#mquantity").val(($("#today_peruse_temp").val()-$("#previous_peruse_temp").val()));
        $("#today_peruse_elec").val($("#today_peruse_temp").val());
    }
    </script> 
<script language="javascript">
        $(document).ready(function () {
                
                $("#today_peruse_date").datetimepicker({
                format: site.dateFormats.js_ldate,
                fontAwesome: true,
                language: 'sma',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                onSelect: function(dateText, inst) {
                        //var date = $(this).val();
                        //var time = $('#time').val();
                        alert($("#today_peruse_date").val());
                        //$("#start").val(date + time.toString(' HH:mm').toString());

                    }
            }).on("changeDate", function (e) {
    $("#today_peruse_date_elec").val($("#today_peruse_date").val());});
    $("#quick_pay").click(function(){
           
           $("#amount_1").val($("#gtotal").text());
           $("#quick_pay_action").val('1');
           $('#pos-sale-form').submit();
       });
        });
    </script> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>     
<script type="text/javascript">
        // Mahiruho - Gaurav
        $(document).ready(function(){
                //shortable
                $( "#sortable" ).sortable();
                $( "#sortable" ).disableSelection();
                //shortable
                //resize_able
               // $('#container').layout();
                    /*$( "#leftdiv_resize" ).resizable({
                      containment: "#resize_container"
                    });*/
                //resize_able    
            $('table#posTable').on('click','tbody tr',function(){
                var ele = $(this);
                var img = '<?=site_url('assets\/uploads\/')?>' + $(this).attr('data-image');
                $('#productImage').attr('src', img);
                $('#productName').html(ele.find('td:first-child span').html());
                $('#productId').html('<?=lang("product_id")?>: <strong>' + ele.find('input[name="product_id[]"]').val() + '</strong>');
                $('#productPrice').html('$' + ele.find('td:nth-child(2) span').html());
                $('#productQuantity').html('*' + ele.find('input[name="quantity[]"]').val());
            });
            var ele = $('table#posTable tbody tr:first-child');
            ele.click();
        });
    </script> 
<script type="text/javascript" charset="UTF-8">
    <?=$s2_file_date?>
        $(window).bind("resize", widthFunctions);
    </script>
    <style type="text/css">
      


  
    </style>
</body>
</html>
