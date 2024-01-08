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

  <section id="marketing" style="padding-bottom: 20px;">
    <div class="marketing-site-content-section">
      <div class="marketing-site-content-section-img">
        <img src="/images/schoolchildren1.jpg" alt="The best School Management Software" />
      </div>
      <div class="marketing-site-content-section-block">
        <h3 class="marketing-site-content-section-block-header">API Shopping Cart Integrations</h3>
        <a href="<?php echo $SESSION->Generate_Link("integration", ""); ?>" class=" hollow round button small">learn more</a>
      </div>
      <div class="marketing-site-content-section-block small-order-2 medium-order-1">
        <h3 class="marketing-site-content-section-block-header">External REST API</h3>
        <a href="<?php echo $SESSION->Generate_Link("features", ""); ?>" class="hollow round button small">learn more</a>
      </div>
      <div class="marketing-site-content-section-img small-order-1 medium-order-2">
        <img src="/images/schoolchildren2.jpg" alt="Choose eSoftSchool and you will never regret" />
      </div>
    </div>
  </section>

  <section id="benefits" style="background-color: #2c3840; padding: 20px 0;">
      <div class="row column">
        <h2 class="lead" style="color: aliceblue;">BENEFITS</h2>
      </div>

      <div class="row small-up-1 medium-up-2 large-up-3">
        <div class="column">
          <div class="callout">
            <p>Easy Accessible</p>
            <p><img src="/images/acessible.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Full Online Implementation</p>
            <p><img src="/images/online.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Data Backup Provided</p>
            <p><img src="/images/network.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Secured From Cyber Attacks</p>
            <p><img src="/images/cyber-security.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p>Easy Online Accounts Reconciliation</p>
            <p><img src="/images/communication.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>
        <div class="column">
          <div class="callout">
            <p> 24/7 Support: whatsapp and Email</p>
            <p><img src="/images/monitor.jpg" alt="image of a planet called Pegasi B"></p>
            <p class="subheader">Find Earth-like planets life outside the Solar System</p>
          </div>
        </div>

      </div>
  </section>

  <section class="marketing-site-three-up" id="services">
    <h2 class="marketing-site-three-up-headline">Services</h2>
    <div class="row medium-unstack">
      <div class="columns">
        <i class="fa fa-gg" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Primary School</h4>
        <p class="marketing-site-three-up-desc">These modules are interlinked by datasets that allows Parents, Teachers, School Management and Students to manage, maintain monitor and provide quality education and services to every student attending your school.</p>
      </div>
      <div class="columns">
        <i class="fa fa-user-o" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Junior High School</h4>
        <p class="marketing-site-three-up-desc">SoftSchool is built on the latest computer technologies and can be used by schools of any size. Its database is robust and can support millions of records.</p>
      </div>
      <div class="columns">
        <i class="fa fa-check-square-o" aria-hidden="true"></i>
        <h4 class="marketing-site-three-up-title">Products</h4>
        <p class="marketing-site-three-up-desc">Data is never thrown away and will be available for querying long after students have graduated and left. Parents and guardians ability to access student data and reports over the internet is an added bonus. SoftSchool is developed and supported by Superior Software Systems and its customer focused network of expert channel partners.</p>
      </div>
    </div>
  </section>

  <section id="about-us" style="padding-top: 8vw; padding-bottom: 8vw; background-color: #2c3840;">
    <div style="margin-right: auto; margin-left: auto; max-width: 1000px; align-items: center; text-align: center;">
      <p style="color: aliceblue;"><span>- eSoftSchool -</span></p>
      <h3 style="font-weight: 800; color: #a0d9d5;">ABOUT US</h3>

      <p style="color: lightgray;"><span>The SoftSchool System is the integrated school management system for the Primary, Junior High School (JHS) and Senior High School (SHS) that wants to be innovative and competitive in this new millennium. It has been designed with an extensive feature set, yet it is simple to manage and configure. SoftSchool is modular in design and can grow as your institution and requirements grow. It grows with you, ensuring that new features that are introduced are truly features that are needed. SoftSchool is a system that is open to the needs and requests of its customers. In creating a large family of users, you can be assured that as requests for certain features are incorporated, all users will benefit.</span><br>

      <span style="color: darkgrey">SoftSchool is built on the latest computer technologies and can be used by schools of any size. Its database is robust and can support millions of records. Data is never thrown away and will be available for querying long after students have graduated and left. Parents and guardians ability to access student data and reports over the internet is an added bonus SoftSchool is developed and supported by Superior Software Systems and its customer focused network of expert channel partners. You can be assured that there is always a support person nearby. There is also a dedicated help desk, which is just a phone call or an e-mail away.</span></p>
    </div>
  </section>

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