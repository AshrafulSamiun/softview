s<html>
<head>
	<title>Multi form</title>

	<link href="{!! asset('assets/vendor/bootstrap/css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.slim.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js') }}"></script>

<!-- 
  	<script src="plugins/jquery/jquery.slim.min.js"></script>
  	<script src="js/popper.min.js"></script>
  	<script src="assets/vendor/jquery/bootstrap.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->


 	<style>

 		section{
 			padding-top:100px;
 		}

 		.form-section{
 			padding-left: 15px;
 			display: none;
 		}

 		.form-section.current{
 			display: inherit;

 		}

 		.btn-info, .btn-success{
 			margin-top:10px;
 		}

 		.parsley-errors-list{
 			margin:2px 0 3px;
 			padding:0;
 			list-style-type: none;
 			color:red;
 		}

 	</style>
</head>
<body>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4">

					<div class="card">
						<div class="card-heading"></div>
						<div class="card-body">
							<form class="contact-form">
								
								<div class="form-section">
									<lavel for="first-name">First Name</lavel>
									<input class="form-control" name="first_name" type="text" required></input>
								
									<lavel for="last-name">Last Name</lavel>
									<input class="form-control" name="last_name" type="text" required></input>
								</div>
								 <div class="form-section">
									<lavel for="email">Email</lavel>
									<input class="form-control" name="email" type="email" required></input>
								
									<lavel class="phone">phone</lavel>
									<input class="form-control" name="phone" type="phone" required></input>
								</div>

								<div class="form-section">
									<lavel for="first-name">Seceond</lavel>
									<input class="form-control" name="first_name" type="text" required></input>
								
									<lavel for="last-name">sdsadasd</lavel>
									<input class="form-control" name="last_name" type="text" required></input>
								</div>
								 <div class="form-section">
									<lavel for="email">jjjjjjjjjjj</lavel>
									<input class="form-control" name="email" type="email" required></input>
								
									<lavel class="phone">eeeeee</lavel>
									<input class="form-control" name="phone" type="phone" required></input>
								</div>
								<div class="form-navigation">
									<button type="button" class="previous btn btn-info float-left">Previous</button>
									<button type="button" class="next btn btn-info float-right">Next</button>
									<button type="submit" class=" btn btn-success float-right">Submit</button>
								</div>

							</form>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</section>

	<script>
		$( document ).ready(function() {
		    //alert();
		});


		$(function(){

			var $sections=$(".form-section");

			function navigateTo(index)
			{
				alert(index);
				$sections.removeClass('current').eq(index).addClass('current');
				$('.form-navigation .previous').toggle(index>0);
				var atTheEnd=index>=$sections.length-1;
				$('.form-navigation .next').toggle(!atTheEnd);
				$('.form-navigation [type=submit]').toggle(atTheEnd);
			}

			function curIndex()
			{
				return $sections.index($sections.filter('.current'));
			}


			$('.form-navigation .previous').click(function(){
				navigateTo(curIndex()-1);
			});


			$('.form-navigation .next').click(function(){
				$('.contact-form').parsley().whenValidate({
					group:'block-'+curIndex()
				}).done(function(){
					navigateTo(curIndex()+1);
				});
			});



			$sections.each(function(index,section){

				$(section).find(':input').attr('data-parsley-group','block-'+index)
			})

			navigateTo(0);
		});
	</script
</body>
</html>