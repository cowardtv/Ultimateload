<?php
/**
Name: Frame Module 
Description: 
	Displays a URL in a box. This can be a better idea than using HTML Box with a URL.
Options: 
	url - The URL to load. You may use user variables in this URL.
	title - The title of the module. This will only display if show_titlebar is true.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$title = key_or_default($Module_Config, "title", "Frame");
$url = key_or_default($Module_Config, "url", "https://facepunch.com/");

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
		<?php echo htmlentities($title); ?>
	</div>
	<?php } // Titlebar If ?>
	<div class="module content">
<?php 
} // Card If
?>
		<iframe 
			class="<?php if(!$card) { ?>no_card<?php } ?>"
			style='width: 100%; height: 100%;' 
			scrolling="no"
			src="<?php echo htmlentities(interpolate_url($url)); ?>" 
			frameborder="0"
			seamless>
		</iframe>
<?php
if($card)
{
?>
	</div>
</div>
<?php
} // Card If
?>