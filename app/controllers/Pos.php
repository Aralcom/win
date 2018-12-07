<?php defined('BASEPATH') or exit('No direct script access allowed');

//error_reporting(E_ALL);
ini_set('display_errors',0);
class Pos extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if ($this->Customer || $this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->load->model('pos_model');
        $this->load->helper('text');
        $this->pos_settings = $this->pos_model->getSetting();
        $this->pos_settings->pin_code = $this->pos_settings->pin_code ? md5($this->pos_settings->pin_code) : NULL;
        $this->data['pos_settings'] = $this->pos_settings;

$this->load->model('settings_model');
$this->load->model('table_model');
$this->settings_model = $this->settings_model->getSettings();
$this->data['settings_model'] = $this->settings_model;

        $this->session->set_userdata('last_activity', now());
        $this->lang->load('pos', $this->Settings->user_language);
        $this->load->library('form_validation');
    }
 public function validate_gift_card($no)
    {
        //$this->sma->checkPermissions();

//$no = $_REQUEST['cn'];
// echo $no;
// die(0);

        if ($gc = $this->site->getGiftCardByNO($no)) {
            if ($gc->expiry) {
                if ($gc->expiry >= date('Y-m-d')) {
                    $this->sma->send_json($gc);
                } else {
                    $this->sma->send_json(false);
                }
            } else {
                $this->sma->send_json($gc);
            }
        } else {
            $this->sma->send_json(false);
        }
    }
    public function sales($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] = NULL;
            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');
            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : NULL;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('pos_sales')));
        $meta = array('page_title' => lang('pos_sales'), 'bc' => $bc);
        $this->page_construct('pos/sales', $meta, $this->data);
    }

    public function getSales($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('index');

        if ((!$this->Owner || !$this->Admin) && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
        $detail_link2 = anchor('sales/modal_view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details_modal'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link3 = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');

$sms_link = '<a href="javascript:;" onclick="sendSMS(this)"><i class="fa fa-mobile"></i> &nbsp;&nbsp;&nbsp;SMS Send</a>';//anchor('#', '<i class="fa fa-mobile"></i> ' . 'SMS Send', 'class="email_receipt" onclick="sendSMS(this)"');

        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>' . $detail_link . '</li>
        <li>' . $detail_link2 . '</li>
        <li>' . $detail_link3 . '</li>
        <li>' . $payments_link . '</li>
        <li>' . $add_payment_link . '</li>
        <li>' . $add_delivery_link . '</li>
        <li>' . $edit_link . '</li>
        <li>' . $email_link . '</li>
<li>' . $sms_link . '</li>
        <li>' . $return_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
</div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+COALESCE(rounding, 0)), paid, (grand_total-paid) as balance, sale_status, payment_status, companies.email as cemail")
                ->from('sales')
                ->join('companies', 'companies.id=sales.customer_id', 'left')
                ->where('warehouse_id', $warehouse_id)
                ->where('deleted', 0)
                ->group_by('sales.id');
        } else {
            $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+COALESCE(rounding, 0)), paid, (grand_total+rounding-paid) as balance, sale_status, payment_status, companies.email as cemail")
                ->from('sales')
                ->join('companies', 'companies.id=sales.customer_id', 'left')
                ->where('deleted', 0)
                ->group_by('sales.id');
        }
        $this->datatables->where('pos', 1);
        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
        $this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');
        echo $this->datatables->generate();
    }

 public function getSalesNotify($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('index');

        if ((!$this->Owner || !$this->Admin) && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
        $detail_link2 = anchor('sales/modal_view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details_modal'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link3 = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');

$sms_link = '<a href="javascript:;" onclick="sendSMS(this)"><i class="fa fa-mobile"></i> &nbsp;&nbsp;&nbsp;SMS Send</a>';//anchor('#', '<i class="fa fa-mobile"></i> ' . 'SMS Send', 'class="email_receipt" onclick="sendSMS(this)"');

        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>' . $detail_link . '</li>
        <li>' . $detail_link2 . '</li>
        <li>' . $detail_link3 . '</li>
        <li>' . $payments_link . '</li>
        <li>' . $add_payment_link . '</li>
        <li>' . $add_delivery_link . '</li>
        <li>' . $edit_link . '</li>
        <li>' . $email_link . '</li>
<li>' . $sms_link . '</li>
        <li>' . $return_link . '</li>
        <li>' . $delete_link . '</li>
    </ul>
</div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+COALESCE(rounding, 0)), paid, (grand_total-paid) as balance, sale_status, payment_status, companies.email as cemail,pos")
                ->from('sales')
                ->join('companies', 'companies.id=sales.customer_id', 'left')
                ->where('warehouse_id', $warehouse_id)
                ->where('sales.deleted', 0)
                ->group_by('sales.id');
        } else {
            $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+COALESCE(rounding, 0)), paid, (grand_total+rounding-paid) as balance, sale_status, payment_status, companies.email as cemail,pos")
                ->from('sales')
                ->join('companies', 'companies.id=sales.customer_id', 'left')
                ->where('sales.deleted', 0)
                ->group_by('sales.id');

        }

        //$this->datatables->where('pos', 1);
       $this->datatables->where('payment_status !=', 'paid');

        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
		$settings = $this->settings_model;
