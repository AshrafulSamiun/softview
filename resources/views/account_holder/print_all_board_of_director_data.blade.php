<?php  ob_start();  ?>

</!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/main.css" rel="stylesheet">
</head>

<style type="text/css">
	

	.table tr th , .table tr td{
		font-size: 16px !important;
	}
</style>
<body>
	<div style="width:2500px;" align="center">

			<?php 


			//echo count($col);die;
			?>
			<table width="1300" align="center">
				<tr><td align="center" style="font-size:28px;" colspan="8"><img class="media-object img-circle" src="{{asset('images/bmtf_logo.png')}}" width="38" height="38"></td></tr>
		        <tr><td align="center" style="font-size:30px;" colspan="8"><b>{{$company_name}}</b></td></tr>
		        <tr><td align="center" style="font-size:30px;" colspan="8"><b>Board of Director Details</b></td></tr>
		        
		    </table>
		    <table width="3700" align="center" class="table">
		    	<thead>
		    		<tr>
		    			<th>SL</th>
		    			<th>System No </th>
		    			<th>Name</th>
		    			<th>Position</th>
		    			<th>Title</th>
		    			<th>Education</th>
		    			<th>Has Dedicated File</th>
		    			<th>Has a Portal</th>
		    			<th>Photo</th>
		    			<th>Chart of Accounts</th>
		    			<th>House Number </th>
		    			<th>Street Number</th>
		    			<th>City</th>
		    			<th>State</th>
		    			<th>Country</th>
		    			<th>Zip- Code</th>
		    			<th>Office Phone </th>
		    			<th>Mobile No </th>
		    			<th>Email </th>
		    			<th>Fax </th>
		    			<th>Website</th>
		    		</tr>
		    	</thead>
		    	
		       <tbody>
		       	@if(!empty($account_holder_list))
			      	@foreach ($account_holder_list as $key => $value) 
			      		<tr>
			    			<td>{{$key+1}}</td>
			    			<td>{{$value['system_no']}} </td>
			    			<td>{{$value['board_of_director_name']}} </td>
			    			<td>{{$value['board_of_director_position']}}</td>
			    			<td>{{$value['title']}}</td>
			    			<td>{{$value['education']}} </td>
			    			<td>{{$value['account_holder_dedicated_file']}}</td>
			    			<td>{{$value['account_holder_portal']}}</td>
			    			<td><img class="media-object img-circle" src="{{asset($value['photo_path'])}}" width="38" height="38"></td>
			    			<td>{{$value['chart_of_acocounts']}}</td>
			    			<td>{{$value['house_number']}}</td>
			    			<td>{{$value['street_number']}}</td>
			    			<td>{{$value['city']}}</td>
			    			<td>{{$value['state']}}</td>
			    			<td>{{$value['zip_code']}} </td>
			    			<td>{{$value['zip_code']}} </td>
			    			<td>{{$value['office_phone']}}</td>
			    			<td>{{$value['cell_phone']}}</td>
			    			<td>{{$value['email']}}</td>
			    			<td>{{$value['fax_no']}}</td>
			    			<td>{{$value['website']}}</td>			    			
			    		</tr>
			      	@endforeach
			     @endif
			    </tbody>

		  	</table>

		</div>
</body>
</html>

