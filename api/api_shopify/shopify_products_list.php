<?php 

   require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
   require_once($_SERVER['DOCUMENT_ROOT'] . "/api/api_shopify/shopify_functions.php");  
   set_time_limit(1800);
   //

   $rel = '';
   if (isset($_GET['rel'])) { $rel = $_GET['rel']; }

   $cursor = '';
   if (isset($_GET['cursor'])) { $cursor = $_GET['cursor']; }

   $shop_url = '';
   if (isset($_GET['url'])) { $shop_url = $_GET['url']; }

   $submit_endpoint = '';
   if (isset($_GET['sub_endpoint'])) { $submit_endpoint = $_GET['sub_endpoint']; }

   $request_status = 0;
   if (isset($_GET['request_status'])) { $request_status = $_GET['request_status']; }
   //echo $request_status; //published unpublished

   $request_sku = 0;
   if (isset($_GET['request_sku'])) { $request_sku = $_GET['request_sku']; }
   //echo $request_sku; //with_sku without_sku

   $search_sku = "";
   if (isset($_GET['search_sku'])) { $search_sku = $_GET['search_sku']; }

   $search_product_id = "";
   if (isset($_GET['search_product_id'])) { $search_product_id = $_GET['search_product_id']; }

   $data_location_id = '';
   if (isset($_GET['data_location_id'])) { $data_location_id = $_GET['data_location_id']; }

   $access_token = '';
   if (isset($_GET['access_token'])) { $access_token = $_GET['access_token']; }

   $access_key = '';
   if (isset($_GET['access_key'])) { $access_key = $_GET['access_key']; }
   //


   $result = get_ProductVariant_GraphQL($access_token, $shop_url, $data_location_id, $rel, $cursor, $request_status, $request_sku, $search_sku, $search_product_id);
   //Then we return the values back to ajax
   ob_clean();
   echo $result;
   die();

   function get_ProductVariant_GraphQL($access_token, $shop_url, $location_id, $rel, $cursor, $request_status, $request_sku, $search_sku, $search_product_id) {

      $numRecords = 'first: 70';
      $cursor_str = '';
      if ($rel == 'previous') {
         $numRecords = 'last: 70';
         $cursor_str = ', before:"'. $cursor .'"';
      } else if ($rel == 'next') {
         $numRecords = 'first: 70';
         $cursor_str = ', after:"'. $cursor. '"';
      }

      $query_request_status = '';
      if ($request_status != '0') {
         $query_request_status = 'product_status:' . $request_status;
      }

      $query_request_sku = "";
      if ($request_sku != "0") {

         $and_connector = "";
         if ($query_request_status != "") $and_connector = " AND ";

         if ($request_sku == "with_sku") {
            $query_request_sku = $and_connector . "-sku:''";
         } else {
            $query_request_sku = $and_connector . "sku:''";
         }
      }

      $query_search_sku = '';
      if ($search_sku != '') {

         $and_connector = "";
         if (($query_request_status != "") || ($query_request_sku != "")) $and_connector = " AND ";

         $query_search_sku = $and_connector . 'sku:' . $search_sku;
      }

      $query_search_product_id = '';
      if ($search_product_id != '') {

         $and_connector = "";
         if (($query_request_status != "") || ($query_request_sku != "")) $and_connector = " AND ";

         $query_search_product_id = $and_connector . 'product_id:' . $search_product_id;
      }


      $query = array('query' => '{
         productVariants(query: "'. $query_request_status . $query_request_sku . $query_search_sku . $query_search_product_id . '", '. $numRecords . $cursor_str .') {
             edges {
               cursor
               node {
                 id
                 sku
                 displayName
                 inventoryQuantity
                 price
                 weight
                 weightUnit
                 harmonizedSystemCode
                 inventoryManagement
                 position
                 requiresShipping
                 barcode
                 image {
                   id
                   transformedSrc(maxHeight: 300, preferredContentType: JPG)
                 }
                 inventoryItem {
                   id
                   inventoryLevels(first: 2) {
                     edges {
                       node {
                         location {
                           id
                           name
                         }
                       }
                     }
                   }
                 }
                 product {
                   id
                   status
                   images(first: 2) {
                     edges {
                       node {
                         id
                         transformedSrc(maxHeight: 300, preferredContentType: JPG)
                         height
                         width
                       }
                     }
                   }
                 }
               }
             }
             pageInfo {
               hasNextPage
               hasPreviousPage
               startCursor
               endCursor
            }
         }
      }');
      //print_r($query);
      //die('DIE AAAA');

      $id = "";
      $name = "";
      $edges_cnt = 0;
      $products_output = array();
      //
      $variant['flag_registriert'] = 0;
      $variant['location_id'] = "***";
      $variant['location_name'] = "Others";

      $productVariants = shopify_gql_rest_api($access_token, $shop_url, $query, $rel);
      //print_r($productVariants);
      //print_r($productVariants['data']);
      $pageInfo_data = json_decode($productVariants['data'], true);
      foreach ($pageInfo_data['data'] as $pageInfo) $pageInfo_node = $pageInfo['pageInfo'];
      $hasNextPage = $pageInfo_node['hasNextPage'];
      $hasPreviousPage = $pageInfo_node['hasPreviousPage'];
      $startCursor = $pageInfo_node['startCursor'];
      $endCursor = $pageInfo_node['endCursor'];
      // print_r($pageInfo_node['hasNextPage']);
      // print_r($pageInfo_node['hasPreviousPage']);

      //die('PPP');
      $headers =  $productVariants['headers'];
      //print_r($headers);

      $productVariant_data = json_decode($productVariants['data'], true);
      foreach ($productVariant_data['data'] as $productVariant) {
         foreach($productVariant['edges'] as $product) {
            $variant = [];
            //
            // print_r($product['node']['id']);
            // print_r($product['node']['displayName']);
            $variant_id = str_replace('gid://shopify/ProductVariant/', '', $product['node']['id']);
            $variant['id'] = $variant_id;
            $variant['sku'] = $product['node']['sku'];
            $variant['hs_tariff'] = $product['node']['harmonizedSystemCode'];
            $variant['product_id'] = str_replace('gid://shopify/Product/', '', $product['node']['product']['id']);
            $variant['product_title'] = $product['node']['displayName'];
            $variant['title'] = "";
            $variant['status'] = $product['node']['product']['status'];
            $variant['fulfillment_service'] = "manual";
            $variant['grams'] = $product['node']['weight'];
            $variant['weight'] = $product['node']['weight'];
            $variant['weight_unit'] = $product['node']['weightUnit'];
            $variant['inventory_item_id'] = str_replace('gid://shopify/InventoryItem/', '', $product['node']['inventoryItem']['id']);
            $variant['inventoryManagement'] = $product['node']['inventoryManagement'];
            $variant['inventory_quantity'] = $product['node']['inventoryQuantity'];
            $variant['position'] = $product['node']['position'];
            $variant['requires_shipping'] = $product['node']['requiresShipping'];
            $variant['barcode'] = $product['node']['barcode'];
            $variant['price'] = $product['node']['price'];
            $variant['image'] = $product['node']['image'];

            if ($product['node']['image'] != null) {
               $img_arr = array();
               $img_cnt = 1;
               $li = array(); //Declear Line Item Array
               $li += ['images_ref' => str_replace('gid://shopify/ProductImage/', '', $product['node']['image']['id'])];
               $li += ['position' => $img_cnt];
               $li += ['src' => $product['node']['image']['transformedSrc']];
               //
               array_push($img_arr, $li); //Build images
               $variant += ['images' => $img_arr]; //Append Line Items

            } else {

               $img_arr = array();
               $img_cnt = 1;
               foreach($product['node']['product']['images']['edges'] as $images) {
                  //print_r($images['node']['transformedSrc']);
                  $li = array(); //Declear Line Item Array
                  //
                  $li += ['images_ref' => str_replace('gid://shopify/ProductImage/', '', $images['node']['id'])];
                  $li += ['width' => $images['node']['width']];
                  $li += ['height' => $images['node']['height']];
                  $li += ['position' => $img_cnt];
                  $li += ['src' => $images['node']['transformedSrc']];
                  //
                  $img_cnt++;
                  array_push($img_arr, $li); //Build images
               }
               $variant += ['images' => $img_arr]; //Append Line Items
            }

            //
            $variant['flag_registriert'] = 0;
            $variant['location_id'] = "***";
            $variant['location_name'] = "Others";
            //
            foreach($product['node']['inventoryItem']['inventoryLevels']['edges'] as $inventoryLevels) {
               //print_r($inventoryLevels['node']['location']);
               $id = str_replace('gid://shopify/Location/', '', $inventoryLevels['node']['location']['id']);
               if ($id == $location_id) {
                  $variant['flag_registriert'] = 1;
                  $variant['location_id'] = $id;
                  $variant['location_name'] = $inventoryLevels['node']['location']['name'];
               }
            }

            //Get Produkt detail
            $obj_Produkt = DB_Get_ObjProdukt($variant_id);
            $variant['db_produkt_arr'] = $obj_Produkt;
            $flag_db_registriert = 0;
            //Check if product is registered in Database
            if (count($obj_Produkt) > 0) $flag_db_registriert = 1;
            $variant['flag_db_registriert'] = $flag_db_registriert;


            array_push($products_output, $variant);
         }
      } //end foreach ()

      //print_r($products_output);

      return json_encode( array( 
         'hasPreviousPage' => $hasPreviousPage, 'startCursor' => $startCursor, 
         'hasNextPage' => $hasNextPage, 'endCursor' => $endCursor, 
         'data' => $products_output )
      );
      
      //return;
      //die('AAAAAA');
   }
?>