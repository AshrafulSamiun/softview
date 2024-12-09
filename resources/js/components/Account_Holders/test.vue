@else if($account_holder['posting_status']==0)
		            	@if($account_holder['status_active']==1)
		            		<td align="left">:	Saved</td>
		            	@else if($account_holder['status_active']==2)
		            		<td align="left">:	Rejected</td>
		            	@endif
		            @else if($account_holder['posting_status']==1)
		            	@if($account_holder['status_active']==1)
		            		<td align="left">:	Transmited Out</td>
		            	@else if($account_holder['status_active']==2)
		            		<td align="left">:	Voied</td>
		            	@endif