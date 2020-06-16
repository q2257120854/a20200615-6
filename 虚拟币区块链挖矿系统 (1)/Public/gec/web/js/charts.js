/**
 * Created by Administrator on 2017/2/16.
 */
//数据处理函数
function setData(type,data){
    //type=1为分时线数据
    var dd={};
    dd.time=[];
    dd.data=[];
    for(var i=0;i<data.length;i++){
        var time=data[i].date[13]+data[i].date[14]+data[i].date[15]+data[i].date[16]+data[i].date[17];
        dd.time.push(time);
        if(data[i].danjia==""){
        }
        dd.data.push(data[i].danjia);
    }
    if(type==1){
    }
    //type=2为为其他类型的数据

}
//不同现行的请求控制
function line(id,myChart,option){
    //请求数据
    myChart.showLoading();
    $.ajax({
        type : "POST",
        url : "{:U('/Index.php/Home/Ajax/getgp')}",
        data : null,
        dataType : "json",
        success : function(data) {
            console.log(data);
            if(id==1){
                option.xAxis.type="line";
                option.tooltip.formatter=function (param) {
                    return param.name + '<br>' + (param.data.coord || '');
                }
            }else{
                option.xAxis.type="line";
                option.tooltip.formatter=function (param) {
                    return param.name + '<br>' + (param.data.coord || '');
                }
            }
            option.xAxis.data=[];
            option.yAxis.data=[];
            myChart.setOption(option);
        },
        error:function(){
            $.alert("网络错误");
        },
        complete:function(){
            myChart.hideLoading();
        }
    });
}

$(function(){
//获取图表
    var myChart = echarts.init(document.getElementById('main'));
//    商城配置信息
    var option={
        //背景颜色
        backgroundColor:'#EFEFF4',
        //提示框设置
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                animation: true,
                lineStyle: {
                    color: '#376df4',
                    width: 2,
                    opacity: 1
                }
            }
        },
        //数据轴设置
        xAxis: {
            type: 'line',
            data: [],
            axisLine: { lineStyle: { color: '#8392A5' } }
        },
        //坐标轴设置
        yAxis: {
            scale: true,
            data:[],
            axisLine: { lineStyle: { color: '#8392A5' } },
            splitLine: { show: false }
        }
    }
    //        高亮设置
    $("#lineType a").bind("click",function(){
        $("#lineType a").removeClass("active");
        $(this).addClass('active');
        line($(this).attr("data-id"),myChart,option);
    });
//请求数据
})
