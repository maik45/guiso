$(function(){
	function c(){
		p();
		var e=h();
		var r=0;
		var u=false;
		l.empty();
		while(!u)
		{
			if(s[r]==e[0].weekday)
			{
				u=true
			}
			else
			{
				l.append('<div class="blank"></div>');
				r++
			}
		}
		for(var c=0;c<42-r;c++)
		{
			if(c>=e.length)
			{
				l.append('<div class="blank"></div>')
			}
			else
			{
				var v=e[c].day;
				var m=g(new Date(t,n-1,v))?'<div class="today">':"<div>";
				l.append(m+""+v+"</div>")
			}
		}
		var y=o[n-1];
		a.css("background-color",y).find("h1").text(i[n-1]+" "+t).css("margin-top", "0px");
		f.find("div").css("color",y);
		l.find(".today").css("background-color",y);
		d()
	}
	
	function h()
	{
		var e=[];
		for(var r=1;r<v(t,n)+1;r++)
		{
			e.push(
			{
				day:r,weekday:s[m(t,n,r)]
			})
		}
		return e
	}

	// Fills calendar2-weekdays
	function p()
	{
		f.empty();
		for(var e=0;e<7;e++)
		{
			f.append("<div>"+s[e].substring(0,3)+"</div>")
		}
	}

	function d()
	{
		var t;
		var n=$("#calendar2").css("width",e+"px");
		n.find(t="#calendar_weekdays2, #calendar_content2").css("width",e+"px").find("div").css({width:e/7+"px",height:e/7+"px","line-height":e/7+"px"});
		n.find("#calendar_header2").css({height:e*(1/7)+"px"}).find('i[class^="icon-chevron"]').css("line-height",e*(1/13)+"px")
	}

	// Returns the total number of days in month t
		function v(e,t)
		{
			return(new Date(e,t,0)).getDate()
		}

		function m(e,t,n)
		{
			return(new Date(e,t-1,n)).getDay()
		}

		// e = obj Date;
		function g(e)
		{
			return y(new Date)==y(e)
		}

		// e = obj Date;
		// Returns a string "yyyy/month/day"
		function y(e)
		{
			return e.getFullYear()+"/"+(e.getMonth()+1)+"/"+e.getDate()
		}

		// t = year four-digit year; n = month 1-12
		function b()
		{
			var e=new Date;
			t=e.getFullYear();
			n=e.getMonth()+1
		}
		var e=300;
		var t=2013;
		var n=9;
		var r=[];
		var i=["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
		var s=["DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO"];
		var o=["#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300","#ff3300"];
		var u=$("#calendar2");
		var a=u.find("#calendar_header2");
		var f=u.find("#calendar_weekdays2");
		var l=u.find("#calendar_content2");
		b();
		c();
		a.find('i[class^="icon-chevron"]').on("click",function(){
			var e=$(this);
			var r=function(e){
				n=e=="next"?n+1:n-1;
				if(n<1)
				{
					n=12;
					t--
				}
				else if(n>12)
				{
					n=1;
					t++
				}
				c()
			};
			if(e.attr("class").indexOf("left")!=-1)
			{
				r("previous")
			}
			else
			{
				r("next")
			}
		})})