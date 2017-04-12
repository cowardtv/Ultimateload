<?php
/**
Name: Phrases Module 
Description: 
	If you've ever played a Maxis game (The Sims, SimCity), you've seen the funny loading text that cycles on the 
	loading screens. This module does that. Just give it a list of phrases to cycle through.
Options: 
	phrases - An array of strings to cycle through.
	alignment (optional) - The alignment of the text. Possible values are left, right, and center. Default is left.
	brighter (optional) - Boolean. If true, the text is brighter and easier to see against a dark background.
	shadow (optional) - Boolean. If true, the text has a shadow. Defaults to false.
	card (optional) - Boolean. If true, this module will act as a card (has titlebar and background). The default is false.
	title (optional) - If card is true, this is the title of the card.
	align_card (optional) - Boolean. If true, and if card is false, this will cause this phrase to be aligned with cards
		below it. Use this with center or right alignment. Default is false.
	delay (optional) - The amount of time in seconds to wait on each phrase. Default is 2 seconds. 
	fade (optional) - Boolean. If true, text will fade out and in when transitioning. Otherwise, it will just be replaced.
		The default is true.
	transition_speed (optional) - The speed of the transition, either "fast", "slow", or "medium". The default is "fast".
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$phrases = key_or_default($Module_Config, "phrases", []);
shuffle($phrases);
$card = key_or_default($Module_Config, "card", false);
$title = key_or_default($Module_Config, "title", "Phrases");
$delay = key_or_default($Module_Config, "delay", 2);
$fade = key_or_default($Module_Config, "fade", true);
$transition_speed = key_or_default($Module_Config, "transition_speed", "fast");
$brighter = key_or_default($Module_Config, "brighter", false);
$alignment = key_or_default($Module_Config, "alignment", "left");
$align_card = key_or_default($Module_Config, "align_card", false);
$shadow = key_or_default($Module_Config, "shadow", false);

// Generate a unique ID for this module. 
// This is used as the ID of the element so we can address this one specifically. 
$id = "phrases_" . sha1(uniqid("", true) . mt_rand());

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
	<div class="phrases module content">
<?php  
} // Card If 
?>
	<div 
		id="<?php echo htmlentities($id); ?>" 
		class="
			<?php if($brighter){?>white<?php } ?> 
			<?php if(!$card) { ?>no-card<?php } ?> 
			<?php echo htmlentities($alignment); ?>
			<?php if($align_card && !$card) { ?>card_size<?php } ?>
			<?php if($shadow) { ?> shadowed <?php } ?>
			phrase label">
		<?php 
		if(count($phrases) > 0) 
		{ 
			echo htmlentities($phrases[0]);
		}
		?>
	</div>
	
	<?php 
	// Output phrase JS only if there's more than one phrase. 
	if(count($phrases) > 1)
	{
	?>
	<script type="text/javascript">
	// Put this in a closure so we don't pollute the global namespace.
	(function() {
		var phrases = <?php echo json_encode($phrases); ?>;
		var currentPhrase = phrases[0];
		var fade = <?php echo $fade ? 'true' : 'false'; ?>;
		var transitionSpeed = "<?php echo $transition_speed; ?>";
		var element = $("#<?php echo htmlentities($id); ?>");
		
		// Return a new phrase that's different from the current one, if possible.
		function selectPhrase()
		{
			var possiblePhrases = phrases.filter(function(p) {
				return p != currentPhrase;
			});
			
			if(possiblePhrases.length == 0) return;
			
			return currentPhrase = possiblePhrases[Math.floor(Math.random() * possiblePhrases.length)];
		}
		
		function transition()
		{
			var newPhrase = selectPhrase();
			if(fade)
			{
				element.fadeOut(
					transitionSpeed, 
					function() {
						element.text(newPhrase).fadeIn(transitionSpeed);
					});
			}
			else 
			{
				element.text(newPhrase);
			}
		}
		
		setInterval(transition, <?php echo $delay * 1000; ?>);
	})();
	</script>
	<?php } // Phrase If ?>
<?php 
// Card If
if($card) 
{
?>
	</div>
</div>
<?php } // Card If ?>