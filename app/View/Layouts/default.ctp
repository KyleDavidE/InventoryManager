<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
$themeColor = 'teal';
?>
<!DOCTYPE html>
<html>
<head>
	
	<?php echo $this->Html->charset(); ?>
	<title>
		Inventory Manager:
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="theme-color" content="#009688" />
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('http://fonts.googleapis.com/icon?family=Material+Icons','/bower_components/Materialize/dist/css/materialize.css','app'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script(array('/bower_components/jquery/dist/jquery.js','/bower_components/Materialize/dist/js/materialize.js','app'));
		echo $this->fetch('script');
	?>
</head>
<body><nav class=" theme-me">
  
  <!-- <ul id="slide-out" class="side-nav fixed">
    <li><a href="#!">First Sidebar Link</a></li>
    <li><a href="#!">Second Sidebar Link</a></li>
  </ul> -->
  <div class="nav-wrapper container">
  <!-- <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a> -->
  <a href="#" class="back-button waves-effect waves-light waves-circle " data-magic-link-go="-1"><i class="material-icons">arrow_back</i></a>
  <span class="page-title" ></span>
  </div>

</nav>
	
	<main class="container">
		 
		
		
		<div id="content">


			<?php echo $this->fetch('content'); ?>
		</main>
		
				
			
	</div>
	<span id="modals"></span>
	<!-- <footer class="page-footer theme-me"><div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div></footer> -->
	<?php 
		// echo $this->element('sql_dump'); 
		
	?>
	<!--<?php echo $cakeVersion; ?>-->
</body>
</html>
