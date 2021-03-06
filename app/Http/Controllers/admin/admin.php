<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class admin extends Controller
{




#########################
#### FUNCTION-NO::01 ####
#########################
# Sets up required items before loading admin home page;
# Stored data in 20 sessions.

function set_up_home(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    
    # Getting all basic Info.
    $basic_info=DB::table('admin')->where('Ad_ID',$ad_id)->first();

    session(['ADMIN_NAME' => $basic_info->Ad_Name]);
    session(['ADMIN_GENDER' => $basic_info->Ad_Gender]);
    session(['ADMIN_EMAIL' => $basic_info->Ad_Email]);
    session(['ADMIN_PHONE' => $basic_info->Ad_Phone]);
    session(['ADMIN_IMAGE' => $basic_info->Ad_Image]);

    # Getting all account variables.
    $acc_var=DB::table('account_variables')
    ->orderBy('AI_ID','desc')
    ->first();

    $vat = $acc_var->Vat;
    $commission = $acc_var->Commission;
    $invigilator_fee = $acc_var->Invigilator_Fee;
    $emergency_fee = $acc_var->Emergency_Fee;
    $er_hospital_percentage = $acc_var->ER_Hospital_Percentage;
    $dental_hospital_percentage = $acc_var->Dental_Hospital_Percentage;
    $pathology_hospital_percentage = $acc_var->Pathology_Hospital_Percentage;
    $physio_hospital_percentage = $acc_var->Physio_Hospital_Percentage;
    $ligation = $acc_var->Ligation;
    $third_seizure = $acc_var->Third_Seizure;

    session(['VAT' => $vat]);
    session(['COMMISSION' => $commission]);
    session(['Invigilator_Fee' => $invigilator_fee]);
    session(['Emergency_Fee' => $emergency_fee]);
    session(['ER_Hospital_Percentage' => $er_hospital_percentage]);
    session(['Dental_Hospital_Percentage' => $dental_hospital_percentage]);
    session(['Pathology_Hospital_Percentage' => $pathology_hospital_percentage]);
    session(['Physio_Hospital_Percentage' => $physio_hospital_percentage]);
    session(['Ligation' => $ligation]);
    session(['Third_Seizure' => $third_seizure]);

    $rest = 100-($vat+$commission);

    session(['REST' => $rest]);
    session(['modal' => 'off']);

    # Date and day set up.
    date_default_timezone_set('Asia/Dhaka');
    $date = date("Y-m-d");
    $year = date("Y");

    $timestamp = strtotime($date);
    $day = date('D', $timestamp);

    $request->session()->put('DATE_TODAY',$date);
    $request->session()->put('DAY_TODAY',$day);

    $request->session()->put('log_access_type','admin');

    $user['user']=DB::table('admin_activity_log')
        ->where('Ad_ID',$ad_id)
        ->orderBy('AI_ID','desc')
        ->get();

    $global['global']=DB::table('admin_activity_log')
        ->orderBy('AI_ID','desc')
        ->get();

    ################################################################################
    ################################################################################

    # Doctor count
    $doctor_active=DB::table('logins')
        ->where('Emp_ID','like','D_'.'%')
        ->where('status','1')
        ->count('Emp_ID');

    $request->session()->put('doctor_active',$doctor_active);

    $doctor_inactive=DB::table('logins')
        ->where('Emp_ID','like','D_'.'%')
        ->where('status','0')
        ->count('Emp_ID');

    $request->session()->put('doctor_inactive',$doctor_inactive);

    # Nurse count
    $nurse_active=DB::table('logins')
        ->where('Emp_ID','like','N_'.'%')
        ->where('status','1')
        ->count('Emp_ID');

    $request->session()->put('nurse_active',$nurse_active);

    $nurse_inactive=DB::table('logins')
        ->where('Emp_ID','like','N_'.'%')
        ->where('status','0')
        ->count('Emp_ID');

    $request->session()->put('nurse_inactive',$nurse_inactive);

    # Accounts count
    $accounts_active=DB::table('logins')
        ->where('Emp_ID','like','AC_'.'%')
        ->where('status','1')
        ->count('Emp_ID');

    $request->session()->put('accounts_active',$accounts_active);

    $accounts_inactive=DB::table('logins')
        ->where('Emp_ID','like','AC_'.'%')
        ->where('status','0')
        ->count('Emp_ID');

    $request->session()->put('accounts_inactive',$accounts_inactive);

    # Receptionist count
    $receptionists_active=DB::table('logins')
        ->where('Emp_ID','like','R_'.'%')
        ->where('status','1')
        ->count('Emp_ID');

    $request->session()->put('receptionists_active',$receptionists_active);

    $receptionists_inactive=DB::table('logins')
        ->where('Emp_ID','like','R_'.'%')
        ->where('status','0')
        ->count('Emp_ID');

    $request->session()->put('receptionists_inactive',$receptionists_inactive);

    # OT count
    $ot_active=DB::table('logins')
        ->where('Emp_ID','like','OT_'.'%')
        ->where('status','1')
        ->count('Emp_ID');

    $request->session()->put('ot_active',$ot_active);

    $ot_inactive=DB::table('logins')
        ->where('Emp_ID','like','OT_'.'%')
        ->where('status','0')
        ->count('Emp_ID');

    $request->session()->put('ot_inactive',$ot_inactive);

    ################################################################################
    ################################################################################

    # Male ward count
    $male_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Male')
        ->count('B_ID');

    $request->session()->put('male_ward',$male_ward);

    $occ_male_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Male')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_male_ward',$occ_male_ward);

    # Female ward count
    $female_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Female')
        ->count('B_ID');

    $request->session()->put('female_ward',$female_ward);

    $occ_female_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Female')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_female_ward',$occ_female_ward);

    # Child ward count
    $child_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Child')
        ->count('B_ID');

    $request->session()->put('child_ward',$child_ward);

    $occ_child_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Child')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_child_ward',$occ_child_ward);

    # Maternity ward count
    $maternity_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Maternity')
        ->count('B_ID');

    $request->session()->put('maternity_ward',$maternity_ward);

    $occ_maternity_ward=DB::table('beds')
        ->where('Bed_Type','Ward')
        ->where('Quality','Maternity')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_maternity_ward',$occ_maternity_ward);

    ################################################################################
    ################################################################################

    # Normal cabin count
    $normal_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','Normal')
        ->count('B_ID');

    $request->session()->put('normal_cabin',$normal_cabin);

    $occ_normal_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','Normal')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_normal_cabin',$occ_normal_cabin);

    # AC cabin count
    $ac_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','AC')
        ->count('B_ID');

    $request->session()->put('ac_cabin',$ac_cabin);

    $occ_ac_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','AC')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_ac_cabin',$occ_ac_cabin);

    # Double AC cabin count
    $double_ac_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','Double AC')
        ->count('B_ID');

    $request->session()->put('double_ac_cabin',$double_ac_cabin);

    $occ_double_ac_cabin=DB::table('beds')
        ->where('Bed_Type','Cabin')
        ->where('Quality','Double AC')
        ->where('Confirmation','1')
        ->count('B_ID');

    $request->session()->put('occ_double_ac_cabin',$occ_double_ac_cabin);

    ################################################################################
    ################################################################################

    # Credit yearly
    $credit_yearly=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $request->session()->put('credit_yearly',$credit_yearly);

    # Credit Jan
    $credit_jan=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-01-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_jan_per = ($credit_jan*100)/$credit_yearly;
    $credit_jan_per_10 = (($credit_jan_per*10)/100)%10;

    $request->session()->put('credit_jan',$credit_jan);
    $request->session()->put('credit_jan_per',$credit_jan_per);
    $request->session()->put('credit_jan_per_10',$credit_jan_per_10);

    # Credit Feb
    $credit_feb=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-02-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_feb_per = ($credit_feb*100)/$credit_yearly;
    $credit_feb_per_10 = (($credit_feb_per*10)/100)%10;

    $request->session()->put('credit_feb',$credit_feb);
    $request->session()->put('credit_feb_per',$credit_feb_per);
    $request->session()->put('credit_feb_per_10',$credit_feb_per_10);

    # Credit Mar
    $credit_mar=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-03-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_mar_per = ($credit_mar*100)/$credit_yearly;
    $credit_mar_per_10 = (($credit_mar_per*10)/100)%10;

    $request->session()->put('credit_mar',$credit_mar);
    $request->session()->put('credit_mar_per',$credit_mar_per);
    $request->session()->put('credit_mar_per_10',$credit_mar_per_10);

    # Credit Apr
    $credit_apr=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-04-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_apr_per = ($credit_apr*100)/$credit_yearly;
    $credit_apr_per_10 = (($credit_apr_per*10)/100)%10;

    $request->session()->put('credit_apr',$credit_apr);
    $request->session()->put('credit_apr_per',$credit_apr_per);
    $request->session()->put('credit_apr_per_10',$credit_apr_per_10);

    # Credit May
    $credit_may=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-05-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_may_per = ($credit_may*100)/$credit_yearly;
    $credit_may_per_10 = (($credit_may_per*10)/100)%10;

    $request->session()->put('credit_may',$credit_may);
    $request->session()->put('credit_may_per',$credit_may_per);
    $request->session()->put('credit_may_per_10',$credit_may_per_10);

    # Credit Jun
    $credit_jun=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-06-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_jun_per = ($credit_jun*100)/$credit_yearly;
    $credit_jun_per_10 = (($credit_jun_per*10)/100)%10;

    $request->session()->put('credit_jun',$credit_jun);
    $request->session()->put('credit_jun_per',$credit_jun_per);
    $request->session()->put('credit_jun_per_10',$credit_jun_per_10);

    # Credit Jul
    $credit_jul=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-07-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_jul_per = ($credit_jul*100)/$credit_yearly;
    $credit_jul_per_10 = (($credit_jul_per*10)/100)%10;

    $request->session()->put('credit_jul',$credit_jul);
    $request->session()->put('credit_jul_per',$credit_jul_per);
    $request->session()->put('credit_jul_per_10',$credit_jul_per_10);

    # Credit Aug
    $credit_aug=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-08-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_aug_per = ($credit_aug*100)/$credit_yearly;
    $credit_aug_per_10 = (($credit_aug_per*10)/100)%10;

    $request->session()->put('credit_aug',$credit_aug);
    $request->session()->put('credit_aug_per',$credit_aug_per);
    $request->session()->put('credit_aug_per_10',$credit_aug_per_10);

    # Credit Sep
    $credit_sep=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-09-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_sep_per = ($credit_sep*100)/$credit_yearly;
    $credit_sep_per_10 = (($credit_sep_per*10)/100)%10;

    $request->session()->put('credit_sep',$credit_sep);
    $request->session()->put('credit_sep_per',$credit_sep_per);
    $request->session()->put('credit_sep_per_10',$credit_sep_per_10);

    # Credit Oct
    $credit_oct=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-10-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_oct_per = ($credit_oct*100)/$credit_yearly;
    $credit_oct_per_10 = (($credit_oct_per*10)/100)%10;

    $request->session()->put('credit_oct',$credit_oct);
    $request->session()->put('credit_oct_per',$credit_oct_per);
    $request->session()->put('credit_oct_per_10',$credit_oct_per_10);

    # Credit Nov
    $credit_nov=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-11-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_nov_per = ($credit_nov*100)/$credit_yearly;
    $credit_nov_per_10 = (($credit_nov_per*10)/100)%10;

    $request->session()->put('credit_nov',$credit_nov);
    $request->session()->put('credit_nov_per',$credit_nov_per);
    $request->session()->put('credit_nov_per_10',$credit_nov_per_10);

    # Credit Dec
    $credit_dec=DB::table('hospital_income_log')
        ->where('Credit','>','0')
        ->where('Entry_Date','like','%'.'-12-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Credit');

    $credit_dec_per = ($credit_dec*100)/$credit_yearly;
    $credit_dec_per_10 = (($credit_dec_per*10)/100)%10;

    $request->session()->put('credit_dec',$credit_dec);
    $request->session()->put('credit_dec_per',$credit_dec_per);
    $request->session()->put('credit_dec_per_10',$credit_dec_per_10);

    ################################################################################
    ################################################################################

    # Debit yearly
    $debit_yearly=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $request->session()->put('debit_yearly',$debit_yearly);

    # Debit Jan
    $debit_jan=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-01-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_jan_per = ($debit_jan*100)/$debit_yearly;
    $debit_jan_per_10 = (($debit_jan_per*10)/100)%10;

    $request->session()->put('debit_jan',$debit_jan);
    $request->session()->put('debit_jan_per',$debit_jan_per);
    $request->session()->put('debit_jan_per_10',$debit_jan_per_10);

    # Debit Feb
    $debit_feb=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-02-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_feb_per = ($debit_feb*100)/$debit_yearly;
    $debit_feb_per_10 = (($debit_feb_per*10)/100)%10;

    $request->session()->put('debit_feb',$debit_feb);
    $request->session()->put('debit_feb_per',$debit_feb_per);
    $request->session()->put('debit_feb_per_10',$debit_feb_per_10);

    # Debit Mar
    $debit_mar=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-03-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_mar_per = ($debit_mar*100)/$debit_yearly;
    $debit_mar_per_10 = (($debit_mar_per*10)/100)%10;

    $request->session()->put('debit_mar',$debit_mar);
    $request->session()->put('debit_mar_per',$debit_mar_per);
    $request->session()->put('debit_mar_per_10',$debit_mar_per_10);

    # Debit Apr
    $debit_apr=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-04-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_apr_per = ($debit_apr*100)/$debit_yearly;
    $debit_apr_per_10 = (($debit_apr_per*10)/100)%10;

    $request->session()->put('debit_apr',$debit_apr);
    $request->session()->put('debit_apr_per',$debit_apr_per);
    $request->session()->put('debit_apr_per_10',$debit_apr_per_10);

    # Debit May
    $debit_may=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-05-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_may_per = ($debit_may*100)/$debit_yearly;
    $debit_may_per_10 = (($debit_may_per*10)/100)%10;

    $request->session()->put('debit_may',$debit_may);
    $request->session()->put('debit_may_per',$debit_may_per);
    $request->session()->put('debit_may_per_10',$debit_may_per_10);

    # Debit Jun
    $debit_jun=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-06-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_jun_per = ($debit_jun*100)/$debit_yearly;
    $debit_jun_per_10 = (($debit_jun_per*10)/100)%10;

    $request->session()->put('debit_jun',$debit_jun);
    $request->session()->put('debit_jun_per',$debit_jun_per);
    $request->session()->put('debit_jun_per_10',$debit_jun_per_10);

    # Debit Jul
    $debit_jul=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-07-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_jul_per = ($debit_jul*100)/$debit_yearly;
    $debit_jul_per_10 = (($debit_jul_per*10)/100)%10;

    $request->session()->put('debit_jul',$debit_jul);
    $request->session()->put('debit_jul_per',$debit_jul_per);
    $request->session()->put('debit_jul_per_10',$debit_jul_per_10);

    # Debit Aug
    $debit_aug=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-08-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_aug_per = ($debit_aug*100)/$debit_yearly;
    $debit_aug_per_10 = (($debit_aug_per*10)/100)%10;

    $request->session()->put('debit_aug',$debit_aug);
    $request->session()->put('debit_aug_per',$debit_aug_per);
    $request->session()->put('debit_aug_per_10',$debit_aug_per_10);

    # Debit Sep
    $debit_sep=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-09-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_sep_per = ($debit_sep*100)/$debit_yearly;
    $debit_sep_per_10 = (($debit_sep_per*10)/100)%10;

    $request->session()->put('debit_sep',$debit_sep);
    $request->session()->put('debit_sep_per',$debit_sep_per);
    $request->session()->put('debit_sep_per_10',$debit_sep_per_10);

    # Debit Oct
    $debit_oct=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-10-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_oct_per = ($debit_oct*100)/$debit_yearly;
    $debit_oct_per_10 = (($debit_oct_per*10)/100)%10;

    $request->session()->put('debit_oct',$debit_oct);
    $request->session()->put('debit_oct_per',$debit_oct_per);
    $request->session()->put('debit_oct_per_10',$debit_oct_per_10);

    # Debit Nov
    $debit_nov=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-11-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_nov_per = ($debit_nov*100)/$debit_yearly;
    $debit_nov_per_10 = (($debit_nov_per*10)/100)%10;

    $request->session()->put('debit_nov',$debit_nov);
    $request->session()->put('debit_nov_per',$debit_nov_per);
    $request->session()->put('debit_nov_per_10',$debit_nov_per_10);

    # Debit Dec
    $debit_dec=DB::table('hospital_income_log')
        ->where('Debit','>','0')
        ->where('Entry_Date','like','%'.'-12-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Debit');

    $debit_dec_per = ($debit_dec*100)/$debit_yearly;
    $debit_dec_per_10 = (($debit_dec_per*10)/100)%10;

    $request->session()->put('debit_dec',$debit_dec);
    $request->session()->put('debit_dec_per',$debit_dec_per);
    $request->session()->put('debit_dec_per_10',$debit_dec_per_10);

    ################################################################################
    ################################################################################

    # Total_Income yearly
    $total_income_yearly=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $request->session()->put('total_income_yearly',$total_income_yearly);

    # Total_Income Jan
    $total_income_jan=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-01-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_jan_per = ($total_income_jan*100)/$total_income_yearly;
    $total_income_jan_per_10 = (($total_income_jan_per*10)/100)%10;

    $request->session()->put('total_income_jan',$total_income_jan);
    $request->session()->put('total_income_jan_per',$total_income_jan_per);
    $request->session()->put('total_income_jan_per_10',$total_income_jan_per_10);

    # Total_Income Feb
    $total_income_feb=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-02-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_feb_per = ($total_income_feb*100)/$total_income_yearly;
    $total_income_feb_per_10 = (($total_income_feb_per*10)/100)%10;

    $request->session()->put('total_income_feb',$total_income_feb);
    $request->session()->put('total_income_feb_per',$total_income_feb_per);
    $request->session()->put('total_income_feb_per_10',$total_income_feb_per_10);

    # Total_Income Mar
    $total_income_mar=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-03-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_mar_per = ($total_income_mar*100)/$total_income_yearly;
    $total_income_mar_per_10 = (($total_income_mar_per*10)/100)%10;

    $request->session()->put('total_income_mar',$total_income_mar);
    $request->session()->put('total_income_mar_per',$total_income_mar_per);
    $request->session()->put('total_income_mar_per_10',$total_income_mar_per_10);

    # Total_Income Apr
    $total_income_apr=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-04-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_apr_per = ($total_income_apr*100)/$total_income_yearly;
    $total_income_apr_per_10 = (($total_income_apr_per*10)/100)%10;

    $request->session()->put('total_income_apr',$total_income_apr);
    $request->session()->put('total_income_apr_per',$total_income_apr_per);
    $request->session()->put('total_income_apr_per_10',$total_income_apr_per_10);

    # Total_Income May
    $total_income_may=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-05-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_may_per = ($total_income_may*100)/$total_income_yearly;
    $total_income_may_per_10 = (($total_income_may_per*10)/100)%10;

    $request->session()->put('total_income_may',$total_income_may);
    $request->session()->put('total_income_may_per',$total_income_may_per);
    $request->session()->put('total_income_may_per_10',$total_income_may_per_10);

    # Total_Income Jun
    $total_income_jun=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-06-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_jun_per = ($total_income_jun*100)/$total_income_yearly;
    $total_income_jun_per_10 = (($total_income_jun_per*10)/100)%10;

    $request->session()->put('total_income_jun',$total_income_jun);
    $request->session()->put('total_income_jun_per',$total_income_jun_per);
    $request->session()->put('total_income_jun_per_10',$total_income_jun_per_10);

    # Total_Income Jul
    $total_income_jul=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-07-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_jul_per = ($total_income_jul*100)/$total_income_yearly;
    $total_income_jul_per_10 = (($total_income_jul_per*10)/100)%10;

    $request->session()->put('total_income_jul',$total_income_jul);
    $request->session()->put('total_income_jul_per',$total_income_jul_per);
    $request->session()->put('total_income_jul_per_10',$total_income_jul_per_10);

    # Total_Income Aug
    $total_income_aug=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-08-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_aug_per = ($total_income_aug*100)/$total_income_yearly;
    $total_income_aug_per_10 = (($total_income_aug_per*10)/100)%10;

    $request->session()->put('total_income_aug',$total_income_aug);
    $request->session()->put('total_income_aug_per',$total_income_aug_per);
    $request->session()->put('total_income_aug_per_10',$total_income_aug_per_10);

    # Total_Income Sep
    $total_income_sep=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-09-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_sep_per = ($total_income_sep*100)/$total_income_yearly;
    $total_income_sep_per_10 = (($total_income_sep_per*10)/100)%10;

    $request->session()->put('total_income_sep',$total_income_sep);
    $request->session()->put('total_income_sep_per',$total_income_sep_per);
    $request->session()->put('total_income_sep_per_10',$total_income_sep_per_10);

    # Total_Income Oct
    $total_income_oct=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-10-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_oct_per = ($total_income_oct*100)/$total_income_yearly;
    $total_income_oct_per_10 = (($total_income_oct_per*10)/100)%10;

    $request->session()->put('total_income_oct',$total_income_oct);
    $request->session()->put('total_income_oct_per',$total_income_oct_per);
    $request->session()->put('total_income_oct_per_10',$total_income_oct_per_10);

    # Total_Income Nov
    $total_income_nov=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-11-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_nov_per = ($total_income_nov*100)/$total_income_yearly;
    $total_income_nov_per_10 = (($total_income_nov_per*10)/100)%10;

    $request->session()->put('total_income_nov',$total_income_nov);
    $request->session()->put('total_income_nov_per',$total_income_nov_per);
    $request->session()->put('total_income_nov_per_10',$total_income_nov_per_10);

    # Total_Income Dec
    $total_income_dec=DB::table('hospital_income_log')
        ->where('Total_Income','>','0')
        ->where('Entry_Date','like','%'.'-12-'.'%')
        ->where('Entry_Year', $year)
        ->sum('Total_Income');

    $total_income_dec_per = ($total_income_dec*100)/$total_income_yearly;
    $total_income_dec_per_10 = (($total_income_dec_per*10)/100)%10;

    $request->session()->put('total_income_dec',$total_income_dec);
    $request->session()->put('total_income_dec_per',$total_income_dec_per);
    $request->session()->put('total_income_dec_per_10',$total_income_dec_per_10);


    # Returning to the view below.
    return view('hospital/admin/home',$global,$user);

}

