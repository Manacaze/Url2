<!-- ############ PAGE START-->
<div class="p-a white lt box-shadow">
    <div class="margin">
        <h5 class="m-b-0 _300">Ola, Bem Vindo ao Sistema</h5>
        <small class="text-muted">Descricao da pagina</small><br/>
    </div>
</div>
<div class="padding">
    <div class="row">

      <div class="col-sm-6">
        <div class="box">
          <div class="box-header">
            <h3>Basic Column</h3>
            <small class="block text-muted">label, animation</small>
          </div>
          <div class="box-body">
            <div ui-jp="chart" ui-options=" {
              tooltip : {
                  trigger: 'axis'
              },
              legend: {
                  data:['Sale','Market']
              },
              calculable : true,
              xAxis : [
                  {
                      type : 'category',
                      data : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                  }
              ],
              yAxis : [
                  {
                      type : 'value'
                  }
              ],
              series : [
                  {
                      name:'Sale',
                      type:'bar',
                      data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                      markPoint : {
                          data : [
                              {type : 'max', name: 'Max'},
                              {type : 'min', name: 'Min'}
                          ]
                      },
                      markLine : {
                          data : [
                              {type : 'average', name: 'Average'}
                          ]
                      }
                  },
                  {
                      name:'Market',
                      type:'bar',
                      data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                      markPoint : {
                          data : [
                              {name : 'Max', value : 182.2, xAxis: 7, yAxis: 183, symbolSize:18},
                              {name : 'Min', value : 2.3, xAxis: 11, yAxis: 3}
                          ]
                      },
                      markLine : {
                          data : [
                              {type : 'average', name : 'Average'}
                          ]
                      }
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
            <h3>Basic bar</h3>
            <small class="block text-muted">inverted axes</small>
          </div>
          <div class="box-body">
            <div ui-jp="chart" ui-options="{
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['2011', '2012']
                },
                calculable : true,
                grid : {
                  x: 60
                },
                xAxis : [
                    {
                        type : 'value',
                        boundaryGap : [0, 0.01]
                    }
                ],
                yAxis : [
                    {
                        type : 'category',
                        data : ['Brasil','Indonesia','USA','India','China','World(M)']
                    }
                ],
                series : [
                    {
                        name:'2011',
                        type:'bar',
                        data:[18203, 23489, 29034, 104970, 131744, 630230]
                    },
                    {
                        name:'2012',
                        type:'bar',
                        data:[19325, 23438, 31000, 121594, 134141, 681807]
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