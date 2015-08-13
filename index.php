<?php
$MY_ENV = array();
$MY_ENV['complete'] = "yes"; // assume the best: we got all what we need in the form
$MY_ENV['message']  = ""; // empty to start with, might become an error message later, used in form
$MY_ENV['date']     = date('j. F Y');
if (isset($_POST['title']))       { $MY_ENV['title'] = stripslashes($_POST['title']); }
if (isset($_POST['description'])) { $MY_ENV['description'] = stripslashes($_POST['description']);}
if (isset($_POST['project']))     { $MY_ENV['project'] = stripslashes($_POST['project']);}
if (isset($_POST['version']))     { $MY_ENV['version'] = stripslashes($_POST['version']);}
if (isset($_POST['target']))      { $MY_ENV['target'] = stripslashes($_POST['target']);}
if (isset($_POST['name']))        { $MY_ENV['name'] = stripslashes($_POST['name']);}
if (isset($_POST['email']))       { $MY_ENV['email'] = stripslashes($_POST['email']);}
if (isset($_POST['date']))        { $MY_ENV['date'] = stripslashes($_POST['date']);}
if (isset($_POST['language']))    { $MY_ENV['language'] = stripslashes($_POST['language']);}
if (isset($_POST['imgurl']))      { $MY_ENV['imgurl'] = stripslashes($_POST['imgurl']);}
// check if all information filled out
if (empty($MY_ENV['language']))     { $MY_ENV['complete'] = "language"; } // we didn't get this variable, ask for it later
if (empty($MY_ENV['name']))         { $MY_ENV['complete'] = "name"; } // we didn't get this variable, ask for it later
// if (empty($MY_ENV['version'])) { $MY_ENV['complete'] = "version"; } // we didn't get this variable, ask for it later
if (empty($MY_ENV['description']))  { $MY_ENV['complete'] = "description"; } // we didn't get this variable, ask for it later
if (empty($MY_ENV['title']))        { $MY_ENV['complete'] = "title"; } // we didn't get this variable, ask for it later
// if (empty($MY_ENV['email'])) { $MY_ENV['complete'] = "email"; } // we didn't get this variable, ask for it later


// language
$l = "en";
if (isset($_POST['l'])) { $l = $_POST['l']; }
if (isset($_GET['l']))  { $l = $_GET['l']; }

// reading lang from config, read english as default
$lang = array();
include 'lang-en.php';
if(file_exists("lang-".$l.".php")) {
  include "lang-".$l.".php";
}

// creating error message, only after posting data ( isset($MY_ENV['title']) )
if (isset($MY_ENV['title']) && $MY_ENV['complete'] != "yes") { 
  $MY_ENV['message'] = "<div class='error'>".$lang['errorform']."</div>"; 
  // creating errors for form display
  if (empty($MY_ENV['language']))     { $MY_ENV['error']['language']    = "error"; } 
  if (empty($MY_ENV['name']))         { $MY_ENV['error']['name']        = "error"; } 
  if (empty($MY_ENV['description']))  { $MY_ENV['error']['description'] = "error"; } 
  if (empty($MY_ENV['title']))        { $MY_ENV['error']['title']       = "error"; } 
}

// collecting "selected" information for pulldowns and language choice in form
// this is an awkward way of doing this. I am a bit embarrassed about it. But no time to fix it.
if ($MY_ENV['project'] == "airtime")        { $MY_ENV['selected']['projairtime'] = " SELECTED"; } 
if ($MY_ENV['project'] == "booktype")       { $MY_ENV['selected']['projbooktype'] = " SELECTED"; } 
if ($MY_ENV['project'] == "newscoop")       { $MY_ENV['selected']['projnewscoop'] = " SELECTED"; } 
if ($MY_ENV['project'] == "superdesk")      { $MY_ENV['selected']['projsuperdesk'] = " SELECTED"; } 
if ($MY_ENV['project'] == "screencast")     { $MY_ENV['selected']['projscreencast'] = " SELECTED"; } 
if ($MY_ENV['project'] == "sourcefabric")   { $MY_ENV['selected']['projsourcefabric'] = " SELECTED"; } 
if ($MY_ENV['target'] == "editors")         { $MY_ENV['selected']['targeditors'] = " SELECTED"; } 
if ($MY_ENV['target'] == "template")        { $MY_ENV['selected']['targtemplate'] = " SELECTED"; } 
if ($MY_ENV['target'] == "administration")  { $MY_ENV['selected']['targadministration'] = " SELECTED"; } 
if ($MY_ENV['target'] == "trainer")         { $MY_ENV['selected']['targtrainer'] = " SELECTED"; } 
if ($MY_ENV['target'] == "screencaster")    { $MY_ENV['selected']['targscreencaster'] = " SELECTED"; }
if ($l == "en")    { $MY_ENV['selected']['langen'] = "selected"; }
if ($l == "cz")    { $MY_ENV['selected']['langcz'] = "selected"; }
if ($l == "de")    { $MY_ENV['selected']['langde'] = "selected"; }
if ($l == "es")    { $MY_ENV['selected']['langes'] = "selected"; }
if ($l == "pl")    { $MY_ENV['selected']['langpl'] = "selected"; }
if ($l == "ru")    { $MY_ENV['selected']['langru'] = "selected"; }

