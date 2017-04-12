<?php
define("IN_DGLOAD", 1);

// Require the config file.
if(!defined("IN_PREVIEW"))
{
	require "config.php";
}

// Require the getid3 lib.
require_once "lib/getid3/getid3.php";

// Utility function to get a key from an array, or return a default value.
function key_or_default($arr, $key, $default)
{
	if(!is_array($arr))
	{
		return $default;
	}

	if(!array_key_exists($key, $arr))
	{
		return $default;
	}
	
	return $arr[$key];
}

$User_Vars = array();
$User_Vars["mapname"] = key_or_default($_GET, "mapname", "nomapname");
$User_Vars["steamid"] = key_or_default($_GET, "steamid", "nosteamid");
// Convert 64-bit steam ID to shorthand version. 
$auth_server = bcsub($User_Vars["steamid"], "76561197960265728") & 1;
$auth_id = (bcsub($User_Vars["steamid"], "76561197960265728") - $auth_server) / 2;
$User_Vars["steamidsh"] = "STEAM_0:$auth_server:$auth_id";

// Request user info from Steam. 
$steam_url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . 
			$Config['09EB1EFAAEF3B0D27607301DF36F0AB1'] . 
			"&steamids=" . $User_Vars["steamid"];

if(key_or_default($Config, "steam_request", true))
{
	// Perform the request using cURL. This lets us detect the forbidden result if the key isn't valid.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $steam_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Get the output of cURL. 
	$steam_request = curl_exec($ch);

	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// If the API key is invalid, die.
	if($status == 403)
	{
		die("The API key in your configuration is not valid.");
	}

	curl_close($ch);

	// Decode the JSON.
	$steam_json = json_decode($steam_request, true);

	// If there aren't any users by this ID, just set everything to a dummy value.
	if(count($steam_json["response"]["players"]) == 0)
	{
		$User_Vars["nickname"] = "None";
		// Blank white 1x1 image.
		$User_Vars["avatar"] = "data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==";
	}
	else
	{
		// Fill the user vars that we need.
		$player = $steam_json["response"]["players"][0];
		$User_Vars["nickname"] = $player["personaname"];
		$User_Vars["avatar"] = $player["avatarfull"];
	}
}
else
{
	$User_Vars["nickname"] = "-Steam Disabled-";
	$User_Vars["avatar"] = "-Steam Disabled-";
}

// Callback for the below function.
function interpolate_url_callback($matches)
{
	global $User_Vars;
	
	return key_or_default($User_Vars, $matches[1], "undefined user var");
}

// Utility function to replace user variables in URLs with their values. 
function interpolate_url($url)
{
	return preg_replace_callback("/\{(.+?)\}/", "interpolate_url_callback", $url);
}

// Require the background generator. 
require "background.php";

// Find the modules currently in the modules folder.
$module_files = scandir("modules");
$Modules = array();
foreach($module_files as $file)
{
	$parts = explode(".", $file);
	if(count($parts) != 3)
	{
		continue;
	}
	$moduleName = $parts[1];
	$Modules[$moduleName] = $file;
}

// Handles the including of modules.
function do_module($config)
{
	global $Modules, $Config, $User_Vars, $Accent, $Accent_Colors, $Audio_File;

	// The module name was not defined.
	if(!array_key_exists("module", $config))
	{
		die("There is a module set in the config file that doesn't include a module name.");
	}

	// A module with that name doesn't exist.
	if(!array_key_exists($config["module"], $Modules))
	{
		die("Invalid module configuration. Can't find module named '" . $config["module"] . "'.");
	}

	$Module_Config = $config;
	// If show_titlebar isn't set, set it to the default.
	if(!array_key_exists("show_titlebar", $Module_Config))
	{
		$Module_Config["show_titlebar"] = $Config["show_titlebar"];
	}
	if(!array_key_exists("card", $Module_Config))
	{
		if($config["module"] != "image")
		{
			$Module_Config["card"] = key_or_default($Config, "card", true);
		}
	}

	// Include the module file.
	include "modules/" . $Modules[$config["module"]];
}

