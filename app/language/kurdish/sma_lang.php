<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: English
 *
 * Last edited:
 * 30th April 2015
 *
 * Package:
 * Business Management System v3.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 *  salah@rozhsoft.com
 * Thank you
 */

/* --------------------- CUSTOM FIELDS ------------------------ */
/*
* Below are custome field labels
* Please only change the part after = and make sure you change the the words in between "";
* $lang['bcf1']                         = "Biller Custom Field 1";
* Don't change this                     = "You can change this part";
* For support email contact@rozhsoft.com Thank you!
*/

$lang['bcf1']                           = "خانەی تایبەتی رێکخەری پسوڵە 1";
$lang['bcf2']                           = "خانەی تایبەتی رێکخەری پسوڵە 2";
$lang['bcf3']                           = "خانەی تایبەتی رێکخەری پسوڵە 3";
$lang['bcf4']                           = "خانەی تایبەتی رێکخەری پسوڵە 4";
$lang['bcf5']                           = "خانەی تایبەتی رێکخەری پسوڵە 5";
$lang['bcf6']                           = "خانەی تایبەتی رێکخەری پسوڵە 6";
$lang['pcf1']                           = "خانەی تایبەتی بەرهەم 1";
$lang['pcf2']                           = "خانەی تایبەتی بەرهەم 2";
$lang['pcf3']                           = "خانەی تایبەتی بەرهەم 3";
$lang['pcf4']                           = "خانەی تایبەتی بەرهەم 4";
$lang['pcf5']                           = "خانەی تایبەتی بەرهەم 5";
$lang['pcf6']                           = "خانەی تایبەتی بەرهەم 6";
$lang['ccf1']                           = "خانەی تایبەتی کڕیار 1";
$lang['ccf2']                           = "خانەی تایبەتی کڕیار 2";
$lang['ccf3']                           = "خانەی تایبەتی کڕیار 3";
$lang['ccf4']                           = "خانەی تایبەتی کڕیار 4";
$lang['ccf5']                           = "خانەی تایبەتی کڕیار 5";
$lang['ccf6']                           = "خانەی تایبەتی کڕیار 6";
$lang['scf1']                           = "خانەی تایبەتی دابینکەر 1";
$lang['scf2']                           = "خانەی تایبەتی دابینکەر 2";
$lang['scf3']                           = "خانەی تایبەتی دابینکەر 3";
$lang['scf4']                           = "خانەی تایبەتی دابینکەر 4";
$lang['scf5']                           = "خانەی تایبەتی دابینکەر 5";
$lang['scf6']                           = "خانەی تایبەتی دابینکەر 6";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@rozhsoft.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "هیچ داتایەک لە خشتەکەدا نییە",
    'sInfo'                         => "Showing _START_ to _END_ of _TOTAL_ entries",
    'sInfoEmpty'                    => "Showing 0 to 0 of 0 entries",
    'sInfoFiltered'                 => "(filtered from _MAX_ total entries)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Show _MENU_ ",
    'sLoadingRecords'               => "Loading...",
    'sProcessing'                   => "Processing...",
    'sSearch'                       => "گەڕان",
    'sZeroRecords'                  => "No matching records found",
    'oAria'                                     => array(
      'sSortAscending'                => ": activate to sort column ascending",
      'sSortDescending'               => ": activate to sort column descending"
      ),
    'oPaginate'                                 => array(
      'sFirst'                        => "<< First",
      'sLast'                         => "Last >>",
      'sNext'                         => "Next >",
      'sPrevious'                     => "< Previous",
      )
    );

/* ----------------- Select2 LANGUAGE ---------------------- */
/*
* Below are select2 lib language entries
* Please only change the part after = and make sure you change the the words in between "";
* 's2_errorLoading'                 => "The results could not be loaded",
* Don't change this                 => "You can change this part but not the word between {} like {t};
* For support email support@rozhsoft.com Thank you!
*/

