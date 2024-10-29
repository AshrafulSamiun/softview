<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $__env->make('web_include.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body >
	 <?php echo $__env->make('web_include.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<main id="main">
	   
	   
	        
	            <?php echo $__env->yieldContent('content'); ?>

	        
	    
     
	</main>
	 <?php echo $__env->make('web_include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	 <?php echo $__env->make('web_include.footScript', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>



</html>