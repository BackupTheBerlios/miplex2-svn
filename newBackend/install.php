<?php

// header("HTTP/1.0 401 Unauthorized"); echo "Geh doch nach Hause.";  die();

require("lib/Miplex2/MiplexConfig.class.php");

$config = new MiplexConfig();

$config->docroot = "/miplex2/";
$config->fileSystemRoot = "C:\\xampp5\\htdocs\\miplex2\\";
$config->htmlAreaDir = $config->docroot."lib/htmlarea/";
$config->imageFolder = $config->docroot."img/";
$config->libDir = "lib/";
$config->smartyDir = $config->libDir."smarty/libs/";
$config->xpathDir = $config->libDir."XPath/";
$config->tplDir = "tpl/";
$config->contentFileName = "content.xml";
$config->contentDir = "content/";
$config->miplexDir = $config->libDir."Miplex2/";
$config->theme = "grund.tpl";

$string = serialize($config);

fwrite(fopen("config/config.ser", "w"), $string);

?>