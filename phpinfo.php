<body><?php
print ( (substr( strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR'])), -12 ) != 'stanford.edu') || (substr( strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR'])), -12 ) != 'berkeley.edu') );
?></body>
