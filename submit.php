<?php
    // Google reCAPTCHA API keys settings
    $secretKey = 'YOUR_SECRET_KEY';

    // Email Settings
    $recipientEmail = 'RECIPIENT_EMAIL_ADDRESS';

    // Assign default values   
    $postData = $valErr = $statusMsg = '';
    $status = 'error';

    // If the form is submitted 
    if (isset($_POST['submit_frm'])) {
        // Get the submitted from data
        $postData = $_POST;
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $message  = trim($_POST['message']);

        // Validate input fields
        if (empty($name)) {
            $valErr .= 'Please enter your name.<br/>';
        }
        if (empty($email || filter_var($email, FILTER_VALIDATE_EMAIL) === false)) {
            $valErr .= 'Please enter a valid email.<br/>';
        }
        if (empty($message)) {
            $valErr .= 'Please enter a message.<br/>';
        }

        // Check if submitted input data is valid
        if (empty($valErr)) {
            // Validate recaptcha response
            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                //  Google reCAPTCHA verification API Request
                $api_url = 'https://www.google.com/recaptcha/api/siteverify';
                $resq_data = array(
                    'secret' => $secretKey,
                    'response' => $_POST['g-recaptcha-response'],
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                );

                $curlConfig = array(
                    CURLOPT_URL => $api_url,
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $resq_data
                );

                $ch = curl_init();
                curl_setopt_array($ch, $curlConfig);
                $response = curl_exec($ch);
                curl_close($ch);

                // Decode JSON data of API response in array
                $responseData = json_decode($response);

                // If the reCAPTCHA API response is valid 
                if ($responseData->success) {
                    // Send email notification to the site admin
                    $to = $recipientEmail;
                    $subject ='New Contact Request Submitted';
                    $htmlContent = "
                        <h4>Contact request details</h4>
                        <p><b>Name:</b>".$name."/p>
                        <p><b>Email:</b>".$email."/p>
                        <p><b>message:</b>".$message."/p>
                    ";

                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    // Sender info header
                    $headers .= 'From:'.$name.' <'.$email.'>' . "\r\n";

                    // Send email
                    mail($to, $subject, $htmlContent, $headers);

                    $status = 'success';
                    $statusMsg = 'Thank you! Your contact request has been submitted successfully.'; 
                    $postData = '';

                }else{
                    $statusMsg = 'The reCAPTCHA verification failed, please try again.';    
                }
            }else{
                $statusMsg = 'Something went wrong, please try again.';
            }
        }else {
              $valErr = !empty($valErr)?'<br/>'.trim($valErr, '<br/>'):'';
              $statusMsg = 'Please fill all the mandatory fields:'.$valErr;
        }
    }
?>