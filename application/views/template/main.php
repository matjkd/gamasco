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
    	<div class="container_24">
    	
    	<!-- Logo here --> 
    	<div id="logo">
    		<img width="346px" height="75px" src="<?=base_url()?>images/template/logo.png" alt="Gamasco Logo" />
    	</div>
    	<div id="top_menu">
    		<ul>
    		<li>Home</li>
    		<li>About us</li>
    		<li>Products</li>
    		<li>Contact Us</li>
    		</ul>
    		</div>
		
		<div id="slide_area">
			<?=$this->load->view('slideshow/slideshow')?>
		</div>
		
		</div>
    </header>
    
    
    
    <div class="container_24" id="main">
    	
		<div class="container_24 grid_11">
			
			<?=$this->load->view('global/content')?>
		</div>
		
		<div id="side_box">
			
			
		</div>
	

    </div>
    <div class="clear"></div>
 
 
 <?php if(isset($section2)) { ?>
 <div id="section2">   
     <div class="container_24" >

		<?=$this->load->view($section2)?>

    </div>
 </div>
 <?php } ?>


<div id="section3">   
     <div class="container_24" >
The GMS Company. Gamasco House, 35 Hornsby Square, Southfields Industrial Park, Laindon, Essex SS15 6SD. <br/>
Tel: 01268 419909 Fax: 01268 544346. Email office@gamasco.co.uk<br/>
<strong>Europes Leading Supploer of Thermal Engineering Products</strong>
    </div>
 </div>
    
    
    <footer>
    	<div class="container_24">
footer 2
		</div>
    </footer>
  </div> 

<!--! end of #container -->
<?=$this->load->view('global/footer')?>
  
</body>
</html>