<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Capital</h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/add_capital", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label class="control-label" for="code">Date</label>

                <div
                    class="controls"> <?php echo form_input('date', '', 'class="form-control" id="date" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="name">Description</label>

                <div
                    class="controls"> <?php echo form_input('description', '', 'class="form-control" id="description" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="rate">Value</label>

                <div
                    class="controls"> <?php echo form_input('value', '', 'class="form-control" id="value" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="rate">Type</label>

                <div class="controls"> 
                    <select name="type"class="form-control">
                        <option value="in">Capital</option>
                        <option value="out">Withdraw</option>
                            </select>
                    </div>
            </div>
           
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_capital', 'Add Capital', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
    <script language="javascript">
    $(document).ready(function () {
            $('#date').datetimepicker();
    });
</script>
</div>
<?= $modal_js ?>
