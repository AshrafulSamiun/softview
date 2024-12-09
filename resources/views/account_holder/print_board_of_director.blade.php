

</!DOCTYPE html>
<html>
<head>
	<title></title>
	
</head>
<body>
	<div style="width:1100px; margin-left: 100px;" align="center">

			<?php 


			//echo count($col);die;
			?>
			<table width="1100" align="center">
				<tr><td align="center" style="font-size:28px;" colspan="6"><img class="media-object img-circle" src="{{asset('images/hollywood-polygonal_1057-3206.jpg')}}" width="60" height="60"></td></tr>
		        <tr><td align="center" style="font-size:30px;" colspan="6"><b>{{$company_name}}</b></td></tr>
		        
		        <tr><td align="center" style="font-size:30px;" colspan="6"><u><strong>Board of Director Details</strong></u></td></tr> 
		        <tr>
		        	<td align="center" style="font-size:18px;" colspan="6">Printing Date: {{date("D  M d, Y")}}
		        	</td>
		    	</tr> 
		    	<tr>
		        	<td align="center" style="font-size:18px;" colspan="6">&nbsp;
		        	</td>
		    	</tr>


		        <tr style="font-size:20px;">
		        	<td align="left" width="200"> ID No</td>
		        	<td align="left" width="300">: {{$account_holder['system_no']}} </td>
		        	<td align="left" width="200">Chart of Account</td>
		        	<td align="left" width="200">: {{$account_holder['chart_of_acocounts']}}</td>

		        </tr> 

		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">Name</td>
		        	<td align="left" width="300">: {{$account_holder['board_of_director_name']}}</td>
		        	<td align="left">Title</td>
		        	<td align="left">: {{$account_holder['title']}}</td>
		        	
		        </tr>

		        

		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">Position</td>
		        	<td align="left" width="300">: {{$account_holder['board_of_director_position']}}</td>
		        	<td align="left">Account Status</td>

	        	 	@if($account_holder['account_holder_portal']==1) 
	        	 		<td align="left">:	Yes</td>
	        	 	@else  		        	 		
	        	 		<td align="left">:	No</td>
		        	@endif

		        </tr>

		        <tr  style="font-size:20px;">
		        	<td align="left">Has a Portal</td>
		        	@if($account_holder['account_holder_portal']==1) 
	        	 		<td align="left">:	Yes</td>
	        	 	@else  		        	 		
	        	 		<td align="left">:	No</td>
		        	@endif

		        	<td align="left">Has a Dedicated </td>
	        	 	@if($account_holder['account_holder_dedicated_file']==1) 
	        	 		<td align="left">:	Yes</td>
	        	 	@else  		        	 		
	        	 		<td align="left">:	No</td>
		        	@endif

		        </tr>
		        
		        <tr  style="font-size:20px; margint-top:50">
		        	<td align="left" colspan="2"><h2>Address </h2></td>
		        	<td align="left" colspan="2"><h2>Contact</h2></td>
		        </tr>
		        
		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">House Number</td>
		        	<td align="left" width="300">: {{$account_holder['house_number']}}</td>
		        	<td align="left">Office Phone</td>
		        	<td align="left">: {{$account_holder['office_phone']}}</td>
		        </tr>

		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">Streed Number</td>
		        	<td align="left" width="300">: {{$account_holder['street_number']}}</td>
		        	<td align="left">Moble No</td>
		        	<td align="left">: {{$account_holder['cell_phone']}}</td>
		        </tr>

		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">City</td>
		        	<td align="left" width="300">: {{$account_holder['city']}}</td>
		        	<td align="left">Email</td>
		        	<td align="left">: {{$account_holder['email']}}</td>
		        </tr>

		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">State</td>
		        	<td align="left" width="300">: {{$account_holder['state']}}</td>
		        	<td align="left">Fax</td>
		        	<td align="left">: {{$account_holder['fax']}}</td>
		        </tr>
		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">Website</td>
		        	<td align="left" width="300">: {{$account_holder['country']}}</td>
		        	<td align="left">Website</td>
		        	<td align="left">: {{$account_holder['website']}}</td>
		        </tr>
		        <tr  style="font-size:20px;">
		        	<td align="left" width="200">Zip Code/ Postal Code</td>
		        	<td align="left" width="300">: {{$account_holder['zip_code']}}</td>
		        	<td align="left">Posting Status</td>

		        	<?php 

	        			$data['account_holder']['posting_status_string']=0;

	        			if($account_holder['posting_status']==0)
			            {
			                if ($account_holder['status_active']==1)
			                    $data['account_holder']['posting_status_string']="Saved";
			                else if ($account_holder['status_active']==3)
			                    $data['account_holder']['posting_status_string']="Rejected";
			            }
			            if($account_holder['posting_status']==1)
			            {
			                if ($account_holder['status_active']==1)
			                    $data['account_holder']['posting_status_string']="Transmited Out";
			                else if ($account_holder['status_active']==2)
			                    $data['account_holder']['posting_status_string']="Voided";
			            }
			            else if ($account_holder['posting_status']==2)
			            {
			               $data['account_holder']['posting_status_string']="Posted";
			            }
			            else if ($account_holder['posting_status']==3)
			            {
			                $data['account_holder']['posting_status_string']="Adjusted";
			            }
			            else if ($account_holder['posting_status']==4)
			            {
			                $data['account_holder']['posting_status_string']="Reposted";
			            }

		        	?>
		        	
		        	
		            <td align="left">:													{{$data['account_holder']['posting_status_string']}}
		            </td>
		        	
		        </tr>
		        
		  	</table>

		</div>
</body>
</html>