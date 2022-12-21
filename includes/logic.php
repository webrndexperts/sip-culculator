<?php
if(isset($_POST['investment']) && isset($_POST['return_rate']) && isset($_POST['year'])){
$investment= intval($_POST['investment']);
$annualRate= intval($_POST['return_rate']);
$years= intval($_POST['year']);
$monthlyRate=$annualRate/12/100;
$months=$years*12;
$futureValue=0;
$futureValue=$investment*((pow(1+$monthlyRate,$months)-1)/$monthlyRate)*(1+$monthlyRate);
$investment_amount=$investment*12*$years;
$est_rtn=$futureValue-$investment_amount;
 $data=array(
'invested_amount'=>intval($investment_amount),
'est_return'=>intval($est_rtn),
'total_value'=>intval($futureValue)
);
echo json_encode($data);
}
die();
?>