# End of function set_up_home.                              <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# This will be updated in the future.
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::02 ####
#########################
# Blocks account;
# Update will happen on --: TABLE :------ logins.

function block_account(Request $request, $emp_id){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $status=array(
        'status'=>0
    );

    # Update status.
    DB::table('logins')
        ->where('Emp_ID',$emp_id)
        ->update($status);

    # Update activity log.
    $msg = "Blocked user ".$emp_id.".";

    $entry=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($entry);

    # Redirecting.
    $empListType = $request->session()->get('empListType');

    if($empListType == "doctors"){
        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');
    }if($empListType == "accounts"){
        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');
    }if($empListType == "nurses"){
        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');
    }if($empListType == "ot_operator"){
        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');
    }if($empListType == "receptionists"){
        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');
    }if($empListType == "admin"){
        # Redirecting to [FUNCTION-NO::33].
        return redirect('/admin/admin/list');
    }

}

# End of function doctor_list_browse.                       <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::03 ####
#########################
# Unblocks account;
# Update will happen on --: TABLE :------ logins.

function unblock_account(Request $request, $emp_id){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $status=array(
        'status'=>1
    );

    # Update status.
    DB::table('logins')
        ->where('Emp_ID',$emp_id)
        ->update($status);

    # Update activity log.
    $msg = "Unblocked user ".$emp_id.".";

    $entry=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($entry);

    # Redirecting.
    $empListType = $request->session()->get('empListType');

    if($empListType == "doctors"){
        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');
    }if($empListType == "accounts"){
        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');
    }if($empListType == "nurses"){
        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');
    }if($empListType == "ot_operator"){
        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');
    }if($empListType == "receptionists"){
        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');
    }if($empListType == "admin"){
        # Redirecting to [FUNCTION-NO::33].
        return redirect('/admin/admin/list');
    }

}

