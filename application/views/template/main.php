<!doctype html>  

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
 
<?=$this->load->view('global/header')?>

</head>

<body>

  <div id="container">
    <header>
page header
    </header>
    
    <div id="main">
main body
    </div>
    
    <footer>
page footer
    </footer>
  </div> 

<!--! end of #container -->
<?=$this->load->view('global/footer')?>
  
</body>
</html>