<?php
    /**
     * This downloads and extracts the latest version of wordpress in a directory.
     * @author Aaron Professorval
     * @see www.professorval.com
     * @version 1.0
     * 
     */
    set_time_limit(0);
    $url = "https://wordpress.org/latest.zip";
    
    $fp = fopen (dirname(__FILE__) . '/wordpress.zip', 'w+');
    $ch = curl_init(str_replace(" ","%20",$url));
    
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    curl_setopt($ch, CURLOPT_FILE, $fp); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if(curl_exec($ch)){
        $zip = new ZipArchive;
        $res = $zip->open('wordpress.zip');
        if ($res === TRUE) {
          $zip->extractTo('./');
          $zip->close();
          //echo 'Wordpress downloaded successfully!';

          $files = scandir("wordpress");
          $oldfolder = "wordpress/";
          $newfolder = "./";
          foreach($files as $fname) {
              if($fname != '.' && $fname != '..') {
                  rename($oldfolder.$fname, $newfolder.$fname);
              }
          }

          //--Delete the empty wp folder
          rmdir("wordpress");

          //--Delete the wordpress.zip file
          unlink("wordpress.zip");

          echo 'Wordpress downloaded successfully!';

        } else {
          echo 'Wordpress not downloaded!';
        }
    } 
    curl_close($ch);
    fclose($fp);
?>