# End of function doctor_list_browse.                       <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::04 ####
#########################
# Generates necessary data for employee registration.

function employee_add_form(Request $request){

    $specialty['specialty']=DB::table('doctors')
        ->select('Specialty')
        ->orderBy('Specialty','asc')
        ->distinct('Specialty')
        ->get();

    $department['department']=DB::table('doctors')
        ->select('Department')
        ->orderBy('Department','asc')
        ->distinct('Department')
        ->get();

    # Returning to the view below.
    return view('hospital/admin/add_employee', $specialty, $department);

}

# End of function employee_add_form.                        <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::05 ####
#########################
# Adds new employee.

function employee_add(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $name = $request->input('name');
    $password = $request->input('password');
    $gender = $request->input('gender');
    $first_part = $request->input('employee');
    $table = $first_part;

        /* Employee id generator */

        $current_count = DB::table($first_part)->orderBy('AI_ID','desc')->first();

        if($current_count==null){
            $third_part = 1;
        }else{

            if($first_part == 'doctors'){
                $current_count_array = explode('-',$current_count->D_ID);
            }elseif($first_part == 'nurses'){
                $current_count_array = explode('-',$current_count->N_ID);
            }elseif($first_part == 'accounts'){
                $current_count_array = explode('-',$current_count->Acc_ID);
            }elseif($first_part == 'receptionists'){
                $current_count_array = explode('-',$current_count->R_ID);
            }elseif($first_part == 'ot_operator'){
                $current_count_array = explode('-',$current_count->OTO_ID);
            }

            $third_part = end($current_count_array);
            $third_part++;
        }
            
        if($first_part == 'doctors'){
            $first_part = 'D';

            $specialty = $request->input('specialty');
            $department = $request->input('department');
            $basic_fee = $request->input('basic_fee');
            $discount = $request->input('discount');

            $type = "doctor";

        }elseif($first_part == 'nurses'){
            $first_part = 'N';
            $type = "nurse";

        }elseif($first_part == 'accounts'){
            $first_part = 'AC';
            $type = "accountant";

        }elseif($first_part == 'receptionists'){
            $first_part = 'R';
            $type = "receptionist";

        }elseif($first_part == 'ot_operator'){
            $first_part = 'OT';
            $type = "ot operator";

        }

        $second_part = $gender;

        if($second_part == 'Male'){
            $second_part = 'M';
        }elseif($second_part == 'Female'){
            $second_part = 'F';
        }elseif($second_part == 'Others'){
            $second_part = 'O';
        }

        $ID = "$first_part"."-"."$second_part"."-".str_pad($third_part,3,"0",STR_PAD_LEFT);

        /* Employee id generator end */

        if($table == 'doctors'){
        
            $entry=array(

                'D_ID'=>$ID,
                'Dr_Name'=>$name,
                'Dr_Gender'=>$gender,
                'Specialty'=>$specialty,
                'Department'=>$department,
                'Basic_Fee'=>$basic_fee,
                'Second_Visit_Discount'=>$discount

            );

            $entry2=array(

                'D_ID'=>$ID,
                'F'=>"16:00:00",
                'T'=>"20:00:00",
                'Sat'=>'A',
                'Sun'=>'A',
                'Mon'=>'A',
                'Tue'=>'A',
                'Wed'=>'A',
                'Thu'=>'A',
                'Fri'=>'A'

            );

            DB::table($table)->insert($entry);

            DB::table('doctor_schedules')->insert($entry2);
        
        }if($table == 'nurses'){
        
            $entry=array(

                'N_ID'=>$ID,
                'N_Name'=>$name,
                'N_Gender'=>$gender

            );

            DB::table($table)->insert($entry);

        }if($table == 'accounts'){
        
            $entry=array(

                'Acc_ID'=>$ID,
                'Acc_Name'=>$name,
                'Acc_Gender'=>$gender

            );

            DB::table($table)->insert($entry);

        }if($table == 'receptionists'){
        
            $entry=array(

                'R_ID'=>$ID,
                'R_Name'=>$name,
                'R_Gender'=>$gender

            );

            DB::table($table)->insert($entry);

        }if($table == 'ot_operator'){
        
            $entry=array(

                'OTO_ID'=>$ID,
                'OTO_Name'=>$name,
                'OTO_Gender'=>$gender

            );

            DB::table($table)->insert($entry);

        }

        $entry3=array(

            'Emp_ID'=>$ID,
            'Log_Password'=>$password,
            'status'=>'1'

        );

        DB::table('logins')->insert($entry3);

        $msg = "New ".$type." registered, ID: ".$ID.", name: ".$name.", & assigned password: ".$password.".";

        $entry4=array(

            'Ad_ID'=>$ad_id,
            'Log'=>$msg

        );

        DB::table('admin_activity_log')->insert($entry4);

    # Personal check redirect.
    if($table=="doctors"){

        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');

    }if($table=="nurses"){

        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');

    }if($table=="accounts"){

        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');

    }if($table=="ot_operator"){

        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');

    }if($table=="receptionist"){

        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');

    }

}

