<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ApplyFormController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->cname)) {
            $country = $request->cname;
        } else {
            $country = "";
        }

        if (isset($request->uid)) {
            $university = $request->uid;
        } else {
            $university = "";
        }

        if (isset($request->couid)) {
            $course = $request->couid;
        } else {
            $course = "";
        }

        if (isset($request->couid)) {
            $intake = DB::connection('mysql2')->table('uni_course')->select('course_id', 'intake')->where('uni_id', $university)->where('course_id', $course)->first();
            $months = explode(',', $intake->intake);
            $currentMonth = Carbon::now()->format('M');

            $nextIntakeMonthIndex = -1;
            foreach ($months as $index => $month) {

                // Trim the month to remove any extra spaces or characters
                $trimmedMonth = trim($month);
                if (Carbon::createFromFormat('M', $trimmedMonth)->gt(Carbon::now())) {
                    $nextIntakeMonthIndex = $index;
                    break;
                }
            }

            // If no upcoming intake month is found, set the index to the first month
            if ($nextIntakeMonthIndex === -1) {
                $nextIntakeMonthIndex = 0;
            }

            // Get the next intake month
            $nextIntakeMonth = $months[$nextIntakeMonthIndex];
            $intake_month = str_replace(' ', '', $nextIntakeMonth);
        } else {
            $intake_month = "";
        }

        return view('applyform.index', compact('country', 'university', 'course', 'intake_month'));
    }


    public function submit(Request $request)
    {
        $time = time();
        if($request->confirm == 'Yes' && !empty($request->confirm)) {
            if(isset($_FILES['con_doc']) && !empty($_FILES['con_doc'])) {
                $files = $_FILES['con_doc']['name'];
                $filter = array_values(array_filter($files));

                $total_files = count($filter);

                //Check File Size
                $maxFileSize = 5 * 1024 * 1024; //5MB
                $size = array_sum($_FILES['con_doc']['size']);

                if($size > $maxFileSize) {
                    session()->flash('error', 'File size is greater than allowed size');
                    return redirect()->back();
                } else {
                    $documents = array();
                    $file_types = ['masters','bachelor','diploma','plus_two','cv','passport','ielts','oxford','other-documents'];

                    foreach($files as $key => $fileType) {
                        if(array_key_exists($key, $file_types) && $fileType != '') {
                            $documents[$key] = 'test-documents/'.$file_types[$key].'/'.$time.'-'.$fileType;
                        }
                    }

                    foreach($documents as $key => $document) {
                        $document_main[$key] = array(
                            'document' => $document,
                            'remarks' => $file_types[$key]
                        );
                    }

                    $crm_new_documents = [];
                    foreach($document_main as $key => $innerArray) {
                        $crm_new_documents[$key] = $innerArray;
                    }

                    $document_types = array();
                    foreach($files as $key => $documentTypes) {
                        if(array_key_exists($key, $file_types) && $documentTypes != '') {
                            $document_types[$key] = $file_types[$key];
                        }
                    }

                    $values = array_values($document_types);
                    $file_type = json_encode($values);

                    $fileNames = [];

                    foreach(array_values($request->file('con_doc')) as $key => $file) {
                        $fileName = $time.'-'.$file->getClientOriginalName();
                        $file->move(public_path('images/applynow'), $fileName);
                        $fileContent = file_get_contents(public_path('images/applynow/') . $fileName);

                        //   Set cURL options
                        $filePath =  public_path('images/applynow/').$fileName;
                        $file_data = new \CURLFile($filePath);
                        $postFields = [
                        'file' => $file_data,
                        'folder' => $values[$key],
                        'file_name' => $time . '-' . $file->getClientOriginalName(),
                        ];

                        $ch = curl_init('https://mis.bizzeducation.com/backend/web/file-upload/upload-testdocument');

                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);

                        $fileNames[] = $fileName;
                    }


                    $mainfiles = json_encode($fileNames);

                }
            } else {
                $file_type = null;
                $mainfiles = null;
            }

            //Data from Form
            $date = date("Y-m-d h:i:s");
            $event_name = 'Apply Now';
            $fullname = $request->fullname;
            $phone = $request->phone;
            $email = $request->email;
            $address = $request->address;
            $passed_year = $request->passed_year;
            //$passed_y_m = date('Y',strtotime($passed_y_m));
            $qualification = $request->qualification;
            $interest_country = $request->interest_country;
            $interest_course = $request->int_course_level;
            $course_details = DB::connection('mysql2')->table('courses')->find($interest_course);
            $english = $request->english;
            $eng_score = $request->eng_score;
            $scores = $request->score;
            $university_id = $request->university;
            $university_details = DB::connection('mysql2')->table('universities')->find($university_id);
            $university = $university_id;
            $intake = $request->intake;
            $intake_year = $request->intake_year;
            $filetype = $file_type;
            $doc = $mainfiles;
            $hear_us = $request->about_us;
            $confirm = $request->confirm;

            $path = public_path('images/applynow/');

            for($key = 0; $key < $total_files; $key++) {
                if(isset($_FILES['con_doc']['name'][$key]) && $_FILES['con_doc']['size'][$key] > 0) {
                    $original_filename = $fullname.'-'.$_FILES['con_doc']['name'][$key];
                    $target = $path . basename($original_filename);
                    $tmp  = $_FILES['con_doc']['tmp_name'][$key];
                    if(move_uploaded_file($tmp, $target)):
                        $uploadok = 1;
                    endif;
                }

            }

            if($english != null) {
                if($english == '+2') {
                    $english_score = $eng_score;
                    $english_proficiency = null;
                    $english_type = null;
                    $test_score = null;
                } else {
                    $english_score = null;
                    $english_proficiency = "Yes";
                    $english_type = $english;
                    $test_score = $eng_score;
                }
            } else {
                $english_score = null;
                $english_proficiency = "No";
                $english_type = null;
                $test_score = null;
            }


            $crm_data = array(
                'fullname' => $fullname,
                'country' => $interest_country,
                'form_name' => $event_name,
                'form_from' => '6',
                'address' => $address,
                'email' => $email,
                'mobile_number' => $phone,
                'last_qualification' => $qualification,
                'score' => $scores,
                'eng_score' => $english_score,
                'english_proficiency' => $english_proficiency,
                'english_proficiency_type' => $english_type,
                'test_score_1' => $test_score,
                'course_id' => $interest_course,
                'university_id' => $university,
                'intake' => $intake,
                'intake_year' => $intake_year,
                'passed_year' => $passed_year,
                'enroll' => 'pending',
                'added_by' => '1',
                'entry_date' => $date,
            );

            $crm = DB::connection('mysql2')->table('tbl_inquiry')->insertGetId($crm_data);
            if($crm > 0) {
                if(!empty($mainfiles)) {
                    $crm_documents = array(
                        'inquiry_id' => $crm,
                        'status' => 'pending',
                        'flag' => '0',
                        'created_by' => 1,
                        'created_at' => $date
                    );

                    foreach($crm_new_documents as $crm_user_document) {
                        $crm_documentsss = (array_merge($crm_documents, $crm_user_document));
                        DB::connection('mysql2')->table('inquiry_documents')->insert($crm_documentsss);
                    }
                }
            }

            $msg = '<div style="border:1px solid grey;border-radius:10px;padding:20px;box-shadow:1px 1px 3px;">'.
            '<h2 style="color: #d21c10;">'.$event_name.'</h2>'.
            '<table>
            	<tr><td>Fullname:</td><td>'.$fullname.'</td></tr>'.
                    '<tr><td>Email:</td><td>'.$email.'</td></tr>'.
                    '<tr><td>Mobile:</td><td>'.$phone.'</td></tr>'.
                    '<tr><td>Address:</td><td>'.$address.'</td></tr>'.
                    '<tr><td>Last Qualification:</td><td>'.$qualification.'</td></tr>'.
                    '<tr><td>Scores:</td><td>'.$scores.'</td></tr>'.
                    '<tr><td>Interested Course:</td><td>'.$course_details->title.'</td></tr>'.
                    '<tr><td>Interested Country:</td><td>'.$interest_country.'</td></tr>'.
                    '<tr><td>University:</td><td>'.$university_details->name.'</td></tr>'.
                    '<tr><td>Confirmation:</td><td>'.$confirm.'</td></tr>'.
                '</table></div>';

            $thankyou = '<div style="width: 100%;background: #184087;">
            <img src="https://bizzeducation.com/img/logoextralarge.png" style="width: 50%; text-align: center;margin: auto; display: block;padding: 30px;" alt="">
            </div>
            <div style="padding:30px ;">
            	<p><b>Dear '.$request['fullname'].',</b></p>
            	<p>Thank you for your Registration</p>
            	<p>We suggest bringing the following documents while entering this event to do an easy document assessment.</p>
            	<p>1. Passport</p>
            	<p>2. All Academic Document</p>
            </div>
            <div style="padding: 30px;background: #184087;color: #fff;">
            	<p style="font-size: 20px;"><b>Bizz Education Consultancy</b></p>
            	<p style="margin: 0; padding: 0 0 5px;">Gatthaghar, Sanima Bank (3rd Floor)</p>
            	<p style="margin: 0; padding: 0 0 5px;;">Contact Number : 01-5913733, 01-5913833</p>
            	<p style="margin: 0; padding: 0 0 5px;;">Email : <a href="mailto:nepal.bizzeducationuk@gmail.com" style="color: white;">nepal.bizzeducationuk@gmail.com</a></p>
            </div>';

            $mailsec = new PHPMailer(true);
            //Server Settings
            $mailsec->isSMTP();
            $mailsec->Host = env('MAIL_HOST'); //Set the SMTP server to send through
            $mailsec->SMTPAuth = true;
            $mailsec->Username = env('MAIL_USERNAME'); //SMTP Username
            $mailsec->Password = env('MAIL_PASSWORD'); //SMTP Pasword
            $mailsec->SMTPSecure = 'tls';
            $mailsec->Port = 587;

            //Disable SSL Certificate Verification (Temporary)
            $mailsec->SMTPOptions = array(
                'ssl'=>array(
                    'verify_peer'=>false,
                    'verify_peer_name'=>false,
                    'allow_self_signed'=>true
                )
            );

            //Recipients
            $mailsec->setFrom('info@bizzeducation.com', 'Bizz Education');
            $mailsec->addAddress($email, 'Bizz Education');
            $mailsec->addReplyTo('info@bizzeducation.co.uk', 'Information');

            //Content
            $mailsec->isHTML(true);
            $mailsec->Subject = 'Thank you for your Registration';
            $mailsec->Body    = $thankyou;
            $mailsec->AltBody = $thankyou;
            $mailsec->send();

            $mail = new PHPMailer(true);
            //Server Setting
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST'); //Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME'); //SMTP Username
            $mail->Password = env('MAIL_PASSWORD'); //SMTP Pasword
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Disable SSL Certificate Verification (Temporary)
            $mail->SMTPOptions = array(
                'ssl'=>array(
                    'verify_peer'=>false,
                    'verify_peer_name'=>false,
                    'allow_self_signed'=>true
                )
            );

            try {
                //Recipients
                $mail->setFrom('info@bizzeducation.com', 'Bizz Education');
                $mail->addAddress('anupshk39@gmail.com', 'Bizz Education');

                //Content
                $mail->isHTML(true);
                $mail->Subject =  $event_name.'['.$fullname.']';
                $mail->Body    = $msg;
                $mail->AltBody = $msg;

                if($mail->send()):
                    session()->flash('success', 'Thank you for your Registration!!! Your message has been sent. Our team will reach you further more process.');
                    return redirect()->back();
                else:
                    session()->flash('error', 'Message could not be sent.');
                    return redirect()->back();
                endif;
            } catch (Exception $e) {
                session()->flash('error', 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Your consent is required to receive other communications from Bizz Education.');
            return redirect()->back();
        }
    }
}