//var_dump($settings->due_payment_notification);
        //$this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');
    if($settings->due_payment_notification>0){
      $result = $this->datatables->generate();
      $result_arr = json_decode($result);
//echo '<pre>';
//var_dump($result_arr->aaData);
		$arr_result = '';
       foreach($result_arr->aaData as $key=>$aadata){
			$db_date = $aadata[1];
			$today = date("Y-m-d h:i:sa");
			//echo $today.'<br>';
			$today_time = strtotime($today);
			$db_time = strtotime($db_date);
			if($today_time > $db_time){
			//echo $db_date.'--'.$today;
			$days = ceil(abs($today_time - $db_time ) / 86400);
			//echo $settings->due_payment_notification.'<br>'.$days.'<br>';
				if($settings->due_payment_notification <= $days){
					$arr_result[] = ($aadata[11]==1?'pos/sales':'sales');
				}
			}
				   // echo $this->datatables->generate();
       }
	   if(count($arr_result)>0){
		   echo json_encode($arr_result);
	   }else{
		   return false;
	   }
    }    
}

    /* ---------------------------------------------------------------------------------------------------- */

    public function index($sid = NULL)
    {
        //var_dump($_REQUEST);
        $this->sma->checkPermissions();

        if (!$this->pos_settings->default_biller || !$this->pos_settings->default_customer || !$this->pos_settings->default_category) {
            $this->session->set_flashdata('warning', lang('please_update_settings'));
            redirect('pos/settings');
        }
        if ($register = $this->pos_model->registerData($this->session->userdata('user_id'))) {
            $register_data = array('register_id' => $register->id, 'cash_in_hand' => $register->cash_in_hand, 'register_open_time' => $register->date);
            $this->session->set_userdata($register_data);
        } else {
            $this->session->set_flashdata('error', lang('register_not_open'));
            redirect('pos/open_register');
        }
        $table_id = $this->input->get('table') ? $this->input->get('table') : '';
        $no_of_guest = $this->input->post('no_of_guest') ? $this->input->post('no_of_guest') : '';
        
        $this->data['sid'] = $this->input->get('suspend_id') ? $this->input->get('suspend_id') : $sid;
		$this->data['table'] = $this->input->get('table') ? $this->input->get('table') : $table_id;
        $did = $this->input->post('delete_id') ? $this->input->post('delete_id') : NULL;
        $suspend = $this->input->post('suspend') ? TRUE : FALSE;
		$table_post = $this->input->post('table_post') ? TRUE : FALSE;
        $count = $this->input->post('count') ? $this->input->post('count') : NULL;
        //validate form input
        $this->form_validation->set_rules('customer', $this->lang->line("customer"), 'trim|required');
        $this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'required');
        $this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required');

        $table_note = $this->input->post('table_note') ? $this->input->post('table_note') : '';
        

        //var_dump($this->form_validation->run());
        //die();
        if ($this->form_validation->run() == TRUE) {

            $date = date('Y-m-d H:i:s');
            $warehouse_id = $this->input->post('warehouse');
            $customer_id = $this->input->post('customer');
            $table_id = (null !==$this->input->post('table') && !empty($this->input->post('table'))?$this->input->post('table'):0);
            
            $order_type_setting = (null !==$this->input->post('order_type_setting') && !empty($this->input->post('order_type_setting'))?$this->input->post('order_type_setting'):0);
            /* added by sudip start*/
            $today_peruse = $this->input->post('today_peruse');

            $today_peruse_date_var = str_replace('/', '-', $this->input->post('today_peruse_date'));
            $today_peruse_date = date('Y-m-d H:i:s', strtotime($today_peruse_date_var));
             /* added by sudip end*/
            $biller_id = $this->input->post('biller');
            $total_items = $this->input->post('total_items');
            $sale_status = 'completed';
            $payment_status = 'due';
            $payment_term = 0;
            $due_date = date('Y-m-d', strtotime('+' . $payment_term . ' days'));
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->site->getCompanyByID($customer_id);
            $customer = $customer_details->company != '-'  ? $customer_details->company : $customer_details->name;
            $biller_details = $this->site->getCompanyByID($biller_id);
            $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            $note = $this->sma->clear_tags($this->input->post('pos_note'));
            $staff_note = $this->sma->clear_tags($this->input->post('staff_note'));
            $reference = $this->site->getReference('pos');

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $percentage = '%';
            $digital = FALSE;
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;

            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_type = $_POST['product_type'][$r];
                $item_code = $_POST['product_code'][$r];
                $item_name = $_POST['product_name'][$r];
                $item_comment = $_POST['product_comment'][$r];
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
                $real_unit_price = $this->sma->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->sma->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;
                $item_unit = $_POST['product_unit'][$r];
                $item_quantity = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->pos_model->getProductByCode($item_code) : NULL;
                    // $unit_price = $real_unit_price;
                    $pr_discount = 0;
                    if ($item_type == 'digital') {
                        $digital = TRUE;
                    }

                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        $dpos = strpos($discount, $percentage);
                        if ($dpos !== FALSE) {
                            $pds = explode("%", $discount);
                            $pr_discount = $this->sma->formatDecimal(((($this->sma->formatDecimal($unit_price)) * (Float)($pds[0])) / 100), 4);
                        } else {
                            $pr_discount = $this->sma->formatDecimal($discount);
                        }
                    }

                    $unit_price = $this->sma->formatDecimal($unit_price - $pr_discount);
                    $item_net_price = $unit_price;
                    $pr_item_discount = $this->sma->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0;
                    $pr_item_tax = 0;
                    $item_tax = 0;
                    $tax = "";

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        if ($tax_details->type == 1 && $tax_details->rate != 0) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }

                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / 100, 4);
                                $tax = $tax_details->rate . "%";
                            } else {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate), 4);
                                $tax = $tax_details->rate . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }

                            $item_tax = $this->sma->formatDecimal($tax_details->rate);
                            $tax = $tax_details->rate;

                        }
                        $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_unit_quantity), 4);

                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_unit_quantity) + $pr_item_tax);
                    $unit = $this->site->getUnitByID($item_unit);

                    $products[] = array(
                        'product_id'      => $item_id,
                        'product_code'    => $item_code,
                        'product_name'    => $item_name,
                        'product_type'    => $item_type,
                        'option_id'       => $item_option,
                        'net_unit_price'  => $item_net_price,
                        'unit_price'      => $this->sma->formatDecimal($item_net_price + $item_tax),
                        'quantity'        => $item_quantity,

                        'product_unit_id' => $item_unit,
                        'product_unit_code' => $unit ? $unit->code : NULL,
                        'unit_quantity' => $item_unit_quantity,
                        'warehouse_id'    => $warehouse_id,
                        'item_tax'        => $pr_item_tax,
                        'tax_rate_id'     => $pr_tax,
                        'tax'             => $tax,
                        'discount'        => $item_discount,
                        'item_discount'   => $pr_item_discount,
                        'subtotal'        => $this->sma->formatDecimal($subtotal),
                        'serial_no'       => $item_serial,
                        'real_unit_price' => $real_unit_price,
                        'comment'         => $item_comment,
                    );

                    $total += $this->sma->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } elseif ($this->pos_settings->item_order == 1) {
                krsort($products);
            }

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('discount');
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== FALSE) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->sma->formatDecimal(((($total + $product_tax) * (Float)($ods[0])) / 100), 4);
                } else {
                    $order_discount = $this->sma->formatDecimal($order_discount_id);
                }
            } else {
                $order_discount_id = NULL;
            }
            $total_discount = $this->sma->formatDecimal($order_discount + $product_discount);

            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->sma->formatDecimal($order_tax_details->rate);
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax = $this->sma->formatDecimal(((($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100), 4);
                    }
                }
            } else {
                $order_tax_id = NULL;
            }

            $total_tax = $this->sma->formatDecimal(($product_tax + $order_tax), 4); 
            $grand_total = $this->sma->formatDecimal(($total + $total_tax + $this->sma->formatDecimal($shipping) - $order_discount), 4);
            $rounding = 0;
            if ($this->pos_settings->rounding) {
                $round_total = $this->sma->roundNumber($grand_total, $this->pos_settings->rounding);
                $rounding = $this->sma->formatMoney($round_total - $grand_total);
            }
            //'pos_resize'        => $this->get_pos_resize(),
            $data = array('date'              => $date,
                          'reference_no'      => $reference,
                          'customer_id'       => $customer_id,
                          'table_id'          => $table_id,
                          'order_type_setting'=> $order_type_setting,
                          'customer'          => $customer,
                          'biller_id'         => $biller_id,
                          'biller'            => $biller,
                          'warehouse_id'      => $warehouse_id,
                          'note'              => $note,
                          'staff_note'        => $staff_note,
                          'total'             => $total,
                          'product_discount'  => $product_discount,
                          'order_discount_id' => $order_discount_id,
                          'order_discount'    => $order_discount,
                          'total_discount'    => $total_discount,
                            //'customer_group_discount'    => $customer_group_discount,
                          'product_tax'       => $product_tax,
                          'order_tax_id'      => $order_tax_id,
                          'order_tax'         => $order_tax,
                          'total_tax'         => $total_tax,
                          'shipping'          => $this->sma->formatDecimal($shipping),
                          'grand_total'       => $grand_total,
                          'total_items'       => $total_items,
                          'today_peruse'      => $total_items,
                          'today_peruse_date' => $today_peruse_date,
                          'sale_status'       => $sale_status,
                          'payment_status'    => $payment_status,
                          'payment_term'      => $payment_term,
                          'rounding'          => $rounding,
                          'table_id'          => $table_id,
                          'no_of_guest'       => $no_of_guest,
                          'suspend_note'      => ($table_post==true?$table_note.' '.($this->pos_model->savetable_count()):$this->input->post('suspend_note')),
                          'pos'               => 1,
                          'paid'              => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,
                          'created_by'        => $this->session->userdata('user_id'),
            );
           // var_dump($table_post);
            //var_dump($suspend);
            
            if (!$suspend && !$table_post) {
                //echo 'in';
               // die();
                $p = isset($_POST['amount']) ? sizeof($_POST['amount']) : 0;

                $paid = 0;
                for ($r = 0; $r < $p; $r++) {
                    if (isset($_POST['amount'][$r]) && !empty($_POST['amount'][$r]) && isset($_POST['paid_by'][$r]) && !empty($_POST['paid_by'][$r])) {
                        $amount = $this->sma->formatDecimal($_POST['balance_amount'][$r] > 0 ? $_POST['amount'][$r] - $_POST['balance_amount'][$r] : $_POST['amount'][$r]);
                        if ($_POST['paid_by'][$r] == 'deposit') {
                            if ( ! $this->site->check_customer_deposit($customer_id, $amount)) {
                                $this->session->set_flashdata('error', lang("amount_greater_than_deposit"));
                                redirect($_SERVER["HTTP_REFERER"]);
                            }
                        } 
                        if ($_POST['paid_by'][$r] == 'gift_card') {
                            $gc = $this->site->getGiftCardByNO($_POST['paying_gift_card_no'][$r]);
                            $amount_paying = $_POST['amount'][$r] >= $gc->balance ? $gc->balance : $_POST['amount'][$r];
                            $gc_balance = $gc->balance - $amount_paying;
                            $payment[] = array(
                                'date'         => $date,
                                // 'reference_no' => $this->site->getReference('pay'),
                                'amount'       => $amount,
                                'paid_by'      => $_POST['paid_by'][$r],
                                'cheque_no'    => $_POST['cheque_no'][$r],
                                'cc_no'        => $_POST['paying_gift_card_no'][$r],
                                'cc_holder'    => $_POST['cc_holder'][$r],
                                'cc_month'     => $_POST['cc_month'][$r],
                                'cc_year'      => $_POST['cc_year'][$r],
                                'cc_type'      => $_POST['cc_type'][$r],
                                'cc_cvv2'      => $_POST['cc_cvv2'][$r],
                                'created_by'   => $this->session->userdata('user_id'),
                                'type'         => 'received',
                                'note'         => $_POST['payment_note'][$r],
                                'pos_paid'     => $_POST['amount'][$r],
                                'pos_balance'  => $_POST['balance_amount'][$r],
                                'gc_balance'  => $gc_balance,
                                );

                        } else {
                            $payment[] = array(
                                'date'         => $date,
                                // 'reference_no' => $this->site->getReference('pay'),
                                'amount'       => $amount,
                                'paid_by'      => $_POST['paid_by'][$r],
                                'cheque_no'    => $_POST['cheque_no'][$r],
                                'cc_no'        => $_POST['cc_no'][$r],
                                'cc_holder'    => $_POST['cc_holder'][$r],
                                'cc_month'     => $_POST['cc_month'][$r],
                                'cc_year'      => $_POST['cc_year'][$r],
                                'cc_type'      => $_POST['cc_type'][$r],
                                'cc_cvv2'      => $_POST['cc_cvv2'][$r],
                                'created_by'   => $this->session->userdata('user_id'),
                                'type'         => 'received',
                                'note'         => $_POST['payment_note'][$r],
                                'pos_paid'     => $_POST['amount'][$r],
                                'pos_balance'  => $_POST['balance_amount'][$r],
                                );

                        }
 
                    }
                }
            }
           // die();
            if (!isset($payment) || empty($payment)) {
                $payment = array();
            }

            // $this->sma->print_arrays($data, $products, $payment);
        }

        if ($this->form_validation->run() == TRUE && !empty($products) && !empty($data)) {
            //var_dump($suspend);
            //var_dump($table_post);
            //die();
            // var_dump($payment);
            // exit;
            if ($suspend) {
                    if ($this->pos_model->suspendSale($data, $products, $did)) {
                        $this->session->set_userdata('remove_posls', 1);
                        $this->session->set_flashdata('message', $this->lang->line("sale_suspended"));
                        redirect("pos");
                    }
            }elseif ($table_post) {
                        if ($this->pos_model->tableSale($data, $products, $did)) {
                            $this->session->set_userdata('remove_posls', 1);
                            $this->session->set_flashdata('message', $this->lang->line("sale_tablestore"));
                            redirect("pos");
                        }
            } else {
                    if ($sale = $this->pos_model->addSale($data, $products, $payment, $did)) {
                        $this->session->set_userdata('remove_posls', 1);
                        $msg = $this->lang->line("sale_added");
						
						$this->db->query("DELETE FROM `sma_suspended_bills` WHERE id='".$this->input->post('suspend_sale_id')."'");

                        if (!empty($sale['message'])) {
                            foreach ($sale['message'] as $m) {
                                $msg .= '<br>' . $m;
                            }
                        }
                        
                        $redirect_to = $this->pos_settings->after_sale_page ? "pos" : "pos/view/" . $sale['sale_id'];
                        if ($this->pos_settings->auto_print) {
                            if ($this->Settings->remote_printing != 1) {
                                $redirect_to .= '?print='.$sale['sale_id'];
                            }
                        }
                        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
                            echo json_encode(array('id'=>$sale['sale_id']));
                        }
                        else {
                            $this->session->set_flashdata('message', $msg);
                            redirect($redirect_to);
                        }
                        //var_dump($redirect_to);
                        
                    }
            }
				
           } else {
            $this->data['suspend_sale'] = NULL;
            //var_dump($table_id);
			 
            if ($sid) {
                if ($suspended_sale = $this->pos_model->getOpenBillByID($sid)) {
                    $inv_items = $this->pos_model->getSuspendedSaleItems($sid);
                    krsort($inv_items);
                    $c = rand(100000, 9999999);
                    foreach ($inv_items as $item) {
                        $row = $this->site->getProductByID($item->product_id);
                        if (!$row) {
                            $row = json_decode('{}');
                            $row->tax_method = 0;
                            $row->quantity = 0;
                        } else {
                            $category = $this->site->getCategoryByID($row->category_id);
                            $row->category_name = $category->name;
                            unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                        }
                        $pis = $this->site->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $row->quantity += $pi->quantity_balance;
                            }
                        }
                        $row->id = $item->product_id;
                        $row->code = $item->product_code;
                        $row->name = $item->product_name;
                        $row->type = $item->product_type;            
                        $row->quantity += $item->quantity;
                        $row->discount = $item->discount ? $item->discount : '0';
                        $row->price = $this->sma->formatDecimal($item->net_unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity));
                        $row->unit_price = $row->tax_method ? $item->unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity) + $this->sma->formatDecimal($item->item_tax / $item->quantity) : $item->unit_price + ($item->item_discount / $item->quantity);
                        $row->real_unit_price = $item->real_unit_price;
                        $row->base_quantity = $item->quantity;
                        $row->base_unit = isset($row->unit) ? $row->unit : $item->product_unit_id;
                        $row->base_unit_price = $row->price ? $row->price : $item->unit_price;
                        $row->unit = $item->product_unit_id;
                        $row->qty = $item->unit_quantity;
                        $row->tax_rate = $item->tax_rate_id;
                        $row->serial = $item->serial_no;
                        $row->option = $item->option_id;
                        $options = $this->pos_model->getProductOptions($row->id, $item->warehouse_id);

                        if ($options) {
                            $option_quantity = 0;
                            foreach ($options as $option) {
                                $pis = $this->site->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                                if ($pis) {
                                    foreach ($pis as $pi) {
                                        $option_quantity += $pi->quantity_balance;
                                    }
                                }
                                if ($option->quantity > $option_quantity) {
                                    $option->quantity = $option_quantity;
                                }
                            }
                        }

                        $row->comment = isset($item->comment) ? $item->comment : '';
                        $row->ordered = 1;
                        $combo_items = false;
                        if ($row->type == 'combo') {
                            $combo_items = $this->pos_model->getProductComboItems($row->id, $item->warehouse_id);
                        }
                        $units = $this->site->getUnitsByBUID($row->base_unit);
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $ri = $this->Settings->item_addition ? $row->id : $c;
                        
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 
                                'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options);
                        $c++;
                    }
                   // var_dump($suspended_sale);
                    $this->data['items'] = json_encode($pr);
                    $this->data['sid'] = $sid;
                    $this->data['suspend_sale'] = $suspended_sale;
                    $this->data['message'] = lang('suspended_sale_loaded');
                    $this->data['customer'] = $this->pos_model->getCompanyByID($suspended_sale->customer_id);
                    $this->data['reference_note'] = $suspended_sale->suspend_note;
                } else {
                    $this->session->set_flashdata('error', lang("bill_x_found"));
                    redirect("pos");
                }
            } else if ($table_id) {
                if ($tablesave_sale = $this->pos_model->getOpenBillByID_table($table_id)) {
                    $inv_items_tablesave = $this->pos_model->getSuspendedSaleItems_table($table_id);
                   // var_dump($inv_items_tablesave);
                    krsort($inv_items_tablesave);
                    $c = rand(100000, 9999999);
                    foreach ($inv_items_tablesave as $item) {
                        $row = $this->site->getProductByID($item->product_id);
                        if (!$row) {
                            $row = json_decode('{}');
                            $row->tax_method = 0;
                            $row->quantity = 0;
                        } else {
                            $category = $this->site->getCategoryByID($row->category_id);
                            $row->category_name = $category->name;
                            unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                        }
                        $pis = $this->site->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $row->quantity += $pi->quantity_balance;
                            }
                        }
                        $row->id = $item->product_id;
                        $row->code = $item->product_code;
                        $row->name = $item->product_name;
                        $row->type = $item->product_type;            
                        $row->quantity += $item->quantity;
                        $row->discount = $item->discount ? $item->discount : '0';
                        $row->price = $this->sma->formatDecimal($item->net_unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity));
                        $row->unit_price = $row->tax_method ? $item->unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity) + $this->sma->formatDecimal($item->item_tax / $item->quantity) : $item->unit_price + ($item->item_discount / $item->quantity);
                        $row->real_unit_price = $item->real_unit_price;
                        $row->base_quantity = $item->quantity;
                        $row->base_unit = isset($row->unit) ? $row->unit : $item->product_unit_id;
                        $row->base_unit_price = $row->price ? $row->price : $item->unit_price;
                        $row->unit = $item->product_unit_id;
                        $row->qty = $item->unit_quantity;
                        $row->tax_rate = $item->tax_rate_id;
                        $row->serial = $item->serial_no;
                        $row->option = $item->option_id;
                        $options = $this->pos_model->getProductOptions($row->id, $item->warehouse_id);

                        if ($options) {
                            $option_quantity = 0;
                            foreach ($options as $option) {
                                $pis = $this->site->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                                if ($pis) {
                                    foreach ($pis as $pi) {
                                        $option_quantity += $pi->quantity_balance;
                                    }
                                }
                                if ($option->quantity > $option_quantity) {
                                    $option->quantity = $option_quantity;
                                }
                            }
                        }

                        $row->comment = isset($item->comment) ? $item->comment : '';
                        $row->ordered = 1;
                        $combo_items = false;
                        if ($row->type == 'combo') {
                            $combo_items = $this->pos_model->getProductComboItems($row->id, $item->warehouse_id);
                        }
                        $units = $this->site->getUnitsByBUID($row->base_unit);
                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                        $ri = $this->Settings->item_addition ? $row->id : $c;
                        
                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 
                                'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options);
                        $c++;
                    }
                   // var_dump($suspended_sale);
                    $this->data['items'] = json_encode($pr);
                    $this->data['table_sid'] = $table_id;
                    $this->data['table_suspend_sale'] = $tablesave_sale;
                    $this->data['message'] = lang('table_sale_loaded');
                    $this->data['customer'] = $this->pos_model->getCompanyByID($tablesave_sale->customer_id);
                    $this->data['reference_note'] = $tablesave_sale->suspend_note;
                } else {
                    $this->session->set_flashdata('error', lang("bill_x_found"));
                    redirect("pos");
                }
            } else {
                $this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);
                $this->data['reference_note'] = NULL;
            }

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['message'] = isset($this->data['message']) ? $this->data['message'] : $this->session->flashdata('message');

            // $this->data['biller'] = $this->site->getCompanyByID($this->pos_settings->default_biller);
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            $this->data['user'] = $this->site->getUser();
            $this->data["tcp"] = $this->pos_model->products_count($this->pos_settings->default_category);
            $this->data['products'] = $this->ajaxproducts($this->pos_settings->default_category);
            $this->data['categories'] = $this->site->getAllCategories();
            $this->data['brands'] = $this->site->getAllBrands();
            $this->data['subcategories'] = $this->site->getSubCategories($this->pos_settings->default_category);
            $this->data['printer'] = $this->pos_model->getPrinterByID($this->pos_settings->printer);
            $order_printers = json_decode($this->pos_settings->order_printers);
            /*foreach ($order_printers as $printer_id) {
                $printers[] = $this->pos_model->getPrinterByID($printer_id);
            }*/
            $this->data['order_printers'] = (isset($printers)?$printers:'');
            $this->data['pos_settings'] = $this->pos_settings;

            /*added by sudip start*/
            $default_customer_id = $this->data['customer']->id;
            $ssql ="SELECT * FROM `sma_sales` where customer_id='$default_customer_id' order by id desc  LIMIT 0,1";
                //echo $ssql;
            $previouseSaleDetail=$this->db->query($ssql);               
            if($previouseSaleDetail->num_rows() > 0){
                $this->data['previouseSaleDetail'] =$previouseSaleDetail->row();
                //print_r($this->data['previouseSaleDetail']->total_items);
                //exit;
            }
            /*added by sudip end*/ 

            if ($this->pos_settings->after_sale_page && $saleid = $this->input->get('print', true)) {
                if ($inv = $this->pos_model->getInvoiceByID($saleid)) {
                    $this->load->helper('pos');
                    if (!$this->session->userdata('view_right')) {
                        $this->sma->view_rights($inv->created_by, true);
                    }
                    $this->data['rows'] = $this->pos_model->getAllInvoiceItems($inv->id);
                    $this->data['biller'] = $this->pos_model->getCompanyByID($inv->biller_id);
                    $this->data['customer'] = $this->pos_model->getCompanyByID($inv->customer_id);
                    $this->data['payments'] = $this->pos_model->getInvoicePayments($inv->id);
                    $this->data['return_sale'] = $inv->return_id ? $this->pos_model->getInvoiceByID($inv->return_id) : NULL;
                    $this->data['return_rows'] = $inv->return_id ? $this->pos_model->getAllInvoiceItems($inv->return_id) : NULL;
                    $this->data['return_payments'] = $this->data['return_sale'] ? $this->pos_model->getInvoicePayments($this->data['return_sale']->id) : NULL;
                    $this->data['inv'] = $inv;
                    $this->data['print'] = $inv->id;
                    $this->data['created_by'] = $this->site->getUser($inv->created_by);
                }
            }
             $totalSaleCount=$this->db->query("SELECT id FROM `sma_sales` where 1 order by id desc  LIMIT 0,1;");
            if($totalSaleCount->num_rows() > 0){
                $this->data['totalSaleCount'] =$totalSaleCount->row();
            }
            $this->data['pos_resize'] = $this->get_pos_resize();
            //echo $customer_id;
            $this->load->view($this->theme . 'pos/add', $this->data);
        }
    }
     public function peruse_no()
    {
$default_customer_id = $this->input->get('customer_id');
            $ssql ="SELECT * FROM `sma_sales` where customer_id='$default_customer_id' order by id desc  LIMIT 0,1";
//echo $ssql;
            $previouseSaleDetail=$this->db->query($ssql);               
            if($previouseSaleDetail->num_rows() > 0){
                $previouseSaleDetail =$previouseSaleDetail->row();
                $arr['today_peruse'] = $previouseSaleDetail->today_peruse;
 $this->sma->send_json(array('result' => 'success', 'peruse_no' => $previouseSaleDetail->today_peruse));
//echo json_encode($arr);
         
            }else{
$this->sma->send_json(array('result' => 'success', 'peruse_no' => 0));
}
}
    public function view_bill()
    {
        $this->sma->checkPermissions('index');
        $this->data['tax_rates'] = $this->site->getAllTaxRates();
        $this->load->view($this->theme . 'pos/view_bill', $this->data);
    }

    public function stripe_balance()
    {
        if (!$this->Owner) {
            return FALSE;
        }
        $this->load->model('stripe_payments');

        return $this->stripe_payments->get_balance();
    }

    public function paypal_balance()
    {
        if (!$this->Owner) {
            return FALSE;
        }
        $this->load->model('paypal_payments');

        return $this->paypal_payments->get_balance();
    }

    public function registers()
    {
        $this->sma->checkPermissions();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['registers'] = $this->pos_model->getOpenRegisters();
        //$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('open_registers')));
        // $meta = array('page_title' => lang('open_registers'), 'bc' => $bc);
        // $this->page_construct('pos/registers', $meta, $this->data);
        $this->load->view($this->theme . 'pos/registers', $this->data);
    }

    public function open_register()
    {
        $this->sma->checkPermissions('index');
        $this->form_validation->set_rules('cash_in_hand', lang("cash_in_hand"), 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'date' => date('Y-m-d H:i:s'),
                'cash_in_hand' => $this->input->post('cash_in_hand'),
                'user_id'      => $this->session->userdata('user_id'),
                'status'       => 'open',
                );
        }
        if ($this->form_validation->run() == TRUE && $this->pos_model->openRegister($data)) {
            $this->session->set_flashdata('message', lang("welcome_to_pos"));
            redirect("pos");
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('open_register')));
            $meta = array('page_title' => lang('open_register'), 'bc' => $bc);
            $this->page_construct('pos/open_register', $meta, $this->data);
        }
    }

    public function close_register($user_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if (!$this->Owner && !$this->Admin) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->form_validation->set_rules('total_cash', lang("total_cash"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cheques', lang("total_cheques"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cc_slips', lang("total_cc_slips"), 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
            if ($this->Owner || $this->Admin) {
                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
                $rid = $user_register ? $user_register->id : $this->session->userdata('register_id');
                $user_id = $user_register ? $user_register->user_id : $this->session->userdata('user_id');
            } else {
                $rid = $this->session->userdata('register_id');
                $user_id = $this->session->userdata('user_id');
            }
            $data = array(
                'closed_at'                => date('Y-m-d H:i:s'),
                'total_cash'               => $this->input->post('total_cash'),
                'total_cheques'            => $this->input->post('total_cheques'),
                'total_cc_slips'           => $this->input->post('total_cc_slips'),
                'total_cash_submitted'     => $this->input->post('total_cash_submitted'),
                'total_cheques_submitted'  => $this->input->post('total_cheques_submitted'),
                'total_cc_slips_submitted' => $this->input->post('total_cc_slips_submitted'),
                'note'                     => $this->input->post('note'),
                'status'                   => 'close',
                'transfer_opened_bills'    => $this->input->post('transfer_opened_bills'),
                'closed_by'                => $this->session->userdata('user_id'),
                );
        } elseif ($this->input->post('close_register')) {
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : $this->session->flashdata('error')));
            redirect("pos");
        }

        if ($this->form_validation->run() == TRUE && $this->pos_model->closeRegister($rid, $user_id, $data)) {
            $this->session->set_flashdata('message', lang("register_closed"));
            redirect("welcome");
        } else {
            if ($this->Owner || $this->Admin) {
                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
                $register_open_time = $user_register ? $user_register->date : NULL;
                $this->data['cash_in_hand'] = $user_register ? $user_register->cash_in_hand : NULL;
                $this->data['register_open_time'] = $user_register ? $register_open_time : NULL;
            } else {
                $register_open_time = $this->session->userdata('register_open_time');
                $this->data['cash_in_hand'] = NULL;
                $this->data['register_open_time'] = NULL;
            }
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time, $user_id);
            $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time, $user_id);
            $this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time, $user_id);
            $this->data['gcsales'] = $this->pos_model->getRegisterGCSales($register_open_time);
            $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time, $user_id);
            $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time, $user_id);
            $this->data['authorizesales'] = $this->pos_model->getRegisterAuthorizeSales($register_open_time, $user_id);
            $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time, $user_id);
            $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time, $user_id);
            $this->data['cashrefunds'] = $this->pos_model->getRegisterCashRefunds($register_open_time, $user_id);
            $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time, $user_id);
            $this->data['users'] = $this->pos_model->getUsers($user_id);
            $this->data['suspended_bills'] = $this->pos_model->getSuspendedsales($user_id);
            $this->data['user_id'] = $user_id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'pos/close_register', $this->data);
        }
    }

    public function getProductDataByCode($code = NULL, $warehouse_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('code')) {
            $code = $this->input->get('code', TRUE);
        }
        if ($this->input->get('warehouse_id')) {
            $warehouse_id = $this->input->get('warehouse_id', TRUE);
        }
        if ($this->input->get('customer_id')) {
            $customer_id = $this->input->get('customer_id', TRUE);
        }
        if (!$code) {
            echo NULL;
            die();
        }
        $warehouse = $this->site->getWarehouseByID($warehouse_id);
        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $row = $this->pos_model->getWHProduct($code, $warehouse_id);
        $option = false;
        if ($row) {
            unset($row->cost, $row->details, $row->product_details, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
            $row->item_tax_method = $row->tax_method;
            $row->qty = 1;
            $row->discount = '0';
            $row->serial = '';
            $options = $this->pos_model->getProductOptions($row->id, $warehouse_id);
            if ($options) {
                $opt = current($options);
                if (!$option) {
                    $option = $opt->id;
                }
            } else {
                $opt = json_decode('{}');
                $opt->price = 0;
            }
            $row->option = $option;
            $row->quantity = 0;
            $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
            if ($pis) {
                foreach ($pis as $pi) {
                    $row->quantity += $pi->quantity_balance;
                }
            }
            if ($row->type == 'standard' && (!$this->Settings->overselling && $row->quantity < 1)) {
                echo NULL; die();
            }
            if ($options) {
                $option_quantity = 0;
                foreach ($options as $option) {
                    $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
                    if ($pis) {
                        foreach ($pis as $pi) {
                            $option_quantity += $pi->quantity_balance;
                        }
                    }
                    if ($option->quantity > $option_quantity) {
                        $option->quantity = $option_quantity;
                    }
                }
            }
            if ($row->promotion) {
                $row->price = $row->promo_price;
            } elseif ($customer->price_group_id) {
                if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $customer->price_group_id)) {
                    $row->price = $pr_group_price->price;
                }
            } elseif ($warehouse->price_group_id) {
                if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $warehouse->price_group_id)) {
                    $row->price = $pr_group_price->price;
                }
            }
