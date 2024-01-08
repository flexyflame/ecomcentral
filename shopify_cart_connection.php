
<!--Include Header-->
<?php 
  $path = $_SERVER['DOCUMENT_ROOT'];
  $header = $path . "/includes/header.php";
  include ($header);

  $nav = $path . "/includes/nav.php";
  include ($nav);
?>


<article>
  <div class="row">

    <div class="small-12 medium-12 large-12 columns">
      <h1 class="hero-heading" style="text-align: left; font-family: inherit; letter-spacing: unset; font-size: 40px;"><span class="pink-h">Shopify</span> Shopping Cart Connection</h1>
      <p class="subheader">Here we walk through the configuration of the connection between eCom Warehouse Manager and Shopify. This connection allows for the following information to be synced:</p>

      <ol>
        <li>Orders from Shopify to eCom Central Warehouse Manager</li>
        <li>Inventory numbers from eCom Central Warehouse Manager to Shopify</li>
        <li>Tracking numbers from eCom Central Warehouse Manager to orders in Shopify</li>
      </ol>

      <p class="subheader">Each of these syncing options and configuration guidelines are further detailed below.</p>

      <p class="subheader">If you do not currently have an API connection enabled for your account and are interested in setting up a consultation, please contact our Customer Service. If you'd prefer to go ahead and move forward without a consultation, please fill out our API Integration Survey. Once submitted, we will contact you within 2–4 business days regarding next steps.</p>

      <ul>
        <li><a href="#syncing_options" target="_self">Syncing Options</a>
        <ul>
          <li><a href="#orders" target="_self">Orders</a></li>
          <li><a href="#inventory" target="_self">Inventory</a></li>
          <li><a href="#tracking_numbers" target="_self">Tracking numbers</a></li>
        </ul>
        </li>
        <li><a href="#guidelines" target="_self">Guidelines</a>
          <ul>
            <li><a href="#connection" target="_self">Set up the shopping cart connection</a>
              <ul>
                <li><a href="#gen_api_key" target="_self">Step 1: Generate Shopify API keys</a></li>
                <li><a href="#config_api_permissions" target="_self">Step 2: Configure Admin API permissions</a></li>
                <li><a href="#location_id" target="_self">Step 3: Locate your Shopify Location ID</a></li>
              </ul>
            </li>
            <li><a href="#warehouse_manager" target="_self">Update orders via eCom Central Warehouse Manager</a></li>
            <li><a href="#notifications" target="_self">Set up event notifications</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="small-12 medium-12 large-12 columns">
      <h3 class="hero-heading" id="syncing_options">Syncing Options</h3>
      <h4 class="hero-heading" id="orders">Orders</h4>

      <p class="subheader">This connection brings in orders with a fulfillment status of “Not Fulfilled” and a payment status of “Paid”. It can also be configured to bring in "Authorized", "Pending", “Partially Fulfilled”, “Refunded”, or “Partially Refunded” orders.</p>

      <p class="subheader">For orders to properly sync, each Shopify product on the order must contain a SKU that is set up in eCom Central Warehouse Manager. Even if line items in Shopify are already fulfilled, they still need a matching SKU in eCom Central Warehouse Manager. If you’re not going to fulfill those lines, we recommend using the Ignore SKU function. For more information on this feature, see Ignoring SKUs.</p>

      <p class="subheader">Smart User Tip: Rather than setting up shipping methods manually in eCom Central Warehouse Manager, we recommend using ship method mappings. For more information, see Managing Ship Method Mappings.</p>

      <div class="callout warning">
        <p class="subheader">Please note that setting up an item in Shopify does not necessarily mean it has a SKU. A SKU is not required value for a product in Shopify, so if an order gets created and the product doesn’t have a SKU, that item does not sync in eCom Central Warehouse Manager.</p>  

        <p class="subheader">Furthermore, updating a product in Shopify does not retroactively impact Shopify’s existing orders. For example, if you leave all your SKU values blank on your products and then receive 100 orders, going back and filling in the SKU value for the product does not mean we can pull in those orders after the fact. The Shopify API still shows the SKU field for each order as what the product had when the order was created.</p>  

        <p class="subheader">For more information on products in Shopify, please visit Shopify's Help Center page for Products.</p>  
      </div> 

      <h4 class="hero-heading" id="inventory">Inventory</h4>

      <p class="subheader">Inventory syncing is optional. If enabled, the connection pulls available inventory numbers from eCom Central Warehouse Manager and updates the available quantities in Shopify. Similar to order syncing, products must have SKUs configured to sync inventory numbers and these SKUs must exist in both eCom Central Warehouse Manager and Shopify.</p>

      <p class="subheader">When you add inventory to Shopify, your inventory does not automatically update in eCom Central Warehouse Manager. In order to reflect new inventory, a receipt must be generated into the system.</p>

      <h4 class="hero-heading" id="tracking_numbers">Tracking numbers</h4>
      <p class="subheader">Tracking numbers are sent back to orders in Shopify from eCom Central Warehouse Manager once the order has been confirmed in the system. For more information on this process, please see Update orders via eCom Central Warehouse Manager below.</p>

      <p class="subheader">Tracking number post-back for this connection is supported at the order-level only. Line-item-level tracking post-back is not supported, which means that orders loaded from Shopify must be fully shipped. If you short ship or split a shipment, the tracking number provided on the order will post-back to Shopify—marking the entire order as fulfilled, not just the items that were shipped.</p>


      <h3 class="hero-heading" id="guidelines">Guidelines</h3>
      <h4 class="hero-heading" id="connection">Set up the shopping cart connection</h4>

      <p class="subheader">Please fill out our API Integration Survey to request a connection to Shopify. To obtain the credentials asked for in the survey, please complete Steps 1 through 3 below.<br> 
      After you submit the survey, your Customer Success Manager will send you a DocuSign within one business day. Once you complete the DocuSign, our Professional Services team begins the cart setup process. These requests are typically completed 24–48 hours after receiving all the necessary information.</p>

      <p class="subheader">If you have not received a DocuSign within the specified time frame or would like to know the project status, please reach out to your CSM.</p>

      <h4 class="hero-heading" id="gen_api_key">Step 1: Generate Shopify API keys</h4>

      <p class="subheader">To begin the setup configuration, you or your customer must first generate a set of Shopify private app keys. The process of generating the app keys is detailed here.<br>
      Once you or your customer have generated the API keys (see Step 8 of the documentation linked above titled “Generate credentials from the Shopify admin”), complete the instructions in Step 2 below to assign the required API permissions to the newly generated set of keys.</p>

      <h4 class="hero-heading" id="config_api_permissions">Step 2: Configure Admin API permissions</h4>

      <p class="subheader">To ensure the connection runs properly, please follow the steps below to provide the necessary Admin API permissions for the API keys created in Step 1 above.</p>

