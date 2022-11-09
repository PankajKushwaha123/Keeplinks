<!-- Link Container with Password Box if enabled. -->	
		<?php 
			if($links['status']=='blocked'){
				echo '<i class="fa fa-ban"></i> This link has been blocked by the User.<br>You can Request the user to Unblock this.';
			} elseif($links['status']=='removed'){
				echo '<i class="fa fa-unlink"></i> Unfortunately, the link has been removed.';
			} else {
				if($links['password']!=''){
					echo '<div class="form-group"><form action="" method="post" autocomplete="off">
								<div class"text-muted text-center"><i class="fas fa-lock"></i> Link is protected. Please enter Password to view the links</div><br>
								<div class="form-group">
								<div class="input-group input-group-alternative">
								<input type="password" name="pass" class="form-control text-center" placeholder="Enter Password" autofocus required>
								</div>
								</div>
								<div class="text-center">
								<button name="unlock" type="submit" class="btn btn-primary"><i class="fas fa-unlock"></i> Unlock</button>
								</div>
							</form>
							</div>
					';
				} else {
				$urls = '/(http|HTTP|https|HTTPS|ftps|FTPS|ftp|FTP)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{0,10}(\/\S*)?/';   
				$string= preg_replace($urls, '<a href="$0" target="_blank" title="$0">$0</a><hr class="my-2">', $links['urls']);
				echo $string;
				}
			}
		?>