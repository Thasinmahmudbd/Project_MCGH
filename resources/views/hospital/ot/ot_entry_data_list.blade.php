@extends('hospital/frame/frame')

@section('page_title','MCGH Portal')

@section('page_type','OT (List)')






<!-----------------------link---------------------->

@section('links')

<li class="list_item">
    <a href="{{url('/ot/new/entry/all/data')}}" class="link">
        <i class="link_icons fas fa-th-list"></i>
        <span class="link_name"> Refresh List </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/ot/doctor_selection')}}" class="link">
        <i class="link_icons fas fa-user-plus"></i>
        <span class="link_name"> Pick Surgeon </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/ot/show/anesthesiologist/list')}}" class="link">
        <i class="link_icons fas fa-user-plus"></i>
        <span class="link_name"> Pick Anesthesiologist </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/ot/show/nurse/list')}}" class="link">
        <i class="link_icons fas fa-user-plus"></i>
        <span class="link_name"> Pick Nurse </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/ot/assistant/data/collection')}}" class="link">
        <i class="link_icons fas fa-user-plus"></i>
        <span class="link_name"> Pick Assistant </span>
    </a>
</li>

<li class="link_item">
    <a href="{{url('/ot/new/entry/cancel')}}" class="link">
        <i class="link_icons far fa-window-close"></i>
        <span class="link_name"> Cancel Entry </span>
    </a>
</li>

@endsection

<!--------------------link end---------------------->






<!-----------------------mobile link---------------------->

@section('mobile_links')

<div id="myLinks" class="mobile_links">
    <a class="mobile_link" href="{{url('/ot/new/entry/all/data')}}">Refresh List</a>
    <a class="mobile_link" href="{{url('/ot/doctor_selection')}}">Pick Surgeon</a>
    <a class="mobile_link" href="{{url('/ot/show/anesthesiologist/list')}}">Pick Anesthesiologist</a>
    <a class="mobile_link" href="{{url('/ot/show/nurse/list')}}">Pick Nurse</a>
    <a class="mobile_link" href="{{url('/ot/assistant/data/collection')}}">Pick Assistant</a>
    <a class="mobile_link" href="{{url('/ot/new/entry/cancel')}}">Cancel Entry</a>
</div>

@endsection

<!--------------------mobile link end---------------------->







<!-----------------------content---------------------->

