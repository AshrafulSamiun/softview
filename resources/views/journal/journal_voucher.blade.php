<div style="width:900px;" align="center">

	<?php 
	$col=0;
	$journal_check_arr=array();
	foreach ($details_data as $key => $value) {
		if($value->customer_id!=NULL) 		{$journal_check_arr['customer_id']		=$value->customer_id; $col++; }
		if($value->supplier_id!=NULL) 		{$journal_check_arr['supplier_id']		=$value->supplier_id; $col++; }
		if($value->customer_invoice!=NULL) 	{$journal_check_arr['customer_invoice']	=$value->customer_invoice; $col++; }
		if($value->supplier_invoice!=NULL) 	{$journal_check_arr['supplier_invoice']	=$value->supplier_invoice; $col++; }
		if($value->profit_center_id!=0) 	{$journal_check_arr['profit_center_id'] =$value->profit_center_id; $col++; }
		if($value->division_id !=NULL)   	{$journal_check_arr['division_id'] 	 	=$value->division_id ; $col++; }

		if($value->department_id!=NULL) 	{$journal_check_arr['department_id']	=$value->department_id; $col++; }
		if($value->section_id!=NULL) 		{$journal_check_arr['section_id']		=$value->section_id; $col++; }
		if($value->location_id!=NULL) 		{$journal_check_arr['location_id']		=$value->location_id; $col++; }
		if($value->bank_id!=NULL) 			{$journal_check_arr['bank_id']			=$value->bank_id; $col++; }
		if($value->import_ref!=NULL) 		{$journal_check_arr['import_ref']		=$value->import_ref; $col++; }
		if($value->bank_ref!=NULL)   		{$journal_check_arr['bank_ref'] 		=$value->bank_ref ; $col++; }

		if($value->employee_name!=NULL) 	{$journal_check_arr['employee_name']	=$value->employee_name; $col++; }
		if($value->loan_ref!=NULL) 			{$journal_check_arr['loan_ref']			=$value->loan_ref; $col++; }
		//if($value->location_id!=NULL) 		$journal_check_arr['location_id']	=$value->location_id;
		//if($value->bank_id!=NULL) 			$journal_check_arr['bank_id']		=$value->bank_id;
		//if($value->import_ref!=NULL) 		$journal_check_arr['import_ref']		=$value->import_ref;
		//
	//	if($value->bank_ref!=NULL)   		$journal_check_arr['bank_ref '] 		=$value->bank_ref ;

	}
	$total_debit=0;
	$total_credit=0;
	$table_width=$col*100+500;

	?>
	<table width="100%" align="center">
        <tr><td align="center" style="font-size:28px;" colspan="6"><b>{{$master_data->company->company_name}}</b></td></tr>
        <tr><td align="center" style="font-size:14px;" colspan="6">{{$master_data->company->company_address}}</td></tr>  
        <tr><td align="center" style="font-size:20px;" colspan="6"><b>{{$master_data->journal_type_string}}</b></td></tr> 
  	</table>


  	<table width="500" align="center">
        <tr> 
        	<td width="100">Transaction Date:</td>
        	<td width="100" align="left">{{$master_data->journal_date}}</td>
        	<td width="100">Journal ID: </td>
        	<td width="100" align="left">{{$master_data->journal_id}}</td>
        </tr>  
    </table>


	<table width="{{$table_width}}" cellpadding="0" cellspacing="0" border="1" align="center">
		<thead>
			<tr>
				<th width="40">SL</th>
				<th width="80">AC Code</th>
				<th>AC Description</th>
				@if(!empty($journal_check_arr['customer_id']))
					<th>Customer</th>
				@endif
				@if(!empty($journal_check_arr['customer_invoice']))
					<th>Customer Invoice</th>
				@endif
				@if(!empty($journal_check_arr['supplier_id']))
					<th>Supplier</th>
				@endif
				@if(!empty($journal_check_arr['supplier_invoice']))
					<th>Supplier Invoice</th>
				@endif
				@if(!empty($journal_check_arr['profit_center_id']))
					<th>Department</th>
				@endif
				@if(!empty($journal_check_arr['division_id']))
					<th>Division</th>
				@endif
				@if(!empty($journal_check_arr['department_id']))
					<th>Department</th>
				@endif
				@if(!empty($journal_check_arr['section_id']))
					<th>Section</th>
				@endif
				@if(!empty($journal_check_arr['location_id']))
					<th>Location</th>
				@endif
				@if(!empty($journal_check_arr['bank_id']))
					<th>Bank</th>
				@endif
				@if(!empty($journal_check_arr['import_ref']))
					<th>Import Ref.</th>
				@endif
				@if(!empty($journal_check_arr['bank_ref']))
					<th>Bank Ref.</th>
				@endif
				@if(!empty($journal_check_arr['employee_name']))
					<th>Employee</th>
				@endif
				@if(!empty($journal_check_arr['loan_ref']))
					<th>Loan Ref.</th>
				@endif

				
				<th width="100"> Debit</th>
				<th width="100">Credit</th>
				
			</tr>

		</thead>
		<tbody>
			@foreach ($details_data as $detls_id => $dtls_value)
			<tr>
				<td>{{$detls_id+1}}</td>
				<td>{{$dtls_value->account_code}}</td>
				<td>{{$dtls_value->ac_description}}</td>

				@if(!empty($journal_check_arr['customer_id']))
					<td>{{$dtls_value->customer['short_name']}}</td>
				@endif
				@if(!empty($journal_check_arr['customer_invoice']))
					<td>{{$dtls_value->customer_invoice}}</td>
				@endif
				@if(!empty($journal_check_arr['supplier_id']))
					<td>{{$dtls_value->supplier['short_name']}}</td>
				@endif
				@if(!empty($journal_check_arr['supplier_invoice']))
					<td>{{$dtls_value->supplier_invoice}}</td>
				@endif
				@if(!empty($journal_check_arr['profit_center_id']))
					<td>{{$dtls_value->profit_center_id}}</td>
				@endif
				@if(!empty($journal_check_arr['division_id']))
					<td>{{$dtls_value->division['divisionName']}}</td>
				@endif
				@if(!empty($journal_check_arr['department_id']))
					<td>{{$dtls_value->department[']departmentName']}}</td>
				@endif
				@if(!empty($journal_check_arr['section_id']))
					<td>{{$dtls_value->section['sectionName']}}</td>
				@endif
				@if(!empty($journal_check_arr['location_id']))
					<td>{{$dtls_value->location['locationName']}}</td>
				@endif
				@if(!empty($journal_check_arr['bank_id']))
					<td>{{$dtls_value->bank['bank_name']}}</td>
				@endif
				@if(!empty($journal_check_arr['import_ref']))
					<td>{{$dtls_value->import_ref}}</td>
				@endif
				@if(!empty($journal_check_arr['bank_ref']))
					<td>{{$dtls_value->bank_ref}}</td>
				@endif
				@if(!empty($journal_check_arr['employee_name']))
					<td>{{$dtls_value->employee_name}}</td>
				@endif
				@if(!empty($journal_check_arr['loan_ref']))
					<td>{{$dtls_value->loan_ref}}</td>
				@endif

				<td align="right">{{$dtls_value->debit_amount }}</td>
				<td align="right">{{$dtls_value->credit_amount}}</td>
			</tr>
			<?php 
				if($dtls_value->debit_amount) $total_debit+=$dtls_value->debit_amount;
				if($dtls_value->credit_amount) $total_credit+=$dtls_value->credit_amount;
			?>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="{{$col+3}}" align="right">Total</th>
				<th align="right">{{$total_debit}}</th>
				<th align="right">{{$total_credit}}</th>
			</tr>
		</tfoot>
	</table>
	<br/>
	<table width="{{$table_width}}" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
			<td>Naration:</td>
			<td colspan="{{$col+5}}" align="left">{{$master_data->mst_narration}}</td>
		</tr>
	</table>

</div>