<ol>
<li>Log in to your <a class="external-link" href="https://www.shopify.com/login" target="_blank" rel="noopener">Shopify</a> store.</li>
<li>Select&nbsp;<strong>Apps</strong> from your dashboard menu.<br><img src="/images/ShopifyApps.png" alt="ShopifyApps.png"></li>
<li>Toward the bottom of the page, click <strong>Manage private apps</strong>.<br><img src="/images/ShopifyManagePrivateApp.png" alt="ShopifyManagePrivateApp.png"></li>
<li>Under the 'Private app name' column, select the private app you are using for eCom Central Warehouse Manager.</li>
<li>Under the 'Admin API Permissions' section, use the drop-down menus next to select <strong>Read and write&nbsp;</strong>access for the following permissions:<br>
<ol>
<li>Fulfillment services</li>
<li>Inventory</li>
<li>Orders</li>
<li>Product listings</li>
<li>Products<br><img src="/images/ShopifyAPIpermissions.png" alt="ShopifyAPIpermissions.png"><br><i class="fa fa-info" aria-hidden="true" style="border: 1px solid #ffae00; padding: 5px 10px; border-radius: 5000px; background-color: antiquewhite; font-style: italic;"></i> If these permissions do not display automatically, you may need to click <strong>Show inactive Admin API permissions</strong>.</li>
</ol>
</li>
<li>At the bottom-right of the page, click <strong>Save</strong>.</li>
</ol>
      
      <h4 class="hero-heading" id="location_id">Step 3: Locate your Shopify Location ID</h4>

      <p class="subheader">We recommend verifying the correct Location ID with your customer. Your customer can verify this by navigating to <strong>Settings > Locations</strong> in Shopify, selecting the relevant location to see its details, then capturing the numeric value at the end of the URL—e.g., https://acme.myshopify.com/admin/settings/locations/<strong>XXXXXXXX</strong>.</p>

      <h3 class="hero-heading" id="warehouse_manager">Update orders via eCom Central Warehouse Manager</h3>

      <p class="subheader">Once eCom Central Warehouse Manager has received and processed the Shopify orders, shipping and closing the orders sends the tracking numbers and marks the order as complete in Shopify.</p>

