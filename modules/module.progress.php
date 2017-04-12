<?php
/**
Name: Progress Module 
Description: 
	A module that shows a progress bar and the file download progress. You will probably want this!
	This module has no titlebar.
Options: 
	brighter - Boolean. If true, the text is brighter and easier to see against a dark background.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$brighter = key_or_default($Module_Config, "brighter", false);
$accent_override = key_or_default($Module_Config, "accent_override", "none");
$color = ($accent_override == "none" ? $Accent : key_or_default($Accent_Colors, $accent_override, "white"));

// HTML starts here
?>

<div class="ui basic progress container segment">
	<div class="small ui progress indicator">
		<div class="bar" style="background: <?php echo $color; ?>">
		</div>
		<div class="<?php if($brighter) { ?>white<?php }?> label">
			Loading...
		</div>
	</div>
</div>