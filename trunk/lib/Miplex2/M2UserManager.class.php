<?php

/**
* DIese Klasse dient dazu, die Benutzer, die in Miplex arbeiten auf
* einer gewissen Abstraktionsebene zu verwalten
* Die Struktur lautet:
* <userManager>
*   <rights>{<right type='{value}'>Name</right>}</rights>
*   <groups>{<group>Name</group>}</groups>
*   <user></user>
* </userManager>
*
* Folgende Methoden werden bereitgestellt:
* - fetchGroups()
* - addGroup()
* - deleteGroup()
* - saveGroup()
* - fetchGroupMembers()
*
* - fetchRights()
* - addRight()
* - deleteRight()
*
* - fetchAllUsers()
* - addUser()
* - deleteUser()
* - saveUser()
*
* Was fehlt:
* + checkUser();
* + saveRight();
* + saveGroupt();
*/
class M2UserManager
{
    
    var $xpath = null;
    var $xmlFileName = "";
    var $user = array();
    var $beautify = 0;
    var $oBeautify = null;
    var $error = array(
                    "Creation of a new Database failed!", //0
                    "Loading Database failed!", //1
                    "Saving Database failed!", //2
                    "Desired Group does not exist!", //3
                    "Desired User does not exist!", //4
                    "Failed to add User, submitted group does not match any existing group!", //5
                    "Database Structure is invalid!", //6
                    "Failed to add User, submitte parametes are not sufficient", //7
                    "Failed to add User", //8
                    "Failed to add Group", //9
                    "Failed to add Right", //10
                    "Failed to delete Group", //11
                    "Updating User failed" //12
                    );
    var $displayAllErrors = true;
    var $lastErrors = array();
    var $rights = array();
    var $rightTypes = array("integer", "string", "boolean");
    var $groups = array();
    
    /**
    * Der Konstruktor dient dazu die Klasse zu initialisieren und
    * die vorhandenen benutzer zu laden, falls keine Datenbank angelegt
    * ist, wird automatisch eine neue erstellt. Der einfachheit halber wird
    * eine referenz auf ein XPath Objekt �bergeben.
    *
    * @param    String  $xmlFile    Der Pfad zur XML Datenbank der Benuzer
    * @param    XPath   $xpath      Eine Referenz auf das XPath Objekt
    * @param    BeautifyXML $bf     Eine Referenz auf ein BeautifyXML Objekt
    */
    function M2UserManager($xmlFile, $xpath, $bf = null)
    {
        if (empty($xmlFile))
            return false;
        
        if (!is_object($xpath))
            return false;
            
        $this->xmlFileName = $xmlFile;
        $this->xpath = $xpath;
        $this->oBeautify = $bf;
        
        //check if we need to create a new Database
        if (!is_file($this->xmlFileName))
        {
            
            if ($this->createNewDatabase() == false) {
                
                $this->reportError(0);
            
            } 
                
        } else {
             
            if (!$this->loadDatabase()) {
                
                $this->reportError(1);
            }
            
        }
    }
    
    /**
    * Diese Funktion wird benutzt um eine neue Benutzerdatenbank anzulegen
    * dabei wird die vorbestimmte XML Struktur �bernommen
    *
    */
    function createNewDatabase()
    {
        //at first prepare the basic nodes
        $basic = "
                <userManager>
                    <rights />
                    <groups />
                </userManager>
                ";
        
        //Now import xml string into xpath object an then save
        $newDB = $this->xpath->importFromString($basic);
        if ($newDB != false)
            return $this->saveDatabase();
        else 
        {
            //report error
            $this->reportError(2);
            return false;
        }
    }
    
    /**
    * Diese funktion speichert den aktuellen Zustand der Datenbank in dem
    * in $this->xmlFileName �bergebenen Pfad ab. Falls gew�nscht wird
    * der Quelltext der XML Datei neu formatiert.
    */
    function saveDatabase()
    {
        //now fetch xml and write to file
        $content = $this->xpath->exportAsXml();
        
        //beautify??
        if ($this->beautify == 1 && is_object($this->oBeautify))
            $content = $this->oBeautify->formatXML($content);
        
        $fh = fopen($this->xmlFileName, "w");
        $bytes = fwrite($fh, $content);
        fclose($fh);
        
        if ($bytes > 0)
            return true;
        else  {
            
            $this->reportError(2);  
            exit(0);
            return false;
        }
        
    }
    
