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
        <tr><td align="center" style="font-size:20px;" colspan="6"><b>Balance Sheet as on {{$as_on_date}}</b></td></tr> 
 
  	</table>





	<table width="660" class="rpt_table rpt_tbl_dtls" rules="all" border="1" cellpadding="0" cellspacing="0">
    	<thead class="table_header">
        	<th width="350" class="text-center">Source of Fund</th>
        	<th width="70" class="text-center">Note</th>
            <th width="120" class="text-center">Amount ({{$period_name}})</th>
            <th width="120" class="text-center">Amount({{$period_name}})</th>
        </thead>
		<tbody>
			<tr>
				<td colspan="4" align="center" ><strong>Capital & Liabilities</strong></td>
			</tr>
			<?php 
				$is_asset_printed=0;
				$total_main_group = count($main_group_arr);
				$mg=0;
				$total_liabilities=0;
				$total_asset=0;
			?>
			@foreach ($main_group_arr as $main_group_index => $main_group_value)

			<?php 
				$mg++;  $k=0;
				if($is_asset_printed==0 && $main_group_value->main_group==4)
				{
					?>
					<tr>
						<td align="center" colspan="4" style="font-size:13px;"><strong>Asset</strong></td>
					</tr>
					 <tr>
						<td align="left" colspan="4"><strong>Application of Fund</strong></td>
					</tr>
					<?php
				}

			?>
				<tr>
					<td align="" colspan="4" style="font-size:13px;"><strong>{{$accounts_main_group[$main_group_value->main_group]}}</strong></td>
				</tr>
				<?php $subgroup_total=0; $num_rows=0; ?>
				@if(!empty($main_group_wise_subgroup_data[$main_group_value->main_group]))
				<?php ksort($main_group_wise_subgroup_data[$main_group_value->main_group]); 
					$num_rows=count($main_group_wise_subgroup_data[$main_group_value->main_group]); ?> 

					@foreach ($main_group_wise_subgroup_data[$main_group_value->main_group] as $sub_group_id => $sub_group_value)
						<tr>
							<td  width="350" style="font-size:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$sub_group_id}}--{{$sub_group_value['sub_group']}}</td>
							<td align="center"  >{{$sub_group_value['sub_group_code']}}</td>
					 		<td align="right">
					 			<?php 
					 				$k++;
					 				echo number_format($sub_group_value['balance'],2);
					 				if($sub_group_id==25)
									{	 
										$subgroup_total= $subgroup_total-$sub_group_value['balance'];
									}
									else
									{
										$subgroup_total= $subgroup_total+$sub_group_value['balance'];
									}

					 			?>	
					 		</td>
	                      	<?php
	                        if ($k!=$num_rows) 
							{ ?>
								<td width="" align="right"></td>
						  	<?php
	                      	}
						  	else
							{
							?>
								  <td width="" align="right"><?php //echo number_format($subgroup_total,2); 
								   if($main_group_value->main_group==1 ||$main_group_value->main_group==2 ||$main_group_value->main_group==3) 
								   		$total_liabilities= $total_liabilities+$subgroup_total;
								   if($main_group_value->main_group==4 || $main_group_value->main_group==5) 
								   		$total_asset= $total_asset+ $subgroup_total;
								   //	echo $total_liabilities."hhh".$main_group_value->main_group;
								  ?>
								  </td>
							<?php
							}
							?>
						</tr>

					@endforeach
				@endif



				<?php 
					if($main_group_value->main_group==3)
					{
						?>
						<tr>
							<td align="center" colspan="2" style="font-size:13px;"><strong>Total Capital & Liabilities</strong></td>
					 		<td></td>
                            <td align="right"><?php echo number_format($total_liabilities,2);?></td>
						</tr>
						<?php
					}
				

					if($mg==$total_main_group)
					{
						?>
						<tr>
							<td align="center" colspan="2" style="font-size:13px;"><strong>Total Assets</strong></td>
					 		<td></td>
                            <td align="right"><?php echo number_format($total_liabilities,2);?></td>
						</tr>
						<?php
					}
				?>




			@endforeach
		</tbody>
		
	</table>


</div>