<?php
/* Algorithmus zu erstellen der Thumbs stammt von Michael Müller.
 * Herzlichen Dank an dieser Stelle.
 *
 * Näheres dazu unter 
 * http://www.php4u.net/index.php?main=codeschnipsel&source=57
 */


class Image
{
    var $folder;
    var $imgfile;
    var $counter;
    var $thumbsFolder = "/thumbs";
    var $width;
    var $height;
    
    var $fileExtension;
    var $filewoExtension;
    var $number;
    var $alt;
    var $title;
    
    function Image($folder, $imgfile)
    {
    // Objekt-Variablen laden
        $this->folder = $folder;
        
        $tmp = explode(".", $imgfile);
        
        // Datei-Endung entfernen
        $this->fileExtension = array_pop($tmp);

        $this->filewoExtension = implode(".", $tmp);

        // Nummer, alt, title ermittlen
        $tmp = explode(",", $this->filewoExtension);

        $this->number  = $tmp[0];
        $this->alt  = $tmp[1];
        $this->title  = $tmp[2];        
        
        $this->imgfile = $imgfile;
    }

    function getNumber()
    {
        return $this->number;
    }
    
    function getThumbFileName()
    {
        $thumb = $this->folder.$this->thumbsFolder."/".$this->filewoExtension."_".$this->width."x".$this->height.".".$this->fileExtension;
        $img = $this->getImageFileName();
        
    // Überprüfen, ob Thumb aktuell ist
        if(!file_exists($thumb) || @filemtime($thumb)< @filemtime($img))
        {
            // Thumb ist nicht aktuell -> Lösche den alten und erstelle einen neuen
            @unlink($thumb);
            $infos = getimagesize($img);
            
        // Seitenlängen bestimmen
            // Proportionen erhalten
            $iWidth = $infos[0];
            $iHeight = $infos[1];
            $iRatioW = $this->width / $iWidth;
            $iRatioH = $this->height / $iHeight;
            
            if ($iRatioW < $iRatioH)
            {
                $iNewW = $iWidth * $iRatioW;
                $iNewH = $iHeight * $iRatioW;
            } else {
                $iNewW = $iWidth * $iRatioH;
                $iNewH = $iHeight * $iRatioH;
            } // end if

        // Thumbs erzeugen
/**
 * GLib 1.6
 *
            if($infos[2] == 2) {
                // Bild ist vom Typ jpg
                $imgA = imagecreatefromjpeg($img);
                $imgB = imagecreate($iNewW,$iNewH);
                imagecopyresized($imgB, $imgA, 0, 0, 0, 0, $iNewW,
                                   $iNewH, $infos[0], $infos[1]);
                imagejpeg($imgB, $thumb);
            } elseif($infos[2] == 3) {
                // Bild ist vom Typ png
                $imgA = imagecreatefrompng($img);
                $imgB = imagecreate($iNewW, $iNewH);
                imagecopyresized($imgB, $imgA, 0, 0, 0, 0, $iNewW,
                                   $iNewH, $infos[0], $infos[1]);
                imagepng($imgB, $thumb);
            }
 **/
/**
 * GLib 2.0 
 **/
            if($infos[2] == 2) {
                // Bild ist vom Typ jpg
                $imgA = imagecreatefromjpeg($img);
                $imgB = imagecreatetruecolor($iNewW,$iNewH);
                imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW,
                                   $iNewH, $infos[0], $infos[1]);
                imagejpeg($imgB, $thumb);
            } elseif($infos[2] == 3) {
                // Bild ist vom Typ png
                $imgA = imagecreatefrompng($img);
                $imgB = imagecreatetruecolor($iNewW, $iNewH);
                imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW,
                                   $iNewH, $infos[0], $infos[1]);
                imagepng($imgB, $thumb);
            }
 /**/
        }

    // Übergeben, der Pfadinformationen    
        return $thumb;
    }
    
    function getImageFileName()
    {
        return $this->folder."/".$this->imgfile;
    }
    
    function getThumbTag($urlbase, $width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    
        $size = getimagesize($this->getThumbFileName());
    
        $out = "<a href=\"".$urlbase."/einzel/".$this->number.".html\">";
        $out.= "<img src=\"/".$this->getThumbFileName()."\" ".$size[3]." alt=\"".$this->alt."\" title=\"".$this->title."\" />";
        $out.= "</a>";
        return $out;
    }
    
    function getImageTag($urlbase)
    {
        $size = getimagesize ($this->getImageFileName());

        $out.= "<img src=\"/".$this->getImageFileName()."\" ".$size[3]." alt=\"".$this->alt."\" title=\"".$this->title."\" />";
        
        return $out;
    }
}


?>