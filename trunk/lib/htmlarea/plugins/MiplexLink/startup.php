<?php



function getAll()
{
    //Include MiplexConfig
    $config = file_get_contents("../../../../config/config.ser");
    require_once("../../../../lib/Miplex2/MiplexConfig.class.php");
    $oConfig = unserialize($config);
    
    ini_set("include_path", ini_get("include_path").":".$oConfig->fileSystemRoot."lib/Miplex2/:".$oConfig->fileSystemRoot."lib/XPath/");
    require("MiplexDatabase.class.php");
    
    $oConfig->contentDir = "../../../../".$oConfig->contentDir;
    
    $mdb = new MiplexDatabase($oConfig, 1);
    $structure = $mdb->getSiteStructure();
    
    //Nun die Struktur auslesen und array bauen
    $o = "<ul>";
    foreach ($structure as $ele)
    {
       $o.="<li>";
       $o.= "<a href='?path=".$oConfig->docroot.$oConfig->baseName."/".$ele->path."' >". $ele->attributes['name'] . "</a>";
       if ($ele->hasChildPage==1)
            $o.=rec($ele->subs, $oConfig);

       $o.="</li>";

    }
    $o.="</ul>" ;

    return $o;
}

function rec($site, $oConfig)
{
    $o = "<ul>";
    foreach ($site as $ele)
    {
       $o.="<li>";
       $o.= "<a href='?path=".$oConfig->docroot.$oConfig->baseName."/".$ele->path."' >". $ele->attributes['name'] . "</a>";
       if ($ele->hasChildPage==1)
            $o.=rec($ele->subs);
       $o.="</li>";
    }
    $o.="</ul>" ;
    return $o;
}

function getCe()
{
    function getRequestedPage($tmpUri, $site)
    {
        //Das Array ist der Pfad zu dem richtigen Page Object

        $tmpUri = array_reverse($tmpUri);
        $error = false;

        while (!empty($tmpUri) && $error != true)
        {
            //Get requested ID
            $alias =  array_pop($tmpUri);
            $id = getArrayId($site, $alias);
            $error = $id == -1 ? true : false;

            //If we are going to next level select
            if (count($tmpUri)>0 && $error != true)
            {
                $site = $site[$id]->subs;

            }

        }
        
        $retPage = $site[$id];
        return $retPage;
    }
    
    function getArrayId($pageObjects, $alias)
    {
        $matchedPO = -1;
        foreach ($pageObjects as $key => $po) {
            
            if ($po->attributes['alias']== $alias)
                $matchedPO = $key;
        }

        
        return $matchedPO;
    }



    //Include MiplexConfig
    $config = file_get_contents("../../../../config/config.ser");
    require_once("../../../../lib/Miplex2/MiplexConfig.class.php");
    $oConfig = unserialize($config);

    ini_set("include_path", ini_get("include_path").":".$oConfig->fileSystemRoot."lib/Miplex2/:".$oConfig->fileSystemRoot."lib/XPath/");
    //require("MiplexDatabase.class.php");

    $oConfig->contentDir = "../../../../".$oConfig->contentDir;
    
    $mdb = new MiplexDatabase($oConfig, 1);
    $structure = $mdb->getSiteStructure();

    //ok wir haben die Struktur, nun das CE suchen
    if (!empty($_GET))
    {
      $path = $_GET['path'];
  
  
      $path = explode("/", $path);
  
      array_shift($path);
      //für jedes / im docroot einmal shift
      $dc = explode("/", $oConfig->docroot);
      for ($i=1; $i < count($dc);$i++)
      {
            array_shift($path);

      }

      $page = getRequestedPage($path, $mdb->site);

  
      $ces = $page->content;
      $o="<ul>";
      foreach($ces as $ley =>$ce)
      {
        $name = !empty($ce['attributes']['name'])?$ce['attributes']['name']:"(none)";
        $o.="<li><a href='?path=".$oConfig->docroot.$oConfig->baseName."/".$page->path."&key=".$ce['attributes']['alias']."'>".$name."</a></li>";
      }
      $o.="</ul>";
  
      return $o;
    }

}


?>

