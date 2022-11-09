<!-- Countdown Timer -->			  
			  <div class="text-muted text-center mt-2 mb-4">
				<form action="" method="post">
				<button name="get" id="get_btn" class="btn btn-primary mt-4" type="submit" disabled><span id="timer">Wait <span id="progressBar">10</span> Sec</span></button>
				<script>window.onload = function() {
		window.setTimeout(setDisabled, 9000);
	}
	function setDisabled() {
		document.getElementById('get_btn').disabled = false;
	}
	var timeleft = 10;
	var downloadTimer = setInterval(function(){
	 var time= document.getElementById("progressBar").innerHTML = --timeleft;
	  if(time <= 0)
		 document.getElementById("timer").innerHTML = "Get Links";
	},1000);</script>
				</form>
			  </div>