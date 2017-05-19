<?php

/**
 * This function is run to fix any unintended tab or next line characters that may be read in the database
 * It also fixes unintended formating in excel
 * @param type $str
 */
    function cleanData(&$str) {
        $str = addslashes($str);
        // force certain number/date formats to be imported as strings
    }
class ReportService extends Singleton {

 

    /**
     * This function requires a query as a parameter and uses it to download an excel file with the query information
      <<<<<<< HEAD
     * It adds tab characters between values in a row as the seperator, this may need to be set in excel to properly display the table
      =======
      >>>>>>> b3b561159249842acb17ad71b1d18656ef0d4c0f
     * @param type $result
     */    
    public function generateReports($result) {
        // filename for download
        $filename = "1Pet1Vet_Report_" . date('m_d_Y') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");

        $row = $result->fetch_assoc();
        
        echo "<table style='border-collapse: collapse;'><tr>";
        $keys=  array_keys($row);
        foreach($keys as $k) {
            echo "<td bgcolor='#ffff00' style='border : 2px solid #000;'>" . $k . "</td>";
        }
        echo "</tr>";

        do {
            $values=array_values($row);
            array_walk($values, 'cleanData');
            foreach($values as $v) {
                echo "<td style='border : 2px solid #000;'>" . $v . "</td>";
            }
            echo "</tr>";
        } while ($row = $result->fetch_assoc());
        echo "</table>";
        //end of query. Go to next query
        //exit;
    }

}