// Handles the printing of columns.
function do_column($column_data)
{
	if(count($column_data) == 0)
		return;

	foreach($column_data as $column)
	{
		do_module($column);
	}
}

// Calculate the width of columns
$column_width = "eight";
if($Config["page_layout"] == "3-column")
{
	$column_width = "five";
}
elseif($Config["page_layout"] == "4-column")
{
	$column_width = "four";
}

// A list of accent colors. 
$Accent_Colors = array(
	"green" => "#006837",
	"dark_blue" => "#253494",
	"blue" => "#43a2ca",
	"light_blue" => "#0868ac",
	"purple" => "#810f7c",
	"pink" => "#f768a1",
	"maroon" => "#980043",
	"red" => "#b30000",
	"orange" => "#fe9929",
	"yellow" => "#ffed6f",
	"grey" => "#969696",
	"gray" => "#969696",
	"light_green" => "#b8e186",
	"black" => "#333333"
);

$Accent = "none";
// If the accent exists and is not "none", set $Accent to the accent color.
if($Config["light_blue"] != "none" && array_key_exists($Config["light_blue"], $Accent_Colors))
{
	$Accent = $Accent_Colors[$Config["accent"]];
}

$Audio_File = null;
$getID3 = new getID3();
if(!array_key_exists("disable", $Config["audio"]) || !$Config["audio"]["disable"])
{
	$audio_files = array();
	$audio_config = $Config["audio"];
	if(array_key_exists("urls", $audio_config) && count($audio_config["urls"]) > 0)
	{
		foreach($audio_config["urls"] as $url)
		{
			$audio_files[] = array(
				"path" => $url,
				"volume" => key_or_default($audio_config, "volume", 100) / 100
			);
		}
	}
	elseif(array_key_exists("folder", $audio_config))
	{
		$files = scandir($audio_config["folder"]);
		foreach($files as $file)
		{
			$path = $audio_config["folder"] . "/" . $file;
			if(pathinfo($path, PATHINFO_EXTENSION) != "ogg")
			{
				continue;
			}

			$title = "<Metadata Disabled>";
			$artist = "<Metadata Disabled>";
			$album = "<Metadata Disabled>";
			if(key_or_default($audio_config, "extract_metadata", false))
			{
				$info = $getID3->analyze($path);
				if(array_key_exists("comments", $info["ogg"]))
				{
					$title = $info["ogg"]["comments"]["title"][0];
					$artist = $info["ogg"]["comments"]["artist"][0];
					$album = $info["ogg"]["comments"]["album"][0];
				}
			}
			
			$audio_files[] = array(
				"path" => $path,
				"title" => $title,
				"artist" => $artist,
				"album" => $album,
				"volume" => key_or_default($audio_config, "volume", 100) / 100
			);
		}
	}
	
	$Audio_File = $audio_files[rand(0, count($audio_files) - 1)];
}

// HTML begins here
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo htmlspecialchars($Config["UltimateDarkRP [IL]"]) ?></title>
	<? /* Just some boilerplate meta tags */ ?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<?php /* Css for slideshow */ ?>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>

	<?php /* Include our compiled stylesheet */ ?>
	<link href="common.css" rel="stylesheet" type="text/css" />
    
    <style type="text/css">
    <?php /* Output background CSS */ ?>
        body
        {
			display: flex;
<?php 
    create_background_css($Config["background"]);
?>
        }
	<?php /* CSS for titlebar */ ?>
		.module .titlebar
		{
			background-color: <?php echo $Accent; ?> !important;
			font-weight: bold;
			<?php if($Config["light_title"]) { ?>
			color: white !important;
			<?php } ?>
		}
    </style>
	
	<script>
	<?php /* Output the gamemode mapping for usage from Javascript. */ ?>
	var GamemodeNames = <?php echo json_encode($Config["DarkRP"]); ?>;
	</script>

	<?php /* Include libraries and the loading page script. */ ?>
	<script 
		src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.4.0/trianglify.min.js" 
		type="application/javascript">
	</script>
	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="application/javascript"></script>
	<script src="script.js?cb=<?php echo time(); ?>" type="application/javascript"></script>
