<!--Include Header-->
<?php  

    $path = $_SERVER['DOCUMENT_ROOT'];
    $header = $path . "/includes/header.php";
    include ($header);

    $nav = $path . "/includes/nav.php";
    include ($nav);

    //require_once($path . "/includes/output_functions.php");  

    $aktion = "show";
    if (!empty($_REQUEST['page_aktion'])) { $aktion = $_REQUEST['page_aktion']; }

    $posted = FALSE;
    if (!empty($_REQUEST['posted_'])) { $posted = TRUE; }

    $id_users = 0;
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }


?>

<article>
    <div class="main-page">
        <div class="container-fluid">
            <div class="row">
                 <div class="small-12 medium-8 large-10 columns" style="border-bottom: 1px solid #4c9cb4; margin: 0px -10px 0px 10px;">
                    <h2 class="title" style="margin: 5px 0 0 0;">Manage Shopify Systems</h2>
                </div>
                
            </div> 
        </div>

        <div class="container-fluid">
            <div style="margin-top: 5px;">
                <ul class="accordion" data-accordion data-allow-all-closed="true" style="margin: 10px 25px">
                  <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title filter-button">Advance Filter</a>
                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content style="padding: 5px;">
                        <div class="filter-cover">
                            <div class="row">
                                <div class="small-6 medium-3 large-3 columns">
                                    <label for="text_id_shop_system_filter" class="left inline">Shop System ID:</label>
                                    <input name="text_id_shop_system_filter" type="text" id="text_id_shop_system_filter" placeholder="Shop System ID" oninput="Filter_Reload();" />
                                </div>
                                <div class="small-6 medium-3 large-3 columns">
                                    <label for="select_status" class="left inline">Shop Type:</label>
                                    <?php
                                        $shop_type_selektiert = 0;
                                        if (isset($select_shop_type)) {
                                            $shop_type_selektiert = $select_shop_type;
                                        }
                                        $select_id = "select_shop_type_filter";
                                        $select_name = "select_shop_type_filter";
                                        $select_size = 1;
                                        $select_extra_code = 'onchange="Filter_Reload();"';
                                        $db_conn_opt = false;
                                        $arr_option_values = array(0 => '');
                                        echo $UTIL->SELECT_Shop_Type($shop_type_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                                    ?>
                                </div>

                                <div class="small-12 medium-6 large-6 columns">
                                    <label for="select_status" class="left inline">Customer:</label>
                                    <?php
                                        $id_customer_selektiert = 0;
                                        if (isset($select_id_customer)) {
                                            $id_customer_selektiert = $select_id_customer;
                                        }
                                        $show_all = false; //Include inactive
                                        $show_contact_person = true;
                                        $select_id = "select_id_customer_filter";
                                        $select_name = "select_id_customer_filter";
                                        $select_size = 1;
                                        $select_extra_code = 'onchange="Filter_Reload();"';
                                        $db_conn_opt = false;
                                        $arr_option_values = array(0 => '');
                                        echo $UTIL->SELECT_Customer($shop_type_selektiert, $show_all, $show_contact_person, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                    ?>
                                </div>
                            </div> 

                            <div class="row">
                               
                                <div class="small-9 medium-9 large-9 columns">
                                    <label for="text_shop_name_filter" class="left inline">Shop Name:</label>
                                    <input name="text_shop_name_filter" type="text" id="text_shop_name_filter" placeholder="Shop Name" oninput="Filter_Reload();"/>
                                </div>
                                <div class="small-3 medium-3 large-3 columns">
                                    <label for="select_status_filter" class="left inline">Status</label>
                                    <select id="select_status_filter" name="select_status_filter" onchange="Filter_Reload();">
                                        <option value="-1">Any</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                  </li>
                </ul>
            </div>
        </div>

        <!-- content rows -->
        <form accept-charset="utf-8"  class="custom" enctype="multipart/form-data" style="overflow: auto;" id="form_users_overview" name="form_users_overview" method="post">
            <div class="row" style="padding-top:5px">   

                <div class="small-12 medium-4 large-4 columns limit-cover cell">
                    <div style="display: inline-flex; color: blue;" id="myTable_length">
                        <label style="display: inline-flex;">
                            <span style="padding: 9px 5px 0px 0px; color: #00ced1;;">Show </span> 
                            <select name="myTable_limit" id="myTable_limit" aria-controls="myTable">
                                <option value="3">3</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                            <span style="padding: 9px 5px 0px 5px; color: #00ced1;"> entries</span> 
                            <input type="hidden" name="myTable_offset" id="myTable_offset" value="0" />
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-5 large-5 columns search-cover cell">
                    <div id="myTable_filter" class="dataTables_filter">
                        <label style="display: flex;">
                           <span style="padding: 9px 5px 0px 0px; color: #00ced1;">Shop Systems: </span> 
                           <?php
                              $id_shop_system_selektiert = 0;
                              $select_id = "select_id_shop_system";
                              $select_name = "select_id_shop_system";
                              $select_size = 1;
                              $select_extra_code = 'style="width: fit-content;" onchange="';
                              $db_conn_opt = false;
                              $arr_option_values = array(0 => '');
                              echo $UTIL->SELECT_Shop_System($id_shop_system_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                           ?>
                        </label>
                    </div>
                </div>

                <div class="small-12 medium-3 large-3 columns buttons-cover">
                    <a class="button small btn-Table success" title="Save as CSV" href="/output_files.php?page_aktion=csv" onclick="SpinnerBlock();"><i class="fas fa-file" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save as Excel" href="/output_files.php?page_aktion=excel" onclick="SpinnerBlock();"><i class="fas fa-file-excel" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Save PDF" href="/gen_pdf.php?page_aktion=pdf" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-file-pdf" aria-hidden="true"></i></a>
                    <a class="button small btn-Table success" title="Print" href="/gen_pdf.php?page_aktion=print" target="_blank" onclick="SpinnerBlock();"><i class="fas fa-print" aria-hidden="true"></i></a>

                    <a class="button small btn-Table" title="Add Record" onclick="Open_Shop_System_Reveal();"><i class="fas fa-plus-square" aria-hidden="true"></i></a>
                </div>

                <div class="large-12 small-centered columns" style="padding: 0px;">
                    <table class="responsive-card-table  table-expand hover" id="myTable">  
                        <thead>
                            <th width="5%">ID</th>
                            <th width="40%">Shop Name</th>
                            <th width="25%">Customer</th>
                            <th width="10%">Type</th>
                            <th width="10%">Active</th>
                            <th width="10%">***</th>
                        </thead>
                        <tbody id="tbody_Overview">
                            
                        </tbody>
                    </table>
                </div>

                <div class="small-12 medium-12 large-12 columns limit-cover cell">
                    <div class="row">
                        <div class="small-12 medium-6 large-6 columns">
                            <div id="pagenav_info"></div>
                        </div>
                        <div class="small-12 medium-6 large-6 columns">
                            <div id="pagenav" role="status" aria-live="polite"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--Users Edit Reveal-->
    <div class="reveal large" id="reveal_shop_systems_edit" name="reveal_shop_systems_edit" data-reveal data-close-on-click="false" style="padding: 1rem; border: 2px solid #607D8B; border-radius: 15px;">
        <fieldset style="padding: 0; border: 0;">

            <div class="mobile-nav-bar title-bar" style="background-color: #567a92; margin-bottom: 15px; padding: 5px 10px;">
                <div class="title-bar-left">
                    <button class="menu-icon" type="button"></button>
                </div>
                <div class="title-bar-center">
                    <span id="reveal_shop_systems_header_text">Create New Shop System</span>
                </div>
                <div class="title-bar-right">
                    <button class="menu-icon" type="button"></button>
                </div>
            </div>

            <div id="callout_liste_reveal_shop_systems"></div>

            <form id="form_reveal_shop_systems" name="form_reveal_shop_systems" style="margin: 0px; box-shadow: unset;">
                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <div class="row">
                            <div class="small-4 medium-2 large-2 columns">
                               <label for="text_id_shop_system" class="left inline">Shop System ID:</label>
                               <input name="text_id_shop_system" type="text" id="text_id_shop_system" placeholder="ID" value="" readonly />
                            </div>
                            <div class="small-8 medium-6 large-6 columns">
                               <label for="text_shop_name" class="left inline">Name</label>
                               <input name="text_shop_name" type="text" id="text_shop_name" placeholder="Shop Name" value="" />
                            </div>
                            <div class="small-6 medium-2 large-2 columns">
                              <label for="select_shop_type" class="left inline">Shop Type:</label>
                              <?php
                                  $shop_type_selektiert = 0;
                                  $select_id = "select_shop_type";
                                  $select_name = "select_shop_type";
                                  $select_size = 1;
                                  $select_extra_code = '';
                                  $db_conn_opt = false;
                                  $arr_option_values = array(0 => '');
                                  echo $UTIL->SELECT_Shop_Type($shop_type_selektiert, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code);
                              ?>
                            </div>
                            <div class="small-6 medium-2 large-2 columns">
                                <label for="select_flag_aktiv" class="left inline">Status</label>
                                <select id="select_flag_aktiv" name="select_flag_aktiv">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row"> 
                           <div class="small-6 medium-2 large-2 columns">
                               <label for="text_shop_id" class="left inline">Shop ID:</label>
                               <input name="text_shop_id" type="text" id="text_shop_id" placeholder="Shop ID" value=""/>
                            </div>
                            <div class="small-12 medium-6 large-6 columns">
                                <label for="select_id_customer" class="left inline">Customer:</label>
                                <?php
                                    $id_customer_selektiert = 0;
                                    $show_all = false; //Include inactive
                                    $show_contact_person = true;
                                    $select_id = "select_id_customer";
                                    $select_name = "select_id_customer";
                                    $select_size = 1;
                                    $select_extra_code = '';
                                    $db_conn_opt = false;
                                    $arr_option_values = array(0 => '');
                                    echo $UTIL->SELECT_Customer($shop_type_selektiert, $show_all, $show_contact_person, $arr_option_values, $select_id, $select_name, $select_size, $select_extra_code, $db_conn_opt);
                                ?>
                            </div>
                            <div class="small-6 medium-4 large-4 columns">
                               <label for="text_api_hostname" class="left inline">Hostname:</label>
                               <input name="text_api_hostname" type="text" id="text_api_hostname" placeholder="Login" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 medium-5 large-5 columns">
                               <label for="text_api_user" class="left inline">API User:</label>
                               <input name="text_api_user" type="text" id="text_api_user" placeholder="Login" value="" />
                            </div>
                            <div class="small-10 medium-5 large-5 columns">
                               <label for="text_api_key" class="left inline">API Key:</label>
                               <input name="text_api_key" type="text" id="text_api_key" placeholder="Login" value="" />
                            </div>
                            <div class="small-2 medium-2 large-2 columns">
                               <label for="text_api_port" class="left inline">API Port:</label>
                               <input name="text_api_port" type="text" id="text_api_port" placeholder="Login" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-8 medium-8 large-8 columns">
                               <label for="text_api_token" class="left inline">API Token:</label>
                               <input name="text_api_token" type="text" id="text_api_token" placeholder="Login" value="" />
                            </div>
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_api_version" class="left inline">API Version:</label>
                               <input name="text_api_version" type="text" id="text_api_version" placeholder="Login" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 medium-4 large-4 columns">
                               <label for="text_api_location" class="left inline">API Location:</label>
                               <input name="text_api_location" type="text" id="text_api_location" placeholder="Login" value="" />
                            </div>
                            <div class="small-12 medium-8 large-8 columns">
                               <label for="text_tracking_url" class="left inline">Tracking URL:</label>
                               <input name="text_tracking_url" type="text" id="text_tracking_url" placeholder="Login" value="" />
                            </div>
                        </div> 

                        <div class="row">
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_id_referenz1" class="left inline">Referenz 1:</label>
                               <input name="text_id_referenz1" type="number" id="text_id_referenz1" placeholder="Referenz 1" value="" />
                            </div>
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_id_referenz2" class="left inline">Referenz 2:</label>
                               <input name="text_id_referenz2" type="number" id="text_id_referenz2" placeholder="Referenz 2" value="" />
                            </div>
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_id_referenz3" class="left inline">Referenz 3:</label>
                               <input name="text_id_referenz3" type="number" id="text_id_referenz3" placeholder="Referenz 3" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_str_custom1" class="left inline">Custom 1:</label>
                               <input name="text_str_custom1" type="text" id="text_str_custom1" placeholder="Custom 1" value="" />
                            </div>
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_str_custom2" class="left inline">Custom 2:</label>
                               <input name="text_str_custom2" type="text" id="text_str_custom2" placeholder="Custom 2" value="" />
                            </div>
                            <div class="small-4 medium-4 large-4 columns">
                               <label for="text_str_custom3" class="left inline">Custom 3:</label>
                               <input name="text_str_custom3" type="text" id="text_str_custom3" placeholder="Custom 3" value="" />
                            </div>
                        </div>

                        <div class="row" style="margin: 0;">
                            <div class="small-12 medium-12 large-12 columns checkbox-cover">

                                <div class="row">
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="api_active" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">API Active</label>
                                    </div>
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="api_tracking" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">API Tracking</label>
                                    </div>
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="flag_notify_customer" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">Notify Customer</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="flag_process_pending_payment" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Process Pending Payment</label>
                                    </div>
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="flag_import_missing_shipment_product" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Import Missing Shipment Product</label>
                                    </div>
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="flag_automatischer_abruf" data-element-index="21" value="0" onclick="Checkbox_value_change(this)">Automatischer abruf</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-12 medium-4 large-4 columns">
                                        <label><input type="checkbox" id="flag_auftragsabruf_ohne_details" data-element-index="20" value="0" onclick="Checkbox_value_change(this)">Auftragsabruf ohne details</label>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 medium-2 large-2 columns"></div>
                    <div class="small-12 medium-8 large-8 columns">
                        <div class="button-group-option" data-grouptype="OR" style="margin: 5px 0px; padding: 0px;">
                            <a class="button alert radius" style="padding: 10px;" id="btn_abbrechen" name="btn_abbrechen" onclick="Close_Shop_System_Reveal();">Cancel</a>
                            <a class="button success radius" style="padding: 10px;" id="btn_speichern" name="btn_speichern" onclick="REST_Shop_Systems_Save();" data-element-index="10">Save</a>
                        </div>
                    </div>
                    <div class="small-12 medium-2 large-2 columns"></div>
                </div>
            </form>
        </fieldset>
    </div>

   <!-------Hidden controls--------->
   <div class="hidden-controls">
      <input type="hidden" id="id_shop_system_hidden" value="0" />
   </div>

</article>

<!--Include Nav_Footer and Footer-->
<?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
?>


<script type="text/javascript">
    var select_shop_type_filter = document.getElementById("select_shop_type_filter");
    var select_id_customer_filter = document.getElementById("select_id_customer_filter");
    var text_id_shop_system_filter = document.getElementById("text_id_shop_system_filter");
    var text_shop_name_filter = document.getElementById("text_shop_name_filter");
    var select_status_filter = document.getElementById("select_status_filter");

    //Reveal controls
    var reveal_shop_systems_header_text = document.getElementById("reveal_shop_systems_header_text");
    var id_shop_system_hidden = document.getElementById("id_shop_system_hidden");
    var callout_liste_reveal_shop_systems = document.getElementById("callout_liste_reveal_shop_systems");

    var rEVEAL_text_id_shop_system = document.getElementById("text_id_shop_system");
    var rEVEAL_text_shop_name = document.getElementById("text_shop_name");
    var rEVEAL_select_shop_type = document.getElementById("select_shop_type");
    var rEVEAL_select_flag_aktiv = document.getElementById("select_flag_aktiv");
    var rEVEAL_select_id_customer = document.getElementById("select_id_customer");
    var rEVEAL_text_shop_id = document.getElementById("text_shop_id");

    var rEVEAL_text_api_hostname = document.getElementById("text_api_hostname");
    var rEVEAL_text_api_port = document.getElementById("text_api_port");
    var rEVEAL_text_api_user = document.getElementById("text_api_user");
    var rEVEAL_text_api_key = document.getElementById("text_api_key");
    var rEVEAL_text_api_token = document.getElementById("text_api_token");
    var rEVEAL_text_api_version = document.getElementById("text_api_version");
    var rEVEAL_text_api_location = document.getElementById("text_api_location");
    var rEVEAL_text_tracking_url = document.getElementById("text_tracking_url");
    var rEVEAL_text_id_referenz1 = document.getElementById("text_id_referenz1");
    var rEVEAL_text_id_referenz2 = document.getElementById("text_id_referenz2");
    var rEVEAL_text_id_referenz3 = document.getElementById("text_id_referenz3");
    var rEVEAL_text_str_custom1 = document.getElementById("text_str_custom1");
    var rEVEAL_text_str_custom2 = document.getElementById("text_str_custom2");
    var rEVEAL_text_str_custom3 = document.getElementById("text_str_custom3");
    var rEVEAL_api_active = document.getElementById("api_active");
    var rEVEAL_api_tracking = document.getElementById("api_tracking");
    var rEVEAL_flag_notify_customer = document.getElementById("flag_notify_customer");
    var rEVEAL_flag_process_pending_payment = document.getElementById("flag_process_pending_payment");
    var rEVEAL_flag_import_missing_shipment_product = document.getElementById("flag_import_missing_shipment_product");
    var rEVEAL_flag_automatischer_abruf = document.getElementById("flag_automatischer_abruf");
    var rEVEAL_flag_auftragsabruf_ohne_details = document.getElementById("flag_auftragsabruf_ohne_details");
    //             
   
    var myTable_limit = document.getElementById("myTable_limit");
    var myTable_offset = document.getElementById("myTable_offset");

    addLoadEvent(REST_Shop_Systems_list(0, myTable_offset.value, myTable_limit.value));

    $("#reveal_shop_systems_edit").on("open.zf.reveal", function () {
        console.log("reveal_shop_systems_edit: open.zf.reveal");

        $("#form_reveal_shop_systems")[0].reset();

        callout_liste_reveal_shop_systems.innerHTML = "";

        if (id_shop_system_hidden.value != 0) {
            reveal_shop_systems_header_text.innerText = "Edit Shop System (" + id_shop_system_hidden.value + ")";

            REST_Shop_Systems_load(id_shop_system_hidden.value)

        } else {
            reveal_shop_systems_header_text.innerText = "Create New Shop System";
        }

    });

   function Close_Shop_System_Reveal() {
      console.log('Close_Shop_System_Reveal()');

      $('#reveal_shop_systems_edit').foundation('close');
   } //end Close_Shop_System_Reveal();

   function Open_Shop_System_Reveal (var_id_shop_system = 0) {
      console.log('Open_Shop_System_Reveal('+var_id_shop_system+')');

      id_shop_system_hidden.value = var_id_shop_system;

      $('#reveal_shop_systems_edit').foundation('open');

      return;
   } //end Open_Shop_System_Reveal();

   function Filter_Reload() {
     REST_Shop_Systems_list(0, 0, myTable_limit.value);
   }

   function PageNav(show_num_pages, query_total, query_offset, query_limit) {  
     //alert(query_total + " " + query_offset + " " + query_limit);
     var div_pagenav = document.getElementById("pagenav");
     var div_pagenav_info = document.getElementById("pagenav_info");

     var innerHTML = '<p style="color: #2ba6cb;"><strong>Total Records:</strong> '+query_total+' entries</p>';
     div_pagenav_info.innerHTML=innerHTML; 

     if (div_pagenav == null) return;

     // Hilfsberechnungen
     var show_num_pages_half = Math.floor(show_num_pages / 2); // Hilfsberechnung für halbe Seitenzahlenanzeige
     var num_pages = Math.ceil(query_total / query_limit); // Anzahl aktueller Seiten
     var current_page = Math.floor(query_offset / query_limit); // aktuelle Seiten-Nr.  
     //
     // Vorherigen Content entfernen
     div_pagenav.innerHTML = '';
     
     var div_row_pagenav = document.createElement('div');    
     div_row_pagenav.className = 'row';
         
     var div_col_pagenav = document.createElement('div');
     div_col_pagenav.className = 'small-12 medium-12 large-12 columns';
     
     var li = null;
     var ul_pagenav = document.createElement('ul');
     ul_pagenav.className = 'pagination text-center';
     
     div_col_pagenav.appendChild(ul_pagenav);
     div_row_pagenav.appendChild(div_col_pagenav);
     div_pagenav.appendChild(div_row_pagenav);
     
     // Pfeil nach links anzeigen, wenn Datensatz > 1
     if (current_page > 0) {
         li = document.createElement('li');
         li.className = 'arrow';
         li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((current_page - 1) * query_limit) + ', ' + query_limit + ');">&laquo;</a>';
         ul_pagenav.appendChild(li);
     }

     // Seitenanzeige aufbauen
     if (show_num_pages < num_pages) { // mehr Seiten als "Anzahl-Seiten" vorhanden
         if (current_page > show_num_pages_half) {
             // Seite 1 ...
             li = document.createElement('li');
             li.className = 'arrow';
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (0 * query_limit) + ', ' + query_limit + ');">1</a>';
             ul_pagenav.appendChild(li);
             
             li = document.createElement('li');
             li.className = 'unavailable';
             li.innerHTML = '<a>&hellip;</a>';
             ul_pagenav.appendChild(li);
         } // end if (current_page > show_num_pages_half);
         
         
         if (current_page <= show_num_pages_half) { // Seite 1..7
             for (i = 0; i < show_num_pages; i++) {
                 li = document.createElement('li');
                 if (i == current_page) {
                     li.className = 'current';
                 } else {
                     li.className = '';
                 }
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                 ul_pagenav.appendChild(li);
             } // end for (i);
             
         } else if (current_page >= ((num_pages - 1) - show_num_pages_half)) { // Seite (n-1) - 7 bis (n-1)
             for (i = (num_pages - show_num_pages); i < num_pages; i++) {
                 li = document.createElement('li');
                 if (i == current_page) {
                     li.className = 'current';
                 } else {
                     li.className = '';
                 }
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                 ul_pagenav.appendChild(li);
             } // end for (i);
             
         } else { // zwischen min und max Seiten
                 
             for (i = (current_page - show_num_pages_half); i <= (current_page + show_num_pages_half); i++) {
                 li = document.createElement('li');
                 if (i == current_page) {
                     li.className = 'current';
                 } else {
                     li.className = '';
                 }
                 li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
                 ul_pagenav.appendChild(li);
             } // end for (i);   
         }

         if (current_page < ((num_pages - 1) - show_num_pages_half) ) {
             // ... Seite n-1
             li = document.createElement('li');
             li.className = 'unavailable';
             li.innerHTML = '<a>&hellip;</a>';
             ul_pagenav.appendChild(li);             
             
             li = document.createElement('li');
             li.className = 'arrow';
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((num_pages - 1) * query_limit) + ', ' + query_limit + ');">' + num_pages + '</a>';         
             ul_pagenav.appendChild(li);
         
         } // end if (current_page < (num_pages - show_num_pages_half) );

     } else { // weniger als 7 Seiten
     
         for (i = 0; i < num_pages; i++) {
             li = document.createElement('li');
             if (i == current_page) {
                 li.className = 'current';
             } else {
                 li.className = '';
             }
             li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + (i * query_limit) + ', ' + query_limit + ');">' + (i + 1) + '</a>';
             ul_pagenav.appendChild(li);
         } // end for (i);
     } // end if (show_num_pages > num_pages);
     
     if (current_page < (num_pages - 1)) {
         li = document.createElement('li');
         li.className = 'arrow';
         li.innerHTML = '<a class="class_spinner_id" onclick="REST_Shop_Systems_list(' + query_total + ', ' + ((current_page + 1) * query_limit) + ', ' + query_limit + ');">' + '&raquo;' + '</a>';      
         ul_pagenav.appendChild(li);     
     } // end if (current_page > 0)

     return;
   } // end PageNav();

   function REST_Shop_Systems_list(query_total, query_offset, query_limit) {
      console.log('REST_Shop_Systems_list()');

      //Keep query_offset and query_limit for refresh
      myTable_offset.value = query_offset;
      myTable_limit.value = query_limit;

      //Prepare Table Filter
      var zFilter_Param = '&id_shop_system=' + text_id_shop_system_filter.value + '&shop_type=' + select_shop_type_filter.value + '&id_customer=' + select_id_customer_filter.value + '&shop_name=' + text_shop_name_filter.value;
      zFilter_Param += '&flag_aktiv=' + select_status_filter.value;
      //

      var tbody_Overview = document.getElementById("tbody_Overview");

      //SpinnerStart(false);

      var xmlhttp;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            // var str = xmlhttp.responseText;
            // alert(str);
            // alert(xmlhttp.responseXML);
            console.log(xmlhttp.responseXML);
            if (xmlhttp.responseXML == null) { console.log('No data found!'); return; }

            tbody_Overview.innerHTML = '';

            var i_bgcolor = 0;

            var node_query_count = xmlhttp.responseXML.getElementsByTagName("query_count");
            var node_query_offset = xmlhttp.responseXML.getElementsByTagName("query_offset");
            var node_query_limit = xmlhttp.responseXML.getElementsByTagName("query_limit");
            var xml_query_count = node_query_count[0].childNodes[0].nodeValue;
            var xml_query_offset = node_query_offset[0].childNodes[0].nodeValue;
            var xml_query_limit = node_query_limit[0].childNodes[0].nodeValue;

            PageNav(7, xml_query_count, xml_query_offset, xml_query_limit); // (show_num_pages, query_total, query_offset, query_limit)

            var nodeShop_Systems_List = xmlhttp.responseXML.getElementsByTagName("shop_systems_list");
            // alert(nodeShop_Systems_List[0].childNodes.length);
            for (var i = 0; i < nodeShop_Systems_List[0].childNodes.length; i++) {
                // alert("NodeName: " + nodeShop_Systems_List[0].childNodes[i].nodeName + " | NodeType:" + nodeShop_Systems_List[0].childNodes[i].nodeType); 
                if (nodeShop_Systems_List[0].childNodes[i].nodeType == 1) {
                    var nodeShop_Systems = nodeShop_Systems_List[0].childNodes[i];
                    // alert(nodeShop_Systems.childNodes.length);

                    var xml_id_shop_system = 0,
                    xml_id_customer = 0,
                    xml_customer_company = '';
                    xml_customer_contact_person = '';

                    xml_shop_type = '',
                    xml_shop_name = '',
                    xml_shop_id = '',
                    xml_api_active = 0,
                    xml_api_hostname = '',
                    xml_api_version = '',
                    xml_api_port = '',
                    xml_api_user = '',
                    xml_api_key = '',
                    xml_api_token = '',
                    xml_api_location = '',
                    xml_api_tracking = '',
                    xml_tracking_url = '',
                    xml_flag_process_pending_payment = 0,
                    xml_flag_notify_customer = 0,
                    xml_flag_import_missing_shipment_product = 0,
                    xml_id_referenz1 = '',
                    xml_id_referenz2 = '',
                    xml_id_referenz3 = '',
                    xml_str_custom1 = '',
                    xml_str_custom2 = '',
                    xml_str_custom3 = '',
                    xml_flag_aktiv = 0,
                    xml_flag_automatischer_abruf = 0,
                    xml_flag_auftragsabruf_ohne_details = 0;

                    for (var j = 0; j < nodeShop_Systems.childNodes.length; j++) {
                        if (nodeShop_Systems.childNodes[j].nodeType == 1) {
                            // alert("NodeName: " + nodeShop_Systems.childNodes[j].nodeName + " | NodeType:" + nodeShop_Systems.childNodes[j].nodeType + " | NodeValue: " +  nodeShop_Systems.childNodes[j].childNodes[0].nodeValue); 
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'customer_company') xml_customer_company = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'customer_contact_person') xml_customer_contact_person = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                            if (nodeShop_Systems.childNodes[j].nodeName === 'shop_type') xml_shop_type = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'shop_id') xml_shop_id = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_active') xml_api_active = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_hostname') xml_api_hostname = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_version') xml_api_version = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_port') xml_api_port = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_user') xml_api_user = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_key') xml_api_key = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_token') xml_api_token = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_location') xml_api_location = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'api_tracking') xml_api_tracking = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'tracking_url') xml_tracking_url = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_process_pending_payment') xml_flag_process_pending_payment = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_notify_customer') xml_flag_notify_customer = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_import_missing_shipment_product') xml_flag_import_missing_shipment_product = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz1') xml_id_referenz1 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz2') xml_id_referenz2 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz3') xml_id_referenz3 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom1') xml_str_custom1 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom2') xml_str_custom2 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom3') xml_str_custom3 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_aktiv') xml_flag_aktiv= nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_automatischer_abruf') xml_flag_automatischer_abruf = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                            if (nodeShop_Systems.childNodes[j].nodeName === 'flag_auftragsabruf_ohne_details') xml_flag_auftragsabruf_ohne_details = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                        } // nodeType = ELEMENT_NODE
                    } // end for (j);
                  //alert (xml_id_shop_system + " :: " + xml_id_customer + " :: " + xml_shop_name + " :: " + xml_shop_type + " :: " + xml_shop_id);
                  //
                  bgcolor_row = '';
                  if ((i_bgcolor % 2) == 0) {
                     bgcolor_row = '<?php echo $UTIL->table_bg_color_even(); ?>';
                  } else {
                     bgcolor_row = '<?php echo $UTIL->table_bg_color_odd(); ?>';
                  }

                     var tr = document.createElement('tr');
                     tbody_Overview.appendChild(tr);
                     var td = [];

                     //---------------------------------------------------------------------//

                     td[0] = document.createElement('td');
                     td[0].setAttribute('bgcolor', bgcolor_row);
                     td[0].setAttribute('valign', 'top');
                     td[0].setAttribute('data-label', 'Shop ID:');

                     td[0].innerHTML = '';

                     td[0].innerHTML += '<div><span style="font-weight: 600; color: crimson;">' + xml_id_shop_system + '</span></div>';

                     //---------------------------------------------------------------------//

                     td[1] = document.createElement('td');
                     td[1].setAttribute('bgcolor', bgcolor_row);
                     td[1].setAttribute('valign', 'top');
                     td[1].setAttribute('data-label', 'Name');

                     td[1].innerHTML = '';
                     td[1].innerHTML += '<div><span style="font-weight: 600; color: #004465;">' + utf8Decode(xml_shop_name) + '</span></div>';

                     //---------------------------------------------------------------------//

                     td[2] = document.createElement('td');
                     td[2].setAttribute('bgcolor', bgcolor_row);
                     td[2].setAttribute('valign', 'top');
                     td[2].setAttribute('data-label', 'Customer');

                     td[2].innerHTML = '';
                     if (xml_customer_company == "") {
                        td[2].innerHTML += '<div><strong>' + xml_id_customer + '</strong></div>';
                     } else {
                        td[2].innerHTML += '<div><strong>' + xml_id_customer + '</strong> - ' + utf8Decode(xml_customer_company) + ' (' + xml_customer_contact_person + ')</div>';
                     }
                     

                     //---------------------------------------------------------------------//

                     td[3] = document.createElement('td');
                     td[3].setAttribute('bgcolor', bgcolor_row);
                     td[3].setAttribute('valign', 'top');
                     td[3].setAttribute('data-label', 'Type');

                     td[3].innerHTML = '';
                     td[3].innerHTML += '<div>' + Shop_Type_Description_JS(xml_shop_type) + '</div>';

                     //---------------------------------------------------------------------//

                     td[4] = document.createElement('td');
                     td[4].setAttribute('bgcolor', bgcolor_row);
                     td[4].setAttribute('valign', 'top');
                     td[4].setAttribute('data-label', 'Email');

                     td[4].innerHTML = '';
                     td[4].innerHTML += '<p style="margin: 1px 0; color: #1779ba; text-align: center;"><span>' + ((xml_flag_aktiv == 1) ? '<?php echo $UTIL->IMG_Activated(15, 15); ?>' : '<?php echo $UTIL->IMG_Deactivated(15, 15); ?>') + '</span></p>';

                     //---------------------------------------------------------------------//

                     td[5] = document.createElement('td');
                     td[5].setAttribute('bgcolor', bgcolor_row);
                     td[5].setAttribute('valign', 'top');
                     td[5].setAttribute('data-label', '***');

                     innerHTML = '';
                     innerHTML += '<div>';
                     innerHTML += ' <a class="table-btn" onclick="Open_Shop_System_Reveal(' + xml_id_shop_system + ')"><i class="fa fa-edit action-controls" title="Edit Record"></i></a>';

                     innerHTML += ' <a class="table-btn" onclick="Toggle_Detail(this, ' + xml_id_shop_system + ');" ><i class="fas fa-chevron-down" title="Show Detail"></i></a>';
                     innerHTML += '</div>';
                     td[5].innerHTML = innerHTML;

                     //---------------------------------------------------------------------//   

                     var tr_labels = document.createElement('tr');
                     tbody_Overview.appendChild(tr_labels);
                     tr_labels.className = 'table-expand-row-content';
                     tr_labels.setAttribute('style', 'border: 2px solid #788A8F;');
                     tr_labels.id = 'label_content_' + xml_id_shop_system;


                     var td_labels = document.createElement('td');
                     tr_labels.appendChild(td_labels);
                     tr_labels.setAttribute('style', 'padding: 0;');
                     td_labels.className = 'table-expand-row-nested';
                     td_labels.setAttribute('colspan', '10');

                     var innerHTML = '';
                     //---------------------------------------------------------------------//
                     innerHTML += '<p style="margin-bottom: 0px; font-size: 0.875rem; font-weight: 600; color: #004465; padding-left: 10px;">Details:</p>';
                     innerHTML += '<p style="padding-left: 10px;"><b>Shop ID: </b><span>' + xml_shop_id + '</span><b style="margin-left:4em;">Hostname: </b><span>' + xml_shop_id + '</span></p>';

                     td_labels.innerHTML = innerHTML;
                     //td_labels.appendChild(sendungsdaten_Liste_ul);


                     //---------------------------------------------------------------------//

                     tr.appendChild(td[0]);
                     tr.appendChild(td[1]);
                     tr.appendChild(td[2]);
                     tr.appendChild(td[3]);
                     tr.appendChild(td[4]);
                     tr.appendChild(td[5]);

                     //---------------------------------------------------------------------//

                     i_bgcolor++;
                 } // nodeType = ELEMENT_NODE

             } // end for (i);

             //SpinnerStop(false);
         } // end if
     } // end onreadystatechange
     xmlhttp.ontimeout = function() {
         //SpinnerStop(false);
     }

     xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_list.php?"), true);
     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xmlhttp.timeout = 120000; // time in milliseconds

     post_parameters = GetAPIAccess();
     post_parameters += zFilter_Param; 

     post_parameters += "&query_offset=" + query_offset;
     post_parameters += "&query_limit=" + query_limit;

     //alert(post_parameters);
     console.log(post_parameters);
     //  
     xmlhttp.send(post_parameters);

     return;
   } // end REST_Shop_Systems_list();

   function REST_Shop_Systems_load(var_id_shop_system) {
        console.log('REST_Shop_Systems_load()');

        //SpinnerStart(false);

        var xmlhttp;
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
               //var str = xmlhttp.responseText;
               //alert(str);
               //alert(xmlhttp.responseXML);
               console.log(xmlhttp.responseXML);
               if (xmlhttp.responseXML == null) { console.log('No data found!'); return; }

                var nodeShop_Systems_List = xmlhttp.responseXML.getElementsByTagName("shop_systems_list");
                // alert(nodeShop_Systems_List[0].childNodes.length);
                for (var i = 0; i < nodeShop_Systems_List[0].childNodes.length; i++) {
                    // alert('NodeName: ' + nodeShop_Systems_List[0].childNodes[i].nodeName + ' | NodeType:' + nodeShop_Systems_List[0].childNodes[i].nodeType);
                    if (nodeShop_Systems_List[0].childNodes[i].nodeType == 1) {
                        var nodeShop_Systems = nodeShop_Systems_List[0].childNodes[i];
                        // alert(nodeShop_Systems.childNodes.length);

                        var xml_id_shop_system = 0,
                        xml_id_customer = 0,
                        xml_shop_type = '',
                        xml_shop_name = '',
                        xml_shop_id = '',
                        xml_api_active = 0,
                        xml_api_hostname = '',
                        xml_api_version = '',
                        xml_api_port = '',
                        xml_api_user = '',
                        xml_api_key = '',
                        xml_api_token = '',
                        xml_api_location = '',
                        xml_api_tracking = '',
                        xml_tracking_url = '',
                        xml_flag_process_pending_payment = 0,
                        xml_flag_notify_customer = 0,
                        xml_flag_import_missing_shipment_product = 0,
                        xml_id_referenz1 = '',
                        xml_id_referenz2 = '',
                        xml_id_referenz3 = '',
                        xml_str_custom1 = '',
                        xml_str_custom2 = '',
                        xml_str_custom3 = '',
                        xml_flag_aktiv = 0,
                        xml_flag_automatischer_abruf = 0,
                        xml_flag_auftragsabruf_ohne_details = 0;

                        for (var j = 0; j < nodeShop_Systems.childNodes.length; j++) {
                           if (nodeShop_Systems.childNodes[j].nodeType == 1) {
                               // alert("NodeName: " + nodeShop_Systems.childNodes[j].nodeName + " | NodeType:" + nodeShop_Systems.childNodes[j].nodeType + " | NodeValue: " +  nodeShop_Systems.childNodes[j].childNodes[0].nodeValue); 
                               if (nodeShop_Systems.childNodes[j].nodeName === 'id_shop_system') xml_id_shop_system = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'id_customer') xml_id_customer = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'shop_type') xml_shop_type = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'shop_name') xml_shop_name = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'shop_id') xml_shop_id = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_active') xml_api_active = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_hostname') xml_api_hostname = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_version') xml_api_version = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_port') xml_api_port = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_user') xml_api_user = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_key') xml_api_key = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_token') xml_api_token = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_location') xml_api_location = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'api_tracking') xml_api_tracking = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'tracking_url') xml_tracking_url = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_process_pending_payment') xml_flag_process_pending_payment = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_notify_customer') xml_flag_notify_customer = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_import_missing_shipment_product') xml_flag_import_missing_shipment_product = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz1') xml_id_referenz1 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz2') xml_id_referenz2 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'id_referenz3') xml_id_referenz3 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom1') xml_str_custom1 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom2') xml_str_custom2 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'str_custom3') xml_str_custom3 = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_aktiv') xml_flag_aktiv= nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_automatischer_abruf') xml_flag_automatischer_abruf = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;
                               if (nodeShop_Systems.childNodes[j].nodeName === 'flag_auftragsabruf_ohne_details') xml_flag_auftragsabruf_ohne_details = nodeShop_Systems.childNodes[j].childNodes[0].nodeValue;

                           } // nodeType = ELEMENT_NODE
                        } // end for (j);
                        //alert (xml_id_shop_system + " :: " + xml_id_customer + " :: " + xml_shop_name + " :: " + xml_shop_type + " :: " + xml_shop_id);
                        //
                        id_shop_system_hidden.value = xml_id_shop_system;
                        rEVEAL_text_id_shop_system.value = xml_id_shop_system;
                        rEVEAL_select_id_customer.value = xml_id_customer;
                        rEVEAL_text_shop_name.value = utf8Decode(xml_shop_name);
                        rEVEAL_text_shop_id.value = utf8Decode(xml_shop_id);
                        SELECT_Option(rEVEAL_select_shop_type, xml_shop_type);
                        SELECT_Option(rEVEAL_select_flag_aktiv, xml_flag_aktiv);


                        rEVEAL_text_api_hostname.value = utf8Decode(xml_api_hostname);
                        rEVEAL_text_api_port.value = utf8Decode(xml_api_port);
                        rEVEAL_text_api_user.value = utf8Decode(xml_api_user);
                        rEVEAL_text_api_key.value = utf8Decode(xml_api_key);
                        rEVEAL_text_api_token.value = utf8Decode(xml_api_token);
                        rEVEAL_text_api_version.value = utf8Decode(xml_api_version);
                        rEVEAL_text_api_location.value = utf8Decode(xml_api_location);
                        rEVEAL_text_tracking_url.value = utf8Decode(xml_tracking_url);
                        rEVEAL_text_id_referenz1.value = utf8Decode(xml_id_referenz1);
                        rEVEAL_text_id_referenz2.value = utf8Decode(xml_id_referenz2);
                        rEVEAL_text_id_referenz3.value = utf8Decode(xml_id_referenz3);
                        rEVEAL_text_str_custom1.value = utf8Decode(xml_str_custom1);
                        rEVEAL_text_str_custom2.value = utf8Decode(xml_str_custom2);
                        rEVEAL_text_str_custom3.value = utf8Decode(xml_str_custom3);

                        rEVEAL_api_active.checked = parseInt(xml_api_active, 10);
                        rEVEAL_api_active.value = parseInt(xml_api_active, 10);

                        rEVEAL_api_tracking.checked = parseInt(xml_api_tracking, 10);
                        rEVEAL_api_tracking.value = parseInt(xml_api_tracking, 10);

                        rEVEAL_flag_notify_customer.checked = parseInt(xml_flag_notify_customer, 10);
                        rEVEAL_flag_notify_customer.value = parseInt(xml_flag_notify_customer, 10);

                        rEVEAL_flag_process_pending_payment.checked = parseInt(xml_flag_process_pending_payment, 10);
                        rEVEAL_flag_process_pending_payment.value = parseInt(xml_flag_process_pending_payment, 10);

                        rEVEAL_flag_import_missing_shipment_product.checked = parseInt(xml_flag_import_missing_shipment_product, 10);
                        rEVEAL_flag_import_missing_shipment_product.value = parseInt(xml_flag_import_missing_shipment_product, 10);

                        rEVEAL_flag_automatischer_abruf.checked = parseInt(xml_flag_automatischer_abruf, 10);
                        rEVEAL_flag_automatischer_abruf.value = parseInt(xml_flag_automatischer_abruf, 10);

                        rEVEAL_flag_auftragsabruf_ohne_details.checked = parseInt(xml_flag_auftragsabruf_ohne_details, 10);
                        rEVEAL_flag_auftragsabruf_ohne_details.value = parseInt(xml_flag_auftragsabruf_ohne_details, 10);

                        //
                    } // end if (node_Liste);
                } // end for (i);

                //SpinnerStop(false);
            } // end if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        } // end onreadystatechange
        xmlhttp.ontimeout = function() {
            SpinnerStop(false);
        }

        xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_list.php?"), true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.timeout = 120000; // time in milliseconds
        //
        post_parameters = GetAPIAccess();
        post_parameters += "&id_shop_system=" + var_id_shop_system;

        // alert(post_parameters);
        console.log(post_parameters);
        //  
        xmlhttp.send(post_parameters);

        return;
    } // end REST_Shop_Systems_load();

   function Helper_Shop_Systems_Edit() {
      console.log("Helper_Shop_Systems_Edit()");

      var fehler = false;

      //
      // Form Eingaben validieren (Hard errors!)
      //
      if (rEVEAL_text_shop_name.value == "") {
         Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(text_shop_name);">Shop name empty.</a>', true, 30000);
         fehler = true;
      }

      // if (m_name_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_name_auftrag_bearbeiten);">Name nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      // if (m_hausnr_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_hausnr_auftrag_bearbeiten);">Hausnr. nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      // if (m_strasse_auftrag_bearbeiten.value == "") {
      //    Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, '<a href="#" onClick="Helper_Shop_Systems_Focus(m_strasse_auftrag_bearbeiten);">Strasse nicht angegeben.</a>', true, 30000);
      //    fehler = true;
      // }

      if (fehler == false) {
         // Auftrag erstellen / speichern
         REST_Shop_Systems_Save(m_SHOPSYS_id_auftrag_hidden.value);
      }

      return;
   } // end Helper_Shop_Systems_Edit();

   function Helper_Shop_Systems_Focus(elem_focus) {
      console.log("Helper_Shop_Systems_Focus()");

      if (elem_focus != null) elem_focus.focus();
   } // end Helper_Shop_Systems_Focus();

   function REST_Shop_Systems_Save() {
      console.log("REST_Shop_Systems_Save()");

      //Validate Adressbuch data 
      if (id_shop_system_hidden.value != "0") {
         if (confirm("Do you want to save changes?") == false) return;
      }

      var xmlhttp;
      if (window.XMLHttpRequest) {
         // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else {
         // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.ontimeout = function() {
         Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, "Auftrag speichern: Zeitüberschreitung der Netzwerkverbindung!", true, 0);
      };

      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var str = xmlhttp.responseText;
            // alert(str);
            console.log(xmlhttp.responseXML);

            var node_Liste = xmlhttp.responseXML.getElementsByTagName("shop_systems");
            // alert(node_Liste[0].childNodes.length);
            var xml_id_shop_system = 0;

            for (var i = 0; i < node_Liste[0].childNodes.length; i++) {
               // alert('NodeName: ' + node_Liste[0].childNodes[i].nodeName + ' | NodeType:' + node_Liste[0].childNodes[i].nodeType);
               if (node_Liste[0].childNodes[i].nodeType == 1) {
                  if (node_Liste[0].childNodes[i].nodeName === "id_shop_system") xml_id_shop_system = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
                  // if (node_Liste[0].childNodes[i].nodeName === 'fehlercode') xml_fehlercode = node_Liste[0].childNodes[i].childNodes[0].nodeValue;
               } // end if (nodeType == 1);
            } // end for (i);

            //alert(xml_id_shop_system);

            if (parseInt(xml_id_shop_system) > 0) {

               id_shop_system_hidden.value = parseInt(xml_id_shop_system);

               // Liste neu laden
               REST_Shop_Systems_list(0, myTable_offset.value, myTable_limit.value);
               Close_Shop_System_Reveal();

            } else {
               Callout_Meldung(callout_liste_reveal_shop_systems, CALLOUT_ALERT, "Fehler beim Speichern des Auftrag!", true, 20000);
            }

         } // end if (xmlhttp.readyState === 4 && xmlhttp.status === ABC);
      }; // end onreadystatechange();

      var post_parameters = GetAPIAccess();

      if (id_shop_system_hidden.value == 0) {
         post_parameters += "&id_shop_system=" + id_shop_system_hidden.value; //Create
      } else {
         post_parameters += "&id_shop_system=" + id_shop_system_hidden.value; //Update
      }
      //

      if (id_shop_system_hidden != null) post_parameters += '&id_shop_system=' + id_shop_system_hidden.value;
      if (rEVEAL_select_id_customer != null) post_parameters += '&id_customer=' + rEVEAL_select_id_customer.value;
      if (rEVEAL_select_shop_type != null) post_parameters += '&shop_type=' + rEVEAL_select_shop_type.value;
      if (rEVEAL_text_shop_name != null) post_parameters += '&shop_name=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_shop_name.value);
      if (rEVEAL_text_shop_id != null) post_parameters += '&shop_id=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_shop_id.value);
      if (rEVEAL_api_active != null) post_parameters += '&api_active=' + rEVEAL_api_active.value;
      if (rEVEAL_text_api_hostname != null) post_parameters += '&api_hostname=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_hostname.value);

      if (rEVEAL_text_api_version != null) post_parameters += '&api_version=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_version.value);
      if (rEVEAL_text_api_port != null) post_parameters += '&api_port=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_port.value);

      if (rEVEAL_text_api_user != null) post_parameters += "&text_api_user=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_user.value);
      if (rEVEAL_text_api_key != null) post_parameters += "&text_api_key=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_key.value);
      if (rEVEAL_text_api_token != null) post_parameters += "&text_api_token=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_token.value);
      if (rEVEAL_text_api_location != null) post_parameters += "&api_location=" + Helper_encodeURIComponentWithAmp(rEVEAL_text_api_location.value);

      if (rEVEAL_api_tracking != null) post_parameters += '&api_tracking=' + Helper_encodeURIComponentWithAmp(rEVEAL_api_tracking.value);
      if (rEVEAL_text_tracking_url != null) post_parameters += '&tracking_url=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_tracking_url.value);
      if (rEVEAL_flag_process_pending_payment != null) post_parameters += '&flag_process_pending_payment=' + rEVEAL_flag_process_pending_payment.value;
      if (rEVEAL_flag_import_missing_shipment_product != null) post_parameters += '&flag_import_missing_shipment_product=' + rEVEAL_flag_import_missing_shipment_product.value;
      if (text_id_referenz1 != null) post_parameters += '&id_referenz1=' + Helper_encodeURIComponentWithAmp(text_id_referenz1.value);
      if (text_id_referenz2 != null) post_parameters += '&id_referenz2=' + Helper_encodeURIComponentWithAmp(text_id_referenz2.value);
      if (text_id_referenz3 != null) post_parameters += '&id_referenz3=' + Helper_encodeURIComponentWithAmp(text_id_referenz3.value);

      if (rEVEAL_text_str_custom1 != null) post_parameters += '&str_custom1=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_str_custom1.value);
      if (rEVEAL_text_str_custom2 != null) post_parameters += '&str_custom2=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_str_custom2.value);
      if (rEVEAL_text_str_custom3 != null) post_parameters += '&str_custom3=' + Helper_encodeURIComponentWithAmp(rEVEAL_text_str_custom3.value);
      if (rEVEAL_select_flag_aktiv != null) post_parameters += "&flag_aktiv=" + rEVEAL_select_flag_aktiv.value;
      if (rEVEAL_flag_automatischer_abruf != null) post_parameters += '&flag_automatischer_abruf=' + rEVEAL_flag_automatischer_abruf.value;
      if (rEVEAL_flag_auftragsabruf_ohne_details != null) post_parameters += '&flag_auftragsabruf_ohne_details=' + rEVEAL_flag_auftragsabruf_ohne_details.value;

      xmlhttp.open("POST", encodeURI("/api/xml/v1/shop_systems_create_update.php?"), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.timeout = 120000; // time in milliseconds
      //
      // alert(post_parameters);
      console.log("/api/xml/v1/shop_systems_create_update.php?" + post_parameters);
      //  
      xmlhttp.send(post_parameters);

      return;
   } // end REST_Shop_Systems_Save();

   function Toggle_Detail(elem, var_id) {
      console.log('Toggle_Detail()');

     var label_content = document.getElementById('label_content_' + var_id)
     label_content.classList.toggle('show');

     if (window.getComputedStyle(label_content).display !== "none") {
         elem.querySelector('i').classList.remove('fa-chevron-down');
         elem.querySelector('i').classList.add('fa-chevron-up');
     } else {
         elem.querySelector('i').classList.remove('fa-chevron-up');
         elem.querySelector('i').classList.add('fa-chevron-down');
     }

     //event.preventDefault();
   } //end Toggle_Detail()

   function REST_Shopify_Produkte_Abrufen(ctl, rel) {
      console.log('REST_Shopify_Produkte_Abrufen('+ctl+')');

      var data_rel = '';
      var cursor = '';
      if (ctl != null) {
         data_rel = ctl.getAttribute('data-rel');
         if (data_rel == 'previous') {
            cursor = ctl.getAttribute('startcursor');
         } else if (data_rel == 'next') {
            cursor = ctl.getAttribute('endcursor');
         }
      } else {
         if (rel != null) {
            if (rel == 'current') {
               data_rel = 'previous';
            } else{
               data_rel = 'start';
            }
            
         } 
         cursor = m_query_current_cursor.value;
      }

      var var_id_shop_system = m_SHOPSYS_id_shop_system_hidden.value;
      var var_id_mandant = m_SHOPSYS_id_mandant_hidden.value;
      var var_shop_id = m_SHOPSYS_shop_id_hidden.value;
      //
      var data_store = m_SHOPSYS_api_hostname_hidden.value;
      var data_location_id = m_SHOPSYS_api_location_hidden.value;
      var data_sub_endpoint = m_SHOPSYS_api_version_hidden.value;
      var data_access_token = m_SHOPSYS_api_password_hidden.value;
      var data_access_key = m_SHOPSYS_api_key_hidden.value;
      //
      var tbody_Uebersicht = document.getElementById("tbody_Uebersicht_Shop_Produkte");
      //
      var var_radio_Produkte_fulfill_service = 0;
      for (i = 0; i < m_radio_Produkte_fulfill_service.length; i++) {
         if (m_radio_Produkte_fulfill_service[i].checked == true) var_radio_Produkte_fulfill_service = m_radio_Produkte_fulfill_service[i].value;
      } // end for (i);

      /////////////////////////////////////////////////////////////
      SpinnerStart(false);

      var xmlhttp;
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function() {
         if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            //
            var response_Arr = JSON.parse(xmlhttp.responseText);
            //console.log(response_Arr);

            var nodeHasPreviousPage = response_Arr.hasPreviousPage;
            var nodeStartCursor = response_Arr.startCursor;
            var nodeHasNextPage = response_Arr.hasNextPage;
            var nodeEndCursor = response_Arr.endCursor;
            //
            var nodeProdukt = response_Arr.data;
            //console.table(nodeProdukt);
            //
            m_shop_produkte_prev.setAttribute('startCursor', nodeStartCursor);
            m_shop_produkte_prev.setAttribute('hasPreviousPage', nodeHasPreviousPage);
            m_shop_produkte_next.setAttribute('endCursor', nodeEndCursor);
            m_shop_produkte_next.setAttribute('hasNextPage', nodeHasNextPage);
            //
            //Save prevoiusCursor for table refresh
            m_query_current_cursor.value = m_shop_produkte_next.getAttribute('endCursor');
            //

            (nodeHasPreviousPage == true) ? m_shop_produkte_prev.disabled = false : m_shop_produkte_prev.disabled = true;
            (nodeHasNextPage == true) ? m_shop_produkte_next.disabled = false : m_shop_produkte_next.disabled = true;
            //
            tbody_Uebersicht.innerHTML = '';
            m_SHOPSYS_bulk_produkt_erstellen_speichern.value = 0; //Set back to False
            //
            var i_bgcolor = 0;
            var i;
            //
            
            var arr_images_ref = [];
            var arr_position = [];
            var arr_width = [];
            var arr_height = [];
            var arr_src = [];

            //console.log(nodeProdukt.length);
            for(i = 0; i < nodeProdukt.length; i++) {
               //console.log(nodeProdukt[i].id, nodeProdukt[i].title);

               if (var_radio_Produkte_fulfill_service == 'registered') {
                  if (nodeProdukt[i].flag_registriert != 1) continue;
               } else if (var_radio_Produkte_fulfill_service == 'unregistered') {
                  if (nodeProdukt[i].flag_registriert == 1) continue;
               } 

               bgcolor_row = '';
               if ((i_bgcolor % 2) == 0) { bgcolor_row = '#FFFFFF'; } else { bgcolor_row = '#eaedef'; }

               //Check status
               if (nodeProdukt[i].flag_db_registriert == 0) { bgcolor_row = '#ffe4c4'; } else { if (nodeProdukt[i].flag_db_registriert == 0) { bgcolor_row = '#eafef6'; } }

               var image_records = 1;
               if (nodeProdukt[i].image == null) {
                  image_records = nodeProdukt[i].images.length;
               }
               var db_produkt_id = '';
               var db_produkt_img_cnt = 0;

               //Object Parameters for Saving product in database
               var produkt_abruf = '{';
                  if (var_id_mandant != '') produkt_abruf += 'id_mandant: '+ String_Backticks_Quotes(var_id_mandant ) + ', ';
                  if (nodeProdukt[i].id != '') produkt_abruf += 'produkt_id: '+ String_Backticks_Quotes(nodeProdukt[i].product_id ) + ', ';
                  if (nodeProdukt[i].product_title != '') produkt_abruf += 'produkt_titel: '+ String_Backticks_Quotes(encodeURI(nodeProdukt[i].product_title)) + ', ';
                  if (nodeProdukt[i].id != '') produkt_abruf += 'variant_id: '+ String_Backticks_Quotes(nodeProdukt[i].id) + ', ';
                  if (nodeProdukt[i].title != '') produkt_abruf += 'variant_titel: '+ String_Backticks_Quotes(encodeURI(nodeProdukt[i].title)) + ', ';
                  if (nodeProdukt[i].status != '') produkt_abruf += 'status: '+ String_Backticks_Quotes(nodeProdukt[i].status) + ', ';
                  if (nodeProdukt[i].sku != '') produkt_abruf += 'sku: '+ String_Backticks_Quotes(nodeProdukt[i].sku) + ', ';
                  if (nodeProdukt[i].barcode != '') produkt_abruf += 'barcode: '+ String_Backticks_Quotes(nodeProdukt[i].barcode) + ', ';

                  if (nodeProdukt[i].fulfillment_service != '') produkt_abruf += 'fulfillment_service_handle: '+ String_Backticks_Quotes(nodeProdukt[i].fulfillment_service) + ', ';
                  if (nodeProdukt[i].price != '') produkt_abruf += 'price: '+ String_Backticks_Quotes(nodeProdukt[i].price) + ', ';
                  if (nodeProdukt[i].grams != '') produkt_abruf += 'gewicht_g: '+ String_Backticks_Quotes(nodeProdukt[i].grams) + ', ';
                  if (nodeProdukt[i].inventory_item_id != '') produkt_abruf += 'inventory_item_id: '+ String_Backticks_Quotes(nodeProdukt[i].inventory_item_id) + ', ';
                  if (nodeProdukt[i].inventory_quantity != '') produkt_abruf += 'anzahl: '+ String_Backticks_Quotes(nodeProdukt[i].inventory_quantity) + ', ';
                  //if (nodeProdukt[i].image_id != '') produkt_abruf += 'image_id: '+ String_Backticks_Quotes(nodeProdukt[i].image_id) + ', ';
                  // if (imgs != '') produkt_abruf += 'images: '+ String_Backticks_Quotes(imgs) + ', ';
                  if (nodeProdukt[i].flag_registriert != '') produkt_abruf += 'flag_registriert: '+ String_Backticks_Quotes(nodeProdukt[i].flag_registriert) + ', ';

                  if (nodeProdukt[i].location_id != '') produkt_abruf += 'location_id: '+ String_Backticks_Quotes(nodeProdukt[i].location_id) + ', ';
                  if (nodeProdukt[i].location_name != '') produkt_abruf += 'location_name: '+ String_Backticks_Quotes(nodeProdukt[i].location_name) + ', ';

                  if (var_shop_id != '') produkt_abruf += 'shop_id: '+ String_Backticks_Quotes(var_shop_id) + ', ';
                  if (var_id_shop_system != '') produkt_abruf += 'id_shop_system: '+ String_Backticks_Quotes(var_id_shop_system);
               produkt_abruf += '}';

               //console.log(produkt_abruf);

               //Object Parameters for registering product in shopify for fulfillment
               var abruf = '{';
                  abruf += 'id_variante: '+ String_Backticks_Quotes(nodeProdukt[i].id) + ', ';
                  abruf += 'inventory_item_id: '+ String_Backticks_Quotes(nodeProdukt[i].inventory_item_id) + ', ';
                  abruf += 'id_mandant: '+ var_id_mandant + ', ';
                  abruf += 'id_shop_system: '+ var_id_shop_system + ', ';
                  abruf += 'flag_registriert: '+ nodeProdukt[i].flag_registriert;
               abruf += '}';
               //
               var tr = document.createElement('tr');
               tr.setAttribute('id', 'pr_li_' + nodeProdukt[i].id);
               tr.setAttribute('variant_id', nodeProdukt[i].id);
               tr.setAttribute('flag_registriert', nodeProdukt[i].flag_registriert);
               tr.setAttribute('flag_db_registriert', nodeProdukt[i].flag_db_registriert);

               tbody_Uebersicht.appendChild(tr);
               var td = [];

               //---------------------------------------------------------------------//         

               td[0] = document.createElement('td');
               td[0].setAttribute('bgcolor', 'darkgrey');
               td[0].setAttribute('valign', 'top');
               td[0].setAttribute('data-label', 'Check:');

               td[0].innerHTML = '';
               td[0].innerHTML += '<div style="">';
               //if ((nodeProdukt[i].flag_registriert == 0) && (nodeProdukt[i].requires_shipping == true)) {
               if (nodeProdukt[i].requires_shipping == true) {
                  td[0].innerHTML += '  <input type="checkbox" onchange="shop_product_check_select_onChange();" class="shop_product_check_select" id="shop_product_check_select_' + nodeProdukt[i].id + '" style="margin-bottom: 0px;">';
               }
               td[0].innerHTML += '</div>';

               //---------------------------------------------------------------------//         

               td[1] = document.createElement('td');
               td[1].setAttribute('bgcolor', bgcolor_row);
               td[1].setAttribute('valign', 'top');
               td[1].setAttribute('data-label', 'Product ID/Title:');

               td[1].innerHTML = '';
               td[1].innerHTML += '<div style="">';
               td[1].innerHTML += '  <p style="font-weight: 600; margin: 0;">' + nodeProdukt[i].product_id + '</p>';
               td[1].innerHTML += '  <p style="margin: 0; font-weight: 600; color: darkcyan;">' + utf8Decode(nodeProdukt[i].product_title) + '</p>';
               //td[1].innerHTML += '  <p style="margin: 0;"><strong>Fulfillment: </strong>' + utf8Decode(nodeProdukt[i].fulfillment_service) + '</p>';
               td[1].innerHTML += '  <p style="margin: 0;"><strong>Fulfillment: </strong>' + utf8Decode(nodeProdukt[i].location_name) + '</p>';

               if (nodeProdukt[i].flag_registriert == 0) {
                  if (nodeProdukt[i].requires_shipping == true) {
                     td[1].innerHTML += '  <button class="small button success item-remove" style="text-transform: unset; padding: 5px; width: 100%;" id="btn_fulfill_sync_' + nodeProdukt[i].id + '" title="' + getBeschriftung_JS(1334, g_LANG_ISO3, "Assign fulfillment service to product in shop.") + '" style="margin: 0; margin-top: 5px; width: 100%;" onclick="Shopify_Register_Product(' + utf8Decode(abruf) + ');" data-element-index="6">' + getBeschriftung_JS(2179, g_LANG_ISO3, "Registrieren Produkt für Fulfillment") + ' <i class="fas fa-sign-in-alt"></i></button>';
                  } else {
                     td[1].innerHTML += '  <p style="margin: 0;"><strong style="color: blue;">' + getBeschriftung_JS(2384, g_LANG_ISO3, "Not a phisical product") + ' </strong></p>';
                  }

               } else {
                  td[1].innerHTML += '  <p style="margin: 0;"><strong style="color: #5da423;">' + getBeschriftung_JS(1330, g_LANG_ISO3, "Fulfillment registriert:") + ' </strong><span style="padding: 0px 10px;"><?php echo $UTIL->IMG_Activated(15, 15); ?></span></p>';

                  if (nodeProdukt[i].requires_shipping == true) {
                     td[1].innerHTML += '  <button class="small button alert item-remove" style="text-transform: unset; padding: 5px; width: 100%;" id="btn_fulfill_sync_' + nodeProdukt[i].id + '" title="' + getBeschriftung_JS(999999, g_LANG_ISO3, "Reverse Assigned fulfillment service to product in shop.") + '" style="margin: 0; margin-top: 5px; width: 100%;" onclick="Shopify_Register_Product(' + utf8Decode(abruf) + ');" data-element-index="6">' + getBeschriftung_JS(2548, g_LANG_ISO3, "Reverse Product Fulfillment") + ' <i class="fas fa-sign-in-alt"></i></button>';
                  } else {
                     td[1].innerHTML += '  <p style="margin: 0;"><strong style="color: blue;">' + getBeschriftung_JS(2384, g_LANG_ISO3, "Not a phisical product") + ' </strong></p>';
                  }
               }

               td[1].innerHTML += '</div>';

               //---------------------------------------------------------------------//

               td[2] = document.createElement('td');
               td[2].setAttribute('bgcolor', bgcolor_row);
               td[2].setAttribute('valign', 'top');
               td[2].setAttribute('data-label', 'Variant ID/Title:');

               td[2].innerHTML = '';
               td[2].innerHTML += '<div style="">';
               td[2].innerHTML += '  <p style="font-weight: 600; margin: 0;">' + nodeProdukt[i].id + '</p>';
               if (nodeProdukt[i].title == "Default Title") {
                  td[2].innerHTML += '  <p style="margin: 0; color: #cacaca;">' + utf8Decode(nodeProdukt[i].title) + '</p>';
               } else {
                  td[2].innerHTML += '  <p style="margin: 0; font-weight: 600; color: darkcyan;">' + utf8Decode(nodeProdukt[i].title) + '</p>';
               }
               td[2].innerHTML += '  <p style="margin: 0;"><strong>SKU: </strong>' + nodeProdukt[i].sku + ' <strong>Status: </strong> ' + nodeProdukt[i].status.toUpperCase() + ' </p>';

               if ((BenutzerLevel == BenutzerLevel_Admin) || (BenutzerLevel == BenutzerLevel_Manager)) {
                  if (nodeProdukt[i].flag_db_registriert == 0) {
                     if (nodeProdukt[i].requires_shipping == true) {
                        td[2].innerHTML += '  <button class="small button primary item-remove" style="text-transform: unset; padding: 5px; width: 100%;" id="btn_sync_' + nodeProdukt[i].id + '" title="' + getBeschriftung_JS(2181, g_LANG_ISO3, "Produktdetails in der Lagerverwaltung speichern.") + '" style="margin: 0; width: 100%;" onclick="REST_Shopify_Produkt_erstellen_speichern(' + utf8Decode(produkt_abruf) + ');" data-element-index="6">' + getBeschriftung_JS(1335, g_LANG_ISO3, "Pakajo-Produktmanagement") + ' <i class="fas fa-sign-in-alt"></i></button>';
                     }
      
                  } else {
                     td[2].innerHTML += '  <p style="margin: 0; background-color: #d8eaf9;"><strong style="color: #2ba6cb;">DB <?php echo $LANG->getBeschriftung(2180, $LANG_ISO3, "Pakajo-Lager registriert:"); ?> </strong><span style="padding: 0px 10px;"><?php echo $UTIL->IMG_Activated(15, 15); ?></span></p>';
                     //Products of stock management
                     var nodeDB_Produkts = nodeProdukt[i].db_produkt_arr;
                     //
                     var innerHTML = ' <ul style="color: cadetblue; columns: 2; margin: 0; padding-left: 5px; list-style: none; background-color: #d8eaf9;">';
                     for(z = 0; z < nodeDB_Produkts.length; z++) {
                        db_produkt_img_cnt = nodeDB_Produkts[z].img_cnt;

                        innerHTML += ' <li style="font-weight: 600;">&#9679 ' + nodeDB_Produkts[z].id_produkt + ' ';
                        if (db_produkt_img_cnt == 0) innerHTML += '<span style="color: chocolate;">' + getBeschriftung_JS(2554, g_LANG_ISO3, "No Image") + '</span>';
                        innerHTML += ' </li>';

                     } 

                     innerHTML += '    </ul>';
                     if (nodeDB_Produkts.length > 1) {
                        innerHTML += '<p class="blinking" style="margin: 0; color: red;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + getBeschriftung_JS(2549, g_LANG_ISO3, "Duplicate entry of variant id!") + '</p>';
                     } else {
                        db_produkt_id = nodeDB_Produkts[0].id_produkt;
                     }
                     //db_produkt_id = nodeDB_Produkts[0].id_produkt;
                     td[2].innerHTML += innerHTML;
                  }
               }

               td[2].innerHTML += '</div>';

               //---------------------------------------------------------------------//         
               
               td[3] = document.createElement('td');
               td[3].setAttribute('bgcolor', bgcolor_row);
               td[3].setAttribute('valign', 'top');
               td[3].setAttribute('data-label', 'Details:');

               td[3].innerHTML = '';
               td[3].innerHTML += '<div style="">';
               td[3].innerHTML += ' <p style="margin: 0; display: inline-flex;"><strong style="font-weight: 600; width: 70px;"><?php echo $LANG->getBeschriftung(1331, $LANG_ISO3, "Price:"); ?> </strong>' + nodeProdukt[i].price + '</p>';
               td[3].innerHTML += '  <p style="margin: 0; display: inline-flex;title="<?php echo $LANG->getBeschriftung(1299, $LANG_ISO3, "Gewicht"); ?>"><strong style="font-weight: 600; width: 70px;"><?php echo $LANG->getBeschriftung(1332, $LANG_ISO3, "Weight(g):"); ?> </strong>' + nodeProdukt[i].grams + '</p>';
               td[3].innerHTML += '  <p style="margin: 0; display: inline-flex;"><strong style="font-weight: 600; width: 70px;"><?php echo $LANG->getBeschriftung(1333, $LANG_ISO3, "Stock:"); ?> </strong>' + nodeProdukt[i].inventory_quantity + '</p>';
               td[3].innerHTML += '</div>';

               if (image_records > 0) {
                  td[3].innerHTML += '  <button class="small button warning item-remove" style="padding: 5px; width: 100%;" id="btn_img_' + nodeProdukt[i].id + '" title="' + getBeschriftung_JS(1336, g_LANG_ISO3, "Show Product Images") + '" onclick="Toggle_Images(' + nodeProdukt[i].id + ')" style="margin: 0; margin-top: 5px; width: 100%;" data-element-index="6">' + getBeschriftung_JS(2182, g_LANG_ISO3, "Images") + ' <i class="fas fa-image"></i></button>';
               }

               //---------------------------------------------------------------------//
               if (image_records > 0) {
                  var tr_detail = document.createElement('tr');
                  tbody_Uebersicht.appendChild(tr_detail);
                  tr_detail.className = 'table-expand-row-content';
                  tr_detail.setAttribute('style', 'border: 2px solid #788A8F;');
                  tr_detail.id = 'shopify_product_images_content_' + nodeProdukt[i].id;


                  var td_detail = document.createElement('td');
                  tr_detail.appendChild(td_detail);
                  td_detail.className = 'table-expand-row-nested';
                  td_detail.setAttribute('colspan', '6');

                  var innerHTML = '';

                  //---------------------------------------------------------------------//

                  if (db_produkt_img_cnt > 0)  innerHTML += '<p style="font-weight: 600; color: chocolate;">' + getBeschriftung_JS(2550, g_LANG_ISO3, "Product already assigned image(s)") + '</p>';

                  innerHTML += '<div class="row">';
                     var nodeImages = nodeProdukt[i].images;
                     for(z = 0; z < nodeImages.length; z++) {
                        innerHTML += '<div class="columns">';
                        innerHTML += '    <img style="height: 120px; width: 120px; margin: 0 10px; border: 1px solid #788A8F; border-radius: 10px;" image_ref="' + nodeImages[z].images_ref + '" pos="' + z + '" id="produkt_foto_img_'+ nodeProdukt[i].id + '_' + z + '" src="">';
                        img_id = 'produkt_foto_img_'+ nodeProdukt[i].id + '_' + z;
                        if (db_produkt_id != '') innerHTML += '<p style="margin: 0;"><a class="button hollow" id="btn_upload_foto_'+ nodeProdukt[i].id + '_' + z + '" onclick="Shopify_ProduktBild_erstellen(' + String_Backticks_Quotes(db_produkt_id) + ', ' + String_Backticks_Quotes(img_id) + ', ' + db_produkt_img_cnt + ');" style="width: 120px; margin: 5px 10px 0px; padding: 5px; font-size: smaller;">' + getBeschriftung_JS(2551, g_LANG_ISO3, "Upload photo") + ' <i class="fas fa-cloud-upload-alt"></i></a></p>';
                        innerHTML += '</div>';
                     }
                  innerHTML += '</div>';

                  td_detail.innerHTML = innerHTML;

                  convertImgToWebP(nodeProdukt[i].id, nodeImages);
               }
               //---------------------------------------------------------------------//     

               // tr.appendChild(td[0]);
               // tr.appendChild(td[1]);
               // tr.appendChild(td[2]);
               // tr.appendChild(td[3]);
               //
               i_bgcolor++;
            }

            SpinnerStop(false);
         } // end if
      } // end onreadystatechange

      xmlhttp.ontimeout = function() {
         alert('<?php echo addslashes($LANG->getBeschriftung(1337, $LANG_ISO3, "Network timeout!")); ?>');
         SpinnerStop(false);
      }

      var var_radio_Produkte_anzeigen = 0;
      for (i = 0; i < m_radio_Produkte_anzeigen.length; i++) {
         if (m_radio_Produkte_anzeigen[i].checked == true) var_radio_Produkte_anzeigen = m_radio_Produkte_anzeigen[i].value;
      } // end for (i);

      var var_radio_Produkte_sku = 0;
      for (i = 0; i < m_radio_Produkte_SKU.length; i++) {
         if (m_radio_Produkte_SKU[i].checked == true) var_radio_Produkte_sku = m_radio_Produkte_SKU[i].value;
      } // end for (i);

      var post_parameters = '';
      post_parameters += '&rel=' + data_rel;
      post_parameters += '&cursor=' + cursor;
      post_parameters += '&url=' + data_store;
      post_parameters += '&sub_endpoint=' + data_sub_endpoint;
      post_parameters += '&data_location_id=' + data_location_id;
      post_parameters += '&access_token=' + data_access_token;
      post_parameters += '&access_key=' + data_access_key;
      post_parameters += '&request_status=' + var_radio_Produkte_anzeigen;
      post_parameters += '&request_sku=' + var_radio_Produkte_sku;
      post_parameters += '&search_sku=' + m_text_sku_input.value;
      post_parameters += '&search_product_id=' + m_text_product_id_input.value;

      //
      console.log("/api_shopify/shopify_products_pagination.php?" + post_parameters);
      xmlhttp.open("GET", encodeURI("/api_shopify/shopify_products_pagination.php?" + post_parameters), true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      //
      xmlhttp.send();

      return;
   } //end REST_Shopify_Produkte_Abrufen();

</script>