$lang['select2_lang']               = array(
    'formatMatches_s'               => "تەنها یەک ئەنجام دۆزرایەوە ئینتەر بکە بۆ دەستنیشانکردنی",
    'formatMatches_p'               => "results are available, use up and down arrow keys to navigate.",
    'formatNoMatches'               => "هیش ئەنجامێک نەدۆزرایەوە",
    'formatInputTooShort'           => "کایە {n} کارەکتەر یان زیاتر بنوسە",
    'formatInputTooLong_s'          => "تکایە {n} کارەکتەر بسڕەرەوە",
    'formatInputTooLong_p'          => "تکایە {n} کارەکتەر بسڕەرەوە",
    'formatSelectionTooBig_s'       => "ئایتم دەستنیشان بکەیت {n} دەتوانیت تەنها",
    'formatSelectionTooBig_p'       => "ئایتم دەستنیشان بکەیت {n} دەتوانیت تەنها",
    'formatLoadMore'                => "Loading more results...",
    'formatAjaxError'               => "Ajax request failed",
    'formatSearching'               => "Searching..."
    );


/* ----------------- BMS GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "سەرەکی";
$lang['dashboard']                          = "داشبۆرد";
$lang['username']                           = "ناوی خوازراو";
$lang['password']                           = "پاسوۆرد";
$lang['first_name']                         = "ناو";
$lang['last_name']                          = "ناوی خێزان/باوک";
$lang['confirm_password']                   = "دوبارە پاسوۆرد بنوسەرەوە";
$lang['email']                              = "ئیمەیڵ";
$lang['phone']                              = "ژمارەی تەلەفۆن";
$lang['company']                            = "کۆمپانیا";
$lang['product_code']                       = "کۆدی بەرهەم";
$lang['product_name']                       = "ناوی بەرهەم";
$lang['cname']                              = "ناوی کڕیار";
$lang['barcode_symbology']                  = "Barcode Symbology";
$lang['product_unit']                       = "ژمارەی بەرهەم";
$lang['product_price']                      = "نرخی بەرهەم";
$lang['contact_person']                     = "پەیوەندی";
$lang['email_address']                      = "ئیمەیڵ ئادرێس";
$lang['address']                            = "ناونیشان";
$lang['city']                               = "شار";
$lang['today']                              = "ئەمڕۆ";
$lang['welcome']                            = "بەخێربێیت";
$lang['profile']                            = "پرۆفایل";
$lang['change_password']                    = "گۆڕینی پاسوۆرد";
$lang['logout']                             = "چوونە دەرەوە";
$lang['notifications']                      = "ئاگادارییەکان";
$lang['calendar']                           = "رۆژژمێر";
$lang['messages']                           = "مەسجەکان";
$lang['styles']                             = "ستایلەکان";
$lang['language']                           = "زمان";
$lang['alerts']                             = "ئاگادارکردنەوەکان";
$lang['list_products']                      = "لیستی بەرهەمەکان";
$lang['add_product']                        = "دانانی بەرهەم";
$lang['print_barcodes']                     = "چاپکردنی باڕکۆد";
$lang['print_labels']                       = "چاپکردنی لەیبڵ";
$lang['import_products']                    = "هاوردەکردنی بەرهەمەکان";
$lang['update_price']                       = "نوێکردنەوەی نرخ";
$lang['damage_products']                    = "بەرهەمە خراپبووەکان";
$lang['sales']                              = "فرۆشتنەکان";
$lang['list_sales']                         = "لیستی فرۆشتنەکان";
$lang['add_sale']                           = "دانانی فرۆشتن";
$lang['deliveries']                         = "گەیاندنەکان";
$lang['gift_cards']                         = "کارتی دیارییەکان";
$lang['quotes']                             = "دەرخستەکان";
$lang['list_quotes']                        = "لیستی دەرخستەکان";
$lang['add_quote']                          = "دانانی دەرخستە";
$lang['purchases']                          = "کڕینەکان";
$lang['list_purchases']                     = "لیستی کڕینەکان";
$lang['add_purchase']                       = "دانانی کڕین";
$lang['add_purchase_by_csv']                = "دانانی کڕین بە CSV";
$lang['transfers']                          = "گواستنەوەکان";
$lang['list_transfers']                     = "لیستی گواستنەوەکان";
$lang['add_transfer']                       = "دانانی گواستنەوە";
$lang['add_transfer_by_csv']                = "دانانی گواستنەوە بە CSV";
$lang['people']                             = "خەڵک";
$lang['list_users']                         = "لیستی بەکارهێنەرەکان";
$lang['new_user']                           = "دانانی بەکارهێنەر";
$lang['list_billers']                       = "لیستی رێکخەری پسوڵەکان";
$lang['add_biller']                         = "دانانی رێکخەری پسوڵە";
$lang['list_customers']                     = "لیستی کڕیارەکان";
$lang['add_customer']                       = "دانانی کڕیار";
$lang['list_suppliers']                     = "لیستی دابینکەران";
$lang['add_supplier']                       = "دانانی دابینکەر";
$lang['settings']                           = "رێکخستنەکان";
$lang['system_settings']                    = "رێکخستنەکانی سیستەم";
$lang['change_logo']                        = "گۆڕینی لۆگۆ";
$lang['currencies']                         = "دراوەکان";
$lang['attributes']                         = "جۆرەکانی بەرهەم";
$lang['customer_groups']                    = "گروپەکانی کڕیار";
$lang['categories']                         = "بەشەکان";
$lang['subcategories']                      = "لقەکانی بەشەکان";
$lang['tax_rates']                          = "رێژەکانی باج";
$lang['warehouses']                         = "کۆگاکان";
$lang['email_templates']                    = "قاڵبەکانی ئیمەیڵ";
$lang['group_permissions']                  = "رێگەپێدانەکانی گروپ";
$lang['backup_database']                    = "باک ئەپی داتابەیس";
$lang['reports']                            = "راپۆرتەکان";
$lang['overview_chart']                     = "Overview Chart";
$lang['warehouse_stock']                    = "چارتی کاڵاکانی ناو کۆگا";
$lang['product_quantity_alerts']            = " ئاگادارییەکانی ژمارەی بەرهەم";
$lang['product_expiry_alerts']              = " ئاگادارییەکانی بەسەرچوونی بەرهەم";
$lang['products_report']                    = "راپۆرتی بەرهەمەکان";
$lang['daily_sales']                        = "فرۆشتنی رۆژانە";
$lang['monthly_sales']                      = "فرۆشتنی مانگانە";
$lang['sales_report']                       = "راپۆرتی فرۆشتنەکان";
$lang['payments_report']                    = "راپۆرتی پارەدانەکان";
$lang['profit_and_loss']                    = "قازانج و/یان زەرەر";
$lang['purchases_report']                   = "راپۆرتی کڕینەکان";
$lang['customers_report']                   = "راپۆرتی کڕیارەکان";
$lang['suppliers_report']                   = "راپۆرتی دابینکەران";
$lang['staff_report']                       = "راپۆرتی ستاف";
$lang['your_ip']                            = "Your IP Address";
$lang['last_login_at']                      = "ئەخیر چوونەژوورەوەت لەم کاتەدا بوو";
$lang['notification_post_at']               = "ئەم ئاگاداریە لەم کاتەدا پۆست کرا";
$lang['quick_links']                        = "لینکی خێرا";
$lang['date']                               = "بەروار";
$lang['reference_no']                       = "ژمارەی سەرچاوە";
$lang['products']                           = "بەرهەمەکان";
$lang['customers']                          = "کڕیارەکان";
$lang['suppliers']                          = "دابینکەران";
$lang['users']                              = "بەکارهێنەران";
$lang['latest_five']                        = "نوێترین ٥";
$lang['total']                              = "کۆ";
$lang['payment_status']                     = "دۆخی پارەدان";
$lang['paid']                               = "دراوە";
$lang['customer']                           = "کڕیار";
$lang['status']                             = "دۆخ";
$lang['amount']                             = "بڕ";
$lang['supplier']                           = "دابینکەر";
$lang['from']                               = "لە";
$lang['to']                                 = "بۆ";
$lang['name']                               = "ناو";
$lang['create_user']                        = "دانانی بەکارهێنەر";
$lang['gender']                             = "رەگەز";
$lang['biller']                             = "رێکخەری پسوڵە";
$lang['select']                             = "دەستنیشانکردن";
$lang['warehouse']                          = "کۆگا";
$lang['active']                             = "چالاکە";
$lang['inactive']                           = "چالاک نییە";
$lang['all']                                = "هەمووی";
$lang['list_results']                       = "تکایە ئەم خشتەیەی خوارەوە بەکاربهێنە بۆ دۆزینەوە و رێکخستنی ئەنجامەکان. دەتوانیت خشتەکە بەم شێوانە دابگریت excel,pdf.";
$lang['actions']                            = "کردارەکان";
$lang['pos']                                = "POS";
$lang['access_denied']                      = "Access Denied! You don't have right to access the requested page. If you think, it's by mistake, please contact administrator.";
$lang['add']                                = "دانان";
$lang['edit']                               = "گۆڕانکاری";
$lang['delete']                             = "سڕینەوە";
$lang['view']                               = "پێشاندان";
$lang['update']                             = "نوێکردنەوە";
$lang['save']                               = "سەیڤ کردن";
$lang['login']                              = "چوونە ژوورەوە";
$lang['submit']                             = "پێشکەشکردن";
$lang['no']                                 = "نەخێر";
$lang['yes']                                = "بەڵێ";
$lang['disable']                            = "لەکارخستن";
$lang['enable']                             = "خستنەوە کار";
$lang['enter_info']                         = "تکایە ئەم زانیارییانەی لای خوارەوە پڕبکەرەوە ئەو خانانەی * لاوەیە پێویستە پربکرێنەوە";
$lang['update_info']                        = "تکایە ئەم زانیارییانەی لای خوارەوە نوێبکەرەوە ئەو خانانەی * لاوەیە پێویستە پربکرێنەوە";
$lang['no_suggestions']                     = "هیچ داتایەک بۆ پێشنیارکردن بەدەست نەهات، تکایە دڵنیابەرەوە لە راست پڕکردنەوەی خانەکان";
$lang['i_m_sure']                           = 'بەڵێ دڵنیام';
$lang['r_u_sure']                           = 'دڵنیایت؟';
$lang['export_to_excel']                    = "Export to Excel file";
$lang['export_to_pdf']                      = "Export to PDF file";
$lang['image']                              = "وێنە";
$lang['sale']                               = "فرۆشتن";
$lang['quote']                              = "دەرخستە";
$lang['purchase']                           = "کڕین";
$lang['transfer']                           = "گواستنەوە";
$lang['payment']                            = "پارەدان";
$lang['payments']                           = "پارەدانەکان";
$lang['orders']                             = "داواکارییەکان";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "VAT Number";
$lang['country']                            = "وڵات";
$lang['add_user']                           = "دانانی بەکارهێنەر";
$lang['type']                               = "جۆر";
$lang['person']                             = "کەس";
$lang['state']                              = "state";
$lang['postal_code']                        = "Postal Code";
$lang['id']                                 = "ID";
$lang['close']                              = "داخستن";
$lang['male']                               = "نێر";
$lang['female']                             = "مێ";
$lang['notify_user']                        = "ئاگادارکردنەوەی بەکارهێنەر";
$lang['notify_user_by_email']               = "ئاگادارکردنەوەی بەکارهێنەر بە ئیمەیڵ";
$lang['billers']                            = "رێکخەری پسوڵەکان";
$lang['all_warehouses']                     = "هەموو کۆگاکان";
$lang['category']                           = "بەش";
$lang['product_cost']                       = "تێچووی بەرهەم";
$lang['quantity']                           = "دانە";
$lang['loading_data_from_server']           = "Loading data from server";
$lang['excel']                              = "Excel";
$lang['print']                              = "چاپکردن";
$lang['ajax_error']                         = "Ajax error occurred, Please tray again.";
$lang['product_tax']                        = "باجی بەرهەم";
$lang['order_tax']                          = "باجی داواکاری";
$lang['upload_file']                        = "دانانی فایل";
$lang['download_sample_file']               = "داگرتنی نمونەیەک لە فایلەکە";
$lang['csv1']                               = "The first line in downloaded csv file should remain as it is. Please do not change the order of columns.";
$lang['csv2']                               = "The correct column order is";
$lang['csv3']                               = "&amp; you must follow this. If you are using any other language then English, please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM)";
$lang['import']                             = "هاوردەکردن";
$lang['note']                               = "تێبینی";
$lang['grand_total']                        = "کۆی گشتی";
$lang['download_pdf']                       = "داگرتن بە PDF";
$lang['no_zero_required']                   = "پێویستە پڕبکرێتەوە %s خانەی";
$lang['no_product_found']                   = "هیچ بەرهەمێک نەدۆزرایەوە";
$lang['pending']                            = "لە چاوەڕوانیدایە";
$lang['sent']                               = "نێررا";
$lang['completed']                          = "تەواوکرا";
$lang['shipping']                           = "ناردن";
$lang['add_product_to_order']               = "تکایە بەرهەم زیادبکە بۆ لیستی داواکاری";
$lang['order_items']                        = "داواکردنی ئایتمەکان";
$lang['net_unit_cost']                      = "کۆی تەچووی دانەیەک";
$lang['net_unit_price']                     = "کۆی نرخی دانەیەک";
$lang['expiry_date']                        = "بەرواری بەسەرچوون";
$lang['subtotal']                           = "کۆ";
$lang['reset']                              = "دووبارە رێکخستنەوە";
$lang['items']                              = "ئایتمەکان";
$lang['au_pr_name_tip']                     = "تکایە کۆد یان ناو داخڵبکە یان باڕکۆدەکە سکان بکە";
$lang['no_match_found']                     = "هیچ ئەنجامێک نەدۆزرایەوە. لەوانەیە ئەم بەرهەمە لە کۆگا دەستنیشانکراوەکەدا نەمابێ";
$lang['csv_file']                           = "CSV فایلی";
$lang['document']                           = "هاوپێچکردنی دۆکیومێنت";
$lang['product']                            = "بەرهەم";
$lang['user']                               = "بەکارهێنەر";
$lang['created_by']                         = "دروستکراوە لەلایەن";
$lang['loading_data']                       = "Loading table data from server";
$lang['tel']                                = "ژمارەی تەلەفۆن";
$lang['ref']                                = "سەرچاوە";
$lang['description']                        = "ناساندن";
$lang['code']                               = "کۆد";
$lang['tax']                                = "باج";
$lang['unit_price']                         = "نرخی دانە";
$lang['discount']                           = "داشکاندن";
$lang['order_discount']                     = "داشکاندنی داواکاری";
$lang['total_amount']                       = "کۆی بڕ";
$lang['download_excel']                     = "داگرتن بە Excel";
$lang['subject']                            = "بابەت";
$lang['cc']                                 = "CC";
$lang['bcc']                                = "BCC";
$lang['message']                            = "مەسج";
$lang['show_bcc']                           = "پیشاندان/شاردنەوە BCC";
$lang['price']                              = "نرخ";
$lang['add_product_manually']               = "دانانی بەرهەم بە شێوەی دەستی";
$lang['currency']                           = "دراو";
$lang['product_discount']                   = "داشکاندنی بەرهەم";
$lang['email_sent']                         = "ناردنی ئیمەیڵ سەرکەوتوو بوو";
$lang['add_event']                          = "دانانی پێشهات";
$lang['add_modify_event']                   = "دانان / گۆڕانکاری لە پێشهاتەکەدا ";
$lang['adding']                             = "دائەنرێ...";
$lang['delete']                             = "سڕینەوە";
$lang['deleting']                           = "ئەسڕرێتەوە...";
$lang['calendar_line']                      = "تکایە کلیک لەسەر بەروار بکە بۆ دانان/گۆڕینی پێشهات";
$lang['discount_label']                     = "داشکاندن (5/5%)";
$lang['product_expiry']                     = "product_expiry";
$lang['unit']                               = "دانە";
$lang['cost']                               = "تێچوو";
$lang['tax_method']                         = "شێوازی باج";
$lang['inclusive']                          = "پڕاوپڕ";
$lang['exclusive']                          = "Exclusive";
$lang['expiry']                             = "بەرواری بەسەرچوون";
$lang['customer_group']                     = "گروپی کڕیار";
$lang['is_required']                        = "پێویستە";
$lang['form_action']                        = "کرداری فۆرم";
$lang['return_sales']                       = "گەڕاندنەوەی فرۆشتنەکان";
$lang['list_return_sales']                  = "لیستی گەڕاندنەوەی فرۆشتنەکان";
$lang['no_data_available']                  = "هیچ داتایەک بەردەست نییە";
$lang['disabled_in_demo']                   = "ببورە ئەم فیچەرە لە دێمۆدا کارناکات";
$lang['payment_reference_no']               = "ژمارەی سەرچاوەی پارەدان";
$lang['gift_card_no']                       = "ژمارەی کارتی دیاری";
$lang['paying_by']                          = "ئەدرێت لەلایەن";
$lang['cash']                               = "کاش";
$lang['gift_card']                          = "کارتی دیاری";
$lang['CC']                                 = "کرێدیت کارت";
$lang['cheque']                             = "چەک";
$lang['cc_no']                              = "ژمارەی کرێدیت کارت";
$lang['cc_holder']                          = "ناوی هەڵگری کارت";
$lang['card_type']                          = "جۆری کارت";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['month']                              = "مانگ";
$lang['year']                               = "ساڵ";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "ژمارەی چەک";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['send_email']                         = "ناردنی ئیمەیڵ";
$lang['order_by']                           = "داواکراوە لەلایەن";
$lang['updated_by']                         = "نوێکراوەتەوە لەلایەن";
$lang['update_at']                          = "نوێکراوەتەوە لە بەرواری";
$lang['error_404']                          = "404 Page Not Found ";
$lang['default_customer_group']             = "گروپی سەرەکی کڕیار";
$lang['pos_settings']                       = "POS رێکخستنەکانی";
$lang['pos_sales']                          = "POS فرۆشتنەکانی";
$lang['seller']                             = "فرۆشیار";
$lang['ip:']                                = "IP:";
$lang['sp_tax']                             = "باجی بەرهەمی فرۆشراو";
$lang['pp_tax']                             = "باجی بەرهەمی کڕراو";
$lang['overview_chart_heading']             = "Stock Overview Chart including monthly sales with product tax and  order tax (columns), purchases (line) and current stock value by cost and price (pie). You can save the graph as jpg, png and pdf.";
$lang['stock_value']                        = "نرخی کاڵای کۆگاکراو";
$lang['stock_value_by_price']               = "نرخی کاڵای کۆگاکراو بەپێی نرخی فرۆشتن";
$lang['stock_value_by_cost']                = "نرخی کاڵای کۆگاکراو بەپێی بڕی تێچوو";
$lang['sold']                               = "فرۆشرا";
$lang['purchased']                          = "کڕرا";
$lang['chart_lable_toggle']                 = "You can change chart by clicking the chart legend. Click any legend above to show/hide it in chart.";
$lang['register_report']                    = "راپۆرتی تۆمای دراو";
$lang['sEmptyTable']                        = "هیچ داتایەک لەم تەیبڵەدا نییە";
$lang['upcoming_events']                    = "پێشهاتە نزیکەکان";
$lang['clear_ls']                           = "سڕینەوەی هەموو داتا سەیڤ کراوەکان";
$lang['clear']                              = "شرینەوەی سەرتاسەری";
$lang['edit_order_discount']                = "گۆڕانکاری لە داشکاندنی داواکاریدا";
$lang['product_variant']                    = "جۆری بەرهەم";
$lang['product_variants']                   = "جۆرەکانی بەرهەم";
$lang['prduct_not_found']                   = "ئەم بەرهەمە نەدۆزرایەوە";
$lang['list_open_registers']                = "لیستی تۆماری دراوە کراوەکان";
$lang['delivery']                           = "گەیاندن";
$lang['serial_no']                          = "Serial Number";
$lang['logo']                               = "لۆگۆ";
$lang['attachment']                         = "هاوپێچ";
$lang['balance']                            = "باڵانس";
$lang['nothing_found']                      = "هیچ ئەنجامێک نەدۆزرایەوە";
$lang['db_restored']                        = "گەڕاندنەوەی داتابەیس سەرکەوتوو بوو";
$lang['backups']                            = "باک ئەپەکان";
$lang['best_seller']                        = "پڕفرۆشترین";
$lang['chart']                              = "چارت";
$lang['received']                           = "وەرگیراو";
$lang['returned']                           = "گەڕێنراوە";
$lang['award_points']                       = 'خاڵی پاداشت';
$lang['expenses']                           = "خەرجییەکان";
$lang['add_expense']                        = "دانانی خەری";
$lang['other']                              = "هی تر";
$lang['none']                               = "هیچیان";
$lang['calculator']                         = "ژمێرەر";
$lang['updates']                            = "نوێکردنەوەکان";
$lang['update_available']                   = "نوێکردنەوەی نوێ هەیە. تکایە ئێستا نوێی بکەرەوە";
$lang['please_select_customer_warehouse']   = "تکایە کڕیار/کۆگا دەستنیشان بکە";
$lang['variants']                           = "جۆرەکان";
$lang['add_sale_by_csv']                    = "دانانی فرۆشتن بە CSV";
$lang['categories_report']                  = "راپۆرتی بەشەکان";
$lang['adjust_quantity']                    = "رێکخستنی ژمارەی کاڵا";
$lang['quantity_adjustments']               = "رێکخستنەکانی ژمارەی کاڵا";
$lang['partial']                            = "بەشی";
$lang['unexpected_value']                   = "نرخێکی چاوەڕوان نەکراوت داخڵکردووە";
$lang['select_above']                       = "تکایە لەپێشا لەسەرەوە دەستنیشان بکە";
$lang['no_user_selected']                   = "هیچ بەکارهێنەرێکت دەستنیشان نەکرووە، بە لایەنی کەمەوە بەکارهێنەرێک دەستنیشن بکە";
$lang['sale_details']                       = "وردەکارییەکانی فرۆشتن";
$lang['due'] 								                = "ئەو بڕەی ئەبێت بدرێت";
$lang['ordered'] 							              = "داواکراوە";
$lang['profit'] 						                = "قازانج";
$lang['unit_and_net_tip'] 			            = "Calculated on unit (with tax) and net (without tax) i.e <strong>unit(net)</strong> for all sales";
$lang['expiry_alerts'] 				              = "ئاگادارکردنەوە لە بەرواری بەسەرچوون";
$lang['quantity_alerts'] 				            = "ئاگادارکردنەوە لە ژمارەی بەرهەمی ماوە لە کۆگادا";
$lang['products_sale']                      = "داواکارییەکانی سەر بەرهەم";
$lang['products_cost']                      = "تێچووی بەرەمەکان";
$lang['day_profit']                         = "قازانج و/یان زەرەری ئەو رۆژە";
$lang['get_day_profit']                     = "کلیک لەسەر بەروارەکە بکە بۆ بینینی قازانج و زەرەری ئەو رۆژە";
$lang['combine_to_pdf']                     = "بیکە بە pdf";
$lang['print_barcode_label']                = "چاپکردنی باڕکۆد/لەیبڵ";
$lang['list_gift_cards']                    = "لیستی کارتی دیارییەکان";
$lang['today_profit']                       = "قازانجی ئەمڕۆ";
$lang['adjustments']                        = "رێکخستنەکان";
$lang['download_xls']                       = "داگرتن بە XLS";
$lang['browse']                             = "گەڕان...";
$lang['transferring']                       = "ئەگوێزرێتەوە";
$lang['supplier_part_no']                   = "ژمارەی بەشی دابینکەر";
$lang['deposit']                            = "پارەدانان";
$lang['ppp']                                = "Paypal Pro";
$lang['stripe']                             = "Stripe";
$lang['amount_greater_than_deposit']        = "بڕی پارە زیاترە لە بڕی پاەی دانراوی کڕیار. تکایە بڕێکی کەمتر دیاریبکە و دووبارە هەوڵبدەرەوە";
$lang['stamp_sign']                         = "Stamp &amp; Signature";
$lang['product_option']                     = "جۆری بەرهەم";
$lang['Cheque']                             = "چەک";
$lang['sale_reference']                     = "سەرچاوەی فرۆشتن";
$lang['surcharges']                         = "باجە زیادەکان";
$lang['please_wait']                        = "تکایە چاوەڕوان بە";
$lang['list_expenses']                      = "لیستی خەرجییەکان";
$lang['deposit']                            = "پارەدانان";
$lang['deposit_amount']                     = "بڕی پارەدانان";
$lang['return_purchases']                   = "گەڕاندنەوەی کڕینەکان";
$lang['list_return_purchases']              = "لیستی کڕینە گەڕێندراوەکان";
$lang['expense_categories']                 = "بەشەکانی خەرجی";
$lang['authorize']                          = "Authorize.net";

$lang['please_select_these_before_adding_product'] = "تکایە ئەمانە دەستنیشان بکە پێش دانانی بەرهەم";

$lang['previous_due']                       = "قەرزی کۆن";
$lang['final_bal']                          = "کۆی باڵانس";

