var audiofiles = ['audio/Are your fingers curved.mp3','audio/Curve fingers.mp3','audio/Curve them up.mp3','audio/Curve them.mp3','audio/Curve your fingers.mp3','audio/Curve.mp3']

var playSounds;
var audio;

function startstop()
{		
	var text = document.getElementById("StartStop").firstChild;
	if (text.innerHTML == 'Start')
	{
		if (!validateInputValue())
		{
			return;
		}
		playAudio();
		text.innerHTML = 'Stop';
	}
	else
	{	
		clearTimeout(playSounds);
		audio.pause();
		text.innerHTML = 'Start';
	}
}

function playAudio()
{
	var delta = document.getElementById("timeDelta").value;
	delta = parseInt(delta, 10) + 2; // add two since they're all about two seconds.  Easier than blocking when you play a file. 
	
	var fileToPlay = audiofiles[Math.round(Math.random() * (audiofiles.length - 1))];
	audio.src = fileToPlay;

	audio.play();
	
	playSounds = setTimeout(playAudio, delta*1000);
}

function validateInputValue()
{
	document.getElementById("warning").innerHTML = " &nbsp; ";
	
	//Get the value to evaluate
	delta = parseInt(document.getElementById("timeDelta").value, 10);
	
	if (delta < 0 || delta > 300)
	{
		document.getElementById("warning").innerHTML = "Please enter a number from 0 to 300";
		document.getElementById("timeDelta").value = 30;
		return false;
	}
	return true;
}

window.onload=function(){
                audio = document.getElementById('sound');
				};

