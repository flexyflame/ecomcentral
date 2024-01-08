<script>
    history.pushState(null, null, null);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, null);
    });
</script>


<!--Include Header-->
<?php 
/*require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/output_functions.php");  
Student_Export_XLS('AA');*/


 //require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");
  $path = $_SERVER['DOCUMENT_ROOT'];
  $header = $path . "/includes/header.php";
  include ($header);

  $nav = $path . "/includes/nav.php";
  include ($nav);
?>


<article>
  <div class="row">

    <div class="small-12 medium-12 large-12 columns">
      <h1 class="hero-heading" style="text-align: left; font-family: inherit; letter-spacing: unset; font-size: 40px;">Getting Started with  <span class="pink-h">eCom Central</span> Shopping Cart Integrations</h1>
      <p class="subheader">eCom Central offers a number of standard API integration options that connect your customers' online shopping cart(s) with eCom Warehouse Manager. Setup instructions for our most requested shopping cart integrations are found in the articles on your below. If you don't see your customer's shopping cart integration, we recommend looking into a contact with us.</p>

      <p class="subheader">Please note that you must have a subscription to eCom Central's Ecommerce Package and have the Connections feature enabled within eCom Warehouse Manager prior to setting up an integration. Additionally, each setup requires configuration within the shopping cart, which is completed by the store administrator or merchant.</p>

      <p class="subheader">If you do not currently have an API connection enabled for your account and are interested in setting up a consultation, please contact our Customer Service. If you'd prefer to go ahead and move forward without a consultation, please fill out our API Integration Survey. Once submitted, we will contact you within 2–4 business days regarding next steps.</p>
    </div>
 
    <section class="marketing-site-three-up">
      <h3 class="hero-heading">Integrations Content</h2>
      <p class="subheader">Learn how to get started with integrating third-party platforms with eCom Warehouse Manager</p>
      <div class="row medium-unstack">
        <div class="columns">
          <a href="<?php echo $SESSION->Generate_Link("shopify_cart_connection", ""); ?>">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">Shopify Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from Shopify, Inventory numbers and Tracking numbers from eComCentral to Shopify.</p>
          </a>
        </div>
        <div class="columns">
          <a href="">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">WooCommerce Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from WooCommerce, Inventory numbers and Tracking numbers from eComCentral to WooCommerce.</p>
          </a>
        </div>
        <div class="columns">
          <a href="">
            <i class="fa fa-amazon" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">Amazon Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from Amazon, Inventory numbers and Tracking numbers from eComCentral to Amazon.</p>
          </a>
        </div>
      </div>

      <div class="row medium-unstack" style="margin-top: 10px;">
        <div class="columns">
          <a href="">
            <i class="fa fa-magnet" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">Magento 2.x Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from Magento, Inventory numbers and Tracking numbers from eComCentral to Magento.</p>
          </a>
        </div>
        <div class="columns">
          <a href="">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">eBay Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from eBay, Inventory numbers and Tracking numbers from eComCentral to eBay.</p>
          </a>
        </div>
        <div class="columns">
          <a href="">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            <h4 class="marketing-site-three-up-title">PrestaShop Shopping Cart Connection</h4>
            <p class="marketing-site-three-up-desc">Orders from PrestaShop, Inventory numbers and Tracking numbers from eComCentral to PrestaShop.</p>
          </a>
        </div>
      </div>
    </section>

  </div>

  <div style="padding-top: 4vw; padding-bottom: 4vw; background-color: #a0d9d5;">
    <div style="margin-right: auto; margin-left: auto; max-width: 1000px;">
      <h4 style="text-align: center;">Use the code <strong>#MIXGH007BMW</strong> and get a great disccount on all our components</h4>
    </div>
  </div>

</article>


 <!--Include Nav_Footer and Footer-->
  <?php 
    $path = $_SERVER['DOCUMENT_ROOT'] ;
    include ($path . "/includes/nav_footer.php");
    include ($path . "/includes/footer.php");
  ?>