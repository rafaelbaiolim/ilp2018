<?php

$content = file_get_contents('doc.txt');
$content_exp = explode(PHP_EOL, $content);
$content_exp = array_map(function ($item) {
    return strip_tags(trim($item));
}, $content_exp);

$i = 0;
$abertos = array(
    'SUBTITLE' => 0,
    'BLOCK' => 0,
    'TITLE' => 0,
);

function getBlockComplement($tp)
{
    switch ($tp) {
        case $tp == "SUBTITLE":
            return "########################";
        case $tp == "TITLE":
            return "=============================";
        default:
            return "";
    }
}


function getBlockType($type)
{
    $type = str_replace("#", '', $type);
    switch ($type) {
        case $type == 'subtitle':
            return "SUBTITLE";
        case $type == 'title':
            return "TITLE";
        default:
            return "BLOCK";

    }
}

function podeFechar($content, &$abertos, &$jProcess,$x)
{

    if (preg_match("/^##+\S+/i", $content, $matchs_footer, PREG_OFFSET_CAPTURE)) {
        $tp = getBlockType($matchs_footer[0][0]);
        if ($abertos[$tp] > 0) {
            $abertos[$tp]--;
            $jProcess += 1;
            return true;
        } else {
            throw new Exception("Bloco sem raiz .: ln {$x}");
        }
        $jProcess += 1;
    }
    return false;
}


$jProcess = 0;
$data = array();

//(^#+\S+|^/+\S+)
for ($x = 0; $x < sizeof($content_exp); $x++) {
    if (preg_match("/^#+\S+/i", $content_exp[$x], $matchs_head, PREG_OFFSET_CAPTURE)) {
        $tp = getBlockType($matchs_head[0][0]);
        $abertos[$tp]++;
        $x++;
        $data[$jProcess] = array();
        $data[$jProcess]['tp'] = $tp;
        while (!(podeFechar($content_exp[$x], $abertos, $jProcess,$x))) {
            
            if (empty($data[$jProcess]['content'])) {
                $data[$jProcess]['content'] = $content_exp[$x];
            } else {
                $data[$jProcess]['content'] .= $content_exp[$x];
            }
            if($tp == 'BLOCK'){
                $data[$jProcess]['content'] .= PHP_EOL;
                if(preg_match('#são:#i',$content_exp[$x]) || 
                preg_match('#C:#i',$content_exp[$x])
                ){
                    $data[$jProcess]['content'] .= PHP_EOL;
                }
            }

            $x++;
            if ($jProcess > sizeof($content_exp)) die('Fim arrays');
        }
    }
    $i++;
}

function getSpaces(&$doc,$x = 1){
    for($i = 0; $i < $x; $i++){
        $doc .= PHP_EOL;
    }
}

//geracao da doc
$doc = file_get_contents('index.rst');
getSpaces($doc);
foreach($data as $datDoc){
    $doc .= $datDoc['content'];
    getSpaces($doc);
    $doc .= getBlockComplement($datDoc['tp']);
    getSpaces($doc,3); 
}

file_put_contents('index.rst',$doc);
