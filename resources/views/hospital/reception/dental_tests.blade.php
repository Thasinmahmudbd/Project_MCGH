@extends('hospital/frame/frame')

@section('page_title','MCGH Portal')

@section('page_type','Dental Service Selection')






<!-----------------------link---------------------->

@section('links')

<li class="link_item">
    <a href="{{url('/reception/cancel_test/dental/')}}" class="link">
        <i class="link_icons fas fa-home"></i>
        <span class="link_name"> Go Home </span>
    </a>
</li>

<li class="link_item">
    <a href="{{url('/reception/show_tests/dental/')}}" class="link">
        <i class="link_icons fas fa-th-list"></i>
        <span class="link_name"> All Test </span>
    </a>
</li>

@endsection

<!--------------------link end---------------------->






<!-----------------------mobile link---------------------->

@section('mobile_links')

<div id="myLinks" class="mobile_links">
    <a class="mobile_link" href="{{url('/reception/cancel_test/dental/')}}">Go Home</a>
    <a class="mobile_link" href="{{url('/reception/show_tests/dental/')}}">All Test</a>
</div>

@endsection

<!--------------------mobile link end---------------------->







<!-----------------------content---------------------->

@section('content')

                <div class="patient_and_doctor_info_one_is_to_three">

                    <!--Links to navigate invoice pages-->

                    <span></span>

                    <!--Search bar to search patients-->

                    <form action="{{url('/reception/find_test/dental/by_search/')}}" method="post" class="content_container_white_super_thin center_self">
                    @csrf

                        <div class="patient_form_element_three_is_to_one">

                            <input type="text" class="input" name="test_search_info" placeholder="Enter Test Name" required>

                            <div class="patient_and_doctor_info_one_is_to_one">

                                <button type="submit" class="btn form_btn" name="search_old_patient">Search</button>

                                <a class="btn form_btn text_center" href="{{url('/reception/dental/test/payment/')}}">Next</a>

                            </div>

                        </div>

                    </form>

                </div>







            <!--Session message-->

            @if(session('msg')=='Patient registered, choose tests to proceed.')

            <div class="content_container text_center success_msg">{{session('msg')}}</div> 

            @elseif(session('msg')=='Test selected.')

            <div class="content_container text_center success_msg">{{session('msg')}}</div>

            @elseif(session('msg')=='Test deleted.')

            <div class="content_container text_center warning_msg">{{session('msg')}}</div>

            @elseif(session('msg')=='Already selected.')

            <div class="content_container text_center warning_msg">{{session('msg')}}</div>

            @endif










                <!--Selected tests-->

                <div class="purple_line"></div>
                <div class="gap"></div>

                <!--Showing all of dental tests-->

                <div class="content_container_bg_less_thin">

                    <span></span>
                        
                    <p><b>Selected Tests</b></p>

                    <span></span>

                </div>

                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="50%" class="frame_header_item">Test Name</th>
                        <th width="20%" class="frame_header_item">Rate</th>
                        <th width="20%" class="frame_header_item">Fee</th>
                        <th width="5%" class="frame_header_item">Action</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($logs as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Test Name">{{$list->Test_Name}}</td>
                        <td class="frame_data" data-label="Rate">{{$list->Rate}}</td>

                            <td class="frame_data" data-label="Fee">{{$list->Fee}}</td>

                            <td class="frame_action" data-label="Action">
                                <a href="{{url('/reception/unselect/test/dental/'.$list->AI_ID)}}">
                                    <i class="table_btn_red fas fa-times-circle"></i>
                                </a>
                            </td>

                    </tr>

                    @endforeach

                </table>










            @if(Session::get('dental_test_search')=='1')

                <div class="gap"></div>

                <!--Showing search results of dental tests-->

                <div class="content_container_bg_less_thin">

                    <span></span>
                        
                    <p><b>Search Result</b></p>

                    <span></span>

                </div>

                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="50%" class="frame_header_item">Test Name</th>
                        <th width="20%" class="frame_header_item">Rate</th>
                        <th width="20%" class="frame_header_item">Fee</th>
                        <th width="5%" class="frame_header_item">Action</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($info as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Test Name">{{$list->Test_Name}}</td>
                        <td class="frame_data" data-label="Rate">{{$list->Rate}}</td>

                        <form action="{{url('/reception/select/test/dental/')}}" method="post" class="content_container_white_super_thin center_self">
                        @csrf

                            <td class="frame_data" data-label="Fee">
                                <input class="input" type="text" name="test_fee" required>
                                <input type="hidden" value="{{$list->AI_ID}}" name="test_id">
                                <input type="hidden" value="{{Session::get('dental_test_no')}}" name="test_no">
                            </td>

                            <td class="frame_action" data-label="Action">
                                <button type="submit" class="btn_less">
                                    <i class="fas fa-plus-circle table_btn"></i>
                                </button>
                            </td>

                        </form>

                    </tr>

                    @endforeach

                </table>



                <div class="gap"></div>





            @elseif(Session::get('dental_test_search')=='0')

                <div class="gap"></div>

                <!--Showing search results of dental tests when no result-->

                <div class="content_container_bg_less_thin">

                    <span></span>
                        
                    <p><b>Search Result</b></p>

                    <span></span>

                </div>

                <div class="warning_msg content_container_bg_less_thin">

                    <p class="text_center">No Tests Here.</p>

                </div>





            @elseif(Session::get('dental_test_search')=='3')

                <div class="gap"></div>

                <!--Showing all of dental tests-->

                <div class="content_container_bg_less_thin">

                    <span></span>
                        
                    <p><b>Dental Tests</b></p>

                    <span></span>

                </div>

                <table class="frame_table">

                    <tr class="frame_header">
                        <th width="5%" class="frame_header_item">S/N</th>
                        <th width="50%" class="frame_header_item">Test Name</th>
                        <th width="20%" class="frame_header_item">Rate</th>
                        <th width="20%" class="frame_header_item">Fee</th>
                        <th width="5%" class="frame_header_item">Action</th>
                    </tr>

                    <?php $serial = 1; ?>
                    @foreach($info as $list)

                    <tr class="frame_rows">
                        <td class="frame_data" data-label="S/N"><?php echo $serial; $serial++; ?></td>
                        <td class="frame_data" data-label="Test Name">{{$list->Test_Name}}</td>
                        <td class="frame_data" data-label="Rate">{{$list->Rate}}</td>

                        <form action="{{url('/reception/select/test/dental/')}}" method="post" class="content_container_white_super_thin center_self">
                        @csrf

                            <td class="frame_data" data-label="Fee">
                                <input class="input" type="text" name="test_fee" required>
                                <input type="hidden" value="{{$list->AI_ID}}" name="test_id">
                                <input type="hidden" value="{{Session::get('dental_test_no')}}" name="test_no">
                            </td>

                            <td class="frame_action" data-label="Action">
                                <button type="submit" class="btn_less">
                                    <i class="fas fa-plus-circle table_btn"></i>
                                </button>
                            </td>

                        </form>

                    </tr>

                    @endforeach

                </table>

            @endif









@endsection

<!--------------------content end---------------------->