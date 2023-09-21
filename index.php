<?php
    // Form Submission Script
    include_once 'submit.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Captcha v3</title>
        <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.26/dist/css/uikit.min.css" />

     <!-- Google recaptcha JavaScript API Library -->
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        function onSubmit(token){
            document.getElementById("contactForm").submit();
        }
    </script>
</head>
<body>
    <div class="uk-container uk-width-1-3@l"> <br><br><br>
    <h3 class="uk-text-center uk-text-bold">Google Captcha v3</h3>
        <form  method="POST" class="uk-form-stacked" id="contactForm">

            <!-- Status Message -->
            <?php
                if (!empty($statusMsg)) { ?>
                    <p class="status-msg <?php echo $status;?>"><?php echo $statusMsg; ?></p>
            <?php } ?>
                
            <div class="uk-margin">
                <label class="uk-form-label" for="name">Full Name</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="name" id="name" value="<?php echo !empty($postData['name'])?$postData['name']:''; ?>" type="text" placeholder="e.g ( John Doe )">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="email">Email</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="email" id="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" type="email" placeholder="e.g ( johndoe@gmail.com )">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="message">Message</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea" id="message" name="message" rows="5" placeholder="e.g ( Hello there! )" aria-label="Textarea"><?php echo !empty($postData['message'])?$postData['message']:''; ?></textarea>
                </div>
            </div>

                <input type="hidden" name="submit_frm" value="1">
                
                <!-- Submit Button with reCAPTCHA trigger -->
            <button 
                class="g-recaptcha uk-button uk-align-center uk-button-default"
                data-sitekey="YOUR_SITE_KEY"
                data-callback="onSubmit"
                data-action="submit"
             >
                Submit
            </button>
        </form>
    </div>
      
        <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.26/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.26/dist/js/uikit-icons.min.js"></script>

</body>
</html>