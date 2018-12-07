<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
<?php
//var_dump($table);
?>
    <div class="col-sm-2">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div style="max-width:200px; margin: 0 auto;">
                    <?php
                    if(file_exists('/assets/uploads/avatars/thumbs/' . $table->avatar)){
                        echo $table->avatar ? '<img alt="" src="' . base_url() . 'assets/uploads/avatars/thumbs/' . $table->avatar . '" class="avatar">' :
                        '<img alt="" src="' . base_url() . 'assets/images/' . $table->gender . '.png" class="avatar">';
                    }else{
                       echo  $table->avatar ? '<img alt="" src="' . base_url() . 'assets/uploads/avatars/' . $table->avatar . '" class="avatar">' :
                        '<img alt="" src="' . base_url() . 'assets/images/' . $table->gender . '.png" class="avatar">';
                    }
                    
                    ?>
                </div>
                <h4><?= lang('login_email'); ?></h4>

                <p><i class="fa fa-envelope"></i> <?= $table->email; ?></p>
            </div>
        </div>
    </div>

    <div class="col-sm-10">

        <ul id="myTab" class="nav nav-tabs">
            <li class=""><a href="#edit" class="tab-grey"><?= lang('edit') ?></a></li>
            
            <li class=""><a href="#restaurant" class="tab-grey"><?= lang('restaurant_logo') ?></a></li>
        </ul>

        <div class="tab-content">
            <div id="edit" class="tab-pane fade in">

                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('edit_profile'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">

                                <?php $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                                echo form_open('restaurant/update_table/' . $table->id, $attrib);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <?php echo lang('table_name', 'table_name'); ?>
                                                <div class="controls">
                                                    <?php echo form_input('table_name', $table->table_name, 'class="form-control" id="table_name" required="required"'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <?php echo lang('no_of_guest', 'no_of_guest'); ?>

                                                <div class="controls">
                                                    <?php echo form_input('no_of_guest', $table->no_of_guest, 'class="form-control" id="no_of_guest" required="required"'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('address', 'address'); ?>

                                                <div class="controls">
                                                <textarea  name="address" id="address"><?php echo $table->address;?></textarea>
                                                    <?php //echo form_input('address', $table->address, 'class="form-control" id="last_name" required="required"'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <?php echo lang('phone', 'phone'); ?>
                                                <div class="controls">
                                                    <input type="tel" name="phone" class="form-control" id="phone"
                                                           required="required" value="<?= $table->phone ?>"/>
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
                                        <div class="col-md-6 col-md-offset-1">
                                            

                                                    <div class="row">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-heading"><?= lang('user_options') ?></div>
                                                            <div class="panel-body" style="padding: 5px;">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <?= lang('status', 'status'); ?>
                                                                            <?php
                                                                            $opt = array(1 => lang('active'), 0 => lang('inactive'));
                                                                            echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : $table->active), 'id="status" required="required" class="form-control input-tip select" style="width:100%;"');
                                                                            ?>
                                                                        </div>
                                                                        
                                                                       
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            
                                            <?php echo form_hidden('id', $id); ?>
                                            <?php echo form_hidden($csrf); ?>
                                        </div>
                                    </div>
                                </div>
                                <p><?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?></p>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="restaurant" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-file-picture-o nb"></i><?= lang('restaurant_logo'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-5">
                                    <div style="position: relative;">
                                        <?php if ($table->avatar) { ?>
                                            <img alt=""
                                                 src="<?= base_url() ?>assets/uploads/avatars/<?= $table->avatar ?>"
                                                 class="profile-image img-thumbnail">
                                            <a href="#" class="btn btn-danger btn-xs po"
                                               style="position: absolute; top: 0;" title="<?= lang('delete_avatar') ?>"
                                               data-content="<p><?= lang('r_u_sure') ?></p><a class='btn btn-block btn-danger po-delete' href='<?= site_url('restaurant/delete_avatar/' . $id . '/' . $table->avatar) ?>'> <?= lang('i_m_sure') ?></a> <button class='btn btn-block po-close'> <?= lang('no') ?></button>"
                                               data-html="true" rel="popover"><i class="fa fa-trash-o"></i></a><br>
                                            <br><?php } ?>
                                    </div>
                                    <?php echo form_open_multipart("restaurant/update_avatar"); ?>
                                    <div class="form-group">
                                        <?= lang("change_logo", "change_logo"); ?>
                                        <input type="file" data-browse-label="<?= lang('browse'); ?>" name="avatar" id="product_image" required="required"
                                               data-show-upload="false" data-show-preview="false" accept="image/*"
                                               class="form-control file"/>
                                    </div>
                                    <div class="form-group">
                                        <?php echo form_hidden('id', $id); ?>
                                        <?php echo form_hidden($csrf); ?>
                                        <?php echo form_submit('update_logo', lang('update_logo'), 'class="btn btn-primary"'); ?>
                                        <?php echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#change-password-form').bootstrapValidator({
                message: 'Please enter/select a value',
                submitButtons: 'input[type="submit"]'
            });
        });
    </script>
    <?php if ($Owner && $id != $this->session->userdata('user_id')) { ?>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#group').change(function (event) {
                var group = $(this).val();
                if (group == 1 || group == 2) {
                    $('.no').slideUp();
                } else {
                    $('.no').slideDown();
                }
            });
            var group = <?=$table->group_id?>;
            if (group == 1 || group == 2) {
                $('.no').slideUp();
            } else {
                $('.no').slideDown();
            }
        });
    </script>
<?php } ?>
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>themes/default/assets/timepick/css/timepicki.css'/>
<script type='text/javascript' src='<?php echo base_url(); ?>themes/default/assets/timepick/js/timepicki.js'></script>
<script type='text/javascript'> 
    $('#timepicker').timepicki(); 
    $('#timepicker1').timepicki(); 
</script>