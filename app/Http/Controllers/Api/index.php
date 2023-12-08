<?php


exec('python ./public/code_python/say.py', $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);


?>