    /**
    * Diese Funktion l�dt die in der XML Datei vorhandene Struktur in das interne
    * XPath Objekt.
    * @todo remove empty databse
    */
    function loadDatabase()
    {
        $this->xpath->reset(); 
        if ($this->xpath->importFromFile($this->xmlFileName)) {
            
            $ret = $this->fetchRights();
            $ret = $ret==true ? $this->fetchGroups() : false;
            
            $this->fetchAllUsers();
            
            return true;
            
        } else {
            
            $this->reportError(1);
            exit();
            return false;
        }
    }
    
    /**
    * Diese Funktion extrahiert aus der XML Struktur die m�glichen Rechte
    * Die Vorgehensweise orientiert sich an der oben definierten Struktur
    */
    function fetchRights()
    {
        //evalutate basic structure
        $rights = $this->xpath->evaluate("/userManager[1]/rights[1]/right");
        if ($rights == false)    
        {
            return true;
            
        } else {
            
            //Evaluate each right
            foreach ($rights as $right) {
                
                $sr = $this->xpath->evaluate($right);
                $this->rights[$this->xpath->getData($sr[0])]=$this->xpath->getAttributes($sr[0], "type");                
            	
            }
                
            return true;
        }
    }
    
    
    function getGroupRights($groupName)
    {
        $group = $this->getGroup("name", $groupName);
        $r = array();
        
        foreach ($group['rights'] as $sr) {
            
            $r[] = $sr['name'];
        	
        }
        
        return $r;
    }
    
    function getGroups()
    {
        $r = array();
        foreach ($this->groups as $sg) {
        	$r[] = $sg['name'];
        }
        return $r;
    }
    
    /**
    * Diese Funktion extrahiert aus der XML Struktur die m�glichen Gruppen
    * Die Vorgehensweise orientiert sich an der oben definierten Struktur
    */
    function fetchGroups()
    {
        //evalutate basic structure
        $this->groups = array();
        $groups = $this->xpath->evaluate("/userManager[1]/groups[1]/group");
        if ($groups == false)    
        {
            return true;
            
        } else {
            
            //Evaluate each right
            foreach ($groups as $group) {
                $tmpGroup = array();
                //fetch groupattributes
                $groupAttr = $this->xpath->getAttributes($group);
                $tmpGroup['name'] = $groupAttr["name"];
                
                //fetch righs for this group
                $groupRights = $this->xpath->evaluate($group."/right");
                if ($groupRights != false)
                {  
                    foreach ($groupRights as $gr) {
                    	$rightAttributes = $this->xpath->getAttributes($gr);
                    	$tmpGroup['rights'][] = $rightAttributes;
                    }
                }
                
                $this->groups[]=$tmpGroup;
            	
            }
            
            return true;
        }
    }
    
    /**
    * This function will fetch all users from the databse
    * and will store them in the local array.
    *
    */
    function fetchAllUsers()
    {
        $this->user = array();
        $evalUsers = $this->xpath->evaluate("/userManager[1]/user");
        if (!empty($evalUsers))
        {
            //Walk through all Users
            foreach ($evalUsers as $user) {
            	
                //fetch all attributes
                $attributes = $this->xpath->evaluate($user."/*");
                
                foreach ($attributes as $attribute) {
                
                    $tmp[$this->xpath->nodeName($attribute)] = $this->xpath->getData($attribute);
                    
                    
                } //EOF walk thorugh attributes
                
                //Add tmp user to global array
                $tmp['path'] = $user;
                $this->user[] = $tmp;    
                
            } //EOF walk through user
        }
    }
    
    /**
    * This function adds the possibilty to search for users
    * who are in a spechia group
    *
    * @param    String    $groupName    The name of the group
    */
    function fetchGroupMembers($groupName)
    {
        if (empty($this->user))
        {
            $this->fetchAllUsers();
        }
        
        $groupMembers = array();
        
        //Walk throug all users
        foreach ($this->user as $singleUser) {
        	
            //check if user is in group
            if ($singleUser['group']==$groupName)
            {
                $groupMembers[] = $singleUser;
            }
            
        }
        
        return $groupMembers;
        
    }
    
