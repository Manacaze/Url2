<?php
include_once "../include/cabecalho.php";
//include_once("../include/menu.php");
?>
<!-- ############ PAGE START-->
<div class="padding">
    <div class="row">

      <div class="col-sm-6">
        <div class="box">
          <div class="box-header">
            <h3>Basic Pie</h3>
            <small class="block text-muted">set center, radius</small>
          </div>
          <div class="box-body">
            <div ui-jp="chart" ui-options=" {
              tooltip : {
                  trigger: 'item',
                  formatter: '{a} <br/>{b} : {c} ({d}%)'
              },
              legend: {
                  orient : 'vertical',
                  x : 'left',
                  data:['Direct','Mail','Affiliate','AD','Search']
              },
              calculable : true,
              series : [
                  {
                      name:'Source',
                      type:'pie',
                      radius : '55%',
                      center: ['50%', '60%'],
                      data:[
                          {value:335, name:'Direct'},
                          {value:310, name:'Mail'},
                          {value:234, name:'Affiliate'},
                          {value:135, name:'AD'},
                          {value:1548, name:'Search'}
                      ]
                  }
              ]
            }" style="height:300px" >
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="box">
          <div class="box-header">
            <h3>Doughnut</h3>
            <small class="block text-muted">set center and radius, tooltip display</small>
          </div>
          <div class="box-body">
            <div ui-jp="chart" ui-options="{
                tooltip : {
                  trigger: 'item',
                  formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['Direct','Mail','Affiliate','AD','Search']
                },
                calculable : true,
                series : [
                    {
                        name:'Source',
                        type:'pie',
                        radius : ['50%', '70%'],
                        data:[
                            {value:335, name:'Direct'},
                            {value:310, name:'Mail'},
                            {value:234, name:'Affiliate'},
                            {value:135, name:'AD'},
                            {value:1548, name:'Search'}
                        ]
                    }
                ]
            }" style="height:300px" >
            </div>
          </div>
        </div>
      </div>
      
    </div>
</div>

<!-- ############ PAGE END-->
<?php
include_once "../include/rodape.php";
?>