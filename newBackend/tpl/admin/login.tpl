{assign var=i18nsection value=$i18n->getSection("login")}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset='ISO-8859-1'" />
	<title>{$i18n->get("login.title")}</title>

    <meta name="robots" content="noindex, follow" />
    <meta name="generator" content="Miplex2" />
    <style type="text/css" media="all">
{literal}
    <!--
		body{
			font-family: Tahoma, Verdana, Arial, sans-serif;
			width: 400px;
			margin:auto;
			margin-top: 100px;
		}

		h1{
			font-size: 1.2em;
			border: 0px;
			padding: 0px;
		}

		fieldset{
			text-align: center;
			margin: 0px;
			padding-top: 20px;
			padding-bottom: 20px;
			border: 1px solid lightgray;
			-moz-border-radius: 5px;
		}

		fieldset p{
			text-align: left;
		}


		label{
			text-align: right;
			float: left;
			display: block;
			width: 150px;
			padding-right: 10px;
			color: #336699;
		}

		input.text, input.password{
			border: none;
			border-bottom: 1px dotted #006699;
			color: #006699;
			padding-left: 1em;
		}

		input.submit{
			margin-top: 10px;
			width: 120px;
			height: 30px;
			padding-bottom: 3px;
			background-image: url('tpl/admin/grafiken/submit120.gif');
			background-color: green;
			color: white;
			font-weight: bold;
			border: none;
		}

		input.submit:hover{
			background-position: 0px 30px;
		}

		legend{
			color: brown;
			font-weight: bold;
			font-size: 0.8em;
			background: white;
			padding: 1px 5px;
		}

		fieldset{
		}

		p{
			text-align: center;
		}

		a{
			color: #006699;
			text-decoration: none;
		}

		a:hover{
			text-decoration: underline;
		}

		#error{
			font-size: 0.8em;
			color: red;
			font-weight: bold;
			text-align: center;
		}

		#hinweis{
			font-size: 0.8em;
			color: gray;
		}
    -->
{/literal}
    </style>
</head>

<body>
	<h1>{$i18n->get("login.welcome")}</h1>
	<form method="post" action="admin.php">
		<fieldset>
			<legend>{$i18n->get("login.title")}</legend>
			<p>
				<label for="username">{$i18n->get("login.username")}:</label>
				<input class="text" type="text" name="username" id="username" value="" />
			</p>
			<p>
				<label for="password">{$i18n->get("login.password")}:</label>
				<input class="password" type="password" name="password" id="password" value="" />
			</p>
			<input class="submit" type="submit" name="send" id="send" value="{$i18n->get("login.login")}" />
			{if $error eq true}<p id="error">{$i18n->get("login.error")}</p>{/if}
		</fieldset>
	</form>
	<p id="hinweis">{$i18n->get("login.attention")}</p>
	<p>
		<a href="http://www.miplex.de">www.miplex.de</a>
	</p>
</body>
</html>