/*added by sudip start*/
            $row->price_before_discount = $row->price;
            /*added by sudip end*/
            $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
            /*added by sudip*/
             $row->customer_group_discount = (($row->price_before_discount * $customer_group->percent) / 100);
            $row->customer_group_name = $customer_group->name;

 $row->discount_option_field = 'Customer Price Group : '.$customer->price_group_id.' --- Warehouse Price Group : '.$warehouse->price_group_id.'------ Promotion : '.$row->promotion.'------percent discount : '. $customer_group->percent .'-------Calculation : (('. $row->price .' * '. $customer_group->percent .') / '. 100 .');';


            /*added by sudip*/
            $row->real_unit_price = $row->price;
            $row->base_quantity = 1;
            $row->base_unit = $row->unit;
            $row->base_unit_price = $row->price;
            $row->unit = $row->sale_unit ? $row->sale_unit : $row->unit;
            $row->comment = '';
            $combo_items = false;
            if ($row->type == 'combo') {
                $combo_items = $this->pos_model->getProductComboItems($row->id, $warehouse_id);
            }
            $units = $this->site->getUnitsByBUID($row->base_unit);
            $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

            $pr = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'category' => $row->category_id, 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, 'image' => $row->image);

            $this->sma->send_json($pr);
        } else {
            echo NULL;
        }
    }

    public function ajaxproducts($category_id = NULL, $brand_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('brand_id')) {
            $brand_id = $this->input->get('brand_id');
        }
        if ($this->input->get('category_id')) {
            $category_id = $this->input->get('category_id');
        } else {
            $category_id = $this->pos_settings->default_category;
        }
        if ($this->input->get('subcategory_id')) {
            $subcategory_id = $this->input->get('subcategory_id');
        } else {
            $subcategory_id = NULL;
        }
        if ($this->input->get('per_page') == 'n') {
            $page = 0;
        } else {
            $page = $this->input->get('per_page');
        }

        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url() . "pos/ajaxproducts";
        $config["total_rows"] = $this->pos_model->products_count($category_id, $subcategory_id, $brand_id);
        $config["per_page"] = $this->pos_settings->pro_limit;
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $config['display_pages'] = FALSE;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;

        $this->pagination->initialize($config);

        $products = $this->pos_model->fetch_products($category_id, $config["per_page"], $page, $subcategory_id, $brand_id);
        $pro = 1;
        $prods = '<div>';
        if (!empty($products)) {
            foreach ($products as $product) {
                $count = $product->id;
                if ($count < 10) {
                    $count = "0" . ($count / 100) * 100;
                }
                if ($category_id < 10) {
                    $category_id = "0" . ($category_id / 100) * 100;
                }

                $prods .= "<button id=\"product-" . $category_id . $count . "\" type=\"button\" value='" . $product->code . "' title=\"" . $product->name . "\" class=\"btn-prni btn-" . $this->pos_settings->product_button_color . " product pos-tip\" data-container=\"body\"><img src=\"" . base_url() . "assets/uploads/thumbs/" . $product->image . "\" alt=\"" . $product->name . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded' /><span>" . character_limiter($product->name, 40) . "</span></button>";

                $pro++;
            }
        }
        $prods .= "</div>";

        if ($this->input->get('per_page')) {
            echo $prods;
        } else {
            return $prods;
        }
    }

    public function ajaxcategorydata($category_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('category_id')) {
            $category_id = $this->input->get('category_id');
        } else {
            $category_id = $this->pos_settings->default_category;
        }

        $subcategories = $this->site->getSubCategories($category_id);
        $scats = '';
        if ($subcategories) {
            foreach ($subcategories as $category) {
                $scats .= "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
            }
        }

        $products = $this->ajaxproducts($category_id);

        if (!($tcp = $this->pos_model->products_count($category_id))) {
            $tcp = 0;
        }

        $this->sma->send_json(array('products' => $products, 'subcategories' => $scats, 'tcp' => $tcp));
    }

    public function ajaxbranddata($brand_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('brand_id')) {
            $brand_id = $this->input->get('brand_id');
        }

        $products = $this->ajaxproducts(FALSE, $brand_id);

        if (!($tcp = $this->pos_model->products_count(FALSE, FALSE, $brand_id))) {
            $tcp = 0;
        }

        $this->sma->send_json(array('products' => $products, 'tcp' => $tcp));
    }

    /* ------------------------------------------------------------------------------------ */

    public function view($sale_id = NULL, $modal = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        }
        $this->load->helper('pos');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by, true);
        }
        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);


        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $table_id = $inv->table_id;
       $order_type_setting = $inv->order_type_setting;
      
        $customer_virtual = $this->site->getCompanyByID($customer_id);

        $customer_group = $this->site->getCustomerGroupByID($customer_virtual->customer_group_id);
        //
