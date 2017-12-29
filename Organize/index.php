<!DOCTYPE html>
<html>
<head>
<title>INAM | Temperatura</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->
<!-- Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!-- Style -->
<!-- JavaScript -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!-- Javascript -->

<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>

</head>
</head>
<body onload="startTime()">

<!--Localização do dispositivo -->
 <script>
      $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
         .done (function(location)
         {
            $('#country').html(location.country_name);
            $('#state').html(location.state);
            $('#city').html(location.city);
            $('#ip').html(location.IPv4);               
         });
    </script>
<h1>&nbsp;</h1>

<div class="content">

	<div class="place">

		<div id="txt"></div>

		<div class="dmy">
			<script type="text/javascript">
               var mydate=new Date()
               var year=mydate.getYear()
               if(year<1000)
                 year+=1900
                 var day=mydate.getDay()
                 var month=mydate.getMonth()
                 var daym=mydate.getDate()
               if(daym<10)
                 daym="0"+daym
                 var dayarray=new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sabado")
                 var montharray=new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Augusto","Septembro","Outubro","Novembro","Dezembro")
                 document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")
            </script>
        </div>
       
        <div class="day">
            
            <div class="sat">
                <h3>Sat</h3>
                <p>19°C↓  22°C↑</p>
            </div>

            <div class="sund">
                <h3>Sun</h3>
                <p>17°C↓ 20°C↑</p>
            </div>

            <div class="mon">
                <h3>Mon</h3>
                <p>15°C↓ 18°C↑</p>
            </div>

            <div class="clear"></div>

        </div>
        <div class="city">
        <p><span id="country"></span>, <span id="city"></span></p>
        </div>

	

	
<div class="footer">
     <p>Copyright &copy; 2017 INAM. All Rights Reserved |</p>
</div>
</body>
</html>