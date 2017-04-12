<?php
/**
Name: Example Module 
Description: 
	An example module. You won't use this on your loading page.
Options: 
	custom_content - Some custom text to display as an example.
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
		Example Module
	</div>
	<?php } // Titlebar If ?>
	<div class="module content">
<?php 
} // Card If
?>
		<div class="description <?php if(!$card) { ?>no_card<?php } ?>">
			<p>
				This is an example module. The source code is in modules/module.example.php if you want to check it out!
			</p>
			<?php 
			// Custom Content If
			if(array_key_exists("custom_content", $Module_Config)) {
			?>
			<p>
				Here's some custom content:
			</p>
			<p>
				<?php echo htmlentities($Module_Config["custom_content"]); ?>
			</p>
			<?php } // Custom Content If ?>
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