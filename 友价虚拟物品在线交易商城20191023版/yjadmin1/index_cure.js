define(function (require, exports, module) {
    if($(".trend-Wrap").length > 0){
    	var _yslMonthStr = $("#yslMonthStr").val();
    	var _yslPriceStr = $("#yslPriceStr").val();
    	var yslMonthArray = new Array();
    	var yslPriceArray = new Array();
    	if(!isEmpty(_yslMonthStr) && !isEmpty(_yslPriceStr)){
    		yslMonthArray = _yslMonthStr.split(",");
    		var temp = _yslPriceStr.split(",");
    		for(var i = 0; i < temp.length;i++){
    			yslPriceArray[i] = parseFloat(temp[i]);
    		}
    	}
    	
	    require.async("highcharts.js",function(){
	            $('#newChart').highcharts({
	                chart: {
	                    type: 'spline'
	                },
	                title: {
	                    text: ''
	                },
	                xAxis: {
	                    categories: yslMonthArray,
	                    tickInterval: '2'
	                },
	                yAxis: {
	                    title: {
	                        text: ''
	                    },
	                    labels: {
	                        formatter: function() {
	                            return this.value;
	                        }
	                    }
	                },
	                tooltip: {
	                    crosshairs: true,
	                    shared: true,
	                    borderColor:'#fff',
	                    style:{
	                        fontSize: '12px',
	                        fontFamily: 'Arial, 宋体'
	                    },
	                    valuePrefix: '',
	                    valueSuffix: ''
	                },
	                plotOptions: {
	                    dashStyle:'ShortDashDotDot',
	                    spline: {
	                        lineWidth: 2,
	                        marker: {
	                            radius: 4,
	                            lineWidth: 0
	                        }
	                    }
	                },
	                exporting:{
	                    enabled:false
	                },
	                legend: {
	                    enabled:false
	                },
	                credits:{
	                    enabled: false
	                },
	                series: [{
	                    name: "注册会员",
	                    data: yslPriceArray
	
	                }]
	            });
	    });
    } 
});

function isEmpty(val) {
    var v = false;
    if (val == '' || val == 'null' || val == null || val == 'undefined'
        || val == undefined) {
        v = true;
    }
    return v;
}