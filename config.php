<?php
// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$Config = array();

// The title of the page. This won't show up in-game, but it doesn't hurt to change it.
$Config["title"] = "DGLoad";

// Steam Web API key. This is needed to request info from the Steam API from users. 
$Config["steam_api_key"] = "";

// Gamemode IDs to names mapping.
$Config["gamemode_names"] = array(
	"sandbox" => "Sandbox",
	"darkrp" => "DarkRP",
	"ttt" => "Trouble in Terrorist Town",
	"deathrun" => "Deathrun",
	"murder" => "Murder",
	"guesswho" => "Guess Who",
	"stopitslender" => "Stop it, Slender!",
	"fnafgm" => "Five Nights at Freddy's",
	"thehidden" => "The Hidden",
	"cinema" => "Cinema",
	"prophunt" => "Prop Hunt",
	"underdone" => "Underdone",
	"gungame" => "GunGame",
	"zombiesurvival" => "Zombie Survival",
	"finalfrontier" => "Final Frontier",
	"awesomestrike" => "Awesome Strike: Source",
	"garryware" => "GarryWare"
);

// Whether or not to show the titlebar of modules.
// This can be overridden on a per-module basis.
$Config["show_titlebar"] = true;

// Whether or not to put modules in cards by default.
// A card contain a background and a titlebar.
$Config["card"] = true;

// If true, the loading screen will be centered vertically in the window.
$Config["vertical_center"] = true;

// Background audio settings. 
$Config["audio"] = array(
	"disable" => true,
	// Enable metadata extraction from OGG files.
	"extract_metadata" => true,
	// The volume of the audio (only works for OGG files at the moment).
	"volume" => 100,
	// The name of a folder to find OGG files in. 
	"folder" => "content/music",
	// Alternatively, a list of filenames or YouTube URLs.
	"urls" => array(
		"content/music/02_she - music.ogg",
		"https://www.youtube.com/watch?v=SzClkMxdsgI"
	)
);

// Background settings.
$Config["background"] = array(
	"source" => "triangles",
	"options" => array(
		"variance" => "0.75",
		"cell_size" => "75",
		"x_colors" => "PuOr",
		"y_colors" => "match_x",
		"color_space" => "lab",
		"stroke_width" => "1.51",
		"seed" => "random"
	)
);

// The accent color to use. This will be used for the titlebars. 
$Config["accent"] = "black";
// If true, title text will be white. If false, it will be black.
$Config["light_title"] = true;

// Layout options start here.

// The general layout of the page. Options: 2-column, 3-column, 4-column
$Config["page_layout"] = "3-column";

// The modules at the top of the page, before the columns.
$Config["modules_before"] = array(
	array(
		"module" => "image",
		"image" => "content/example_logo.png",
		"alignment" => "center",
		"padding" => array(
			"top" => "10px"
		)
	)
);

// The actual modules on the page.
$Config["modules"] = array(
	// Column 1
	array(
		array(
			// The module name.
			"module" => "example",
			// Override titlebar settings for this module (optional).
			"show_titlebar" => true,
			// Custom content (optional).
			"custom_content" => "Hey!"
		),
		array(
			"module" => "rules",
			"title" => "Wow, rules!",
			"rules" => array(
				"Don't kill people.",
				"Or do, if you want.",
				"Whatever, I don't care.",
				"This rule is deliberately longer than it has to be so that it wraps around."
			)
		)
	),
	// Column 2
	array(
		array(
			"module" => "phrases",
			"show_titlebar" => false,
			"card" => true,
			"fade" => false,
			"alignment" => "center",
			"phrases" => array(
				"Sequencing Particles",
				"Sub-Sampling Water Data",
				"Zeroing Crime Network",
				"Mopping Occupant Leaks",
				"Projecting Law Enforcement Pastry Intake",
				"Integrating Illumination Form Factors",
				"Generating Jobs",
				"Exposing Flash Variables to Streak System",
				"Deleting Ferry Routes",
				"Charging Ozone Layer",
				"Aligning Covariance Matrices"
			)
		),
		array(
			"module" => "server"
		)
	),
	// Column 3
	array(
		array(
			"module" => "player",
			"size" => "small",
			"show_titlebar" => false
		),
		array(
			"module" => "video",
			"title" => "Uh, a video!",
			"show_titlebar" => false,
			"loop" => true,
			"video" => "content/example.webm"
		),
		array(
			"module" => "image",
			"card" => true,
			"show_titlebar" => false,
			"images" => array(
				"content/example_image.jpg",
				"content/example_logo.png"
			)
		)
	),
	// Column 4
	array(
	)
);

// The modules at the end of the page, after the columns.
$Config["modules_after"] = array(
	array(
		"module" => "progress"
	)
);