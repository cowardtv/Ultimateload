<?php
/**
Name: Rules Module
Description: 
	This will show a customizable list of rules for your server.
Options: 
	rules - An array of rules to display, in order.
	title (optional) - The title of the rules. This will default to "Rules" if you don't provide it.
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
		<?php echo key_or_default($Module_Config, "title", "Rules"); ?>
	</div>
	<?php } // Titlebar If ?>
	<div class="module content">
<?php 
} // Card If
?>
		<div class="<?php if(!$card) { ?>no_card<?php } ?>">
			<div class="ui divided rule list">
				<?php 
				// Rule Foreach
				$count = 0;
				foreach(key_or_default($Module_Config, "rules", array()) as $rule)
				{
					$count++;
				?>
				<div class="rule item">
					<div class="rule number icon">
						<?php echo $count; ?>
					</div>
					<div class="rule content">
						<?php echo $rule; ?>
					</div>
				</div>
				<?php
				} // Rule Foreach
				?>
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