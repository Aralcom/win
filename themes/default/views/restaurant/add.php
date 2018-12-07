<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>

.tableList {

    text-align: center;

    height: 160px;

    width: 160px;

    border-radius: 20px;

    float: left;

    padding: 5px;

}

h2 {

    line-height: 0px;

}

</style>

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>

            </button>

            <h4 class="modal-title" id="myModalLabel"><?php echo lang('select_table'); ?></h4>

        </div>

        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');

        //echo form_open_multipart("customers/add", $attrib); ?>

        <div class="modal-body" style="display:inline-block;">

            <div class="row col-md-12" style="margin: 0 auto;">

                

                    <div class="row tablesrow col-md-12">

                    <?php

					

					if(count($table_list)>0){

						foreach($table_list as $table){

                            //var_dump($table->start_time);

                            //table_name

                            //avatar

                            //start_time

                            //die();

                            //assets/uploads/avatars/

					?>

                        <div class="col-xs-3" style="height: 174px;">

                            <div class="col-sm-2 col-xs-4 tableList">
                                <span class="tabletime"><?php echo $table->start_time;?></span>  

                                <a href="javascript:select_table('<?php echo $table->id?>');">

                                <?php

                               

                                //var_dump(file_exists(FCPATH.'/assets/uploads/avatars/'.$table->avatar));

                                if(file_exists(FCPATH.'/assets/uploads/avatars/'.$table->avatar) && $table->avatar!=null){

                                ?>

                                    <img src="<?php echo base_url() . 'assets/uploads/avatars/'.$table->avatar;?>" alt="store">

                                <?php

                            }else{

                                ?>

                                <img src="<?php echo base_url() . 'assets/uploads/avatars/table.svg';?>" alt="store">

                                <?php

                            }

                                ?>    

                                <div style="margin-top: 10px;" class="clearfix"><div style="width: 50%;float: left;">No of Guest  : </div><div style="width: 50%;float: left;"><?php echo $table->no_of_guest;?></div></div>
                                <span style="font-size: 14px;"><?php echo $table->table_name;?></span>

                                </a>

                            </div>

                        </div>

                        <?php

						}

					}

						?>

                        

                        

                        

                    

                    

                    

                    </div>

                    

                    <!-- <div class="modal-footer">

						<?php echo form_submit('add_customer', lang('add_customer'), 'class="btn btn-primary"'); ?>

                    </div>-->

                    

                

            </div>

        </div>

    </div>

    <?php //echo form_close(); ?>

</div>



<script type="text/javascript">

    $(document).ready(function (e) {

        $('#add-customer-form').bootstrapValidator({

            feedbackIcons: {

                valid: 'fa fa-check',

                invalid: 'fa fa-times',

                validating: 'fa fa-refresh'

            }, excluded: [':disabled']

        });

        $('select.select').select2({minimumResultsForSearch: 7});

        fields = $('.modal-content').find('.form-control');

        $.each(fields, function () {

            var id = $(this).attr('id');

            var iname = $(this).attr('name');

            var iid = '#' + id;

            if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {

                $("label[for='" + id + "']").append(' *');

                $(document).on('change', iid, function () {

                    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);

                });

            }

        });

    });

</script>

