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
    	<div class="container_12">
    	<div id="logo"></div>
    	<div id="top_menu"></div>
		
		<div id="slide_area"></div>
		
		</div>
    </header>
    
    
    
    <div class="container_12" id="main">
main body
    </div>
 
 <div id="section2">   
     <div class="container_12" >
link area
    </div>
 </div>


<div id="section3">   
     <div class="container_12" >
footer 1
    </div>
 </div>
    
    
    <footer>
    	<div class="container_12">
footer 2
		</div>
    </footer>
  </div> 

<!--! end of #container -->
<?=$this->load->view('global/footer')?>
  
</body>
</html>