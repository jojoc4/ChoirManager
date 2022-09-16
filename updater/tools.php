<?php
function tableExists($pdo, $table) {

    // Try a select statement against the table
    // Run it in try-catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM {$table} LIMIT 1");
    } catch (Exception $e) {
        // We got an exception (table not found)
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

function needsUpdate($pdo, $version){
    if(!tableExists($pdo, "config")) return true;
    if($version != $pdo->query("SELECT * FROM config WHERE name='VERSION'")->fetch(PDO::FETCH_ASSOC)['value']) return true;
    return false;
}

function folder_name($name){
    $name = str_replace(" ", "_", $name);
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
    );
    $name = preg_replace(array_keys($utf8), array_values($utf8), $name);
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    $name=strtolower($name);
    $name[0]=strtoupper($name[0]);
    return $name;
}
?>