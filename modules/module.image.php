<?php
/**
Name: Image Module 
Description: 
	Displays an image.
Options: 
	image - The URL of the image to display.
	images - A list of URLs to display. One will be randomly chosen from this list. This will be used over image if set.
	card (optional) - Boolean. If true, this module will act as a card (has titlebar and background). The default is false.
	title (optional) - If card is enabled, this will be the title. The default is "Image"
	alignment (optional) - The alignment of the image. Allowed values are left, center, and right.
	padding (optional) - The amount of space around the image. This can be a string, which will apply to all sides,
		or it can be an array with the keys "top", "bottom", "left", and "right", which apply to those sides. 
	alt (optional) - The text that is displayed when the image can't load.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$alignment = key_or_default($Module_Config, "alignment", "left");
$padding_config = key_or_default($Module_Config, "padding", "0px");

// Set padding string based on config.
$padding = "";
if(is_array($padding_config))
{
	$top = key_or_default($padding_config, "top", "0px");
	$right = key_or_default($padding_config, "right", "0px");
	$bottom = key_or_default($padding_config, "bottom", "0px");
	$left = key_or_default($padding_config, "left", "0px");
	$padding = "$top $right $bottom $left";
}
else
{
	$padding = $padding_config;
}

$card = key_or_default($Module_Config, "card", false);
$title = key_or_default($Module_Config, "title", "Image");

$images = array();
if(array_key_exists("images", $Module_Config))
{
	$images = $Module_Config["images"];
}
else 
{
	$images = [ $Module_Config["image"] ];
}
$image = $images[rand(0, count($images) - 1)];

// HTML starts here

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
		<div class="module-image container <?php echo $alignment; ?>">
			<img 
				src="<?php echo $image; ?>" 
				alt="<?php echo key_or_default($Module_Config, "alt", ""); ?>"
				class="<?php if($card) { ?> ui fluid <?php } ?> module-image image"
				style="padding: <?php echo $padding; ?>;"
			/>
		</div>
<?php  
// Card If
if($card)
{
?>
	</div>
</div>
<?php 
}
?>