    /**
    * Returns the desired group identified by the key submtited to this function
    * @param    String      $identifiedBy   The key
    * @param    String      $value          The value
    */
    function getGroup($identifiedBy,$value)
    {
        foreach ($this->groups as $sg) {
        	if ($sg[$identifiedBy] == $value)
        	   return $sg;
        }
        return false;
    }
    
    ########################Check Functions##########################
    /**
    *
    *
    *
    */
    function checkUser()
    {
    }
    
    
    ########################User Functions############################
    
    /**
    * Diese Funktion f�gt der Datenbank einen Benutzer hinzu. 
    * �bergeben werden alls ein Array alle relevanten Informationen
    * Rechte und Gruppenzuge�rigkeit werden separat �bergeben
    *
    */
    function addUser($userAttributes, $group)
    {
        $node = "<user>";
        
        //Zu erst die Basis Attribute eintragen
        if (!empty($userAttributes)) {
            
            foreach ($userAttributes as $attribute => $value) {
                
                $node.="<".$attribute.">".$value."</".$attribute.">\n";
            	
            }
            
        } else {
            
            $this->reportError(7);
            return false;
            
        }
        
        $node.="<group>$group</group>\n";
        //finish node
        $node.="</user>\n";
        
        //So we have added all we need and now we will submit it to our class
        if (!$this->xpath->appendChild("/userManager[1]", $node))
        {
            $this->reportError(8);
            return false;
        }
        
        //now save all
        $this->saveDatabase();
        
        return true;
        
    }
    
    /**
    * This function is meant to update the existing user identified by 
    * attribute and key. further parameter is an array with all needed
    * rights and groups.
    *
    * @param    String  $identifiedBy   Attribute
    * @param    String  $name           Key
    * @param    Array   $vars           The User array
    */
    function saveUser($identifiedBy, $name, $vars)
    {
        
        //At first delete User
        if ($this->deleteUser($identifiedBy, $name)==true)
        {
            //Add new user with all rights
            if ($this->addUser($vars['attributes'], $vars['group'])==true)
            {
                return true;
                
            } else {
                
                $this->reportError(12);
                return false;
            }
            
        } else {
            $this->reportError(12);
            return false;
        }
        
    }
    
    /**
    * This function fetches the desired user from database. As a parameter
    * the attributed is submitted by that the user is uniqly identified in
    * the databse.
    *
    * @param    String   $identifiedBy  Qualifying attribute
    * @param    String   $name          Key
    */
    function getUser($identifiedBy, $name)
    {
        if (empty($this->user))
        {
            $this->fetchAllUsers();
        }
        
        foreach ($this->user as $user) {
        	
            if (key_exists($identifiedBy, $user) && $user[$identifiedBy] == $name)
            {
                return $user;
            }
        }
        
        //nothing found...
        return false;
        
    }
    
    /**
    * This function deletes a user from the database. The user is identified
    * by his qualifying attribute and the key, that uniqly describes him.
    * @param    String      $identifiedBy   Qualifying attribute
    * @param    String      $key            Key
    */
    function deleteUser($identifiedBy, $key)
    {
        if (is_string($identifiedBy) && !empty($key))
        {
            $user = $this->getUser($identifiedBy, $key);
            if ($user != false)
            {
                if ($this->xpath->removeChild($user['path']))
                {
                    $this->saveDatabase();
                    return true;
                } else {
                    
                    $this->reportError(2);
                    return false;
                }
            } else {

                 $this->reportError(4);
                 return false;
            }
        }
    }
    
    ###################Group Functions#########################
    /**
    * This method is meant to add a new group to the DB
    * array:
    * group -
    *       - name
    *       - rights
    *            name : value
    *
    * group repository
    * @param    Array   $group  GroupAttributes
    */
    function addGroup($group)
    {
        $node="<group name='".$group['name']."'>\n";
        
        //add rights
        foreach ($group['rights'] as $right) {
            
            if (key_exists($right, $this->rights))
            {
                $node.="<right name='$right'/>\n";
            }
        	
        }
        
        $node.="</group>\n";
        
        if (!$this->xpath->appendChild("/userManager[1]/groups[1]", $node))
        {
            $this->reportError(9);
            return false;
        }
        
        $this->saveDatabase();
        return true;
    }
    
