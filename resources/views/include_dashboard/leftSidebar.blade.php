<div class="left-menu">
    <div class="menubar-content">
        <nav class="animated bounceInDown">
            <ul id="sidebar">
               
                
                @foreach ($menu as $mid => $m_value)
                    @if($m_value->rootMenu==0 && $m_value->position==1)
                        <li class="sub-menu">
                            <a href="#"> <i class="fas fa-building"></i> {{$m_value->menuName}}
                                @if(!empty($lavel_one_arr[$m_value->id]))
                                    <div class="fa fa-caret-down right"></div>
                                @endif
                            </a>

                             @if(!empty($lavel_one_arr[$m_value->id]))
                                <ul class="left-menu-dp">

                                    @foreach($lavel_one_arr[$m_value->id] as $l1_id=>$la_value)
                                         <li class="sub-menu">
                                        <a href="#"> <i class="fas fa-cogs"></i> {{$la_value['menuName']}}
                                            @if(!empty($lavel_two_arr[$l1_id]))
                                                <div class="fa fa-caret-down right"></div>
                                            @endif
                                        </a>

                                        @if(!empty($lavel_two_arr[$l1_id]))
                                            <ul class="left-menu-dp">
                                                @foreach($lavel_two_arr[$l1_id] as $l2_id=>$lb_value)

                                                    <li><a href=""><i class="fas fa-id-card"></i>{{$lb_value['menuName']}}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li> 

                                    @endforeach
                                    
                                     
                                    
                                </ul>
                            @endif
                        </li>  
                    @endif
                @endforeach





            </ul>
        </nav>
    </div>
</div>