# End of function employee_add.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::06 ####
#########################
# Shows doctor list;
# Stored data in 2 sessions.

function doctor_list_browse(Request $request){

    $available_data['result']=DB::table('doctors')
        ->join('logins', 'doctors.D_ID', '=', 'logins.Emp_ID')
        ->select('doctors.*','logins.status')
        ->orderBy('doctors.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','0');
    $request->session()->put('empListType','doctors');

    # Returning to the view below.
    return view('hospital/admin/doctor_list', $available_data);

}

# End of function doctor_list_browse.                       <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::07 ####
#########################
# Search doctor list;
# Stored data in 2 sessions.

function doctor_list_search(Request $request){

    $request->validate([

        'search_info'=>'required'

    ]);

    $search_info = $request->input('search_info');

    $available_data['result']=DB::table('doctors')
        ->join('logins', 'doctors.D_ID', '=', 'logins.Emp_ID')
        ->select('doctors.*','logins.status')
        ->where('doctors.D_ID','like',$search_info)
        ->orwhere('doctors.Department','like','%'.$search_info.'%')
        ->orwhere('doctors.Dr_Name','like','%'.$search_info.'%')
        ->orderBy('doctors.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','1');
    $request->session()->put('SEARCH_RESULT','1');

    if(count($available_data['result']) == 0){

        $request->session()->put('SEARCH_RESULT','0');

    }

    # Returning to the view below.
    return view('hospital/admin/doctor_list', $available_data);

}

# End of function doctor_list_search.                       <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::08 ####
#########################
# Shows accountant list;
# Stored data in 2 sessions.

function accountant_list_browse(Request $request){

    $available_data['result']=DB::table('accounts')
        ->join('logins', 'accounts.Acc_ID', '=', 'logins.Emp_ID')
        ->select('accounts.*','logins.status')
        ->orderBy('accounts.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','0');
    $request->session()->put('empListType','accounts');

    # Returning to the view below.
    return view('hospital/admin/accountant_list', $available_data);

}

# End of function accountant_list_browse.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::09 ####
#########################
# Search accountant list;
# Stored data in 2 sessions.

function accountant_list_search(Request $request){

    $request->validate([

        'search_info'=>'required'

    ]);

    $search_info = $request->input('search_info');

    $available_data['result']=DB::table('accounts')
        ->join('logins', 'accounts.Acc_ID', '=', 'logins.Emp_ID')
        ->select('accounts.*','logins.status')
        ->where('accounts.Acc_ID','like',$search_info)
        ->orwhere('accounts.Acc_Name','like','%'.$search_info.'%')
        ->orderBy('accounts.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','1');
    $request->session()->put('SEARCH_RESULT','1');

    if(count($available_data['result']) == 0){

        $request->session()->put('SEARCH_RESULT','0');

    }

    # Returning to the view below.
    return view('hospital/admin/accountant_list', $available_data);

}

# End of function accountant_list_search.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::10 ####
#########################
# Shows nurse list;
# Stored data in 2 sessions.

