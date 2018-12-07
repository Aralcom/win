<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($year)){
$year_to_array = json_decode($year);
}?>
<style type="text/css">
    .dfTable th, .dfTable td {
        text-align: center;
        vertical-align: middle;
    }

    .dfTable td {
        padding: 2px;
    }

    .data tr:nth-child(odd) td {
        color: #2FA4E7;
    }

    .data tr:nth-child(even) td {
        text-align: right;
    }
</style>
<script src="https://cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js"></script>
<script src="https://rawgit.com/niklasvh/html2canvas/master/dist/html2canvas.js"></script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-calendar"></i><?= lang('yearly_sales').' ('.($sel_warehouse ? $sel_warehouse->name : lang('all_warehouses')).')'; ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <?php /* if (!empty($warehouses) && !$this->session->userdata('warehouse_id')) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?=lang("warehouses")?>"></i></a>
                        <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?=site_url('reports/yearly_sales/0/'.$year)?>"><i class="fa fa-building-o"></i> <?=lang('all_warehouses')?></a></li>
                            <li class="divider"></li>
                            <?php
                                foreach ($warehouses as $warehouse) {
                                        echo '<li><a href="' . site_url('reports/yearly_sales/'.$warehouse->id.'/'.$year) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                                    }
                                ?>
                        </ul>
                    </li>
                <?php } ?>
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>*/?>
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a id="image" href="" download="img.png" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang("reports_calendar_text_year") ?></p>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped dfTable reports-table">
                        <thead>
                        <tr class="year_roller">
                            <th><a class="white" href="<?= site_url('reports/yearly_sales/'.($warehouse_id ? $warehouse_id : 0).'/'.($selected_year-1)); ?>">&lt;&lt;</a></th>
                            <th colspan="8"> <?php echo $selected_year; ?></th>
                            <th><a class="white" href="<?= site_url('reports/yearly_sales/'.($warehouse_id ? $warehouse_id : 0).'/'.($selected_year+1)); ?>">&gt;&gt;</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <?php
							if(count($year_to_array)>0){
								foreach($year_to_array as $year_val){
								?>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year_val); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= $year_val; ?>
                                </a>
                            </td>
                            <?php
								}
							}
							?>
                            <?php /* <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/02'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_february"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/03'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_march"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/04'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_april"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/05'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_may"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/06'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_june"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/07'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_july"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/08'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_august"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/09'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_september"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/10'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_october"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/11'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_november"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/yearly_profit/'.$year.'/12'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_december"); ?>
                                </a>
                            </td>
                            */?>
                        </tr>
                        <tr>
                            <?php
							//var_dump($sales);
                           // if (!empty($sales)) {
                                /*foreach ($sales as $value) {
                                    $array[$value->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tbody><tr><td>" . $this->lang->line("discount") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->discount) . "</td></tr><tr><td>" . $this->lang->line("shipping") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->shipping) . "</td></tr><tr><td>" . $this->lang->line("product_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->tax1) . "</td></tr><tr><td>" . $this->lang->line("order_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->tax2) . "</td></tr><tr><td>" . $this->lang->line("total") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->total) . "</td></tr></tbody></table>";
                                }*/
								
							if(count($year_to_array)>0){
								foreach($year_to_array as $year_val){
								
                                //for ($i = 1; $i <= 12; $i++) {
									
									if ((!empty($sales)) && array_key_exists($year_val,$sales) ){
										$carray = $sales[$year_val];
										 echo '<td width="8.3%">';
										echo "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tbody><tr><td>" . $this->lang->line("discount") . "</td></tr><tr><td>" . $this->sma->formatMoney($carray['discount']) . "</td></tr>";
										echo "<tr><td>" . $this->lang->line("shipping") . "</td></tr><tr><td>" . $this->sma->formatMoney($carray['shipping']) . "</td></tr>";
										echo "<tr><td>" . $this->lang->line("product_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($carray['tax1']) . "</td></tr>";
										echo "<tr><td>" . $this->lang->line("order_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($carray['tax2']) . "</td></tr>";
										echo "<tr><td>" . $this->lang->line("total") . "</td></tr><tr><td>" . $this->sma->formatMoney($carray['total']) . "</td></tr></tbody></table>";
										 echo '</td>';
									}else{
										echo '<td width="8.3%"><strong>0</strong></td>';
										/*echo '<td width="8.3%">';
										if (isset($array[$i])) {
											echo $array[$i];
										} else {
											echo '<strong>0</strong>';
										}
										echo '</td>';*/
									}
                                }
							}
								
                          //  } else {
                               /* for ($i = 1; $i <= 12; $i++) {
                                    echo '<td width="8.3%"><strong>0</strong></td>';
                                }*/
                           // }
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://hongru.github.io/proj/canvas2image/canvas2image.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        /*$('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/yearly_sales/'.($warehouse_id ? $warehouse_id : 0).'/'.$year.'/pdf')?>";
            return false;
        }); */
        $('#pdf').click(function() {
          var doc = new jsPDF('landscape', 'pt', 'a4');
          doc.addHTML($('.box'), function() {
            doc.save("yearly.pdf");
          });
        });
       $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                var a = document.createElement('a');
                // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download = 'yearly.jpg';
                a.click();
                }
            });
            return false;
        }); 
        
    });
   
</script>
<script>
    var btnSave = document.getElementById('image');
btnSave.addEventListener('click', function() {
    var image = photo.toDataURL("image/png");
    var anchor = document.createElement('a');
    anchor.setAttribute('download', 'myFilename.png');
    anchor.setAttribute('href', image);
    anchor.click();
});
</script>