<!DOCTYPE html>
<html>
<head> 
<title> Social Auth by Manula</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  
  <style media="screen">
  	#fb-btn{margin-top:15px; margin-right:6px;}
  	#profile{display:none;}
  	
  </style>
  
</head>

<body>

	

	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '406744793122429',
	      cookie     : true,
	      xfbml      : true,
	      version    : 'v2.12'
	});
	
	
	FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	});      
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "https://connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));


	function statusChangeCallback(response)
	{
		if(response.status==='connected')
		{
			console.log("Logged in and Authenticated");
			setElement(true);
			testApi();
		}
		else
		{
			console.log("Not Authenticated");
			setElement(false);
		}
	}

	
	function checkLoginState() {
	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });
	}

	function setElement(isLoggedIn)
	{
		if(isLoggedIn)
		{
			//if user logged in sucessfully
			document.getElementById("liked").style.display = "block"; //show profiel details tag
			document.getElementById("fb-btn").style.display = "none";//hide login button
			document.getElementById("warnMsg").style.display = "none" //hide warning message
			document.getElementById("log_out_btn").style.display="block" //show logout bbutton

			document
		}
		else
		{
			//if user not logged in sucessfully
			document.getElementById('liked').style.display='none'; //hide profiel details tag
			document.getElementById('fb-btn').style.display='block'; //show login button
			document.getElementById('log_out_btn').style.display='none' //hide logout bbutton
			document.getElementById('warnMsg').style.display='block' //show warning message
		}
	}
	
	function logout()
	{
		FB.logout(function(response)
		{
			setElement(false);
			console.log("LoggedOut")
		});
	}

	function testApi()
	{
		FB.api('me/likes',function(response){

			console.log(response);
			buildLikes(response);

		})

	}

//function for build Like Feeds

	function buildLikes(feed)
	{
			let output = `<h4> Your Recent Activity. </h4>`

			for(let i in feed.data)
			{
				console.log(feed.data);
				if(feed.data[i].name)
				{
					output += ` <div class="well well-sm"> ${feed.data[i].name} </div>`;
				}
			}

			document.getElementById("liked").innerHTML=output;
	}
	
	</script>

		<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Retrieve Your Profile Details</a>
	    </div>
	    <ul class="nav navbar-nav">
                <li><a href="index.html">Basic Profile Details</a></li>
	    <!--  <li class="active"><a href="scope2">Scope 2 </a></li> -->
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
     	 <li id="log_out_btn"><a href="#" onclick="logout()"><span class="glyphicon glyphicon-user"></span> LogOut</a></li>
      		<!--facebook Login Button-->
			<fb:login-button 
			  id="fb-btn"
			  scope="public_profile,email"
			  onlogin="checkLoginState();">
			</fb:login-button>	
			
    	</ul>
	  </div>
	</nav>

	<div class="container">
		<h4 id='warnMsg'>Please Login to your facebook account to show details</h4>
		<div id="liked"></div>
		
	</div>


	

</body>
</html>