function nurse_list_browse(Request $request){

    $available_data['result']=DB::table('nurses')
        ->join('logins', 'nurses.N_ID', '=', 'logins.Emp_ID')
        ->select('nurses.*','logins.status')
        ->orderBy('nurses.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','0');
    $request->session()->put('empListType','nurses');

    # Returning to the view below.
    return view('hospital/admin/nurse_list', $available_data);

}

# End of function nurse_list_browse.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::11 ####
#########################
# Search nurse list;
# Stored data in 2 sessions.

function nurse_list_search(Request $request){

    $request->validate([

        'search_info'=>'required'

    ]);

    $search_info = $request->input('search_info');

    $available_data['result']=DB::table('nurses')
        ->join('logins', 'nurses.N_ID', '=', 'logins.Emp_ID')
        ->select('nurses.*','logins.status')
        ->where('nurses.N_ID','like',$search_info)
        ->orwhere('nurses.N_Name','like','%'.$search_info.'%')
        ->orderBy('nurses.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','1');
    $request->session()->put('SEARCH_RESULT','1');

    if(count($available_data['result']) == 0){

        $request->session()->put('SEARCH_RESULT','0');

    }

    # Returning to the view below.
    return view('hospital/admin/nurse_list', $available_data);

}

# End of function nurse_list_search.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::12 ####
#########################
# Shows ot list;
# Stored data in 2 sessions.

function ot_list_browse(Request $request){

    $available_data['result']=DB::table('ot_operator')
        ->join('logins', 'ot_operator.OTO_ID', '=', 'logins.Emp_ID')
        ->select('ot_operator.*','logins.status')
        ->orderBy('ot_operator.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','0');
    $request->session()->put('empListType','ot_operator');

    # Returning to the view below.
    return view('hospital/admin/ot_list', $available_data);

}

# End of function ot_list_browse.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::13 ####
#########################
# Search ot list;
# Stored data in 2 sessions.

function ot_list_search(Request $request){

    $request->validate([

        'search_info'=>'required'

    ]);

    $search_info = $request->input('search_info');

    $available_data['result']=DB::table('ot_operator')
        ->join('logins', 'ot_operator.OTO_ID', '=', 'logins.Emp_ID')
        ->select('ot_operator.*','logins.status')
        ->where('ot_operator.OTO_ID','like',$search_info)
        ->orwhere('ot_operator.OTO_Name','like','%'.$search_info.'%')
        ->orderBy('ot_operator.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','1');
    $request->session()->put('SEARCH_RESULT','1');

    if(count($available_data['result']) == 0){

        $request->session()->put('SEARCH_RESULT','0');

    }

    # Returning to the view below.
    return view('hospital/admin/ot_list', $available_data);

}

# End of function nurse_list_search.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::14 ####
#########################
# Shows receptionist list;
# Stored data in 2 sessions.

function receptionist_list_browse(Request $request){

    $available_data['result']=DB::table('receptionists')
        ->join('logins', 'receptionists.R_ID', '=', 'logins.Emp_ID')
        ->select('receptionists.*','logins.status')
        ->orderBy('receptionists.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','0');
    $request->session()->put('empListType','receptionists');

    # Returning to the view below.
    return view('hospital/admin/receptionist_list', $available_data);

}

# End of function receptionist_list_browse.                   <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::15 ####
#########################
# Search receptionist list;
# Stored data in 2 sessions.

function receptionist_list_search(Request $request){

    $request->validate([

        'search_info'=>'required'

    ]);

    $search_info = $request->input('search_info');

    $available_data['result']=DB::table('receptionists')
        ->join('logins', 'receptionists.R_ID', '=', 'logins.Emp_ID')
        ->select('receptionists.*','logins.status')
        ->where('receptionists.R_ID','like',$search_info)
        ->orwhere('receptionists.R_Name','like','%'.$search_info.'%')
        ->orderBy('receptionists.AI_ID','asc')
        ->get();

    $request->session()->put('INVOICE','1');
    $request->session()->put('SEARCH_RESULT','1');

    if(count($available_data['result']) == 0){

        $request->session()->put('SEARCH_RESULT','0');

    }

    # Returning to the view below.
    return view('hospital/admin/receptionist_list', $available_data);

}

# End of function receptionist_list_search.                 <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::16 ####
#########################
# Search nurse list;
# Stored data in 2 sessions;
# Update might happen on --: TABLE :------ doctors;
# Update might happen on --: TABLE :------ nurses;
# Update might happen on --: TABLE :------ accounts;
# Update might happen on --: TABLE :------ receptionist;
# Update might happen on --: TABLE :------ ot_operator;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function edit_employee_list(Request $request, $id){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $personal = $request->input('personal');
    $basic_fee = $request->input('edit_fee');
    $emp_id = $request->input('edit_id');
    $second_visit = $request->input('edit_discount');
    #$discount = 100-((100*$second_visit)/1000);

    # Activity log.
    $msg = 'Updated info of '.$emp_id.'.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Personal check and Info update.
    if($personal=="doctors"){

        $entry=array(

            'Dr_Name'=>$request->input('edit_name'),
            'Dr_Gender'=>$request->input('edit_gender'),
            'Specialty'=>$request->input('edit_specialty'),
            'Department'=>$request->input('edit_dept'),
            'Basic_Fee'=>$basic_fee,
            'Second_Visit_Discount'=>$second_visit

        );

        DB::table($personal)
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Updated info of doctor '.$emp_id.'.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');

    }if($personal=="nurses"){

        $entry=array(

            'N_Name'=>$request->input('edit_name'),
            'N_Gender'=>$request->input('edit_gender'),

        );

        DB::table($personal)
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Updated info of nurse '.$emp_id.'.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');

    }if($personal=="receptionists"){

        $entry=array(

            'R_Name'=>$request->input('edit_name'),
            'R_Gender'=>$request->input('edit_gender'),

        );

        DB::table($personal)
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Updated info of receptionist '.$emp_id.'.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');

    }if($personal=="accounts"){

        $entry=array(

            'Acc_Name'=>$request->input('edit_name'),
            'Acc_Gender'=>$request->input('edit_gender'),

        );

        DB::table($personal)
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Updated info of accountant '.$emp_id.'.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');

    }if($personal=="ot_operator"){

        $entry=array(

            'OTO_Name'=>$request->input('edit_name'),
            'OTO_Gender'=>$request->input('edit_gender'),

        );

        DB::table($personal)
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Updated info of ot operator '.$emp_id.'.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');

    }

}

# End of function edit_employee_list.                       <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::17 ####
#########################
# Opens modal;
# Stored data in 4 sessions..

function open_modal_employee(Request $request, $id, $emp, $id2){

    $request->session()->put('emp_del_id',$id);
    $request->session()->put('emp_del_id2',$id2);
    $request->session()->put('emp_del_type',$emp);
    $request->session()->put('modal','on');

    # Personal check redirect.
    if($emp=="doctors"){

        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');

    }if($emp=="nurses"){

        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');

    }if($emp=="accounts"){

        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');

    }if($emp=="receptionists"){

        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');

    }if($emp=="ot_operator"){

        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');

    }

}

# End of function open_modal_employee.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::18 ####
#########################
# Closes modal;
# Removes data from 3 sessions.
# Stored data in 1 sessions.

function close_modal_employee(Request $request){

    $emp = $request->session()->get('emp_del_type');
    $request->session()->forget('emp_del_id');
    $request->session()->forget('emp_del_id2');
    $request->session()->put('modal','off');

    # Personal check redirect.
    if($emp=="doctors"){

        $request->session()->forget('emp_del_type');

        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');

    }if($emp=="nurses"){

        $request->session()->forget('emp_del_type');

        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');

    }if($emp=="accounts"){

        $request->session()->forget('emp_del_type');

        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');

    }if($emp=="receptionists"){

        $request->session()->forget('emp_del_type');

        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');

    }if($emp=="ot_operator"){

        $request->session()->forget('emp_del_type');

        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');

    }

}

