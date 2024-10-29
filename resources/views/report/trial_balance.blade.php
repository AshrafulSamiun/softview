<div style="width:900px;" align="center">

	<?php 
	$col=0;
	
	$total_debit=0;
	$total_credit=0;
	$table_width=$col*100+500;

	?>
	<table width="100%" align="center">
        <tr><td align="center" style="font-size:28px;" colspan="6"><b>{{$company_data->company_name}}</b></td></tr>
        <tr><td align="center" style="font-size:14px;" colspan="6">{{$company_data->company_address}}</td></tr>  
        <tr><td align="center" style="font-size:20px;" colspan="6"><b>Trial Balance</b></td></tr> 
        <tr><td align="center" style="font-size:20px;" colspan="6"><b>As on {{$as_on_date}}</b></td></tr> 
  	</table>





	<table width="700" class="rpt_table rpt_tbl_dtls" rules="all" border="1" cellpadding="0" cellspacing="0">
    	<thead class="table_header">
        	<th width="50" class="text-center">Sl.</th>
        	<th width="100" class="text-center">A/C Code</th>
            <th width="233" class="text-center">A/C Description</th>
            <th width="150" class="text-center">Debit</th>
            <th width="167" class="text-center">Credit</th>
        </thead>
		<tbody>
			@foreach ($trial_bal_sql as $detls_id => $dtls_value)
			<tr>
				<td>{{$detls_id+1}}</td>
				<td>{{$dtls_value->account_code}}</td>
				<td>{{$dtls_value->ac_description}}</td>

				@if(($dtls_value->balance)>0)
					<td align="right">{{$dtls_value->balance}}</td>
				@else
					<td align="right">0</td>
				@endif

				@if(($dtls_value->balance)<0)
					<td align="right">{{($dtls_value->balance*(-1))}}</td>
				@else
					<td align="right">0</td>
				@endif

			

			</tr>
			<?php 
				if(($dtls_value->balance)>0) $total_debit+=$dtls_value->balance;
				else  $total_credit+=($dtls_value->balance*(-1));
			?>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="{{$col+3}}" class="text-right">Total</th>
				<th class="text-right">{{$total_debit}}</th>
				<th class="text-right">{{$total_credit}}</th>
			</tr>
		</tfoot>
	</table>


</div>