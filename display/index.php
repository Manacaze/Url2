<html>
<head>
	<style>
	html, body {
	  width: 100%;
	  height: 100%;
	  margin: 0px;
	}

	#chartdiv {
	  width: 100%;
	  height: 100%;
	}
	</style
</head>
<body>
<script src="//www.amcharts.com/lib/3/amcharts.js"></script>
<script src="//www.amcharts.com/lib/3/pie.js"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js"></script>
<div id="chartdiv"></div>

<script>
	var chart = AmCharts.makeChart("chartdiv", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [{
    "country": "Lithuania",
    "litres": 501.9
  }, {
    "country": "Czech Republic",
    "litres": 301.9
  }, {
    "country": "Ireland",
    "litres": 201.1
  }, {
    "country": "Germany",
    "litres": 165.8
  }, {
    "country": "Australia",
    "litres": 139.9
  }, {
    "country": "Austria",
    "litres": 128.3
  }, {
    "country": "UK",
    "litres": 99
  }, {
    "country": "Belgium",
    "litres": 60
  }, {
    "country": "The Netherlands",
    "litres": 50
  }],
  "valueField": "litres",
  "titleField": "country",
  "colorField": "color",
  "balloon": {
    "fixedPosition": true
  },
  "listeners": [{
    "event": "clickSlice",
    "method": function(e) {
      var dp = e.dataItem.dataContext
      if ( dp[chart.colorField] === undefined )
        dp[chart.colorField] = "#cc0000";
      else
        dp[chart.colorField] = undefined;
        
      e.chart.validateData();
    }
  }]
});
</script>
</body>
</html>