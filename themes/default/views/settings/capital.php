<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= form_open('system_settings/capital_actions', 'id="action-form"') ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-money"></i><?= $page_title ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                                                                                  data-placement="left"
                                                                                  title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?php echo site_url('system_settings/add_capital'); ?>" data-toggle="modal"
                               data-target="#myModal"><i class="fa fa-plus"></i> Add Capital</a></li>
                        <li class="divider"></li>
                        <li><a href="#" id="pdf" data-action="export_pdf"><i
                                    class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                        <li class="divider"></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext">Please use the table below to navigate or filter the results.<?php// echo $this->lang->line("list_results"); ?></p>

                <div class="table-responsive">
                    <table id="CURData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                
                            </th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Value</th>
                            <th style="width:65px;"><?php echo $this->lang->line("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tCapital=0;
                            foreach ($oCapital as $oR){
                                ?>
                            <tr>
                                <td><input class="checkbox" type="checkbox" name="val[]" value="<?=$oR->id?>"/></td>
                                <td><?=$oR->date;?></td>
                                <td><?=$oR->description;?></td>
                                <td class="text-right"><?php
                                if($oR->type =='out'){
                                    $tCapital -=$oR->value;
                                    echo "-".$this->sma->formatMoney($oR->value);
                                }else{
                                    $tCapital +=$oR->value;
                                    echo $this->sma->formatMoney($oR->value);
                                }
                                ?></td>    
                                
                                
                                
                                <td><div class="text-center"><a href="<?php echo site_url('system_settings/edit_capital').'/'.$oR->id; ?>" class="tip" title="" data-toggle="modal" data-target="#myModal" data-original-title="Edit Capital"><i class="fa fa-edit"></i></a> 
                                        <a href="#" class="tip po" title="" data-placement="left"
                                           data-content="<p>Are you sure?</p><a class='btn btn-danger po-delete' href='<?php echo site_url('system_settings/delete_capital').'/'.$oR->id; ?>'>Yes I'm sure</a> <button class='btn po-close'>No</button>" 
                                           rel="popover" data-original-title="<b>Delete Capital</b>"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>                                                    
                        </tbody>
                    </table>
                    <div class="pull-right">Value In Capital: <?=$this->sma->formatMoney($tCapital)?></div>
                </div>

            </div>

        </div>
    </div>
</div>

<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script language="javascript">
    $(document).ready(function () {
                $('.tip.po').popover({html : true    });
                $('.tip.po').tooltip({html : true    });
        $('#delete').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#excel').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#pdf').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

    });
</script>

