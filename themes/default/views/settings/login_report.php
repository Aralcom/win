<script>
 
	function change_user(val){
		document.user_frm.user_id.value = val;
		document.user_frm.submit();
	}
</script>
<style>.table td:nth-child(6) {
        text-align: right;
        width: 10%;
    }

    .table td:nth-child(8) {
        text-align: center;
    }
    #UsrTable_filter{
		display:none;
	}
    </style>
<?php if ($Owner) {
    echo form_open('restaurant/table_actions', 'id="action-form"');
} ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-database"></i><?= lang('login_report'); ?></h2>

        <div class="box-icon">
        <?php    /*<ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                                                                                  data-placement="left"
                                                                                  title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= site_url('restaurant/create_table'); ?>"><i
                                    class="fa fa-plus-circle"></i> <?= lang("add_table"); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_tables") ?></b>"
                               data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                               data-html="true" data-placement="left"><i
                                    class="fa fa-trash-o"></i> <?= lang('delete_tables') ?></a></li>
                    </ul>
                </li>
            </ul>*/?>
        </div>
    </div>
    <div class="" style="width:100%; text-align:center;">
    <div class="" style="width:40%;margin-right:130px;float:right;text-align: left; padding:10px;">
    <?php
	//var_dump($user);
	?>
    
    Select User : <select name="user_id" id="user_id" onchange="change_user(this.value);">
    <option value="">Select User</option>
	<?php
	if(count($user)>0){
		foreach($user as $user_loop){
	?>		
			<option value="<?php echo $user_loop[0]?>" <?php echo ($user_id==$user_loop[0]?'selected="selected':'')?>"><?php echo $user_loop[3]?></option>
     <?php       
		}
	}
	?>
    </select>
     <input type="submit" name="search" value="Search" />
    
    </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
               <!-- <p class="introtext"><?= lang('list_results'); ?></p>-->

                <div class="table-responsive">
                <?php
				//var_dump($login_report);
				?>
                    <table id="UsrTable" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped">
                        
                        <?php
						//var_dump($login_report);
                        if(count($login_report)>0 && $login_report != false){
							?>
                        <thead><tr>
                            
                            <th class="col-xs-2"><?php echo lang('user_name'); ?></th>
                            <th class="col-xs-2"><?php echo lang('email'); ?></th>
                            <th class="col-xs-2"><?php echo lang('log_status'); ?></th>

                            
                           <th class="col-xs-2"><?php echo lang('logout_time'); ?></th>
                           <th class="col-xs-2"><?php echo lang('total_time'); ?></th>
                        </tr>
                        </thead>
                        <tfoot class="dtFilter">
                      <?php  foreach($login_report as $val){
						  ?>
                        <tr class="active">
                            
                            <th><?php echo $val->username?></th>
                            <th><?php echo $val->email?></th>
                            
                            <th><?php echo $val->log_time?></th>
                           <th><?php echo $val->out_time?></th>
                           <th><?php echo $val->total_time;?></th>
                        </tr>
                        <?php
					  }
						?>
                        </tfoot>
                        <?php
						}else{
						?>
                        <tbody>
                        <tr>
                            <td colspan="4" class="dataTables_empty"><?= lang('no_record_found') ?></td>
                        </tr>
                        </tbody>
                        <?php
						}
						?>
                        
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

<form name="user_frm" id="user_frm1" action="<?php echo site_url('system_settings/login_report');?>" method="get">
<input type="hidden" name="user_id" value="" />
</form>
    <script language="javascript">
        $(document).ready(function () {
            $('#set_admin').click(function () {
                $('#usr-form-btn').trigger('click');
            });

        });
    </script>

<?php } ?>