// window.onload = function(){

	// var currentPlaylist = array(); //php array initialization
	var currentPlaylist = []; //javascript array initialization
	var shufflePlaylist = [];
	var tempPlaylist = [];
	var audioElement;
	var mouseDown = false;
	var currentIndex = 0;
	var repeat = false;
	var shuffle = false;
	var userLoggedIn;
	var timer;

	var playButton;
	var pauseButton;


	$(document).click(function(click){
		var target = $(click.target);

		if(!target.hasClass("item") && !target.hasClass("optionsButton")){
			hideOptionsMenu();
		}
	});


	//when the window size does not a permit a scroll bar, this function does not work
	$(window).scroll(function(){
		hideOptionsMenu();
	});

	// Here, "select.playlist" looks for a select html element with class playlist
	// and when that select is changed, the we execute the proceeding function
	$(document).on("change", "select.playlist", function(){
		var playlistId = $(this).val();  //'this', here refers to what 'select' was changed to, i.e the item which was selected and the value of the 'value' attribute will be picked up.
		var songId = $(this).prev(".songId").val();  //(this).prev('songId') will not refer to the one at the top, but rather that which is the immediate previous sibling of the this referred to element
		// 'this' in here refers to 'select.playlist'

		//also, prev takes the immediate previous sibling, whilst 'prevAll' check as many previous siblings as possible

		// console.log('PlaylistId: ' + playlistId);
		// console.log('SongId: ' + songId);

		// $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId})
		// .done(function(error){

		// 	if(error != ''){
		// 		alert(error);
		// 		// return;
		// 	}

		// 	hideOptionsMenu();
		// 	$(this).val("");
		// 	// 'this' in here, refers to callback function 'done(function(error)'
		// });

	});


	function openPage(url){

		// if(timer != null){
		if(timer != ''){
			clearTimeout(timer);
		}

		if(url.indexOf("?") == -1){
			url = url + "?";
		}

		var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
		// document.querySelector('#mainContent').innerHTML = encodedUrl;

		$("#mainContent").load(encodedUrl);
		$("body").scrollTop(0); //Prevents extra scrolling of the page
		history.pushState(null, null, url); //Puts the url of the album you click on in the address bar

		// var httpRequest = new XMLHttpRequest();
		// httpRequest.open('POST', url);
		// httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		// httpRequest.send(encodedUrl);
		// httpRequest.onreadystatechange = function(data){
		// 	if (httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){

		// 		document.querySelector('#mainContent').innerHTML = httpRequest.response;
		// 		// console.log(httpRequest.responseText);
		// 		// console.log(encodedUrl);
		// 	}
		// }
	}


	function createPlaylist(){
		var popup = prompt("Please enter the name of your playlist");

		console.log(userLoggedIn);

		// if(popup != null){
		if(popup != ''){
			$.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn}).done(function(error){
				
				if(error != ''){
					alert(error);
					// return;
				}

				//do something when ajax returns
				openPage("yourMusic.php");  //This one does not work when the return statement is on
			});
			// openPage("yourMusic.php");  //This one works
		}
		// openPage("yourMusic.php");  //This one also works
	}


	function deletePlaylist(playlistId){
		var prompt = confirm("Are you sure you want to delete this playlist?");

		if(prompt == true){

			$.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId}).done(function(error){
				
				if(error != ''){
					alert(error);
					// return;
				}

				//do something when ajax returns
				openPage("yourMusic.php");  //This one does not work when the return statement is on
			});
			// openPage("yourMusic.php");  //This one works
		}
		// openPage("yourMusic.php");  //This one also works
	}

	function hideOptionsMenu(){
		var menu = $('.optionsMenu');

		if(menu.css("display") != "none"){
			menu.css("display", "none");
		}
	}

	function showOptionsMenu(button){

		var songId = $(button).prevAll(".songId").val();

		var menu = $('.optionsMenu');
		// var menu = document.querySelector('.optionsMenu');
		var menuWidth = menu.width();
		// var menuWidth = menu.clientWidth;
		menu.find(".songId").val(songId);
		// var vlf = menu.find(".songId").val();
		var vlf = menu.find(".songId");

		// var vvf = $(".optionsMenu input").val(songId);
		// var valF = menu.find(".songId").val();


		// console.log(menu.find(".songId").val());
		// console.log(vlf);
		console.log(vlf.val());
		// console.log(vvf.val());
		// console.log($(".optionsMenu input").val());
		// console.log(menu.find(".songId").val());
		// console.log(sId.val());
		console.log($(button).prevAll(".songId").val());
		console.log(vlf);

		var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
		var elementOffset = $(button).offset().top; //Distance from top of document
		// var elementOffset = document.querySelector(button).offset();

		var top = elementOffset - scrollTop;
		var left = $(button).position().left;

		menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline"  });
	}


	function formatTime(seconds){
		var time = Math.round(seconds);
		var minutes = Math.floor(time / 60);
		var seconds = time - (minutes * 60);

		// var extraZero;

		// if (seconds < 10) {extraZero = "0";}
		// else{extraZero = "";}

		var extraZero = (seconds < 10) ? "0" : "";

		return minutes + ":" + extraZero + seconds;
	}

	function updateTimeProgressBar(audio){
		document.querySelector('.progressTime.current').textContent = formatTime(audio.currentTime);
		document.querySelector('.progressTime.remaining').textContent = formatTime(audio.duration - audio.currentTime);

		var progress = audio.currentTime / audio.duration * 100;
		document.querySelector('.playbackBar .progress').style.width = progress + '%';
		// console.log(progress + "%");
	}

	function updateVolumeProgressBar(audio){
		var volume = audio.volume * 100;
		document.querySelector('.volumeBar .progress').style.width = volume + '%';
		// console.log(volume);
	}

	function playFirstSong(){
		setTrack(tempPlaylist[0], tempPlaylist, true);
	}


	function Audio(){

		this.currentlyPlaying;
		// this.audio = document.createElement = 'audio';
		this.audio = document.createElement('audio');

		this.audio.addEventListener('ended', function(){
			nextSong();
		});

		//here, 'this' refers to the object that the event was called on, hence 'audio'
		this.audio.addEventListener('canplay', function(){
			var duration = formatTime(this.duration);
			document.querySelector('.progressTime.remaining').textContent = duration;
			// document.querySelector('.progressTime.remaining').textContent = formatTime(this.duration);
		});

		this.audio.addEventListener('timeupdate', function(){
			if (this.duration) {
				updateTimeProgressBar(this);
			}
		});

		this.audio.addEventListener('volumechange', function(){
			updateVolumeProgressBar(this);
		});

		this.setTrack = function(track){
			this.currentlyPlaying = track;
			//here, 'this' refers to instance of the Audio class, so we have to say this.audio.src
			this.audio.src = track.path;
		}

		this.play = function(){
			this.audio.play();
		}

		this.pause = function(){
			this.audio.pause();
		}

		this.setTime = function(seconds){
			this.audio.currentTime = seconds;
		}
	}


	function myHttpUpdate(requestVar, url, xid, yid){
		requestVar = new XMLHttpRequest();
		requestVar.open('POST', url);
		requestVar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		requestVar.send(encodeURI(xid + yid));
	}

	

	function myHttpRequest(requestVar, url, xid, yid, selector, jsonVar, jsMethod){
		requestVar = new XMLHttpRequest();

		requestVar.open('POST', url);
		requestVar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		requestVar.send(encodeURI(xid + yid));
		requestVar.onreadystatechange = function(){
			if (requestVar.readyState === XMLHttpRequest.DONE && requestVar.status === 200) {
				// console.log('\n');
				// console.log(requestVar.responseText);

				jsonVar = JSON.parse(requestVar.responseText);
				// console.log(jsonVar.jsonAttr);
				// console.log(jsonVar);

				if (jsMethod == 'innerHTML') {
					// document.querySelector(selector).innerHTML = jsonVar.name;
					document.querySelector(selector).textContent = jsonVar.name;
					document.querySelector(selector).setAttribute('onclick', "openPage('artist.php?id=" + jsonVar.id + "')");
				}
				else if (jsMethod == 'setAttribute') {
					document.querySelector(selector).setAttribute('src', jsonVar.artworkPath);
					document.querySelector(selector).setAttribute('onclick', "openPage('album.php?id=" + jsonVar.id + "')");
					document.querySelector('.trackInfo .trackName span').setAttribute('onclick', "openPage('album.php?id=" + jsonVar.id + "')");
				}
				
			}
		}
	}


// };
