{literal}
<script language="JavaScript">
	function felder_pruefen()
	{
		if(window.document.Nutzereingabe.pw.value == "") {
			alert("Bitte geben Sie das neue Passwort ein!");
			return false;
		}

		voll = true;
		anzahlFelder = 3;
		for(n = 0; n < anzahlFelder; n++)
		{
			if(window.document.Nutzereingabe.elements[n].value == "")
			voll = false;
		}
		if (!voll)
			alert("Bitte füllen Sie alle Felder aus!");

		return voll;
	}
</script>
{/literal}


<form method="post" action="?module=settings&part=user&action={$type}" name="Nutzereingabe">
<fieldset style="float: left;">
<legend>
	{if $type eq "edit"}
		Benutzer "{$oScreenName}" bearbeiten
	{else}
		Neuen Benutzer anlegen
	{/if}
</legend>
	Angezeigter Name:<br />
		<input type="text" maxLength="25" size="30" name="sn" value="{$ScreenName}" style="margin: 10px; margin-left: 25px;" /><br />
	Login-Name:<br />
		<input type="text" maxLength="12" size="30" name="ln" value="{$LoginName}" style="margin: 10px; margin-left: 25px;" /><br />
	Passwort:<br />
		<input type="password" maxLength="12" size="30" name="pw" value="" style="margin: 10px; margin-left: 25px;" /><br />

	{if $type eq "edit"}
		<input type="hidden" maxLength="25" size="12" name="osn" value="{$oScreenName}" />
	{/if}

	<input type="submit" value="Speichern" name="send" onclick="return felder_pruefen()" style="margin: 10px; margin-left: 150px;" />

</fieldset>
</form>