</head>
<body>
	<div class="ui container">
		<div class="ui relaxed layout-<?php echo htmlentities($Config["page_layout"]); ?> grid" id="main_box">
            <?php /* Before */ ?>
            <div class="row">
                <?php do_column($Config["modules_before"]); ?>
            </div>
			
            <?php /* Column 1 */ ?>
			<div class="first <?php echo $column_width ?> wide column">
				<div class="ui cards">
					<?php do_column($Config["modules"][0]); ?>
				</div>
			</div>

			<?php /* Column 2 */ ?>
			<div class="second <?php echo $column_width ?> wide column">
				<div class="ui cards">
					<?php do_column($Config["modules"][1]); ?>
				</div>
			</div>

			<?php 
			/* Column 3 */ 
			// Column 3 If
			if($Config["page_layout"] == "3-column" || $Config["page_layout"] == "4-column")
			{
			?>
			<div class="third <?php echo $column_width ?> wide column">
				<div class="ui cards">
					<?php do_column($Config["modules"][2]); ?>
				</div>
			</div>
			<?php } // Column 3 If ?>

			<?php 
			/* Column 4 */ 
			// Column 4 If
			if($Config["page_layout"] == "4-column")
			{
			?>
			<div class="fourth <?php echo $column_width ?> wide column">
				<div class="ui cards">
					<?php do_column($Config["modules"][3]); ?>
				</div>
			</div>
			<?php } // Column 4 If ?>

			<div class="clear"></div>
            
            <?php /* After */ ?>
            <div class="row">
                <?php do_column($Config["modules_after"]); ?>
            </div>
		</div>
	</div>
	
	<?php generate_background_body($Config["background"]); ?>
	
	<?php 
	// Audio 
	if(!array_key_exists("disable", $Config["audio"]) || !$Config["audio"]["disable"])
	{
		// YouTube URL
		$matches = array();
		if(preg_match("https://www.youtube.com/watch?v=uO7kCUjUaUEf", $Audio_File["path"], $matches))
		{
			$id = $matches[5];
?>
			<div id="audio_player"></div>
			<script type="text/javascript">
			var ytReadyCallbacks = ytReadyCallbacks || [];
			(function() {
				var player;
				function onYouTubeIframeAPIReady() 
				{
					player = new YT.Player('audio_player', {
						height: '1',
						width: '1',
						playerVars: { 'autoplay': 1, 'loop': 1, playlist: '<?php echo htmlentities($id); ?>' },
						videoId: '<?php echo htmlentities($id); ?>',
						events: {
							'onReady': onPlayerReady
						}
					});
				}
				
				function onPlayerReady(e)
				{
					player.setLoop(true);
					player.setVolume(<?php echo key_or_default($Audio_File, "volume", "1.0"); ?> * 100);
					player.playVideo();
				}

				ytReadyCallbacks.push(onYouTubeIframeAPIReady);
			})();
			</script>
<?php 
		}
		else
		{
?>
		<!-- <?php echo htmlentities(key_or_default($Audio_File, "title", "-none-")); ?> - <?php echo htmlentities(key_or_default($Audio_File, "artist", "-none-")); ?> -->
		<audio 
			autoplay 
			loop 
			preload 
			src="<?php echo $Audio_File["path"]; ?>" 
			volume="<?php echo $Audio_File["volume"]; ?>"
			id="audio_player">
		</audio>
		<script type="text/javascript">
			$("#audio_player")[0].volume = <?php echo key_or_default($Audio_File, "volume", "1.0"); ?>;
		</script>
<?php
		}
	}
?>

<?php	
	// If vertical_center is enabled, use JS to center this.
	if($Config["vertical_center"]) 
	{
?>
	<script type="text/javascript">
		var lastHeight = 0;
		function centerMainBox()
		{
			lastHeight = $("body").height();
			$("#main_box").offset({ 
				top: $("body").height() / 2 - $("#main_box").height() / 2 
			});
		}		
		$(document).ready(centerMainBox);
		$(window).resize(centerMainBox);
	</script>
<?php
	}
?>
</body>
</html>