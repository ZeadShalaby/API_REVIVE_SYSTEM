<?php
namespace App\Traits;

trait ExellTrait

{  
    //todo count of Orders for users
    protected function ReadFile($element){
      
        $filename = "zead.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Academic Number', 'Name'));
      /*  foreach ($students as $student) {
            fputcsv($handle, array($student->student->academic_number, $student->student->name));
        }*/
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($filename, $filename, $headers);


    }


}