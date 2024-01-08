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
  //$header = $path . "/includes/header.php";
  //include ($header);

  //$nav = $path . "/includes/nav.php";
  //include ($nav);
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<article>
  <section id="about-us" style="padding-top: 8vw; padding-bottom: 8vw; background-color: #2c3840;">
    <div style="margin-right: auto; margin-left: auto; max-width: 1000px; align-items: center; text-align: center;">
      <p style="color: aliceblue;"><span>- eComCentral API -</span></p>
      <h3 style="font-weight: 800; color: #a0d9d5;">Description</h3>

      <p style="color: lightgray;"><span>The eComCentral System is the integrated ecommerce management system for the Most popular shops on the market, Shop owners that wants to be innovative and competitive in this new age. It has been designed with an extensive feature set, yet it is simple to manage and configure. eComCentral is modular in design and can grow as your institution and requirements grow. It grows with you, ensuring that new features that are introduced are truly features that are needed. eComCentral is a system that is open to the needs and requests of its customers. In creating a large family of users, you can be assured that as requests for certain features are incorporated, all users will benefit.</span><br>

      <span style="color: darkgrey">eComCentral is built on the latest computer technologies and can be used by shops of any size. Its database is robust and can support millions of records. Data is never thrown away and will be available for querying long after used. Mechants ability to access data and reports over the internet is an added bonus eComCentral is developed and supported by Superior Software Systems and its customer focused network of expert channel partners. You can be assured that there is always a support person nearby. There is also a dedicated help desk, which is just a phone call or an e-mail away.</span></p>
    </div>
  </section>



</article>


</body>
</html>


