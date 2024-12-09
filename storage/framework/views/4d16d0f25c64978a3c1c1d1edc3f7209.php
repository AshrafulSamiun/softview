<!DOCTYPE html>
<html lang="en">
	<head>
	  <?php echo $__env->make('web_include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</head>
	<body >
		 <?php echo $__env->make('web_include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<main id="main">

		    <?php echo $__env->yieldContent('content'); ?>
	    
		</main>
		 <?php echo $__env->make('web_include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		 <?php echo $__env->make('web_include.footScript', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	</body>



</html><?php /**PATH G:\WampServer\www\Development\SoftView\resources\views/layouts/appWebsite.blade.php ENDPATH**/ ?>