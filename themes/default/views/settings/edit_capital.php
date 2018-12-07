<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_currency'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/edit_capital/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            
            
            <div class="form-group">
                <label class="control-label" for="code">Date</label>

                <div
                    class="controls"> <?php echo form_input('date', $oCapital[0]->date, 'class="form-control" id="date" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="name">Description</label>

                <div
                    class="controls"> <?php echo form_input('description', $oCapital[0]->description, 'class="form-control" id="description" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="rate">Value</label>

                <div
                    class="controls"> <?php echo form_input('value', $oCapital[0]->value, 'class="form-control" id="value" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="rate">Type</label>

                <div class="controls"> 
                    <select name="type"class="form-control">
                        <option value="in"
                                <?php if($oCapital[0]->type=='in') echo "selected";?>
                                >Capital</option>
                        <option value="out"
                                <?php if($oCapital[0]->type=='out') echo "selected";?>
                                >Withdraw</option>
                            </select>
                    </div>
            </div>
            
            
            
            
            
            
           
            
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_capital', 'Edit Capital', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
    <script language="javascript">
    $(document).ready(function () {
            $('#date').datetimepicker();
    });
</script>

<?= $modal_js ?>