<?php 

function print_table($array)
{
    if ( is_array($array) )
    {
        echo '<table class="table table-striped table-hover table-bordered">';
        for ($i = 0; $i < count($array); $i++) { 
            if ($i == 0) {
                echo '<tr>';
                foreach ($array[$i] as $key => $value) {
                    echo '<th>' . $key . '</th>';
                }
                echo '</tr>';
            }
            echo '<tr>';
            foreach ($array[$i] as $key => $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    else
    {
        echo 'No results to show';
    }
}

?>