# End of function open_modal_employee.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::19 ####
#########################
# Deletes employee;
# Delete might happen on --: TABLE :------ doctors;
# Delete might happen on --: TABLE :------ nurses;
# Delete might happen on --: TABLE :------ accounts;
# Delete might happen on --: TABLE :------ ot_operator;
# Delete will happen on  --: TABLE :------ logins;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function delete_employee(Request $request){

    $id = $request->session()->get('emp_del_id');
    $id2 = $request->session()->get('emp_del_id2');
    $emp = $request->session()->get('emp_del_type');
    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $request->session()->put('modal','off');

    # Delete employee.
    DB::table($emp)
        ->where('AI_ID', $id)
        ->delete();

    # Delete login.
    DB::table('logins')
        ->where('Emp_ID', $id2)
        ->delete();

    # Activity log.
    $msg = 'Deleted account of '.$id2.'. All data permanently lost.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Session flash message.
    $msg = 'Account deleted.';
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'delete');

    # Personal check redirect.
    if($emp=="doctors"){

        # Redirecting to [FUNCTION-NO::06].
        return redirect('/admin/doctor/list');

    }if($emp=="nurses"){

        # Redirecting to [FUNCTION-NO::10].
        return redirect('/admin/nurse/list');

    }if($emp=="accounts"){

        # Redirecting to [FUNCTION-NO::08].
        return redirect('/admin/accountant/list');

    }if($emp=="receptionists"){

        # Redirecting to [FUNCTION-NO::14].
        return redirect('/admin/receptionist/list');

    }if($emp=="ot_operator"){

        # Redirecting to [FUNCTION-NO::12].
        return redirect('/admin/ot/list');

    }

}

# End of function delete_employee.                          <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::20 ####
#########################
# Shows other service list.

function show_services(Request $request){

    $available_data['result']=DB::table('others_info')
        ->orderBy('AI_ID','desc')
        ->get();

    # Returning to the view below.
    return view('hospital/admin/other_service_list', $available_data);

}

# End of function show_services.                            <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::21 ####
#########################
# Edits other service list;
# Update will happen on --: TABLE :------ ot_operator;
# Entry will happen on  --: TABLE :------ admin_activity_log..

function edit_services(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $id = $request->input('edit_id');
    $name = $request->input('edit_name');

    $Total = $request->input('edit_total');
    $Hospital = $request->input('edit_hospital');
    $DMO = $request->input('edit_dmo');
    $Nurse = $request->input('edit_nurse');
    $Assistant = $request->input('edit_assistant');

    $sum = $Hospital+$DMO+$Nurse+$Assistant;

    if($Total == $sum){

        $entry=array(

            'Other_Name'=>$name,
            'Unit'=>$request->input('edit_unit'),
            'Total'=>$Total,
            'Hospital'=>$Hospital,
            'DMO'=>$DMO,
            'Nurse'=>$Nurse,
            'Assistant'=>$Assistant

        );

        DB::table('others_info')
            ->where('AI_ID',$id)
            ->update($entry);

        # Session flash message.
        $msg = 'Service updated.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'edit');

        # Activity log.
        $log=array(

            'Ad_ID'=>$ad_id,
            'Log'=>$msg

        );

        DB::table('admin_activity_log')->insert($log);

        # Redirecting to [FUNCTION-NO::20].
        return redirect('/admin/show/services');

    }else{

        # Session flash message.
        $msg = 'The summation of hospital('.$Hospital.'), dmo('.$DMO.'), nurse('.$Nurse.'), assistant('.$Assistant.') is '.$sum.' which is not equal total('.$Total.').';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'delete');

        # Redirecting to [FUNCTION-NO::20].
        return redirect('/admin/show/services');

    }

}

# End of function edit_services.                            <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::22 ####
#########################
# Adds other service;
# Entry will happen on --: TABLE :------ ot_operator;
# Entry will happen on --: TABLE :------ admin_activity_log..

function add_services(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $name = $request->input('add_name');

    $Total = $request->input('add_total');
    $Hospital = $request->input('add_hospital');
    $DMO = $request->input('add_dmo');
    $Nurse = $request->input('add_nurse');
    $Assistant = $request->input('add_assistant');

    $sum = $Hospital+$DMO+$Nurse+$Assistant;

    if($Total == $sum){

        $entry=array(

            'Other_Name'=>$name,
            'Unit'=>$request->input('add_unit'),
            'Total'=>$Total,
            'Hospital'=>$Hospital,
            'DMO'=>$DMO,
            'Nurse'=>$Nurse,
            'Assistant'=>$Assistant

        );

        DB::table('others_info')
            ->insert($entry);

        # Session flash message.
        $msg = 'New service ('.$name.') was added.';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'add');

        # Activity log.
        $log=array(

            'Ad_ID'=>$ad_id,
            'Log'=>$msg

        );

        DB::table('admin_activity_log')->insert($log);

        # Redirecting to [FUNCTION-NO::20].
        return redirect('/admin/show/services');

    }else{

        # Session flash message.
        $msg = 'The summation of hospital('.$Hospital.'), dmo('.$DMO.'), nurse('.$Nurse.'), assistant('.$Assistant.') is '.$sum.' which is not equal total('.$Total.').';
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'delete');

        # Redirecting to [FUNCTION-NO::20].
        return redirect('/admin/show/services');

    }

}

# End of function add_services.                            <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::23 ####
#########################
# Opens modal;
# Stored data in 3 sessions.

function open_modal_services(Request $request, $id, $name){

    $request->session()->put('ser_del_id',$id);
    $request->session()->put('ser_del_name',$name);
    $request->session()->put('modal','on');

    # Redirecting to [FUNCTION-NO::20].
    return redirect('/admin/show/services');


}

# End of function open_modal_services.                      <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::24 ####
#########################
# Closes modal;
# Removes data from 2 sessions.
# Stored data in 1 sessions.

function close_modal_services(Request $request){

    $request->session()->forget('ser_del_id');
    $request->session()->forget('ser_del_name');
    $request->session()->put('modal','off');

    # Redirecting to [FUNCTION-NO::20].
    return redirect('/admin/show/services');


}

# End of function close_modal_services.                     <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::25 ####
#########################
# Deletes service;
# Delete will happen on  --: TABLE :------ others_info;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function delete_services(Request $request){

    $id = $request->session()->get('ser_del_id');
    $name = $request->session()->get('ser_del_name');
    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $request->session()->put('modal','off');

    # Delete employee.
    DB::table('others_info')
        ->where('AI_ID', $id)
        ->delete();

    # Activity log.
    $msg = 'Deleted service: '.$name.'. All data permanently lost.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Session flash message.
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'delete');

    # Redirecting to [FUNCTION-NO::20].
    return redirect('/admin/show/services');

}

# End of function delete_services.                          <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::26 ####
#########################
# Shows bed list;
# Stored data in 2 sessions.

function bed_list_browse(Request $request, $type, $quality){

    $available_data['result']=DB::table('beds')
        ->where('Quality',$quality)
        ->where('Bed_Type',$type)
        ->orderBy('B_ID','asc')
        ->get();

    $request->session()->put('quality',$quality);
    $request->session()->put('type',$type);

    # Returning to the view below.
    return view('hospital/admin/bed_list', $available_data);

}

# End of function ward_list_browse.                         <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::27 ####
#########################
# Generates necessary data for bed registration;
# Stored data in 1 sessions.

function bed_add_form(Request $request, $type, $quality){

    $request->session()->put('type',$type);
    $request->session()->put('quality',$quality);

    # Returning to the view below.
    return view('hospital/admin/add_beds');

}

# End of function bed_add_form.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::28 ####
#########################
# Adds new bed.

function bed_add(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $Bed_No = $request->input('bed');
    $Bed_Type = $request->input('type');
    $Quality = $request->input('quality');


    $entry=array(

        'Bed_No' => $Bed_No,
        'Floor_No' => $request->input('floor'),
        'Room_No' => $request->input('room'),
        'Bed_Type' => $Bed_Type,
        'Quality' => $Quality,
        'B_Location' => $request->input('location'),
        'Package_Name' => $request->input('package'),
        'Normal_Pricing' => $request->input('normal_pricing'),
        'Package_Pricing' => $request->input('package_pricing'),
        'Day_Range' => $request->input('range'),
        'Admission_Fee' => $request->input('admission')

    );

    DB::table('beds')->insert($entry);


    $msg = "New ".$Quality." ".$Bed_Type." added, bed no: ".$Bed_No.".";

    $entry2=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($entry2);

    # Session flash message.
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'entry');

    # Redirecting to [FUNCTION-NO::26].
    return redirect('/admin/bed/list/'.$Bed_Type.'/'.$Quality);

}