<ol>
<li>In eCom Central Warehouse Manager, navigate to <strong>Orders</strong> &gt; <strong>Find Orders</strong>.<br><img src="" alt="findorders.png"></li>
<li>Select the order(s) from the grid that you need to close and mark as shipped. Use &lt;<strong> Ctrl</strong> &gt; or &lt; <strong>Shift </strong>&gt; on your keyboard to select multiple orders.</li>
<li>Hover over <strong>Manage</strong>, then click <strong>Ship and close</strong>.</li>
<li>Complete the appropriate fields under 'Routing Information'.</li>
<li>If needed, enter any 'Additional Charges' that may have accumulated—each charge displays in the grid. For multiple orders, be sure to specify whether you wish to 'Apply Charges' separately to each order or divide the charges across all selected orders evenly.<br><i class="fa fa-info" aria-hidden="true" style="border: 1px solid #ffae00; padding: 5px 10px; border-radius: 5000px; background-color: antiquewhite; font-style: italic;"></i> Please note that any charges added here are in addition to all automatic and manual charges that have already been applied to the selected orders.</li>
<li>Click <strong>Ship and Close</strong>. The orders in your Shopify store reflect the latest changes.</li>
</ol>

    
      <h3 class="hero-heading" id="notifications">Set up event notifications</h3>

      <p class="subheader">When Shopify orders are created or fail to import into the system, you can set up automated emails to notify the desired parties. To enable these notifications, complete the following steps:<br>Please note that the error log may also be utilized to understand the cause of an error or rejection—see Using the Customer Error Log for further instructions.</p>

<ol>
<li>Navigate to <strong>Customers </strong>&gt; <strong>Customer Notifies</strong>.<strong><br><img src="" alt="customernotifies.png"></strong></li>
<li>From the drop-down menu, 'Choose a Customer' and click <strong>Select</strong>. This screen allows you to specify which actions trigger an event notification. The applicable options for notifications are as follows:
<ul>
<li><strong>Orders Created by Warehouse: </strong>Triggers each time an order is created by a warehouse user</li>
<li><strong>FTP Order Import Failed: </strong>Triggers each time an order import fails</li>
</ul>
</li>
<li>Under the 'Email Recipients' column, enter the email addresses in the relevant field for each event you would like your customer to receive a notification for. If using multiple recipients for one event, separate them with semicolons.</li>
<li>To change the default email notification for each event, click <strong>Change this cust.</strong> for that particular customer or click<strong>&nbsp;</strong><strong>Change master</strong> next to an event to change the email template for all of your customers. Make your modifications, then click <strong>Save</strong>.</li>
<li>Click <strong>Save</strong>.</li>
</ol>


    </div>

  </div>

</article>


 <!--Include Nav_Footer and Footer-->
  <?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
  ?>