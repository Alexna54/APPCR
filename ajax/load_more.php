 <?php
 error_reporting(0);
 
 $p = $_POST['p'];
 
 $xml = file_get_contents('http://www.cuantarazon.com/ultimos/p/'.$p);
 $xml = substr($xml, strpos($xml, "\n")+1);
 
 $doc = new DOMDocument();
 $doc->loadHTML($xml);
 
 $node = $doc->documentElement;
 
 $data = array();
 recorrer($node, $data);
 echo json_encode($data);
 
 function recorrer($node, &$data) {
     
     if ($node->nodeType == 1) {
         
         if ($node->getAttribute('class') == 'crlink') {
             $data[] = historieta($node);
         } else {
             foreach ($node->childNodes as $child) 
                 recorrer($child, $data);
         }
     }
     
 }
 
 function historieta($node) {
     $src = $node->childNodes->item(0)->getAttribute('src');
     $md5 = md5($src);
     if (!file_exists('cr/original/'.$md5)) {
         copy($src, 'cr/original/'.$md5);
     }
     return $md5;
 }
 
 
 ?>
 
 
