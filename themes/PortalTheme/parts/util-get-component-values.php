<?php
$page_components = $fields['components'];
$values = array();
for($i=0;$i < count($page_components);$i++){

    if( ($page_components[$i]['acf_fc_layout'] === $component) && ($index == $i) ){
        array_push($values, $page_components[$i]);

        
    }
}

$values = $values[0];

?>