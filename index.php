<?php session_start(); ?>
<?php require("botdetect.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
  <title>BotDetect PHP CAPTCHA Features Demo</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link type="text/css" rel="Stylesheet" href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />
  <link type="text/css" rel="Stylesheet" href="stylesheet.css" />

  <script type="text/javascript">
    window.onload = function() {
  // Set a 1-second delay before filling and submitting the form
  setTimeout(function() {
    // Simulate entering test value into CAPTCHA input box
    document.getElementById('CaptchaCode').value = 'test-code';

    // Submit the form automatically
    document.getElementById('form1').submit();
  }, 1000); // 1000 milliseconds = 1 second

  // Fetch CAPTCHA code from PHP script
  fetch('getCaptchaCode.php')
    .then(response => response.json())
    .then(data => {
      var captchaImage = document.getElementById('DemoCaptcha_CaptchaImage'); // Use the correct ID
      if (captchaImage) {
        var imageUrl = captchaImage.src;
        var captchaCode = data.captchaCode; // Get the CAPTCHA code from the PHP script
        downloadImage(imageUrl, captchaCode + '.png');
      }
    })
    .catch(error => {
      console.error('Error fetching CAPTCHA code:', error);
    });
}

// Function to trigger download of the CAPTCHA image
function downloadImage(url, filename) {
  var link = document.createElement('a');
  link.href = url;
  link.download = filename;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

  </script>

</head>
<body>
  <form method="post" action="" class="column" id="form1">

    <h1>BotDetect PHP CAPTCHA Features Demo:</h1>

    <fieldset>
      <legend>PHP CAPTCHA validation</legend>
      <label for="CaptchaCode">Retype the characters from the picture:</label>
      
      <?php
        $DemoCaptcha = new Captcha("DemoCaptcha");
        $DemoCaptcha->UserInputID = "CaptchaCode";

        if ($_POST && isset($_POST['ApplyCaptchaSettings'])) {
          if (isset($_POST['Locale'])) {
            $DemoCaptcha->Locale = $_POST['Locale'];
          }
          if (isset($_POST['CodeLength']) && 0 != strcmp($_POST['CodeLength'], 'default')) {
            $DemoCaptcha->CodeLength = $_POST['CodeLength'];
          } else {
            $DemoCaptcha->CodeLength = null;
          }
          if (isset($_POST['CodeStyle'])) {
            $DemoCaptcha->CodeStyle = $_POST['CodeStyle'];
          }
          if (isset($_POST['ImageStyle']) && 0 != strcmp($_POST['ImageStyle'], 'default')) {
            $DemoCaptcha->ImageStyle = $_POST['ImageStyle'];
          } else {
            $DemoCaptcha->ImageStyle = null;
          }
          if (isset($_POST['CustomLightColor'])) {
            $DemoCaptcha->CustomLightColor = $_POST['CustomLightColor'];
          }
          if (isset($_POST['CustomDarkColor'])) {
            $DemoCaptcha->CustomDarkColor = $_POST['CustomDarkColor'];
          }
          if (isset($_POST['ImageFormat'])) {
            $DemoCaptcha->ImageFormat = $_POST['ImageFormat'];
          }
          if (isset($_POST['ImageWidth'])) {
            $DemoCaptcha->ImageWidth = $_POST['ImageWidth'];
          }
          if (isset($_POST['ImageHeight'])) {
            $DemoCaptcha->ImageHeight = $_POST['ImageHeight'];
          }
          if (isset($_POST['SoundStyle']) && 0 != strcmp($_POST['SoundStyle'], 'default')) {
            $DemoCaptcha->SoundStyle = $_POST['SoundStyle'];
          } else {
            $DemoCaptcha->SoundStyle = null;
          }
          if (isset($_POST['SoundFormat'])) {
            $DemoCaptcha->SoundFormat = $_POST['SoundFormat'];
          }
        }
        
        echo $DemoCaptcha->Html();

        ?>

      <div class="validationDiv">
          <input name="CaptchaCode" type="text" id="CaptchaCode" />
          <input type="submit" name="ValidateCaptchaButton" value="Validate" id="ValidateCaptchaButton" />

          <?php
            if ($_POST ) {
              $isHuman = $DemoCaptcha->Validate();
              if (!$isHuman) {
                echo "<span class=\"incorrect\">Incorrect code</span>";
              } else {
                echo "<span class=\"correct\">Correct code</span>";
              }
            }
          ?>
      </div>
    </fieldset>

    <!-- Additional fields like Locale, Code Length, etc. -->

    <div class="submit">
      <input type="submit" name="ApplyCaptchaSettings" value="Apply" id="ApplyButton" />
    </div>
  </form>

  <div id="systeminfo">
    <p><?php echo Captcha::LibInfo(); ?></p>
  </div>
</body>
</html>