@section('content')






            <!--Patient info tab-->

            <div class="patient_and_doctor_info_one_is_to_one">

                <div>

                    <div class="content_container_bg_less">

                        <p class="section_title">Patient Info</p>

                        <div class="info">

                            <p class="collected_info">Patient's ID</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('OT_NEW_ENTRY_P_ID')}}</p>

                            <p class="collected_info">Operation Type</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('o_type')}}</p>

                            <p class="collected_info">Operation Date</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('o_date')}}</p>

                            <p class="collected_info">Operation Time</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('o_time')}}</p>

                            <p class="collected_info">Operation Duration</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('o_duration')}}</p>

                            <p class="collected_info">Anesthesia Type</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('a_type')}}</p>

                        </div>

                    </div>

                </div>




                <div>

                    <!--consultant info-->

                    <div class="content_container_bg_less">

                        <p class="section_title">OT Charges</p>

                        <div class="info">

                            <p class="collected_info">OT Charge</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('ot_charge')}}</p>

                            <p class="collected_info">OT Discount</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('ot_charge_discount')}}</p>

                        </div>

                        <div class="gap"></div>

                        <p class="section_title">Other Charges</p>

                        <div class="info">

                            <p class="collected_info">Other</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('ot_other')}}</p>

                            <p class="collected_info">Other Charges</p>
                            <p>:</p>
                            <p class="collected_info">{{Session::get('ot_other_charge')}}</p>

                        </div>

                    </div>

                </div>

            </div>








            <div class="purple_line"></div>
            <div class="gap"></div>






                <!--surgeon info-->

                    <div class="patient_form_element_one_is_to_100px">

                        <div class="content_container_bg_less">
        
                            <p><b>Surgeons:</b></p>

                        </div>

                        <div class="content_nav">
        
                            <a href="{{url('/ot/doctor_selection')}}" class="content_nav_link purple">Add</a>

                        </div>

                    </div>


                <!--Session message-->

                @if(session('msg')=='Delete all Surgeon entry and try again.')

                    <div class="content_container text_center warning_msg">{{session('msg')}}</div> 

                @elseif(session('msg')=='Input at least 1 surgeon.')

                    <div class="content_container text_center warning_msg">{{session('msg')}}</div> 

                @endif



                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="57%" class="frame_header_item">Name</th>
                        <th width="15%" class="frame_header_item">Fees</th>
                        <th width="15%" class="frame_header_item">Discount</th>
                        <th width="8%" class="frame_header_item">Remove</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($chosen_surgeons as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Name">{{$list->Surgeon_Name}}</td>
                        <td class="frame_data" data-label="Fees">{{$list->Surgeon_Fee}}</td>
                        <td class="frame_data" data-label="Discount">{{$list->Surgeon_Discount}}</td>

                        <td class="frame_action" data-label="Action">
                            <a target="blank" href="{{url('/remove/surgeon/'.$list->AI_ID)}}">
                                <i class="table_btn_red fas fa-times-circle"></i>
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </table>
                <div class="gap"></div>








                <!--anesthesiologists: info-->

                    <div class="patient_form_element_one_is_to_100px">

                        <div class="content_container_bg_less">
        
                            <p><b>Anesthesiologists:</b></p>

                        </div>

                        <div class="content_nav">
        
                            <a href="{{url('/ot/show/anesthesiologist/list')}}" class="content_nav_link purple">Add</a>

                        </div>

                    </div>


                <!--Session message-->

                @if(session('msg')=='Delete all Anesthesiologist entry and try again.')

                    <div class="content_container text_center warning_msg">{{session('msg')}}</div> 

                @endif


                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="57%" class="frame_header_item">Name</th>
                        <th width="15%" class="frame_header_item">Fees</th>
                        <th width="15%" class="frame_header_item">Discount</th>
                        <th width="8%" class="frame_header_item">Remove</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($chosen_anesthesiologist as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Name">{{$list->Anesthesiologist_Name}}</td>
                        <td class="frame_data" data-label="Fees">{{$list->Anesthesiologist_Fee}}</td>
                        <td class="frame_data" data-label="Discount">{{$list->Anesthesiologist_Discount}}</td>

                        <td class="frame_action" data-label="Action">
                            <a target="blank" href="{{url('/remove/anesthesiologist/'.$list->AI_ID)}}">
                                <i class="table_btn_red fas fa-times-circle"></i>
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </table>
                <div class="gap"></div>







                <!--nurses info-->

                    <div class="patient_form_element_one_is_to_100px">

                        <div class="content_container_bg_less">
        
                            <p><b>Nurses:</b></p>

                        </div>

                        <div class="content_nav">
        
                            <a href="{{url('/ot/show/nurse/list')}}" class="content_nav_link purple">Add</a>

                        </div>

                    </div>



                <!--Session message-->

                @if(session('msg')=='Delete all Nurse entry and try again.')

                    <div class="content_container text_center warning_msg">{{session('msg')}}</div> 

                @endif



                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="72%" class="frame_header_item">Name</th>
                        <th width="15%" class="frame_header_item">Fees</th>
                        <th width="8%" class="frame_header_item">Remove</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($chosen_nurses as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Name">{{$list->Nurse_Name}}</td>
                        <td class="frame_data" data-label="Fees">{{$list->Nurse_Fee}}</td>

                        <td class="frame_action" data-label="Action">
                            <a target="blank" href="{{url('/remove/nurse/'.$list->AI_ID)}}">
                                <i class="table_btn_red fas fa-times-circle"></i>
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </table>
                <div class="gap"></div>







                <!--assistants: info-->

                    <div class="patient_form_element_one_is_to_100px">

                        <div class="content_container_bg_less">
        
                            <p><b>Assistants:</b></p>

                        </div>

                        <div class="content_nav">
        
                            <a href="{{url('/ot/assistant/data/collection')}}" class="content_nav_link purple">Add</a>

                        </div>

                    </div>



                <!--Session message-->

                @if(session('msg')=='Delete all Assistant entry and try again.')

                    <div class="content_container text_center warning_msg">{{session('msg')}}</div> 

                @endif




                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="72%" class="frame_header_item">Name</th>
                        <th width="15%" class="frame_header_item">Fees</th>
                        <th width="8%" class="frame_header_item">Remove</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($chosen_assistant as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Name">{{$list->Assistant_Name}}</td>
                        <td class="frame_data" data-label="Fees">{{$list->Assistant_Fee}}</td>

                        <td class="frame_action" data-label="Action">
                            <a target="blank" href="{{url('/remove/assistant/'.$list->AI_ID)}}">
                                <i class="table_btn_red fas fa-times-circle"></i>
                            </a>
                        </td>

                    </tr>

                    @endforeach

                </table>
                <div class="gap"></div>


                <form action="{{url('/ot/entry/list/submit')}}" class="patient_info_form" method="post">
                @csrf

                    <div class="patient_form_element">

                        <input type="submit" class="btn content_nav_link table_item_green"  value="Confirm all entry -- [CAUTION: This is final and can't be undone.]" name="Next">

                    </div>

                </form>



@endsection

<!--------------------content end---------------------->