//(($row->price_before_discount * $customer_group->percent) / 100);
//die();

        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['table'] = $this->table_model->getTableByID($table_id);
//echo $this->order_type_setting($order_type_setting);
        $this->data['order_type_setting'] = (!empty($order_type_setting)?$this->order_type_setting($order_type_setting):'');
        
        $this->data['pos_resize'] = $this->get_pos_resize();
        
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code128', 30);
        $this->data['return_sale'] = $inv->return_id ? $this->pos_model->getInvoiceByID($inv->return_id) : NULL;
        $this->data['return_rows'] = $inv->return_id ? $this->pos_model->getAllInvoiceItems($inv->return_id) : NULL;
        $this->data['return_payments'] = $this->data['return_sale'] ? $this->pos_model->getInvoicePayments($this->data['return_sale']->id) : NULL;
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['modal'] = $modal;
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['printer'] = $this->pos_model->getPrinterByID($this->pos_settings->printer);
        $this->data['page_title'] = $this->lang->line("invoice");
$this->data['customer_group_percent'] = $customer_group->percent;

        $this->load->view($this->theme . 'pos/view', $this->data);
    }
    public function view_ajax($sale_id = NULL, $modal = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        }
        $this->load->helper('pos');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by, true);
        }
        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);


        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $table_id = $inv->table_id;
       $order_type_setting = $inv->order_type_setting;
      
        $customer_virtual = $this->site->getCompanyByID($customer_id);

        $customer_group = $this->site->getCustomerGroupByID($customer_virtual->customer_group_id);
        //