    /**
    * This method is meant to remove an existing group to the
    * group repository
    * @param    String   $group  The Groupname
    *
    * @todo check if users are in this group
    */
    function deleteGroup($group)
    {
        
        if (!in_array($group, $this->groups)) {
            
            $this->reportError(3);
            return false;
            
        } else {
            
            //fetch all groups
            $evalGroups = $this->xpath->evaluate("/userManager[1]/groups[1]/group");
            if (!empty($evalGroups))
            {
                //walk through
                foreach ($evalGroups as $gr) {
                	
                    //check name and delete if correct
                    $name = $this->xpath->getData($gr);
                    if ($name == $group) {
                        
                        if (!$this->xpath->removeChild($gr))
                        {
                            $this->reportError(11);
                            return false;
                        }
                        
                        $this->saveDatabase();
                        
                    }
                    
                }
            }
        }
    }
    
    /**
    * This method is able to change the groupname of a specific group
    * all users affected by this should be updated.
    * @param    String   $groupold   The old Groupname
    * @param    String   $groupnew   The new Name of the Group
    */
    function saveGroup($groupold, $groupnew)
    {
        //fetch all users affected by this change
    }
    
    ###################Right Functions#########################
    
    /**
    * this method is meant to supply a function to add a new kind of right
    * Submitted as a parameter has to be the name of the right and a kind of type
    * like: string, boolean, integer.
    */
    function addRight($name, $type)
    {
        //Check if right type is in defined categories
        if (!in_array($type, $this->rightTypes)) {
            
            $this->reportError("The desired right type does not match any defined type");
            return false;
            
        }
        
        if (array_key_exists($name, $this->rights))
        {
            $this->reportError("The desired right already exists");
            return false;
        }
        
        $node = "<right type='".$type."'>".$name."</right>";
        
        if (!$this->xpath->appendChild("/userManager[1]/rights[1]", $node)) {
            
            $this->reportError(10);
            return false;
        }
        
        $this->saveDatabase();
        
        return true;
        
    }
    
    /**
    * This function will delete a special right. There a two different problems to
    * handle. if no user uses this right deleting doesnt harm anybody. But if some
    * user own the desired right we should distinguis between:
    * deleting even if users own this right, an delete the user rights as well OR
    * aborting the transaction
    *
    * @param    String  $name   The Name of the right
    *
    * @todo implement function to remove all rights to be deleted from users
    */
    function deleteRight($rightToBeDeleted)
    {
        
        //Check if right exists and is not used
        $existingRights = $this->xpath->evaluate("/userManager[1]/rights[1]/right");
        if (!empty($existingRights) && $this->checkIfRightIsUsed($rightToBeDeleted) == false)
        {
            
            //Walk through array
            $exist = false;
            $path = "";
            foreach ($existingRights as $right) {
            	
                $name = $this->xpath->getData($right);
                if ($name == $rightToBeDeleted)
                {
                    $exist = true;
                    $path = $right;
                }
                
            }
            
            if ($exist == true) {
                    
                    $this->xpath->removeChild($path);
                    $this->saveDatabase();
                    
                }
            
        } else {
            
            $this->reportError("The desired right that sould be deleted does not exist or is in use!");
            return false;            
        }
        
    }
    
    function saveRight()
    {
    }
    
    /**
    * This function is a utility function to check if some right
    * is used by a user.
    *
    * @param    String  $right  The right to check
    * @todo Implement checkFunction
    */
    function checkIfRightIsUsed($right)
    {
        $exists = false;
        return $exists;
    }
    
    ##################Utility and Error Reporting #############
    /**
    * All errors reported will be catched by this method. They are pushed to an array
    * this array can be used to fetch all errors. If displayAllErrors is set to true
    * the error will be immediatly displayed. All errorstrings are saved in the global
    * error array. See above.
    * 
    * @param    Int     $nr     The number of the error
    */
    function reportError($nr)
    {
        
        if (is_string($nr)){
            $this->lastErrors[] = $nr;
        } else 
            $this->lastErrors[] = $this->error[$nr];
        
        if ($this->displayAllErrors == true)
        {
            $this->displayError();
        }
        
    }
    
    /**
    * The LAST error will be immadiatly displayed by this function
    * you can change the style of this message by your own without disabling the
    * main functionality.
    */
    function displayError()
    {
        $div = "<div class='' style='padding:4px;background-color:red; font-weight:bold; border:1px solid black;'>".array_pop($this->lastErrors)."</div>";
        print($div);
    }
}

?>
