<?php
namespace App\Traits;

trait ExellTrait

{  
    // todo insert data into Exell file to training it //
    protected function ReadFile_training($element){
        $http_address = public_path('code_python/dataset/');

        $filename ="training.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Academic Number', 'Name'));
      /*  foreach ($students as $student) {
            fputcsv($handle, array($student->student->academic_number, $student->student->name));
        }*/
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($http_address.$filename, $filename, $headers);


    }

    // todo insert data into Exell file to training it //
    protected function ReadFile_dioxide($element){
        $http_address = public_path('code_python/dataset/');
        $filename = "dioxide.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('co', 'o2'));
      /*  foreach ($students as $student) {
            fputcsv($handle, array($student->student->academic_number, $student->student->name));
        }*/
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($http_address.$filename, $filename, $headers);


    }

    // todo insert data into Exell file to training it //
    protected function ReadFile_weather($element){
        $http_address = public_path('code_python/dataset/');
        $filename = "weather.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('co', 'co2','o2'));
      /*  foreach ($students as $student) {
            fputcsv($handle, array($student->student->academic_number, $student->student->name));
        }*/
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($http_address.$filename, $filename, $headers);


    }

}