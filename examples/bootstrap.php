<?php

error_reporting(E_ALL | E_STRICT);

define('DBC_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);
define('DBC_EXPORTERS_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'exporters' . DIRECTORY_SEPARATOR);

require DBC_DIR . 'IDBCExporter.php';
require DBC_DIR . 'DBC.php';
require DBC_DIR . 'DBCException.php';
require DBC_DIR . 'DBCIterator.php';
require DBC_DIR . 'DBCMap.php';
require DBC_DIR . 'DBCRecord.php';

require DBC_EXPORTERS_DIR . 'DBCDatabaseExporter.php';
require DBC_EXPORTERS_DIR . 'DBCJSONExporter.php';
require DBC_EXPORTERS_DIR . 'DBCXMLExporter.php';
