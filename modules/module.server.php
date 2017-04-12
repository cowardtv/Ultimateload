<?php
/**
Name: Server Info Module 
Description: 
	Displays the name, map and gamemode of the server.
Options: 
	none
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}


$card = key_or_default($Module_Config, "card", false);

// Note: $Module_Config is defined in index.php. It contains the config for just this module.
// HTML starts here
?>

<?php 
// Card If
if($card)
{
?>
<div class="ui centered module card">
	<?php 
	// Titlebar If 
	if($Module_Config["show_titlebar"]) {
	?>
	<div class="titlebar content">
		Server Info
	</div>
	<?php } // Titlebar If ?>
	<div class="module content">
<?php 
} // Card If
?>
		<div class="<?php if(!$card) { ?>no_card<?php } ?>">
			<div class="server module content">
				<?php /* The info is provided to us by Javascript, so we fill them in later. */ ?>
				<div class="marginless ui header">
					<i class="file text outline icon"></i>
					<div class="content name"></div>
				</div>
				<div class="ui divider"></div>
				<div class="marginless ui header">
					<i class="game icon"></i>
					<div class="content gamemode"></div>
				</div>
				<div class="ui divider"></div>
				<div class="marginless ui header">
					<i class="marker icon"></i>
					<div class="content mapname"></div>
				</div>
			</div>
		</div>
<?php
if($card)
{
?>
	</div>
</div>
<?php
} // Card If
?>