# End of function bed_add.                                  <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::29 ####
#########################
# Edits bed ID;
# Stored data in 2 sessions;
# Update might happen on --: TABLE :------ bed;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function edit_bed_list(Request $request, $id){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $Bed_No = $request->input('bed');
    $Bed_Type = $request->input('type');
    $Quality = $request->input('quality');

    # Activity log.
    $msg = "Updated ".$Quality." ".$Bed_Type.", bed no: ".$Bed_No.".";

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Update beds.
    $entry=array(

        'Bed_No' => $Bed_No,
        'Floor_No' => $request->input('floor'),
        'Room_No' => $request->input('room'),
        'Bed_Type' => $Bed_Type,
        'Quality' => $Quality,
        'B_Location' => $request->input('location'),
        'Package_Name' => $request->input('package'),
        'Normal_Pricing' => $request->input('normal_pricing'),
        'Package_Pricing' => $request->input('package_pricing'),
        'Day_Range' => $request->input('range'),
        'Admission_Fee' => $request->input('admission')

    );

    DB::table('beds')
        ->where('B_ID',$id)
        ->update($entry);

    # Session flash message.
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'edit');

    # Redirecting to [FUNCTION-NO::26].
    return redirect('/admin/bed/list/'.$Bed_Type.'/'.$Quality);

}

# End of function edit_bed_list.                            <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::30 ####
#########################
# Opens modal;
# Stored data in 6 sessions.

function open_modal_bed(Request $request, $id, $bed_no, $quality, $bed_type, $conf){

    $request->session()->put('bed_del_id',$id);
    $request->session()->put('bed_del_no',$bed_no);
    $request->session()->put('bed_del_quality',$quality);
    $request->session()->put('bed_del_type',$bed_type);
    $request->session()->put('bed_del_conf',$conf);
    $request->session()->put('modal','on');

    # Redirecting to [FUNCTION-NO::26].
    return redirect('/admin/bed/list/'.$bed_type.'/'.$quality);


}

# End of function open_modal_bed.                           <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::31 ####
#########################
# Closes modal;
# Removes data from 5 sessions;
# Stored data in 1 sessions.

function close_modal_bed(Request $request){

    $Quality = $request->session()->get('bed_del_quality');
    $Bed_Type = $request->session()->get('bed_del_type');

    $request->session()->forget('bed_del_id');
    $request->session()->forget('bed_del_no');
    $request->session()->forget('bed_del_quality');
    $request->session()->forget('bed_del_type');
    $request->session()->forget('bed_del_conf');
    $request->session()->put('modal','off');

    # Redirecting to [FUNCTION-NO::26].
    return redirect('/admin/bed/list/'.$Bed_Type.'/'.$Quality);


}

# End of function close_modal_bed.                          <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::32 ####
#########################
# Deletes bed;
# Delete will happen on  --: TABLE :------ beds;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function delete_bed(Request $request){

    $id = $request->session()->get('bed_del_id');
    $bed_no = $request->session()->get('bed_del_no');
    $Quality = $request->session()->get('bed_del_quality');
    $Bed_Type = $request->session()->get('bed_del_type');
    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $conf = $request->session()->get('bed_del_conf');
    $request->session()->put('modal','off'); 

    # Delete employee.
    DB::table('beds')
        ->where('B_ID', $id)
        ->where('Confirmation', '0')
        ->delete();

    if($conf == 0){

        # Activity log.
        $msg = "Deleted ".$Quality." ".$Bed_Type.", bed no: ".$bed_no.".";

        $log=array(

            'Ad_ID'=>$ad_id,
            'Log'=>$msg

        );

        DB::table('admin_activity_log')->insert($log);

        # Session flash message.
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'delete');

    }else{

        $request->session()->flash('msg', 'The bed is currently occupied.');
        $request->session()->flash('msgHook', 'edit');

    }

    # Redirecting to [FUNCTION-NO::26].
    return redirect('/admin/bed/list/'.$Bed_Type.'/'.$Quality);

}

# End of function delete_bed.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::33 ####
#########################
# Shows admin list;
# Stored data in 1 sessions.

function admin_list(Request $request){

    $available_data['result']=DB::table('admin')
        ->join('logins', 'admin.Ad_ID', '=', 'logins.Emp_ID')
        ->select('admin.*','logins.status')
        ->orderBy('admin.AI_ID','asc')
        ->get();

    $request->session()->put('empListType','admin');

    # Returning to the view below.
    return view('hospital/admin/admin_list', $available_data);

}

# End of function admin_list.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::34 ####
#########################
# Adds new admin;
# Entry will happen on   --: TABLE :------ admin
# Entry will happen on   --: TABLE :------ admin_activity_log.

function admin_add(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');

    $name = $request->input('name');
    $password = $request->input('password');
    $gender = $request->input('gender');

        /* Admin id generator */

        $current_count = DB::table('admin')->orderBy('AI_ID','desc')->first();

        if($current_count==null){
            $third_part = 1;
        }else{
            $current_count_array = explode('-',$current_count->Ad_ID);
            $third_part = end($current_count_array);
            $third_part++;
        }
            
        $first_part = 'Ad';

        if($gender == 'Male'){
            $second_part = 'M';
        }elseif($gender == 'Female'){
            $second_part = 'F';
        }elseif($gender == 'Others'){
            $second_part = 'O';
        }

        $ID = "$first_part"."-"."$second_part"."-".str_pad($third_part,3,"0",STR_PAD_LEFT);

        /* Employee id generator end */

        $entry=array(

            'Ad_ID'=>$ID,
            'Ad_Name'=>$name,
            'Ad_Gender'=>$gender

        );

        DB::table('admin')->insert($entry);

        $entry2=array(

            'Emp_ID'=>$ID,
            'Log_Password'=>$password,
            'status'=>'1'

        );

        DB::table('logins')->insert($entry2);

        $msg = "New admin registered, ID: ".$ID.", name: ".$name.", & assigned password: ".$password.".";

        $entry3=array(

            'Ad_ID'=>$ad_id,
            'Log'=>$msg

        );

        DB::table('admin_activity_log')->insert($entry3);

        # Session flash message.
        $request->session()->flash('msg', $msg);
        $request->session()->flash('msgHook', 'entry');

        # Redirecting to [FUNCTION-NO::33].
        return redirect('/admin/admin/list');

}

# End of function admin_add.                                <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::35 ####
#########################
# Opens modal;
# Stored data in 3 sessions.

function open_modal_admin(Request $request, $ad_id, $id){

    $request->session()->put('ad_del_ad_id',$ad_id);
    $request->session()->put('ad_del_id',$id);
    $request->session()->put('modal','on');

    # Redirecting to [FUNCTION-NO::33].
    return redirect('/admin/admin/list');


}

# End of function open_modal_admin.                      <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::36 ####
#########################
# Closes modal;
# Removes data from 2 sessions.
# Stored data in 1 sessions.

function close_modal_admin(Request $request){

    $request->session()->forget('ad_del_ad_id');
    $request->session()->forget('ad_del_id');
    $request->session()->put('modal','off');

    # Redirecting to [FUNCTION-NO::33].
    return redirect('/admin/admin/list');


}

# End of function close_modal_admin.                     <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::37 ####
#########################
# Deletes admin;
# Delete will happen on --: TABLE :------ admin;
# Delete will happen on  --: TABLE :------ logins;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function delete_admin(Request $request){

    $id = $request->session()->get('ad_del_id');
    $id2 = $request->session()->get('ad_del_ad_id');
    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $request->session()->put('modal','off');

    # Delete admin.
    DB::table('admin')
        ->where('AI_ID', $id)
        ->delete();

    # Delete login.
    DB::table('logins')
        ->where('Emp_ID', $id2)
        ->delete();

    # Activity log.
    $msg = 'Deleted account of '.$id2.'. All data permanently lost.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Session flash message.
    $msg = 'Account deleted.';
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'delete');


    # Redirecting to [FUNCTION-NO::33].
    return redirect('/admin/admin/list');

}

