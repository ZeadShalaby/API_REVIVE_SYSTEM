<?php


/*exec('python ./public/code_python/say.py', $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);
*/
$command = escapeshellcmd('python .\public\code_python\say.py');

exec($command, $output);
print_r($output);

?>