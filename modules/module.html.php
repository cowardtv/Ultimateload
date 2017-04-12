<?php
/**
Name: HTML Box Module 
Description: 
	Displays arbitrary HTML in a box. Can also display the content of a file instead. 
Options: 
	title - The title of the HTML box. This will only display if show_titlebar is true.
	html - The content to display.
	nl2br (optional) - Boolean. If this is true, newlines in the HTML will be converted to real HTML newlines. 
	url (optional) - If this is set, the content of this module will be set to the content of this URL.
		You may use user variables in this URL.
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
		<?php echo key_or_default($Module_Config, "title", "HTML Box"); ?>
	</div>
	<?php } // Titlebar If ?>
	<div class="module content">
<?php 
} // Card If
?>
		<div class="description <?php if(!$card) { ?>no_card<?php } ?>">
			<?php 
			$content = "";
			if(array_key_exists("url", $Module_Config))
			{
				// Fetch content from the URL.
				$content = file_get_contents(interpolate_url($Module_Config["url"]));
			}
			else
			{
				$content = key_or_default($Module_Config, "html", "No content set."); 
			}
			
			if(array_key_exists("nl2br", $Module_Config) && $Module_Config["nl2br"])
			{
				$content = nl2br($content);
			}
			echo $content;
			?>
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