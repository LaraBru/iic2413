<?php 

require_once '../classes/Db.class.php';
require_once 'print_table.php';

$result = 'No result to return.';

if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'query2':
            if (isset($_GET['id_city'])) 
            {
                $rows = Db::getEventsLast10YearsCity($_GET['id_city']);
                $result = print_table($rows);
            }
            break;

        case 'query3':
            if (isset($_GET['username'])) {
                $rows_alert = Db::getAlertUser($_GET['username']);
                $rows_event = Db::getEventUser($_GET['username']);
                $result = '<h4>Alerts</h4>' . print_table($rows_alert) . '<h4>Events</h4>' . print_table($rows_event);
            }
    }
}

echo json_encode(['response' => $result]);

?>