// adding image if URL sent
if(trim($MY_ENV['imgurl']) != "") { $MY_ENV['htmlimgurl'] = "<figure><img src=\"".$MY_ENV['imgurl']."\"></figure>"; }

$html_head = html_head();
print $html_head;

if ($MY_ENV['complete'] != "yes") {
  $html_body = html_form();
} else {
  $html_body = html_page();
}
print $html_body;
function html_head() {
  return "
  <!DOCTYPE html>
  <html>
  <head>
  	<meta charset=\"utf-8\">
  	<title>Screencast</title>
  	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|Roboto+Slab:400,100,700&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
  	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/main.css\">
  </head>";
} // end function html_head()

function html_form() {
  global $lang;
  global $MY_ENV;
  
  $return = "";
  $return .=  "<body>
	<div class=\"wrapper\">
		<div class=\"content\">
			<div class=\"title\">
				<h2>".$lang['pagetitle']."</h2>
			</div>
			".$MY_ENV['message']."
			<div class=\"language\">
				<p>".$lang['langselect']."</p>
				<ul>
          <li class=\"".$MY_ENV['selected']['langen']."\"><a href=\"index.php\" class=\"langen\">english</a></li>
          <li class=\"".$MY_ENV['selected']['langcz']."\"><a href=\"index.php?l=cz\" class=\"langcz\">czech</a></li>
          <li class=\"".$MY_ENV['selected']['langes']."\"><a href=\"index.php?l=es\" class=\"langes\">spanish</a></li>
          <li class=\"".$MY_ENV['selected']['langru']."\"><a href=\"index.php?l=ru\" class=\"langru\">russian</a></li>
          <li class=\"".$MY_ENV['selected']['langpl']."\"><a href=\"index.php?l=pl\" class=\"langpl\">polish</a></li>
          <li class=\"".$MY_ENV['selected']['langde']."\"><a href=\"index.php?l=de\" class=\"langde\">german</a></li>
				</ul>
			</div>

			<form action=\"".$PHP_SELF."\" method=\"post\">
				<div class=\"formitem\">
					<label for=\"title\" class=\"".$MY_ENV['error']['title']."\">".$lang['title']."</label>
					<input name=\"title\" class=\"formlong\" value=\"".$MY_ENV['title']."\">
				</div>

				<div class=\"formitem\">
					<label for=\"description\" class=\"".$MY_ENV['error']['description']."\">".$lang['description']."</label>
					<input name=\"description\" class=\"formlong\" value=\"".$MY_ENV['description']."\">
				</div>

				<div class=\"formitem\">
					<label for=\"project\">".$lang['project']."</label>
					<select name=\"project\">
					<option value=\"airtime\"".$MY_ENV['selected']['projairtime'].">Airtime</option>
					<option value=\"booktype\"".$MY_ENV['selected']['projbooktype'].">Booktype</option>
					<option value=\"newscoop\"".$MY_ENV['selected']['projnewscoop'].">Newscoop</option>
					<option value=\"superdesk\"".$MY_ENV['selected']['projsuperdesk'].">Superdesk</option>
					<option value=\"screencast\"".$MY_ENV['selected']['projscreencast'].">Screencast</option>
					<option value=\"sourcefabric\"".$MY_ENV['selected']['projsourcefabric'].">Sourcefabric</option>
					</select>
				</div>
				
				<div class=\"formitem\">
					<label for=\"version\">".$lang['version']."</label>
					<input name=\"version\" class=\"formshort\" value=\"".$MY_ENV['version']."\">
				</div>
				
				<div class=\"formitem\">
					<label for=\"imgurl\">".$lang['imgurl']."</label>
					<input name=\"imgurl\" class=\"formlong\" value=\"".$MY_ENV['imgurl']."\">
					<!--input type=\"file\" name=\"imgurl\" accept=\"image/*\"-->
				</div>

				
				<div class=\"formitem\">
					<label for=\"name\" class=\"".$MY_ENV['error']['name']."\">".$lang['name']."</label>
					<input name=\"name\" class=\"formlong\" value=\"".$MY_ENV['name']."\">
				</div>

				<div class=\"formitem\">
					<label for=\"email\">".$lang['email']."</label>
					<input name=\"email\" class=\"formlong\" value=\"".$MY_ENV['email']."\">
				</div>
				
				<div class=\"formitem\">
					<label for=\"date\">".$lang['date']."</label>
					<input name=\"date\" class=\"formshort\" value=\"".$MY_ENV['date']."\">
				</div>
					
				<div class=\"formitem\">
					<label for=\"target\">".$lang['target']."</label>
					<select name=\"target\">
					<option value=\"editors\"".$MY_ENV['selected']['targeditors'].">".$lang['editors']."</option>
					<option value=\"template\"".$MY_ENV['selected']['targtemplate'].">".$lang['template']."</option>
					<option value=\"administration\"".$MY_ENV['selected']['targadministration'].">".$lang['administration']."</option>
					<option value=\"trainer\"".$MY_ENV['selected']['targtrainer'].">".$lang['trainer']."</option>
					<option value=\"screencaster\"".$MY_ENV['selected']['targscreencaster'].">".$lang['screencaster']."</option>
					</select>
				</div>

				<div class=\"formitem\">
					<label for=\"language\" class=\"".$MY_ENV['error']['language']."\">".$lang['language']."</label>
					<input name=\"language\" class=\"formshort\" value=\"".$MY_ENV['language']."\">
				</div>

				<br>

				<div class=\"formitem\">
					<input type=\"submit\" value=\"".$lang['submit']."\">
					<input type=\"reset\" value=\"".$lang['reset']."\"> 
				</div>

				<br>

				<p>
				".$lang['sharethis']."<br>
				".$lang['feature'].": <a href=\"mailto:contact@sourcefabric.org\">contact@sourcefabric.org</a>  | 
				<a href=\"http://www.sourcefabric.org\" target=\"_blank\">www.sourcefabric.org</a>
				</p>

			</form>

			<div class=\"colors\">
				<span class=\"orange\">&nbsp;</span>
				<span class=\"blue\">&nbsp;</span>
				<span class=\"green\">&nbsp;</span>
				<span class=\"purple\">&nbsp;</span>
				<span class=\"yellow\">&nbsp;</span>
			</div>

		</div>
	</div>

</body>
</html>";
  return $return;
} // end function html_form()
function html_page() {
  global $MY_ENV;
  global $lang;
  $return = "";
  $return .= "
<body>
	<div class=\"wrapper ".$MY_ENV['project']."\">
		<div class=\"content\">
			<div class=\"title\">
				<h1>".$MY_ENV['title']."</h1> <br>
				<h2>".$MY_ENV['description']."</h2>
			</div>
			<div class=\"author\">
				".$MY_ENV['htmlimgurl']."				
				<p class=\"name\">".$MY_ENV['name']."</p>
				<p class=\"email\">".$MY_ENV['email']."</p>
			</div>
			<div class=\"info\">
				<p><span>".$MY_ENV['date']."</span><span>".$lang[$MY_ENV['target']]."</span><span>".$lang['language'].": ".$MY_ENV['language']."</span></p>
				<p>www.sourcefabric.org</p>
			</div>

			<footer>
				<p class=\"version\"><span>".ucfirst($MY_ENV['project'])."</span> <span>".$lang['version']." ".$MY_ENV['version']."</span></p>
				<img src=\"img/".$MY_ENV['project']."_logo.png\">
				<div class=\"colors\">
					<span class=\"orange\">&nbsp;</span>
					<span class=\"blue\">&nbsp;</span>
					<span class=\"green\">&nbsp;</span>
					<span class=\"purple\">&nbsp;</span>
					<span class=\"yellow\">&nbsp;</span>
				</div>
			</footer>
		</div>
	</div>

</body>
</html>";
  return $return;
} // end function html_page()

?>
