<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('create_table'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?php echo lang('create_table'); ?></p>

                <?php $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open("restaurant/create_table", $attrib);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <?php echo lang('table_name', 'table_name'); ?>
                                <div class="controls">
                                    <?php echo form_input('table_name', '', 'class="form-control" id="table_name" required="required" pattern=".{3,10}"'); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo lang('no_of_guest', 'no_of_guest'); ?>
                                <div class="controls">
                                    <?php echo form_input('no_of_guest', '', 'class="form-control" id="no_of_guest"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                                <?php echo lang('address', 'address'); ?>

                                                <div class="controls">
                                                <textarea  name="address" id="address"></textarea>
                                                    <?php //echo form_input('address', $table->address, 'class="form-control" id="last_name" required="required"'); ?>
                                                </div>
                                            </div>
                            <div class="form-group">

                                                <?php echo lang('phone', 'phone'); ?>
                                                <div class="controls">
                                                    <input type="tel" name="phone" class="form-control" id="phone"
                                                            value="<?= $table->phone ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <?php echo lang('email', 'email'); ?>
                                                <div class="controls">
                                                    <input type="email" name="email" class="form-control" id="email"
                                                            value="<?= $table->email ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <?php echo lang('start_time', 'start_time'); ?>
                                                <div class="controls">
                                                    <input type="text" name="start_time" class="form-control" id="timepicker"
                                                            value="<?= $table->start_time ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <?php echo lang('end_time', 'end_time'); ?>
                                                <div class="controls">
                                                    <input type="text" name="end_time" class="form-control" id="timepicker1"
                                                            value="<?= $table->end_time ?>"/>
                                                </div>
                                            </div>

                            
                        </div>
                        <div class="col-md-5 col-md-offset-1">

                            <div class="form-group">
                                <?= lang('status', 'status'); ?>
                                <?php
                                $opt = array(1 => lang('active'), 0 => lang('inactive'));
                                echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="status" required="required" class="form-control select" style="width:100%;"');
                                ?>
                            </div>
                            

                            <div class="clearfix"></div>
                          


                        </div>
                    </div>
                </div>

                <p><?php echo form_submit('add_table', lang('add_table'), 'class="btn btn-primary"'); ?></p>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('.no').slideUp();
        $('#group').change(function (event) {
            var group = $(this).val();
            if (group == 1 || group == 2) {
                $('.no').slideUp();
            } else {
                $('.no').slideDown();
            }
        });
    });
</script>
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>themes/default/assets/timepick/css/timepicki.css'/>
<script type='text/javascript' src='<?php echo base_url(); ?>themes/default/assets/timepick/js/timepicki.js'></script>
<script type='text/javascript'> 
    $('#timepicker').timepicki(); 
    $('#timepicker1').timepicki(); 
</script>