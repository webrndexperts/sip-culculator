<div class="container">
    <div class="row">

        <div class="col-md-6 col-sm-6 col-lg-6">

            <h2> <?php echo __('SIP calculator', ' sip-calculator'); ?> </h2>
            <div class="card-body">
                <form action="" method="post">
                <div class="form-group">
                    <p id="feedback"><p>

                    </div>
                    <div class="form-group">
                    <label for="investment"> <?php echo __('Monthly investment amount', ' sip-calculator'); ?>:</label>
                        <input type="number" id="investment_amount" name="investment" pattern="[0-9]+"  title="<?php echo __('please enter number only', ' sip-calculator'); ?>" value="<?php echo esc_attr($a['invested_amount_monthly']); ?>"
                            class="form-control">

                    </div>
                    <div class="form-group">
                    <label for="return"> <?php echo __('Expected return rate (in percentage)', ' sip-calculator'); ?>:</label>
                        <input type="number" id="return_rate" name="return rate" pattern="[0-9]+" title="<?php echo __('please enter number only', ' sip-calculator'); ?>" value="<?php echo esc_attr($a['estimated_return_rate']); ?>"
                            class="form-control">

                    </div>
                    <div class="form-group">
                    <label for="year"> <?php echo __('Time period (in years)', ' sip-calculator'); ?>:</label>
                        <input type="number" id="year" name="year" pattern="[0-9]+" title="<?php echo __('please enter number only', ' sip-calculator'); ?>" value="<?php echo esc_attr($a['years']); ?>"  class="form-control">

                    </div>
                    <div class="">
                        <input type="button" id="btn" class="btn btn-success" value="Calculate">

                    </div>

                </form>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th> <?php echo __('Invested amount', ' sip-calculator'); ?> </th>
                        <th><span id="print_invested_amount"> 0 </span></th>
                    </tr>
                    <tr>
                        <th> <?php echo __('Estimated Gain amount', ' sip-calculator'); ?>  </th>
                        <th><span id="print_est_return"> 0 </span></th>
                    </tr>
                    <tr>
                        <th> <?php echo __('Total amount', ' sip-calculator'); ?>  </th>
                        <th><span id="print_total_value"> 0 </span></th>
                    </tr>
                </table>

            </div>
        </div>


        <div class="col-md-6 col-sm-6 col-lg-6">
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
    </div>
</div>
<script>
var print_invested_amount = document.getElementById('print_invested_amount');
var print_est_return = document.getElementById('print_est_return');
var print_total_value = document.getElementById('print_total_value');
var btn = document.getElementById('btn');
btn.addEventListener('click', () => {
    var investment_amount = document.getElementById('investment_amount').value;
    var return_rate = document.getElementById('return_rate').value;
    var year = document.getElementById('year').value;
    document.getElementById('feedback').innerHTML="";
    document.getElementById("feedback").style.color = "white";
    if(investment_amount && return_rate && year){
    jQuery.ajax({
        url: '<?php echo Sip_Calculator_Url . "includes/logic.php"; ?>',
        method: "post",
        data: {
            investment: investment_amount,
            return_rate: return_rate,
            year: year
        },
        success: function(data) {
            data = JSON.parse(data);
            print_invested_amount.innerHTML = parseInt(data.invested_amount);
            print_est_return.innerHTML = parseInt(data.est_return);
            print_total_value.innerHTML = parseInt(data.total_value);
            /////////   starts  coding  chart /////
            var est_return = parseInt(data.est_return);
            var invested_amount = parseInt(data.invested_amount);
			var total_value = parseInt(data.total_value);
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
					['<?php echo __('Task', ' sip-calculator'); ?>', '<?php echo __('invested amount', ' sip-calculator'); ?>'],
                    ['<?php echo __('Invested amount', ' sip-calculator'); ?>', invested_amount],
                    ['<?php echo __('Estimated Gain amount', ' sip-calculator'); ?>', est_return],
					['<?php echo __('Total amount', ' sip-calculator'); ?>', total_value],
                ]);

                var options = {
                    title: '<?php echo __('SIP Pie Chart', ' sip-calculator'); ?>',
                    pieHole: 0.4,
                    slices: {
                        0: {
                            color: '#00d09c'
                        },
                        1: {
                            color: '#5367ff'
                        },
						2: {
                            color: '#146c43'
                        }

                    }
                }

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }

            /////    end coding of chart////

        }

    })
}else{
    
    document.getElementById('feedback').innerHTML="* All fields are required.";
    document.getElementById("feedback").style.color = "red";
}

});
</script>