//(($row->price_before_discount * $customer_group->percent) / 100);
//die();

        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['table'] = $this->table_model->getTableByID($table_id);
//echo $this->order_type_setting($order_type_setting);
        $this->data['order_type_setting'] = (!empty($order_type_setting)?$this->order_type_setting($order_type_setting):'');
        
        $this->data['pos_resize'] = $this->get_pos_resize();
        
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code128', 30);
        $this->data['return_sale'] = $inv->return_id ? $this->pos_model->getInvoiceByID($inv->return_id) : NULL;
        $this->data['return_rows'] = $inv->return_id ? $this->pos_model->getAllInvoiceItems($inv->return_id) : NULL;
        $this->data['return_payments'] = $this->data['return_sale'] ? $this->pos_model->getInvoicePayments($this->data['return_sale']->id) : NULL;
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['modal'] = $modal;
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['printer'] = $this->pos_model->getPrinterByID($this->pos_settings->printer);
        $this->data['page_title'] = $this->lang->line("invoice");
$this->data['customer_group_percent'] = $customer_group->percent;

        $this->load->view($this->theme . 'pos/view_ajax', $this->data);
    }
    public function order_type_setting($selected_id){
        $order_type_setting = json_decode($this->pos_settings->order_type_setting);
		//var_dump($order_type_setting); die();
        $order_type_setting_array = (array)$order_type_setting[0];
		foreach($order_type_setting_array as $key=>$val){
			if($key==$selected_id){
				$current_val = $val;
			}
		}

        return $current_val;
    }
    public function get_pos_resize(){
        $insert_chk = "select * from sma_pos_shorting where user_id='".$this->session->userdata('user_id')."'";
        $res = $this->db->query($insert_chk)->row();
        return $res;
    }
    public function register_details()
    {
        $this->sma->checkPermissions('index');
        $register_open_time = $this->session->userdata('register_open_time');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time);
        $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time);
        $this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time);
        $this->data['gcsales'] = $this->pos_model->getRegisterGCSales($register_open_time);
        $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time);
        $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time);
        $this->data['authorizesales'] = $this->pos_model->getRegisterAuthorizeSales($register_open_time);
        $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time);
        $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time);
        $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time);
        $this->load->view($this->theme . 'pos/register_details', $this->data);
    }

    public function today_sale()
    {
        if (!$this->Owner && !$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['ccsales'] = $this->pos_model->getTodayCCSales();
        $this->data['cashsales'] = $this->pos_model->getTodayCashSales();
        $this->data['chsales'] = $this->pos_model->getTodayChSales();
        $this->data['pppsales'] = $this->pos_model->getTodayPPPSales();
        $this->data['stripesales'] = $this->pos_model->getTodayStripeSales();
        $this->data['authorizesales'] = $this->pos_model->getTodayAuthorizeSales();
        $this->data['totalsales'] = $this->pos_model->getTodaySales();
        $this->data['refunds'] = $this->pos_model->getTodayRefunds();
        $this->data['expenses'] = $this->pos_model->getTodayExpenses();
        $this->load->view($this->theme . 'pos/today_sale', $this->data);
    }

    public function check_pin()
    {
        $pin = $this->input->post('pw', TRUE);
        if ($pin == $this->pos_pin) {
            $this->sma->send_json(array('res' => 1));
        }
        $this->sma->send_json(array('res' => 0));
    }

    public function barcode($text = NULL, $bcs = 'code128', $height = 50)
    {
        return site_url('products/gen_barcode/' . $text . '/' . $bcs . '/' . $height);
    }

    public function settings()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
        $this->form_validation->set_rules('pro_limit', $this->lang->line('pro_limit'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('pin_code', $this->lang->line('delete_code'), 'numeric');
        $this->form_validation->set_rules('category', $this->lang->line('default_category'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('customer', $this->lang->line('default_customer'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('biller', $this->lang->line('default_biller'), 'required|is_natural_no_zero');

        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'pro_limit'                 => $this->input->post('pro_limit'),
                'pin_code'                  => $this->input->post('pin_code') ? $this->input->post('pin_code') : NULL,
                'default_category'          => $this->input->post('category'),
                'default_customer'          => $this->input->post('customer'),
                'default_biller'            => $this->input->post('biller'),
                'display_time'              => $this->input->post('display_time'),
                'receipt_printer'           => $this->input->post('receipt_printer'),
                'cash_drawer_codes'         => $this->input->post('cash_drawer_codes'),
                'cf_title1'                 => $this->input->post('cf_title1'),
                'cf_title2'                 => $this->input->post('cf_title2'),
                'cf_value1'                 => $this->input->post('cf_value1'),
                'cf_value2'                 => $this->input->post('cf_value2'),
                'focus_add_item'            => $this->input->post('focus_add_item'),
                'add_manual_product'        => $this->input->post('add_manual_product'),
                'customer_selection'        => $this->input->post('customer_selection'),
                'add_customer'              => $this->input->post('add_customer'),
                'toggle_category_slider'    => $this->input->post('toggle_category_slider'),
                'toggle_subcategory_slider' => $this->input->post('toggle_subcategory_slider'),
                'toggle_brands_slider'      => $this->input->post('toggle_brands_slider'),
                'cancel_sale'               => $this->input->post('cancel_sale'),
                'suspend_sale'              => $this->input->post('suspend_sale'),
                'print_items_list'          => $this->input->post('print_items_list'),
                'finalize_sale'             => $this->input->post('finalize_sale'),
                'today_sale'                => $this->input->post('today_sale'),
                'open_hold_bills'           => $this->input->post('open_hold_bills'),
                'close_register'            => $this->input->post('close_register'),
                'tooltips'                  => $this->input->post('tooltips'),
                'keyboard'                  => $this->input->post('keyboard'),
                'pos_printers'              => $this->input->post('pos_printers'),
                'java_applet'               => $this->input->post('enable_java_applet'),
                'product_button_color'      => $this->input->post('product_button_color'),
                'paypal_pro'                => $this->input->post('paypal_pro'),
                'stripe'                    => $this->input->post('stripe'),
                'order_type_setting'        => '[{"1":"Dain in","2":"Delivery","3":"Take away"},{"selected":'.$this->input->post('order_type_setting').'}]',
                'restaurant_model'          => $this->input->post('restaurant_model'),
                
                'authorize'                 => $this->input->post('authorize'),
                'fastpay'                 => $this->input->post('fastpay'),
                'rounding'                  => $this->input->post('rounding'),
                'item_order'                => $this->input->post('item_order'),
                'after_sale_page'           => $this->input->post('after_sale_page'),
                'printer'                   => $this->input->post('receipt_printer'),
                'order_printers'            => json_encode($this->input->post('order_printers')),
                'auto_print'                => $this->input->post('auto_print'),
                'remote_printing'           => DEMO ? 1 : $this->input->post('remote_printing'),
                'customer_details'          => $this->input->post('customer_details'),
            );
            $payment_config = array(
                'APIUsername'            => $this->input->post('APIUsername'),
                'APIPassword'            => $this->input->post('APIPassword'),
                'APISignature'           => $this->input->post('APISignature'),
                'stripe_secret_key'      => $this->input->post('stripe_secret_key'),
                'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),
                'api_login_id'           => $this->input->post('api_login_id'),
                'api_transaction_key'    => $this->input->post('api_transaction_key'),
                'MerchantMobileNo'    => $this->input->post('MerchantMobileNo'),
                'StorePassword'    => $this->input->post('StorePassword'),
                'StoreID'    => $this->input->post('StoreID'),
                'FastPaySandbox'    => $this->input->post('FastPaySandbox'),
            );
        } elseif ($this->input->post('update_settings')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == TRUE && $this->pos_model->updateSetting($data)) {
            if (DEMO) {
                $this->session->set_flashdata('message', $this->lang->line('pos_setting_updated'));
                redirect($_SERVER["HTTP_REFERER"]);
            }
            if ($this->write_payments_config($payment_config)) {
                $this->session->set_flashdata('message', $this->lang->line('pos_setting_updated'));
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error', $this->lang->line('pos_setting_updated_payment_failed'));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['pos'] = $this->pos_model->getSetting();
            $this->data['categories'] = $this->site->getAllCategories();
            //$this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);
            $this->data['billers'] = $this->pos_model->getAllBillerCompanies();
            $this->config->load('payment_gateways');
            $this->data['stripe_secret_key'] = $this->config->item('stripe_secret_key');
            $this->data['stripe_publishable_key'] = $this->config->item('stripe_publishable_key');
            $authorize = $this->config->item('authorize');
            $this->data['api_login_id'] = $authorize['api_login_id'];
            $this->data['api_transaction_key'] = $authorize['api_transaction_key'];
            $this->data['APIUsername'] = $this->config->item('APIUsername');
            $this->data['APIPassword'] = $this->config->item('APIPassword');
            $this->data['APISignature'] = $this->config->item('APISignature');
            $this->data['MerchantMobileNo'] = $this->config->item('MerchantMobileNo');
            $this->data['StorePassword'] = $this->config->item('StorePassword');
            $this->data['StoreID'] = $this->config->item('StoreID');
            $this->data['FastPaySandbox'] = $this->config->item('FastPaySandbox');
            $this->data['printers'] = $this->pos_model->getAllPrinters();
            $this->data['paypal_balance'] = NULL; // $this->pos_settings->paypal_pro ? $this->paypal_balance() : NULL;
            $this->data['stripe_balance'] = NULL; // $this->pos_settings->stripe ? $this->stripe_balance() : NULL;
            // $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('pos_settings')));
            // $meta = array('page_title' => lang('pos_settings'), 'bc' => $bc);
            // $this->page_construct('pos/settings', $meta, $this->data);
            $this->load->view($this->theme . 'pos/settings', $this->data);
        }
    }

    public function write_payments_config($config)
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        if (DEMO) {
            return TRUE;
        }
        $file_contents = file_get_contents('./assets/config_dumps/payment_gateways.php');
        $output_path = APPPATH . 'config/payment_gateways.php';
        $this->load->library('parser');
        $parse_data = array(
            'APIUsername'            => $config['APIUsername'],
            'APIPassword'            => $config['APIPassword'],
            'APISignature'           => $config['APISignature'],
            'MerchantMobileNo'           => $config['MerchantMobileNo'],
            'StorePassword'           => $config['StorePassword'],
            'StoreID'           => $config['StoreID'],
            'FastPaySandbox'           => $config['FastPaySandbox'],
            'stripe_secret_key'      => $config['stripe_secret_key'],
            'stripe_publishable_key' => $config['stripe_publishable_key'],
            'api_login_id'           => $config['api_login_id'],
            'api_transaction_key'    => $config['api_transaction_key'],
        );
        $new_config = $this->parser->parse_string($file_contents, $parse_data);

        $handle = fopen($output_path, 'w+');
        @chmod($output_path, 0777);

        if (is_writable($output_path)) {
            if (fwrite($handle, $new_config)) {
                @chmod($output_path, 0644);

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function opened_bills($per_page = 0)
    {
        $this->load->library('pagination');

        //$this->table->set_heading('Id', 'The Title', 'The Content');
        if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        }

        $config['base_url'] = site_url('pos/opened_bills');
        $config['total_rows'] = $this->pos_model->bills_count();
        $config['per_page'] = 6;
        $config['num_links'] = 3;

        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['r'] = TRUE;
        $bills = $this->pos_model->fetch_bills($config['per_page'], $per_page);
		
		//echo"<pre>"; print_r($bills); die;
        if (!empty($bills)) {
            $html = "";
            $html .= '<ul class="ob">';
            foreach ($bills as $bill) {
                $html .= '<li><button type="button" class="btn btn-info sus_sale" id="' . $bill->id . '"><p><strong>Table:</strong> '.$bill->table_name.'</p><p>' . $bill->suspend_note . '</p><strong>' . $bill->customer . '</strong><br>'.lang('date').': ' . $bill->date . '<br>'.lang('items').': ' . $bill->count . '<br>'.lang('total').': ' . $this->sma->formatMoney($bill->total) . '</button></li>';
            }
            $html .= '</ul>';
        } else {
            $html = "<h3>" . lang('no_opeded_bill') . "</h3><p>&nbsp;</p>";
            $data['r'] = FALSE;
        }

        $data['html'] = $html;

        $data['page'] = $this->pagination->create_links();
        echo $this->load->view($this->theme . 'pos/opened', $data, TRUE);

    }
	public function save_tables($per_page = 0)
    {
        $this->load->library('pagination');

        //$this->table->set_heading('Id', 'The Title', 'The Content');
        if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        }

        $config['base_url'] = site_url('pos/save_tables');
        $config['total_rows'] = $this->pos_model->savetable_count();
        $config['per_page'] = 6;
        $config['num_links'] = 3;

        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['r'] = TRUE;
        $bills = $this->pos_model->fetch_tables($config['per_page'], $per_page);
        if (!empty($bills)) {
            $html = "";
            $html .= '<ul class="ob">';
            foreach ($bills as $bill) {
                $html .= '<li><small><!--<a href="javascript:void(0);" onclick="delete_table(' . $bill->id . ');">Close</a>--></small><button type="button" class="btn btn-info sus_sale" id="' . $bill->id . '"><p>' . $bill->suspend_note . '</p>';
                $html .= '<img src="'.site_url('assets\/uploads\/').'avatars/tableB'.$bill->no_guest.'.svg'.'">';
                //<strong>' . $bill->customer . '</strong>
                $html .= '<br>'.lang('date').': ' . $bill->date . '<br>'.lang('items').': ' . $bill->count . '<br>'.lang('total').': ' . $this->sma->formatMoney($bill->total) . '</button></li>';
            }
            $html .= '</ul>';
        } else {
            $html = "<h3>" . lang('no_opeded_bill') . "</h3><p>&nbsp;</p>";
            $data['r'] = FALSE;
        }

        $data['html'] = $html;

        $data['page'] = $this->pagination->create_links();
        echo $this->load->view($this->theme . 'pos/save_tables', $data, TRUE);

    }
    public function delete($id = NULL)
    {

        $this->sma->checkPermissions('index');

        if ($this->pos_model->deleteBill($id)) {
            $this->sma->send_json(array('error' => 0, 'msg' => lang("suspended_sale_deleted")));
        }
    }

    public function email_receipt($sale_id = NULL)
    {
        $this->sma->checkPermissions('index');
        if ($this->input->post('id')) {
            $sale_id = $this->input->post('id');
        } 
        if ( ! $sale_id) {
            die('No sale selected.');
        }
        if ($this->input->post('email')) {
            $to = $this->input->post('email');
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');

        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);

        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code128', 30);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['page_title'] = $this->lang->line("invoice");

        if (!$to) {
            $to = $this->data['customer']->email;
        }
        if (!$to) {
            $this->sma->send_json(array('msg' => $this->lang->line("no_meil_provided")));
        }
        $receipt = $this->load->view($this->theme . 'pos/email_receipt', $this->data, TRUE);

        if ($this->sma->send_email($to, 'Receipt from ' . $this->data['biller']->company, $receipt)) {
            $this->sma->send_json(array('msg' => $this->lang->line("email_sent")));
        } else {
            $this->sma->send_json(array('msg' => $this->lang->line("email_failed")));
        }

    }

    public function active()
    {
        $this->session->set_userdata('last_activity', now());
        if ((now() - $this->session->userdata('last_activity')) <= 20) {
            die('Successfully updated the last activity.');
        } else {
            die('Failed to update last activity.');
        }
    }

    public function add_payment($id = NULL)
    {
        $this->sma->checkPermissions('payments', TRUE, 'sales');
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == TRUE) {
            if ($this->input->post('paid_by') == 'deposit') {
                $sale = $this->pos_model->getInvoiceByID($this->input->post('sale_id'));
                $customer_id = $sale->customer_id;
                if ( ! $this->site->check_customer_deposit($customer_id, $this->input->post('amount-paid'))) {
                    $this->session->set_flashdata('error', lang("amount_greater_than_deposit"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $customer_id = null;
            }
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $payment = array(
                'date'         => $date,
                'sale_id'      => $this->input->post('sale_id'),
                'reference_no' => $this->input->post('reference_no'),
                'amount'       => $this->input->post('amount-paid'),
                'paid_by'      => $this->input->post('paid_by'),
                'cheque_no'    => $this->input->post('cheque_no'),
                'cc_no'        => $this->input->post('paid_by') == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
                'cc_holder'    => $this->input->post('pcc_holder'),
                'cc_month'     => $this->input->post('pcc_month'),
                'cc_year'      => $this->input->post('pcc_year'),
                'cc_type'      => $this->input->post('pcc_type'),
                'cc_cvv2'      => $this->input->post('pcc_ccv'),
                'note'         => $this->input->post('note'),
                'created_by'   => $this->session->userdata('user_id'),
                'type'         => 'received',
            );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

            //$this->sma->print_arrays($payment);

        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == TRUE && $msg = $this->pos_model->addPayment($payment, $customer_id)) {
            if ($msg) {
                if ($msg['status'] == 0) {
                    unset($msg['status']);
                    $error = '';
                    foreach ($msg as $m) {
                        if (is_array($m)) {
                            foreach ($m as $e) {
                                $error .= '<br>'.$e;
                            }
                        } else {
                            $error .= '<br>'.$m;
                        }
                    }
                    $this->session->set_flashdata('error', '<pre>' . $error . '</pre>');
                } else {
                    $this->session->set_flashdata('message', lang("payment_added"));
                }
            } else {
                $this->session->set_flashdata('error', lang("payment_failed"));
            }
            redirect("pos/sales");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $sale = $this->pos_model->getInvoiceByID($id);
            $this->data['inv'] = $sale;
            $this->data['payment_ref'] = $this->site->getReference('pay');
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'pos/add_payment', $this->data);
        }
    }

    public function updates()
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');
        if ($this->form_validation->run() == TRUE) {
            $this->db->update('pos_settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('pos_id' => 1));
            redirect('pos/updates');
        } else {
            $fields = array('version' => $this->pos_settings->version, 'code' => $this->pos_settings->purchase_code, 'username' => $this->pos_settings->envato_username, 'site' => base_url());
            $this->load->helper('update');
            $protocol = is_https() ? 'https://' : 'http://';
            $updates = get_remote_contents($protocol . 'rozhsoft.com/api/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('updates')));
            $meta = array('page_title' => lang('updates'), 'bc' => $bc);
            $this->page_construct('pos/updates', $meta, $this->data);

        }
    }

    public function install_update($file, $m_version, $version)
    {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('update');
        save_remote_file($file . '.zip');
        $this->sma->unzip('./files/updates/' . $file . '.zip');
        if ($m_version) {
            $this->load->library('migration');
            if (!$this->migration->latest()) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                redirect("pos/updates");
            }
        }
        $this->db->update('pos_settings', array('version' => $version, 'update' => 0), array('pos_id' => 1));
        unlink('./files/updates/' . $file . '.zip');
        $this->session->set_flashdata('success', lang('update_done'));
        redirect("pos/updates");
    }

    function open_drawer() {

        $data = json_decode($this->input->get('data'));
        $this->load->library('escpos');
        $this->escpos->load($data->printer);
        $this->escpos->open_drawer();

    }

    function p() {

        $data = json_decode($this->input->get('data'));
        $this->load->library('escpos');
        $this->escpos->load($data->printer);
        $this->escpos->print_receipt($data);

    }

    function printers()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("pos");
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('printers');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('printers')));
        $meta = array('page_title' => lang('list_printers'), 'bc' => $bc);
        $this->page_construct('pos/printers', $meta, $this->data);
    }

    function get_printers()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }

        $this->load->library('datatables');
        $this->datatables
        ->select("id, title, type, profile, path, ip_address, port")
        ->from("printers")
        ->add_column("Actions", "<div class='text-center'> <a href='" . site_url('pos/edit_printer/$1') . "' class='btn-warning btn-xs tip' title='".lang("edit_printer")."'><i class='fa fa-edit'></i></a> <a href='#' class='btn-danger btn-xs tip po' title='<b>" . lang("delete_printer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('pos/delete_printer/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id")
        ->unset_column('id');
        echo $this->datatables->generate();

    }

    function add_printer()
    {

        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("pos");
        }

        $this->form_validation->set_rules('title', $this->lang->line("title"), 'required');
        $this->form_validation->set_rules('type', $this->lang->line("type"), 'required');
        $this->form_validation->set_rules('profile', $this->lang->line("profile"), 'required');
        $this->form_validation->set_rules('char_per_line', $this->lang->line("char_per_line"), 'required');
        if ($this->input->post('type') == 'network') {
            $this->form_validation->set_rules('ip_address', $this->lang->line("ip_address"), 'required|is_unique[printers.ip_address]');
            $this->form_validation->set_rules('port', $this->lang->line("port"), 'required');
        } else {
            $this->form_validation->set_rules('path', $this->lang->line("path"), 'required|is_unique[printers.path]');
        }

        if ($this->form_validation->run() == true) {

            $data = array('title' => $this->input->post('title'),
                'type' => $this->input->post('type'),
                'profile' => $this->input->post('profile'),
                'char_per_line' => $this->input->post('char_per_line'),
                'path' => $this->input->post('path'),
                'ip_address' => $this->input->post('ip_address'),
                'port' => ($this->input->post('type') == 'network') ? $this->input->post('port') : NULL,
            );

        }

        if ( $this->form_validation->run() == true && $cid = $this->pos_model->addPrinter($data)) {

            $this->session->set_flashdata('message', $this->lang->line("printer_added"));
            redirect("pos/printers");

        } else {
            if($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'failed', 'msg' => validation_errors())); die();
            }

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['page_title'] = lang('add_printer');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => site_url('pos/printers'), 'page' => lang('printers')), array('link' => '#', 'page' => lang('add_printer')));
            $meta = array('page_title' => lang('add_printer'), 'bc' => $bc);
            $this->page_construct('pos/add_printer', $meta, $this->data);
        }
    }

    function edit_printer($id = NULL)
    {

        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("pos");
        }
        if($this->input->get('id')) { $id = $this->input->get('id', TRUE); }

        $printer = $this->pos_model->getPrinterByID($id);
        $this->form_validation->set_rules('title', $this->lang->line("title"), 'required');
        $this->form_validation->set_rules('type', $this->lang->line("type"), 'required');
        $this->form_validation->set_rules('profile', $this->lang->line("profile"), 'required');
        $this->form_validation->set_rules('char_per_line', $this->lang->line("char_per_line"), 'required');
        if ($this->input->post('type') == 'network') {
            $this->form_validation->set_rules('ip_address', $this->lang->line("ip_address"), 'required');
            if ($this->input->post('ip_address') != $printer->ip_address) {
                $this->form_validation->set_rules('ip_address', $this->lang->line("ip_address"), 'is_unique[printers.ip_address]');
            }
            $this->form_validation->set_rules('port', $this->lang->line("port"), 'required');
        } else {
            $this->form_validation->set_rules('path', $this->lang->line("path"), 'required');
            if ($this->input->post('path') != $printer->path) {
                $this->form_validation->set_rules('path', $this->lang->line("path"), 'is_unique[printers.path]');
            }
        }

        if ($this->form_validation->run() == true) {

            $data = array('title' => $this->input->post('title'),
                'type' => $this->input->post('type'),
                'profile' => $this->input->post('profile'),
                'char_per_line' => $this->input->post('char_per_line'),
                'path' => $this->input->post('path'),
                'ip_address' => $this->input->post('ip_address'),
                'port' => ($this->input->post('type') == 'network') ? $this->input->post('port') : NULL,
            );

        }

        if ( $this->form_validation->run() == true && $this->pos_model->updatePrinter($id, $data)) {

            $this->session->set_flashdata('message', $this->lang->line("printer_updated"));
            redirect("pos/printers");

        } else {

            $this->data['printer'] = $printer;
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['page_title'] = lang('edit_printer');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => site_url('pos/printers'), 'page' => lang('printers')), array('link' => '#', 'page' => lang('edit_printer')));
            $meta = array('page_title' => lang('edit_printer'), 'bc' => $bc);
            $this->page_construct('pos/edit_printer', $meta, $this->data);

        }
    }

    function delete_printer($id = NULL)
    {
        if(DEMO) {
            $this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
            $this->sma->md();
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }

        if ($this->input->get('id')) { $id = $this->input->get('id', TRUE); }

        if ($this->pos_model->deletePrinter($id)) {
            $this->sma->send_json(array('error' => 0, 'msg' => lang("printer_deleted")));
        }

    }
   
    public function sendSMS($sale_id=''){


        require $_SERVER['DOCUMENT_ROOT'].'/pos3/' . "twilio-php/Services/Twilio.php";
     
        $ajax_response['message'] = 'Message not Sent.';
        $ajax_response['ok'] = 0;
        $sid = TWILIO_SID;
        $token = TWILIO_TOKEN;
        $From = TWILIO_FROM_NUMBER;
//echo $sid.'--'.$token.'--'.$From;
        //$sale_id = $this->input->get('sale_id', TRUE);
        $SaleDetail=$this->db->query("select cmp.phone as phone, sl.grand_total as grand_total  from sma_sales as sl left join sma_companies as cmp on cmp.id=sl.customer_id where sl.id='$sale_id';"); 
              
        if($SaleDetail->num_rows() > 0){
            $customerDetail =$SaleDetail->row();
            if($customerDetail->phone!=''){
                $To = $customerDetail->phone;//receiver mobile number
                //$To = '+9647703146777';
                $Body = 'BMS::Dear Customer, the bill ammounting to '.$customerDetail->grand_total.' is pending.please ignore this SMS if already paid.';
                $client = new Services_Twilio($sid, $token);
                $client->account->messages->create(array(
                    'To' => $To,
                    'From' => $From,
                    'Body' => $Body
                ));
                //$ajax_response['id'] = $inserted_id;
                $ajax_response['message'] = 'Message Sent.';
                $ajax_response['ok'] = 1;
            }
            //print_r($this->data['previouseSaleDetail']->total_items);
            //exit;
	echo json_encode($ajax_response);
        exit;
        }else{
	$ajax_response['error'] = 'SMS not send';
	echo json_encode($ajax_response);
	}
        
        
    
	
	

}
}