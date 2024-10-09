# BotDetect Captcha Dataset

The idea is to create a labeled dataset of BotDetect Captcha images.
- This can help in captcha-solving services.
- It is [highly customizable](https://captcha.com/demos/features/captcha-demo.aspx) and supports different languages.
- You can create an unlimited dataset for training models.

## How

- BotDetect provides [free code](https://captcha.com/captcha-download.html) to generate captchas and perform validation.
- We can save the captcha images with corresponding labels if we know where to look.

## 1. Set up server on localhost

I'm using a clean ubuntu installation.

```
apt update && apt upgrade
apt install apache2
apt install php libapache2-mod-php
apt install php-gd # used to create images
apt-get install php-dom
```

## 2. Move BotDetect files to the server

```
cp -r botdetect-php-captcha-component-free/bdc-php-free/v4.2.5/* /var/www/html
```

## 3. Modify CaptchaIncludes.php

- Open the `/var/www/html/botdetect-captcha-lib/botdetect/CaptchaIncludes.php` file.
- Replace the `BDC_CodeCollection::Validate` function with this:
    <details>
      <summary>Click for code</summary>
      <br>
      ```
      public function Validate($_Idcxkijedyxmg1y6y977paakc3, $_1qrcdti3d2yej6sbz7swvg95h2, $_Op7nxoxp3ee2xwxdwkkki, $_02pd2yu3k8aw6fphlazh8te5zg, $_l213eq4mg0cna6z2, $_Ocsxudjdpvrtxie975t3i = 1200 ) { if (!BDC_StringHelper::HasValue($_1qrcdti3d2yej6sbz7swvg95h2)) { return false; } if (!BDC_StringHelper::HasValue($_Idcxkijedyxmg1y6y977paakc3)) { $this->kbwl5($_1qrcdti3d2yej6sbz7swvg95h2, $_l213eq4mg0cna6z2, false, null); return false; } $_ijugle688vl9bwulnmesyq0fb1 = false; $_0moeuu48y7m7a3v464nfbs4isx = null; if ($this->wyzwe($_1qrcdti3d2yej6sbz7swvg95h2)) { $_0moeuu48y7m7a3v464nfbs4isx = $this->in8o0($_1qrcdti3d2yej6sbz7swvg95h2); $_lt1owygc3wv2qrha = true; if ($_lt1owygc3wv2qrha){ $_ovks07xo2fq2flyp = BDC_AESEncryption::Decrypt($_0moeuu48y7m7a3v464nfbs4isx->get_CaptchaCode(), $_1qrcdti3d2yej6sbz7swvg95h2); error_log('CAPTCHA Code: ' . $_ovks07xo2fq2flyp); $_ipl3u3p2w2feik645uug0 = null; if ($_Op7nxoxp3ee2xwxdwkkki == null){ $_Idcxkijedyxmg1y6y977paakc3 = BDC_StringHelper::Uppercase($_Idcxkijedyxmg1y6y977paakc3); $_ipl3u3p2w2feik645uug0 = $_ovks07xo2fq2flyp; } else { $_ipl3u3p2w2feik645uug0 = BDC_StringHelper::ConvertCharToCase($_ovks07xo2fq2flyp, $_Op7nxoxp3ee2xwxdwkkki); } if (strcmp($_Idcxkijedyxmg1y6y977paakc3, $_ipl3u3p2w2feik645uug0) == 0) { if (!$_0moeuu48y7m7a3v464nfbs4isx->HasExpired($_Ocsxudjdpvrtxie975t3i)) { $_ijugle688vl9bwulnmesyq0fb1 = true; } } } $this->kbwl5($_1qrcdti3d2yej6sbz7swvg95h2, $_l213eq4mg0cna6z2, $_ijugle688vl9bwulnmesyq0fb1, $_0moeuu48y7m7a3v464nfbs4isx); } return $_ijugle688vl9bwulnmesyq0fb1; }
      ```
    </details>
- Now, each time `Validate` gets called, it logs a message to `/var/log/apache2/error.log`. You can definitely do this somehow better.

Note: I'm not providing their source code here. You have to download it from the site.

## 4. Download files

Download the files in this repo, and move them to the `examples` folder for BotDetect.


   ``` 
      cd ~
      mkdir botdetect
      cd botdetect
      git clone https://github.com/nvdomidi/CaptchaDataset.git .
      cp index.php /var/www/html/examples/t_api-captcha~demo
      cp getCaptchaCode.php /var/www/html/examples/t_api-captcha~demo
   ```

## 5. Allow apache to access logs

```sudo usermod -aG adm www-data```


## 5. Open index.php

- You need to allow your browser to download multiple files and save them without asking for names.
- Navigate to http://localhost/examples/t_api-captcha~demo/ in your browser.
- The code will start saving files to your computer `Downloads` folder. But they will have the wrong name.

## 6. Correct file names

- Files are not named correctly. Each file has the label from the previous file created.
- Modify the path inside `rename.sh` to where your images are saved.
- Run `rename.sh`.

   ```sh rename.sh```


