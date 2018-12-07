<?php defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH.'core'.DIRECTORY_SEPARATOR.'MY_Shop_Controller.php');
class Pay extends MY_Shop_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model('pay_model');
        $this->load->model('settings_model');
        $settings = $this->settings_model->getSettings();
        if($settings){
            if($settings->shop_feature == 0){
                redirect('admin/login');
            }
        }
    }

    function index() {
        if (!SHOP) { redirect('admin'); }
        redirect();
    }
    function fastpay($id){
        $this->config->load('payment_gateways');
        if ($inv = $this->pay_model->getSaleByID($id)) {

            $possetting = $this->pay_model->getFastpaySettings();
            if($possetting->fastpay == 1 && (($inv->grand_total - $inv->paid) > 0)){
                $customer = $this->pay_model->getCompanyByID($inv->customer_id);
                $biller = $this->pay_model->getCompanyByID($inv->biller_id);
                $FastPaySandbox = $this->config->item('FastPaySandbox');
                $url_fastpay = 'https://secure.fast-pay.cash';
                if($FastPaySandbox == 1){
                    $url_fastpay = 'https://dev.fast-pay.cash';
                }
                $post_data = array();
                $post_data['merchant_mobile_no'] = $this->config->item('MerchantMobileNo');
                $post_data['store_password'] = $this->config->item('StorePassword');
                $post_data['order_id'] = $id;
                $post_data['bill_amount'] = ($inv->grand_total - $inv->paid);
                $post_data['success_url'] = site_url('pay/fipn/'.$id);
                $post_data['fail_url'] = site_url('pay/fipn/'.$id);
                $post_data['cancel_url'] = site_url('pay/fipn/'.$id);
                $direct_api_url = $url_fastpay.'/merchant/generate-payment-token';
                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $direct_api_url );
                curl_setopt($handle, CURLOPT_TIMEOUT, 10);
                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($handle, CURLOPT_POST, 1 );
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($handle );
                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if($code == 200 && !( curl_errno($handle))) {
                    curl_close( $handle);
                    $response = $content;
                    $decodedResponse = json_decode($response, true );
                    if($decodedResponse['code'] == 200){
                        header("Location: ".$url_fastpay."/merchant/payment?token=".$decodedResponse['token']);
                    }
                    else{
                        $this->session->set_flashdata('error', $decodedResponse['messages'][0]);
                        redirect('/');
                    }
                }
                else {
                    $this->session->set_flashdata('error', 'FAILED TO CONNECT WITH FastPay  API');
                    redirect('shop/orders/'.$id);
                }
            }
        }
        else{
            $this->session->set_flashdata('error', 'Not found order');
            redirect('/');
        }
    }

    function paypal($id) {
        if ($inv = $this->pay_model->getSaleByID($id)) {

            $paypal = $this->pay_model->getPaypalSettings();
            if ($paypal->active && (($inv->grand_total - $inv->paid) > 0)) {
                $customer = $this->pay_model->getCompanyByID($inv->customer_id);
                $biller = $this->pay_model->getCompanyByID($inv->biller_id);
                if (trim(strtolower($customer->country)) == $biller->country) {
                    $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_my / 100);
                } else {
                    $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_other / 100);
                }
                $data = array(
                    'rm' => 2,
                    'no_note' => 1,
                    'no_shipping' => 1,
                    'bn' => 'FC-BuyNow',
                    'item_number' => $inv->id,
                    'item_name' => $inv->reference_no,
                    'return' => urldecode(site_url('pay/pipn')),
                    'notify_url' => urldecode(site_url('pay/pipn')),
                    'currency_code' => $this->default_currency->code,
                    'cancel_return' => urldecode(site_url('pay/pipn')),
                    'amount' => (($inv->grand_total - $inv->paid) + $paypal_fee),
                    'image_url' => base_url() . 'assets/uploads/logos/' . $this->Settings->logo,
                    'business' => (DEMO ? 'saleem-facilitator@tecdiary.com' : $paypal->account_email),
                    'custom' => $inv->reference_no . '__' . ($inv->grand_total - $inv->paid) . '__' . $paypal_fee,
                );
                $query = http_build_query($data, null, '&');
                redirect('https://www'.(DEMO ? '.sandbox' : '').'.paypal.com/cgi-bin/webscr?cmd=_xclick&'.$query);
            }
        }
        $this->session->set_flashdata('error', lang('sale_x_found'));
        redirect('/');
    }

    function skrill($id) {
        if ($inv = $this->pay_model->getSaleByID($id)) {

            $skrill = $this->pay_model->getSkrillSettings();
            if ($skrill->active && (($inv->grand_total - $inv->paid) > 0)) {
                $customer = $this->pay_model->getCompanyByID($inv->customer_id);
                $biller = $this->pay_model->getCompanyByID($inv->biller_id);
                if (trim(strtolower($customer->country)) == $biller->country) {
                    $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_my / 100);
                } else {
                    $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_other / 100);
                }
                redirect('https://www.moneybookers.com/app/payment.pl?method=get&pay_to_email=' . $skrill->account_email . '&language=EN&merchant_fields=item_name,item_number&item_name=' . $inv->reference_no . '&item_number=' . $inv->id . '&logo_url=' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '&amount=' . (($inv->grand_total - $inv->paid) + $skrill_fee) . '&return_url=' . shop_url('orders/'.$inv->id)  . '&cancel_url=' . site_url('/')  . '&detail1_description=' . $inv->reference_no . '&detail1_text=Payment for the sale invoice ' . $inv->reference_no . ': ' . $inv->grand_total . '(+ fee: ' . $skrill_fee . ') = ' . $this->sma->formatMoney($inv->grand_total + $skrill_fee) . '&currency=' . $this->default_currency->code . '&status_url=' . site_url('pay/sipn') );
            }
        }
        $this->session->set_flashdata('error', lang('sale_x_found'));
        redirect('/');
    }
    function paytest(){
        header('Location: https://dev.fast-pay.cash/merchant/payment?token=asdadsadsa');
    }

    function fipn(){

        $this->config->load('payment_gateways');
        if ($this->input->post('order_id') && $this->input->post('transaction_id') && $inv = $this->pay_model->getSaleByID($this->input->post('order_id'))) {
            $id = $this->input->post('order_id');
            $shop_setting = $this->pay_model->getShopSettings();
            $post_data = array();
            $post_data['merchant_mobile_no'] = $this->config->item('MerchantMobileNo');
            $post_data['store_password'] = $this->config->item('StoreID');
            $post_data['order_id']=$id;
            $FastPaySandbox = $this->config->item('FastPaySandbox');
            $url_fastpay = 'https://secure.fast-pay.cash';
            if($FastPaySandbox == 1){
                $url_fastpay = 'https://dev.fast-pay.cash';
            }
            $requested_url = $url_fastpay.'/merchant/payment/validation';
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $requested_url );
            curl_setopt($handle, CURLOPT_TIMEOUT, 10);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($handle, CURLOPT_POST, 1 );
            curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($handle);

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if($code == 200 && !( curl_errno($handle)))
            {
                $result = json_decode($result);
                $messages = $result->messages;
                $code = $result->code;
                $fastpay_data = $result->data;
                if($code == 200){
                    if($fastpay_data->status =='Success'){
                        $amount = $fastpay_data->bill_amount;
                        $payment = array(
                            'date' => date('Y-m-d H:i:s'),
                            'sale_id' => $invoice_no,
                            'reference_no' => $this->site->getReference('pay'),
                            'amount' => $amount,
                            'paid_by' => 'fastpay',
                            'transaction_id' => $fastpay_data->transaction_id,
                            'type' => 'received',
                            'note' => $fastpay_data->customer_account_no . ' had been paid '.$amount.' for the Sale Reference No ' . $inv->reference_no
                        );
                        if ($this->pay_model->addPayment($payment)) {
                            $customer = $this->pay_model->getCompanyByID($inv->customer_id);
                            $this->pay_model->updateStatus($inv->id, 'completed');

                            $this->load->library('parser');
                            $parse_data = array(
                                'reference_number' => $inv->reference_no,
                                'contact_person' => $customer->name,
                                'company' => $customer->company,
                                'site_link' => base_url(),
                                'site_name' => $this->Settings->site_name,
                                'logo' => '<img src="' . base_url('assets/uploads/logos/' . $this->Settings->logo) . '" alt="' . $this->Settings->site_name . '"/>'
                            );

                            $msg = file_get_contents('./themes/' . $this->Settings->theme . '/admin/views/email_templates/payment.html');
                            $message = $this->parser->parse_string($msg, $parse_data);
                            $this->sma->log_payment('SUCCESS', 'Payment has been made for Sale Reference #' . $inv->reference_no . ' via FastPay (' . $fastpay_data->transaction_id . ').', json_encode($fastpay_data));
                            try {
                                $this->sma->send_email($shop_setting->email, 'Payment made for sale '.$inv->reference_no, $message);
                            } catch (Exception $e) {
                                $this->sma->log_payment('Email Notification Failed: ' . $e->getMessage());
                            }
                            $this->session->set_flashdata('message', lang('payment_added'));
                            $ipnstatus = TRUE;
                            redirect(SHOP ? '/' : site_url($ipnstatus ? 'notify/payment_success' : 'notify/payment_failed'));
                        }
                    }
                    else {
                        redirect('shop/orders/'.$id);
                    }
                }
                else {
                    $this->session->set_flashdata('error', 'Failed to connect with FastPay');
                    redirect('/');
                }                

            } else {
                $this->session->set_flashdata('error', 'Failed to connect with FastPay');
                redirect('/');
            }
        }
        else{
            $this->session->set_flashdata('error', lang('sale_x_found'));
            redirect('/');
        }
        
    }

    function pipn() {

        $paypal = $this->pay_model->getPaypalSettings();
        $this->sma->log_payment('INFO', 'Paypal IPN called');
        $ipnstatus = FALSE;

        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Host: www".(DEMO ? '.sandbox' : '').".paypal.com\r\n";
        // $header .= "Host: www.paypal.com\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n";
        $header .= "Connection: close\r\n\r\n";

        $fp = fsockopen ('ssl://www'.(DEMO ? '.sandbox' : '').'.paypal.com', 443, $errno, $errstr, 30);
        // $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

        if (!$fp) {

            $this->sma->log_payment('ERROR', 'Paypal Payment Failed (IPN HTTP ERROR)', $errstr);
            $this->session->set_flashdata('error', lang('payment_failed'));

        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                //log_message('error', 'Paypal IPN - fp handler -'.$res);
                if (stripos($res, "VERIFIED") !== false) {
                    $this->sma->log_payment('INFO', 'Paypal IPN - VERIFIED');

                    $custom = explode('__', $_POST['custom']);
                    $payer_email = $_POST['payer_email'];
                    $invoice_no = $_POST['item_number'];
                    $reference = $_POST['item_name'];

                    if (($_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Processed' || $_POST['payment_status'] == 'Pending') && ($_POST['business'] == $paypal->account_email || $_POST['business'] == 'saleem-facilitator@tecdiary.com')) {

                        if ($_POST['mc_currency'] == $this->Settings->default_currency) {
                            $amount = $_POST['mc_gross'];
                        } else {
                            $currency = $this->site->getCurrencyByCode($_POST['mc_currency']);
                            $amount = $_POST['mc_gross'] * (1 / $currency->rate);
                        }
                        if ($inv = $this->pay_model->getSaleByID($invoice_no)) {
                            $payment = array(
                                'date' => date('Y-m-d H:i:s'),
                                'sale_id' => $invoice_no,
                                'reference_no' => $this->site->getReference('pay'),
                                'amount' => $amount,
                                'paid_by' => 'paypal',
                                'transaction_id' => $_POST['txn_id'],
                                'type' => 'received',
                                'note' => $_POST['mc_currency'] . ' ' . $_POST['mc_gross'] . ' had been paid for the Sale Reference No ' . $inv->reference_no
                            );
                            if ($this->pay_model->addPayment($payment)) {
                                $customer = $this->pay_model->getCompanyByID($inv->customer_id);
                                $this->pay_model->updateStatus($inv->id, 'completed');

                                $this->load->library('parser');
                                $parse_data = array(
                                    'reference_number' => $reference,
                                    'contact_person' => $customer->name,
                                    'company' => $customer->company,
                                    'site_link' => base_url(),
                                    'site_name' => $this->Settings->site_name,
                                    'logo' => '<img src="' . base_url('assets/uploads/logos/' . $this->Settings->logo) . '" alt="' . $this->Settings->site_name . '"/>'
                                );

                                $msg = file_get_contents('./themes/' . $this->Settings->theme . '/admin/views/email_templates/payment.html');
                                $message = $this->parser->parse_string($msg, $parse_data);
                                $this->sma->log_payment('SUCCESS', 'Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Paypal (' . $_POST['txn_id'] . ').', json_encode($_POST));
                                try {
                                    $this->sma->send_email($paypal->account_email, 'Payment made for sale '.$inv->reference_no, $message);
                                } catch (Exception $e) {
                                    $this->sma->log_payment('Email Notification Failed: ' . $e->getMessage());
                                }
                                $this->session->set_flashdata('message', lang('payment_added'));
                                $ipnstatus = TRUE;
                            }
                        }
                    } else {

                        $this->sma->log_payment('ERROR', 'Payment failed for Sale Reference #' . $reference . ' via Paypal (' . $_POST['txn_id'] . ').', json_encode($_POST));
                        $this->session->set_flashdata('error', lang('payment_failed'));

                    }
                } else if (stripos($res, "INVALID") !== false) {
                    $this->sma->log_payment('ERROR', 'INVALID response from Paypal. Payment failed via Paypal.', json_encode($_POST));
                    $this->session->set_flashdata('error', lang('payment_failed'));
                }
            }
            fclose($fp);
        }

        redirect(SHOP ? '/' : site_url($ipnstatus ? 'notify/payment_success' : 'notify/payment_failed'));
        exit();
    }

    function sipn() {

        $skrill = $this->pay_model->getSkrillSettings();
        $this->sma->log_payment('INFO', 'Skrill IPN called', json_encode($_POST));
        $ipnstatus = FALSE;

        if (isset($_POST['merchant_id']) && isset($_POST['md5sig'])) {
            $concatFields = $_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5($skrill->secret_word)) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status'];

            if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->account_email) {
                $invoice_no = $_POST['item_number'];
                $reference = $_POST['item_name'];
                if ($_POST['mb_currency'] == $this->Settings->default_currency) {
                    $amount = $_POST['mb_amount'];
                } else {
                    $currency = $this->site->getCurrencyByCode($_POST['mb_currency']);
                    $amount = $_POST['mb_amount'] * (1 / $currency->rate);
                }
                if ($inv = $this->pay_model->getSaleByID($invoice_no)) {
                    $payment = array(
                        'date' => date('Y-m-d H:i:s'),
                        'sale_id' => $invoice_no,
                        'reference_no' => $this->site->getReference('pay'),
                        'amount' => $amount,
                        'paid_by' => 'skrill',
                        'transaction_id' => $_POST['mb_transaction_id'],
                        'type' => 'received',
                        'note' => $_POST['mb_currency'] . ' ' . $_POST['mb_amount'] . ' had been paid for the Sale Reference No ' . $reference
                        );
                    if ($this->pay_model->addPayment($payment)) {
                        $customer = $this->site->getCompanyByID($inv->customer_id);
                        $this->pay_model->updateStatus($inv->id, 'completed');

                        $this->load->library('parser');
                        $parse_data = array(
                            'reference_number' => $reference,
                            'contact_person' => $customer->name,
                            'company' => $customer->company,
                            'site_link' => base_url(),
                            'site_name' => $this->Settings->site_name,
                            'logo' => '<img src="' . base_url('assets/uploads/logos/' . $this->Settings->logo) . '" alt="' . $this->Settings->site_name . '"/>'
                            );

                        $msg = file_get_contents('./themes/' . $this->Settings->theme . '/admin/views/email_templates/payment.html');
                        $message = $this->parser->parse_string($msg, $parse_data);
                        $this->sma->log_payment('SUCCESS', 'Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Skrill (' . $_POST['mb_transaction_id'] . ').', json_encode($_POST));
                        try {
                            $this->sma->send_email($skrill->account_email, 'Payment made for sale '.$inv->reference_no, $message);
                        } catch (Exception $e) {
                            $this->sma->log_payment('Email Notification Failed: ' . $e->getMessage());
                        }
                        $this->session->set_flashdata('message', lang('payment_added'));
                        $ipnstatus = TRUE;
                    }
                }
            } else {
                $this->sma->log_payment('ERROR', 'Payment failed for via Skrill.', json_encode($_POST));
                $this->session->set_flashdata('error', lang('payment_failed'));
            }
        } else {
            redirect('notify/payment');
        }

        redirect(SHOP ? '/' : site_url($ipnstatus ? 'notify/payment_success' : 'notify/payment_failed'));
        exit();
    }
}
