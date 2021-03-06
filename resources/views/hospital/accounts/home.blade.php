@extends('hospital/frame/frame')

@section('page_title','MCGH Portal')

@section('page_type','My Profile')








<!--------------------charts----------------------->

@section('charts')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Accounts', 'Taka'],
            ['Total Commission',     {{Session::get('COMMISSION')}}],
            ['Total Vat',      {{Session::get('VAT')}}],
            ['Doctor Salary',  {{Session::get('REST')}}]
            
        ]);

        var options = {
            title: '',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
        }
    </script>


@endsection

<!-------------------charts end-------------------->











<!-----------------------link---------------------->

@section('links')

<li class="link_item">
    <a href="{{url('/accounts/home/')}}" class="link">
        <i class="link_icons fas fa-user-md"></i>
        <span class="link_name"> My Profile </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/doctor/income/')}}" class="link">
        <i class="link_icons fas fa-hand-holding-usd"></i>
        <span class="link_name"> Doctor's Income </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/cash/in/'.Session::get('DATE_TODAY'))}}" class="link">
        <i class="link_icons fas fa-cash-register"></i>
        <span class="link_name"> Cash In </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/pay/salary/'.Session::get('pay_salary_person'))}}" class="link">
        <i class="link_icons fas fa-credit-card"></i>
        <span class="link_name"> Pay Salary </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/creditors/')}}" class="link">
        <i class="link_icons fas fa-search-dollar"></i>
        <span class="link_name"> Creditors </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/patient/release/')}}" class="link">
        <i class="link_icons fas fa-hospital-user"></i>
        <span class="link_name"> Patient Release </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/release/slips/')}}" class="link">
        <i class="link_icons fas fa-file-invoice"></i>
        <span class="link_name"> Release Slips </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/ambulance/')}}" class="link">
        <i class="link_icons fas fa-ambulance"></i>
        <span class="link_name"> Ambulance </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/other/transactions/')}}" class="link">
        <i class="link_icons fas fa-random"></i>
        <span class="link_name"> Other Transactions </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/log/')}}" class="link">
        <i class="link_icons fas fa-clipboard-list"></i>
        <span class="link_name"> Logs </span>
    </a>
</li>

<li class="list_item">
    <a href="{{url('/accounts/edit_profile/')}}" class="link">
        <i class="link_icons fas fa-user-edit"></i>
        <span class="link_name"> Edit Profile </span>
    </a>
</li>

@endsection

<!--------------------link end---------------------->






<!-----------------------mobile link---------------------->

@section('mobile_links')

<div id="myLinks" class="mobile_links">
    <a class="mobile_link" href="{{url('/accounts/home/')}}">My Profile</a>
    <a class="mobile_link" href="{{url('/accounts/doctor/income/')}}">Doctors Income</a>
    <a class="mobile_link" href="{{url('/accounts/cash/in/'.Session::get('DATE_TODAY'))}}">Cash In</a>
    <a class="mobile_link" href="{{url('/accounts/pay/salary/'.Session::get('pay_salary_person'))}}">Pay Salary</a>
    <a class="mobile_link" href="{{url('/accounts/creditors/')}}">Creditors</a>
    <a class="mobile_link" href="{{url('/accounts/patient/release/')}}">Patient Release</a>
    <a class="mobile_link" href="{{url('/accounts/release/slips/')}}">Release Slips</a>
    <a class="mobile_link" href="{{url('/accounts/ambulance/')}}">Ambulance</a>
    <a class="mobile_link" href="{{url('/accounts/other/transactions/')}}">Other Transactions</a>
    <a class="mobile_link" href="{{url('/accounts/log/')}}">Logs</a>
    <a class="mobile_link" href="{{url('/accounts/edit_profile/')}}">Edit Profile</a>
</div>

@endsection

<!--------------------mobile link end---------------------->







<!-----------------------content---------------------->

