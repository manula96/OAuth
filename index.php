<!DOCTYPE html>
<html>
<head> 
<title> Social Auth </title>
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
			document.getElementById("profile").style.display = "block"; //profile details
			document.getElementById("fb-btn").style.display = "none";//hide login button
			document.getElementById("warnMsg").style.display = "none" //hide warning message
			document.getElementById("log_out_btn").style.display="block" //show logout button
			document.getElementById('profImg').style.display='inline' //show profile picture of user
			document.getElementById('feed').style.display='block' //fb feed 

			document
		}
		else
		{
			//if user not logged in sucessfully
			document.getElementById('profile').style.display='none'; //hide profle details 
			document.getElementById('fb-btn').style.display='block'; //show login button
			document.getElementById('log_out_btn').style.display='none' //hide logout bbutton
			document.getElementById('warnMsg').style.display='block' //show warning message
			document.getElementById('profImg').style.display='none'; //hide profile picture
			document.getElementById('feed').style.display='none' //hide fb feed 
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
		//retrieve general profile info
		FB.api('me/?fields=id,name,email,birthday,languages,link,location,devices',function (response)
		{
			if(response && !response.error)
			{
				//function to pass the response
				console.log(response)
				buildprofile(response);
				// console.log("device : "+response.languages.data[0].name);
			}
		})

	//to retrieve the fb feed
	FB.api('me/feed',function(response){

		if(response && !response.error)
		{
			console.log(response);
			buildfeed(response);
		}

	})

	//to retrieve the profile picture
	FB.api('me?fields=picture',function(response){

		console.log(response);
		fetchpic(response);

	})


	}

//this function builds general profile information
	function buildprofile(user)
	{
	let profile = `
            <h3>Logged User : ${user.name}</h3>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-info">Facebook ID  <span style="padding-left:15px;"> : ${user.id} </span></li>
    			<li class="list-group-item list-group-item-info">E-Mail <span style="padding-left:56px;"> :${user.email}</span>	</li>
			<li class="list-group-item list-group-item-info">Link    <span style="padding-left:70px;">: <a href="${user.link}" target="_blank"> ${user.link} </a></li>
			<li class="list-group-item list-group-item-info">Birthday <span style="padding-left:43px;"> :${user.birthday}</li>
			<li class="list-group-item list-group-item-info">Location <span style="padding-left:43px;"> : ${user.location.name}</li>
			<li class="list-group-item list-group-item-info">Device <span style="padding-left:43px;"> : Android	</li>

                    </ul> `

                document.getElementById("profile").innerHTML = profile;
            }


	function buildfeed(feed)
	{
		let output=`<h4> Latest Posts </h4>`

		for(let i in feed.data)
		{
			//console.log("Feed Datas : "+feed.data);

			if(feed.data[i].message)
			{
				output += ` <div class="well"> ${feed.data[i].message}  <br/> <b><i>Created Time</b></i> : ${feed.data[i].created_time}</div> `
			}

		}

		document.getElementById("feed").innerHTML=output;
	}

	function fetchpic(pictureResponse)
	{
		console.log("Inside Fetch Function : "+pictureResponse.picture.data.url);
		

		var x = document.createElement("IMG");
    x.setAttribute("src", pictureResponse.picture.data.url);
		x.setAttribute("width","80");
		x.setAttribute("height","80");
		document.getElementById("profImg").appendChild(x);

	}
	
	</script>

		<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Retrieve your FB Profile Details</a>
	    </div>
	    <ul class="nav navbar-nav">
	      <li class="active"><a href="index.html">Basic Profile Details</a></li>
				<li ><a href="scope2.html">Scope 2 </a></li>
				
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
		<div id="profImg"></div>
		<div id="profile"></div>
		<div id="feed"></div>
	</div>


	

</body>
</html>
