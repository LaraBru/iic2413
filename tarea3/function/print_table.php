<?php 

function print_table($array)
{
    if ( is_array($array) )
    {
        $res = '';
        $res .= '<table class="table table-striped table-hover table-bordered">';
        for ($i = 0; $i < count($array); $i++) 
        { 
            if (count($array) != 0 && $i == 0) 
            {
                $res .= '<tr>';
                foreach ($array[$i] as $key => $value) 
                {
                    if ($key != "") 
                    {
                        $res .= '<th>' . $key . '</th>';
                    }
                }
                $res .= '</tr>';
            }
            $res .= '<tr>';
            foreach ($array[$i] as $key => $value) 
            {
                $res .= '<td>' . $value . '</td>';
            }
            $res .= '</tr>';
        }
        $res .= '</table>';
    }
    else
    {
        $res = 'No results to show';
    }
    return $res;
}
function print_one($array)
{
    if ( is_array($array) )
    {
        $res = '';
        $res .= '<table class="table table-striped table-hover table-bordered">';
        $res .= '<tr>';
        foreach ($array as $key => $value) 
        {
            if ($key != "") 
            {
                $res .= '<th>' . $key . '</th>';
            }
        }
        $res .= '</tr><tr>';
        foreach ($array as $key => $value) 
        {
            $res .= '<th>' . $value . '</th>';
        }
        $res .= '</tr>';
        $res .= '</table>';
    }
    else
    {
        $res = 'No results to show';
    }
    return $res;
}

?>