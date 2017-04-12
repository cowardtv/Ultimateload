<?php
/**
Name: Player Module 
Description: 
	This module shows the player's username and avatar.
Options: 
	size - Two options: large or small. The default is "small"
	show_steamid - Boolean. If true, the player's SteamID is displayed under their name. Default is false.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$size = key_or_default($Module_Config, "size", "small");
$show_steamid = key_or_default($Module_Config, "show_steamid", false);

// HTML starts here
?>

<div class="ui centered module card">
	<?php 
	// Titlebar If 
	if($Module_Config["show_titlebar"]) {
	?>
	<div class="titlebar content">
		Player
	</div>
	<?php 
	} // Titlebar If 
	
	// Size If 
	if($size == "large")
	{
	?>
	<div class="module image">
		<img 
			src="<?php echo $User_Vars["avatar"]; ?>" 
			alt="<?php echo htmlentities($User_Vars["nickname"]); ?>'s avatar" />
	</div>
	<div class="module content">
		<div class="header">
			<?php echo htmlentities($User_Vars["nickname"]); ?>
		</div>
		<?php 
		// SteamID If 
		if($show_steamid) 
		{
		?>
		<div class="ui small header" style="margin:0;">
			<?php echo $User_Vars["steamidsh"]; ?>
		</div>
		<?php
		} // SteamID If 
		?>
	</div>
	<?php 
	} else { // Size If 
	?> 
	<div class="player module content">
		<img 
			class="centered tiny circular ui image"
			src="<?php echo $User_Vars["avatar"]; ?>"
			alt="<?php echo htmlentities($User_Vars["nickname"]); ?>'s avatar" />
		<div class="top padded header">
			<?php echo htmlentities($User_Vars["nickname"]); ?>
		</div>
		<?php 
		// SteamID If 
		if($show_steamid) 
		{
		?>
		<div class="ui small header" style="margin:0;">
			<?php echo $User_Vars["steamidsh"]; ?>
		</div>
		<?php
		} // SteamID If 
		?>
	</div>
	<?php 
	} // Size If 
	?>
</div>