<?php

    include 'connection.php';


$tsql= "SELECT * FROM faker.wards";
$getResults= sqlsrv_query($con,$tsql);
// echo ("Reading data from table" . PHP_EOL);
// if ($getResults == FALSE)
//     die(FormatErrors(sqlsrv_errors()));
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    echo ($row['id'] . " " . $row['wardname'] . " " . $row['charges'] . PHP_EOL);

}
sqlsrv_free_stmt($getResults);