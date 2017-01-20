<style>
    .accounting-reg-title{
        display: inline-block;
        text-align: center;
        width: 100%;
    }
</style>

<?php
    function calculateAmountOwed($kidCount)
    {
        $tempResult = 50 + (30 * $kidCount);

        if($tempResult > 170){
            return 170;
        }

        return $tempResult;
    }
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="dropdown">

            <div class="accounting-reg-title">
                <h2>Registration Payment</h2>

            </div>

            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Filter Results
                <span class="caret"></span>
            </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php echo form_open() ?>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="isPaid" value="0">
                                        Unpaid
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="isPaid" value="1">
                                        Paid
                                    </label>
                                    <br><br>
                                    <label>
                                        Family ID:<br>
                                        <input class="form-control" type="number" name="family_id" placeholder="Enter Family ID">
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="submit" class="btn btn-primary" value="Filter">
                            </div>
                        </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div><!-- panel-heading -->

        <div class="panel-body">

        <table class="table table-striped table-reflow">
            <thead>
                <tr>
                    <th>Family ID</th>
                    <th>Status</th>
                    <th>Amount Owed</th>
                    <th>Update Status</th>

                </tr>
            </thead>
            <tbody>
                <form action="./update_accounting" method="post" style="display: inline-block">
                    <?php
                        for($i = 0; $i < count($familyArray); $i++) {
                            echo "<tr>";
                                echo "<td>";
                                    echo $familyArray[$i]->family_id;
                                    echo "<input type=\"hidden\" name=\"rowData[row$i][family_id]\" value=" . $familyArray[$i]->family_id . "></input>";
                                echo "</td>";
                                echo "<td>";
                                    if($familyArray[$i]->isPaid == 0){
                                        echo "Unpaid";
                                        echo "<input type=\"hidden\" name=\"rowData[row$i][paid_status]\" value=\"0\">";
                                    }else{
                                        echo "Paid";
                                        echo "<input type=\"hidden\" name=\"rowData[row$i][paid_status]\" value=\"1\">";
                                    }
                                echo "</td>";
                                echo "<td>";
                                    echo "$" . calculateAmountOwed(@$kidCountsByFamilyID[$familyArray[$i]->family_id]) . ".00";
                                echo "</td>";
                                echo "<td>";
                                    if($familyArray[$i]->isPaid == 1){
                                        echo "<input type=\"checkbox\" name=\"rowData[row$i][update_payment_status]\">";
                                            echo "Change Status to Unpaid";
                                        echo "</input>";
                                    }else{
                                        echo "<input type=\"checkbox\" name=\"rowData[row$i][update_payment_status]\">";
                                            echo "Change Status to Paid";
                                        echo "</input>";
                                    }
                                echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary">Submit Changes</button>
                </form>

                <!--reset all accounts button -->
                <form action="./reset_all_accounts" method="post" style="display: inline-block"
                  onsubmit="return confirm('Are you sure you want to reset all accounts to unpaid?');">
                    <button style="margin-left: 10px;" class="btn btn-danger">Reset All Accounts to Unpaid</button>
                </form>
            </tbody>
        </table>
    </div><!-- panel-body -->
</div>
