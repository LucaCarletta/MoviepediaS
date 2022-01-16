<?php
 function logger($log_msg, $log_author) {
        
        // define the folder name where log file will be creates
        $log_folder_name = "../logs";
        //X = time, 
				$log_msg=strftime("%X").' '.htmlspecialchars($log_author). ': '. htmlspecialchars($log_msg);
        // check if folder exists or not
        if (!file_exists($log_folder_name)) {
            // create directory where log file will be created
            mkdir($log_folder_name, 0777, true);
        }
				
        // create name of a log file with the current date
        $log_file_data = $log_folder_name.'/log_' . date('d-M-Y') . '.log';

        // if you don't add FILE_APPEND, the file will be erased each time when you add a log
        file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
        
        return;
    } 
?>