# End of function delete_admin.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::38 ####
#########################
# Updates admin list;
# Update will happen on --: TABLE :------ admin;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function edit_admin_list(Request $request, $id){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $emp_id = $request->input('edit_id');

    # Activity log.
    $msg = 'Updated info of '.$emp_id.'.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    $entry=array(

        'Ad_Name'=>$request->input('edit_name'),
        'Ad_Gender'=>$request->input('edit_gender')

    );

    DB::table('admin')
        ->where('AI_ID',$id)
        ->update($entry);

    # Session flash message.
    $msg = 'Updated info of doctor '.$emp_id.'.';
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'edit');

    # Redirecting to [FUNCTION-NO::33].
    return redirect('/admin/admin/list');

}

# End of function edit_admin_list.                          <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::39 ####
#########################
# Edit admin profile;
# Update will happen on --: TABLE :------ admin.

function edit_profile(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    
    # validating data from form.
    $request->validate([

        'ad_name'=>'required',
        'ad_email'=>'required',
        'ad_phone'=>'required',
        'profile_photo'=>'image|dimensions:ratio=1/1|mimes:jpg,jpeg,png|dimensions:min_width=200,min_height=200,max_width=600,max_height=600|max:2048'

    ]);

    # Getting data from form.
    $data=array(

        'Ad_Name'=>$request->input('ad_name'),
        'Ad_Email'=>$request->input('ad_email'),
        'Ad_Phone'=>$request->input('ad_phone')
        
    );

    if($request->hasfile('profile_photo')){

        $image=$request->file('profile_photo');
        $ext=$image->extension();
        $file=$ad_id.'.'.$ext;
        $image->storeAs('/public/admin_profile_pictures',$file);

        $data['Ad_Image']=$file;

    }

    DB::table('admin')->where('Ad_ID',$ad_id)->update($data);
    
    $request->session()->flash('msg','Profile updated successfully.');

    # Redirecting to [FUNCTION-NO::01].
    return redirect('/admin/home/');

}

# End of function edit_profile.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# This function might get an update in the future.
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::40 ####
#########################
# Shows test list.

function show_tests(Request $request, $hook){

    if($hook=="Dental"){
        $available_data['result']=DB::table('dental_info')
        ->orderBy('AI_ID','desc')
        ->get();

    }else{
        $available_data['result']=DB::table('pathology_info')
        ->where('Groups',$hook)
        ->orderBy('AI_ID','desc')
        ->get();
    }

    $request->session()->put('hook',$hook);

    # Returning to the view below.
    return view('hospital/admin/tests', $available_data);

}

# End of function show_tests.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::41 ####
#########################
# Edits test list;
# Update might happen on --: TABLE :------ dental_info;
# Update might happen on --: TABLE :------ pathology_info;
# Entry will happen on   --: TABLE :------ admin_activity_log..

function edit_tests(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $hook = $request->session()->get('hook');
    $id = $request->input('id');
    $name = $request->input('name');

    if($hook=='Dental'){

        $entry=array(

            'Test_Name'=>$name,
            'Rate'=>$request->input('rate')

        );

        DB::table('dental_info')
            ->where('AI_ID',$id)
            ->update($entry);
    
    }else{

        $entry=array(

            'Test_Name'=>$name,
            'Test_Fee'=>$request->input('rate'),
            'Room_No'=>$request->input('room')

        );

        DB::table('pathology_info')
            ->where('AI_ID',$id)
            ->update($entry);

    }

    # Session flash message.
    $msg = $hook.' test: '.$name.' updated.';
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'edit');

    # Activity log.
    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);

}

# End of function edit_tests.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::42 ####
#########################
# Adds test;
# Entry might happen on --: TABLE :------ dental_info;
# Entry might happen on --: TABLE :------ pathology_info;
# Entry will happen on  --: TABLE :------ admin_activity_log..

function add_tests(Request $request){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $hook = $request->session()->get('hook');
    $name = $request->input('name');

    if($hook=='Dental'){

        $entry=array(

            'Test_Name'=>$name,
            'Rate'=>$request->input('rate'),
            'State'=>$request->input('state')

        );

        DB::table('dental_info')
            ->insert($entry);
    
    }else{

        $entry=array(

            'Test_Name'=>$name,
            'Test_Fee'=>$request->input('rate'),
            'Room_No'=>$request->input('room'),
            'Groups'=>$hook,
            'State'=>$request->input('state')

        );

        DB::table('pathology_info')
            ->insert($entry);

    }

    # Session flash message.
    $msg = $hook.' test: '.$name.' added.';
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'add');

    # Activity log.
    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);


}

# End of function add_tests.                                <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::43 ####
#########################
# Opens modal;
# Stored data in 3 sessions.

function open_modal_tests(Request $request, $id, $name){

    $request->session()->put('tes_del_id',$id);
    $request->session()->put('tes_del_name',$name);
    $request->session()->put('modal','on');
    $hook = $request->session()->get('hook');

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);


}

# End of function open_modal_tests.                         <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::44 ####
#########################
# Closes modal;
# Removes data from 2 sessions.
# Stored data in 1 sessions.

function close_modal_tests(Request $request){

    $request->session()->forget('tes_del_id');
    $request->session()->forget('tes_del_name');
    $request->session()->put('modal','off');
    $hook = $request->session()->get('hook');

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);


}

# End of function close_modal_tests.                        <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::45 ####
#########################
# Deletes service;
# Delete might happen on --: TABLE :------ dental_info;
# Delete might happen on --: TABLE :------ pathology_info;
# Entry will happen on   --: TABLE :------ admin_activity_log.

function delete_tests(Request $request){

    $id = $request->session()->get('tes_del_id');
    $hook = $request->session()->get('hook');
    $name = $request->session()->get('tes_del_name');
    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $request->session()->put('modal','off');

    # Delete test.
    if($hook=='Dental'){

        DB::table('dental_info')
            ->where('AI_ID', $id)
            ->delete();
    
    }else{

        DB::table('pathology_info')
            ->where('AI_ID', $id)
            ->delete();

    }

    # Activity log.
    $msg = $hook.' test: '.$name.' removed.';

    $log=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($log);

    # Session flash message.
    $request->session()->flash('msg', $msg);
    $request->session()->flash('msgHook', 'delete');

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);

}

# End of function delete_tests.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me.
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::46 ####
#########################
# Blocks tests;
# Update might happen on --: TABLE :------ dental_info;
# Update might happen on --: TABLE :------ pathology_info.

function block_test(Request $request, $id, $name){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $hook = $request->session()->get('hook');

    $state=array(
        'State'=>0
    );

    # Update state.
    if($hook=='Dental'){

        DB::table('dental_info')
            ->where('AI_ID',$id)
            ->update($state);
    
    }else{

        DB::table('pathology_info')
            ->where('AI_ID',$id)
            ->update($state);

    }

    # Update activity log.
    $msg = $hook.' test: '.$name.' blocked.';

    $entry=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($entry);

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);

}

# End of function block_test.                               <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




#########################
#### FUNCTION-NO::47 ####
#########################
# Unblocks tests;
# Update might happen on --: TABLE :------ dental_info;
# Update might happen on --: TABLE :------ pathology_info.

function unblock_test(Request $request, $id, $name){

    $ad_id = $request->session()->get('ADMIN_SESSION_ID');
    $hook = $request->session()->get('hook');

    $state=array(
        'State'=>1
    );

    # Update state.
    if($hook=='Dental'){

        DB::table('dental_info')
            ->where('AI_ID',$id)
            ->update($state);
    
    }else{

        DB::table('pathology_info')
            ->where('AI_ID',$id)
            ->update($state);

    }

    # Update activity log.
    $msg = $hook.' test: '.$name.' blocked.';

    $entry=array(

        'Ad_ID'=>$ad_id,
        'Log'=>$msg

    );

    DB::table('admin_activity_log')->insert($entry);

    # Redirecting to [FUNCTION-NO::40].
    return redirect('/admin/test/list/'.$hook);

}

# End of function unblock_test.                             <-------#
                                                                    #
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
# Note: Hello, future me,
# 
# 
# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #




}
