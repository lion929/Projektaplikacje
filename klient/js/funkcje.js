function time()
{
	var time = new Date();
	var hour = time.getHours();
	var minute = time.getMinutes();
	var second = time.getSeconds();
	
	if(hour < 10)
	{
		hour = '0' + hour;
	}
	
	if(minute < 10)
	{
		minute = '0' + minute;
	}
	
	if(second < 10)
	{
		second = '0' + second;
	}
	
	var t = hour + ':' + minute + ':' + second;
	document.getElementById("clock").innerHTML = t;
	
	setTimeout("time();", 1000);
}

function date()
{
	var months = ["stycznia", "lutego", "marca", "kwietnia","maja", "czerwca", "lipca", "sierpnia", "września", "października", "listopada", "grudnia"];
	var dayOfweek = ["Niedziela", "Poniedziałek", "Wtorek", "Środa","Czwartek", "Piątek", "Sobota"];

	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();
	var day = date.getDay();
	var dayOfmonth = date.getDate();

	if(dayOfmonth < 0)
	{
		dayOfmonth = "0" + dayOfmonth;
	}

	var displayDate = dayOfweek[day] + ", " + dayOfmonth + " " + months[month] + " " + year + " r.";

	document.getElementById("date").innerHTML = displayDate;
}

var k;

function chosen(k)
{
	var btns = document.getElementsByClassName("buttons");
		
	btns[k].style.borderBottom = "2px solid white";

	for(var i=0; i<btns.length; i++)
	{
		if(i != k)
		{
			btns[i].style.borderBottom = "none";
		}
	}
}

function disabled()
{
	var button = document.getElementById("dodaj");

	if(button.disabled == true)
	{
		button.style.cursor = "not-allowed";
	}
}

function opacity(){
	var button1 = document.getElementById("clear");
	var s = document.getElementById("szukaj");
	s.oninput = function(){
		if(s.value != ""){
			if(button1.disabled == true){
				button1.disbaled = false;
			}
			button1.style.opacity = "100%";
			button1.style.cursor = "pointer";
		}else{
			if(button1.disbaled == false){
				button1.disabled = true;
			}
			button1.style.opacity = "0%";
			button1.style.cursor = "default";
		}
	}
}

function f(){
	document.getElementById("szukaj").value = "";
	var button1 = document.getElementById("clear");
	button1.style.opacity = "0%";
	button1.style.cursor = "default";
}
