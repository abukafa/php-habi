<?php 
($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", ""));
mysqli_select_db($GLOBALS["___mysqli_ston"], 'habi');

// FUNGSI DATA QUERY ROWS ------------------------------------------------------------------------------
function myquery($query){
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
// FUNGSI QUERY NUM ROWS -------------------------------------------------------------------------------
function myNumRow($query){
    global $conn;
    $myQue = mysqli_query($conn, $query);
    $numRow = mysqli_num_rows($myQue);
    return $numRow;
}
?>