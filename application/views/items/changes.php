<?php 
/* echo "<pre>";
print_r($getChangesItem);
echo "<pre>"; */

$history = strtotime("-1 year", time());
$noRecentUpdates = "<p>No recent changes recorded for this item.</p>";
 
if($getChangesItem['resultChangesTwoCount'] == 0 && $siteLogcheck['userDatas'][0]->userType   != 0){
    echo $noRecentUpdates;
} else { ?>

    <table class="table table-items small-table-font table-striped table-bordered table-sm changes-table" >
            <thead class="thead-dark">
                <tr>
                    
                            <th align="center">Date</th>
                            <th align="center">Change Type</th>
                            <th align="center">Details</th>
                            <?php if($siteLogcheck['userDatas'][0]->userType   == 0) { ?>
                                <th align="center" style="text-align: center">
                                    <span class="cursorpoint" ng-click="changesTabFunction(null, null)"><i class="fa  fa-plus-circle font-size-18"></i></span>
                                </th>
                            <?php } ?>
                     
                </tr>
            </thead>
            <tbody>

                <?php  
                     if(count($getChangesItem['resultChangesOne']) > 0):
                        foreach($getChangesItem['resultChangesOne'] as $row){  
                                $changeTime = strtotime($row->DateChange);
                                //echo $changeTime. "/ " .$history. "<br />";
                                if ($changeTime < $history) {
                                    echo "<tr style='background-color:#cccccc !important; display:none'><td>".date('Y-m-d', $changeTime)."</td>";
                                } else {
                                    echo "<tr><td>".date('Y-m-d', $changeTime)." </td>";
                                }
                        ?>

                            <td><?=$this->changes_model->getTheChangeType($row->ChangeType)?></td>
                            <td><?=nl2br($row->Description)?></td>

                    <?php
                                if($siteLogcheck['userDatas'][0]->userType   == 0) {
                                    echo '<td style="width:60px"> 
                                    
                                        <span class="cursorpoint icon edit-icon" ng-click="changesTabFunction('.$row->indexNum.', 2)" ><i class="fa  fa-edit font-size-18"></i></span>  
                                        <span class="cursorpoint  icon " ng-click="changesTabFunction('.$row->indexNum.', 3)" ><i class="fa fa-minus-square font-size-18"></i></span>  
                                    
                                    </td>';
                                }
                        }
                    else: 
                        echo '<td colspan= "4" > '.$noRecentUpdates. '</td>';
                    endif;  
                    ?>
                </tr>

            </tbody>
    </table>            

<?php } ?>