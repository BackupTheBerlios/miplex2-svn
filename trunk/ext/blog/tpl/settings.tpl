<h2>Einstellungen</h2>
Hie werden alle Einstellungen für das Blog gemacht
<form action="" method="POST">
    <table>

        <tr>
            <td>Blog Autor:</td>
            <td><input type="text" name="blog[params][author]" value="{$params.author}"/></td>
        </tr>   
        <tr>
            <td>Benachrichtungs Mail an:</td>
            <td><input type="text" name="blog[params][notifyMail]"  value="{$params.notifyMail}"/></td>
        </tr>   
        <tr>
            <td>Blog Titel:</td>
            <td><input type="text" name="blog[params][blogTitle]"  value="{$params.blogTitle}"/></td>
        </tr>   
        
        <tr>
            <td colspan="2">RSS Settings</td>
        </tr>   
        <tr>
            <td>Blog Beschreibung:</td>
            <td><input type="text" name="blog[params][description]"  value="{$params.description}"/></td>
        </tr>   
        <tr>
            <td>Blog Generator:</td>
            <td><input type="text" name="blog[params][generator]"  value="{$params.generator}"/></td>
        </tr>   
        <tr>
            <td>Managing Editor:</td>
            <td><input type="text" name="blog[params][managingEditor]"  value="{$params.managingEditor}"/></td>
        </tr>   
        <tr>
            <td colspan="2">Blog Aussehen:</td>
        </tr>   
        <tr>
            <td>Blog Kategorien:</td>
            <td><input type="text" name="blog[params][categories]"  value="{$params.categories}"/></td>
        </tr>   
        <tr>
            <td>Anzahl der Einträge auf der Startseite:</td>
            <td><input type="text" name="blog[params][countDisplay]"  value="{$params.countDisplay}"/></td>
        </tr>   
        <tr>
            <td>Anzahl der Kommentare für Sticky-Eintrag:</td>
            <td><input type="text" name="blog[params][countSticky]"  value="{$params.countSticky}"/></td>
        </tr>   
        <tr>
            <td>Wie lang soll der Eintrag sticky bleiben:</td>
            <td><input type="text" name="blog[params][durationSticky]"  value="{$params.durationSticky}"/></td>
        </tr>   
        <tr>
            <td><input type="submit" name="save" value="Speichern" /></td>
            <td><input type="reset" name="reset" value="Abbrechen"/></td>
        </tr>   
    </table>
    <input type="hidden" name="action" value="saveConfig" />
    <input type="hidden" name="part" value="Settings" />
</form>