@section('content')

                    <div class="rounded_photo_width_is_to_rest">

                        <div class="content_container center_element">

                        @if(Session::get('ACCOUNTANTS_IMAGE'))

                            <img class="round_image" src="{{asset('storage/account_profile_pictures/'.Session::get('ACCOUNTANTS_IMAGE'))}}" alt="" width="100%">

                        @elseif(Session::get('ACCOUNTANTS_GENDER')=='male' || Session::get('ACCOUNTANTS_GENDER')=='Male')

                            <img class="round_image" src="{{url('/UI_Assets/Media/Images/Template_Images/system/default-placeholder-account-half-length-portrait-vector-male.png')}}" alt="" width="100%">

                        @elseif(Session::get('ACCOUNTANTS_GENDER')=='female' || Session::get('ACCOUNTANTS_GENDER')=='Female')

                            <img class="round_image" src="{{url('/UI_Assets/Media/Images/Template_Images/system/default-placeholder-employee-half-length-portrait-vector-female.png')}}" alt="" width="100%">

                        @else

                            <img class="round_image" src="{{url('/UI_Assets/Media/Images/Template_Images/system/Profile_avatar_placeholder_large.png')}}" alt="" width="100%">

                        @endif

                        </div>




                        <div class="span_hidden_bar">

                            <div class="info content_container_bg_less">

                                <p class="collected_info">Name</p>
                                <p class="collected_info">:</p>
                                <p class="collected_info">{{Session::get('ACCOUNTANTS_NAME')}}</p>

                                <p class="collected_info">Email</p>
                                <p class="collected_info">:</p>
                                <p class="collected_info">{{Session::get('ACCOUNTANTS_EMAIL')}}</p>

                                <p class="collected_info">Phone</p>
                                <p class="collected_info">:</p>
                                <p class="collected_info">{{Session::get('ACCOUNTANTS_PHONE')}}</p>

                            </div>

                            <a class="purple_icon" href="{{url('/accounts/edit_profile')}}">
                                <i class="fas fa-user-edit log_out_btn purple_icon"></i>
                            </a>

                        </div>

                    </div>




                <!--Session message-->

                @if(session('msg')=='Profile updated successfully.')

                    <div class="content_container_bg_less_thin text_center success_msg">{{session('msg')}}</div> 

                @endif



                <div class="purple_line"></div>
                <div class="gap"></div>






                <!--donut chart-->

                <div class="patient_and_doctor_info_one_is_to_one">

                    <!--<div id="donutchart" style="width: 500px; height: 300px;" class="content_container_bg_less"></div>-->

                    <div>

                        <div class="content_container_thin title_bar_purple">Accounts Setup</div>

                        <div class="options">

                            <form action="{{url('/update/commission/')}}" method="post" class="option_container">
                            @csrf

                                <div class="content_container">

                                    <input class="option_input" type="tel" name="commission" value="{{Session::get('COMMISSION')}}" placeholder="%" required>

                                </div>

                                <div class="option_label_btn_bar">

                                    <label for="patient_cap" class="content_container_thin text_center center_element">Commission</label>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/vat/')}}" method="post" class="option_container">
                            @csrf

                                <div class="content_container">

                                    <input class="option_input" type="tel" name="vat" value="{{Session::get('VAT')}}" placeholder="%" required>

                                </div>

                                <div class="option_label_btn_bar">

                                    <label for="patient_cap" class="content_container_thin text_center center_element">Tax</label>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                        </div>

                    </div>

                    

                    <div>

                        <div class="content_container_thin title_bar_purple">Variable Setup</div>

                        <div class="">

                            <form action="{{url('/update/variable/'.'Invigilator_Fee')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Invigilator Fee</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Invigilator_Fee')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Emergency_Fee')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Emergency Fee</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Emergency_Fee')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'ER_Hospital_Percentage')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">ER Hospital Percentage</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('ER_Hospital_Percentage')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Dental_Hospital_Percentage')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Dental Hospital Percentage</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Dental_Hospital_Percentage')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Pathology_Hospital_Percentage')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Pathology Hospital Percentage</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Pathology_Hospital_Percentage')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Physio_Hospital_Percentage')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Physio Hospital Percentage</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Physio_Hospital_Percentage')}}" placeholder="%" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Ligation')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Ligation</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Ligation')}}" placeholder="0" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                            <form action="{{url('/update/variable/'.'Third_Seizure')}}" method="post" class="option_container">
                            @csrf

                                <span></span>

                                <div class="option_label_btn_bar">

                                    <div class="patient_form_element_one_is_to_one">
                                        <label for="value" class="content_container_bg_less_thin text_right">Third Seizure</label>
                                        <input class="content_container_bg_less_thin text_center center_element input" type="tel" name="value" value="{{Session::get('Third_Seizure')}}" placeholder="0" required>
                                    </div>
                                    <button type="submit" class="content_container_bg_less_thin btn form_btn"><i class="fas fa-check-square log_out_btn"></i></button>

                                </div>

                            </form>

                        </div>

                    </div>


                
                </div>








@endsection

<!--------------------content end---------------------->
