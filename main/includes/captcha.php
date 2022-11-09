<!-- ReCaptcha Box -->			  
			  <div class="text-muted text-center mt-2 mb-4">
				<form action='' method='post'>
				  <div style="display: inline-block;" class="h-captcha" data-sitekey="<?php echo $settings['site_key'];?>"></div><br>
				  <button name="captcha_verify" type="submit" class="btn btn-primary">Verify Captcha</button>
				  <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
				</form>
			  </div>