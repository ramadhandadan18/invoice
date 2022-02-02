<?php

if (!function_exists('echopre')) {

    function echopre($dt,$noExit=null,$title=null) {
        
        if($title){
            echo'<pre>';
            print_r($title);
            echo'</pre>';  
        }
        echo'<pre>';
        print_r($dt);
        echo'</pre>';
        if($noExit==null)
        exit;

    }

}

if (!function_exists('echoq')) {

    function echoq($dt) {
        echo $dt->db->last_query();exit;
    }

}

if (!function_exists('preety')) {

    function preety($dt) {
        print("<pre>".print_r($dt,true)."</pre>");exit;
    }

}



if (!function_exists('printq')) {

    function printq($dt) {
        print_r($dt);echo "<br>";
    }

}

if (!function_exists('month')) {
    function month($bulane,$upper=null) {
        $namabln = "Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember";
        $arrybln = explode(" ", $namabln);
        if($upper){
        return strtoupper($arrybln[$bulane - 1]);
        }else
        echo $arrybln[$bulane - 1];
    }
}

if (!function_exists('convromawi')) {
    function convromawi($angka) {
        $romawi = "I II III IV V VI VII VIII IX X";
        $arrayrom = explode(" ", $romawi);
        return $arrayrom[$angka - 1];
    }
}

if (!function_exists('lang')) {
    function lang($ind, $eng) {
        return "<span class='change_lang_eng'>$eng</span><span class='change_lang_ina hidden'>$ind</span>";
    }
}
// by Zulhisan
if (!function_exists('fixingURL')) {
   function fixingURL($targetUrl=""){
    $host = ((isset($_SERVER['HTTP_ACCEPT_ENCODING']) && ($_SERVER['HTTP_ACCEPT_ENCODING'] == "gzip, deflate, br" || $_SERVER['REQUEST_SCHEME']=="http")) ? "http" : "https");
    $url = str_replace("https","",str_replace("http","",base_url($targetUrl)));
        if(substr($url,0,1)!=":")
            $url =":".$url;
          return $host.$url;
   }
}

if (!function_exists('cekFile')) {
    function cekFile($fileurl){
        $file_headers = @get_headers($fileurl);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
             return false;
        }
        else {
             return true;
        } 
    }
}


if (!function_exists('print_r_reverse')) {
    function print_r_reverse($output)
    {
    $output = trim($output);
    $expecting = 0; // 0=nothing in particular, 1=array open paren '(', 2=array element or close paren ')'
    $lines = explode("\n", $output);
    $result = null;
    $topArray = null;
    $arrayStack = array();
    $matches = null;
    while (!empty($lines) && $result === null)
    {
        $line = array_shift($lines);
        $trim = trim($line);
        if ($trim == 'Array')
        {
            if ($expecting == 0)
            {
                $topArray = array();
                $expecting = 1;
            }
            else
            {
                trigger_error("Unknown array.");
            }
        }
        else if ($expecting == 1 && $trim == '(')
        {
            $expecting = 2;
        }
        else if ($expecting == 2 && preg_match('/^\[(.+?)\] \=\> (.+)$/', $trim, $matches)) // array element
        {
            list ($fullMatch, $key, $element) = $matches;
            if (trim($element) == 'Array')
            {
                $topArray[$key] = array();
                $newTopArray =& $topArray[$key];
                $arrayStack[] =& $topArray;
                $topArray =& $newTopArray;
                $expecting = 1;
            }
            else
            {
                $topArray[$key] = $element=="''"?"":$element;
            }
        }
        else if ($expecting == 2 && $trim == ')') // end current array
        {
            if (empty($arrayStack))
            {
                $result = $topArray;
            }
            else // pop into parent array
            {
                // safe array pop
                $keys = array_keys($arrayStack);
                $lastKey = array_pop($keys);
                $temp =& $arrayStack[$lastKey];
                unset($arrayStack[$lastKey]);
                $topArray =& $temp;
            }
        }
        // Added this to allow for multi line strings.
        else if (!empty($trim) && $expecting == 2)
        {
        // Expecting close parent or element, but got just a string
            $topArray[$key] .= "\n".$line;
        }
        else if (!empty($trim))
        {
            $result = $line;
        }
    }

    $output = implode("\n", $lines);
    return $result;
}
}


if (!function_exists('nfe')) {
    //set Number Format by Export
    function nfe($n = ''){
        if(array_key_exists('export',$_GET))
        return ($n === '') ? '' : ($_GET['export']?$n:number_format($n));
        else
        return $n;
    }

}

//ZAJ CONV. AFDELING ex 1 => A
if (!function_exists('convabjad')) {
    function convabjad() {
        $huruf =  range('A','Z');
        array_unshift($huruf,"-");
        return $huruf;
    }
}

if (!function_exists('convangka')) {
    function convangka() {
        $angka =  range(1,20);
        array_unshift($angka,"-");
        return $angka;
    }
}

if (!function_exists('getmapAfd')) {
    function getmapAfd($afd) {
        $text = array();
        if($afd!=""){
            $fname = 'conv'.strtolower($afd);
            if (function_exists($fname)) {
                $text =  call_user_func($fname);
            }
        }
        return  $text;
    }
}


?>