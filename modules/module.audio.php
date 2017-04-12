<?php
/**
Name: Audio Module 
Description: 
	Shows information about the currently playing song.
Options: 
	format - The way the current song is displayed, using the %title%, %artist%, and %album% placeholders.
	alignment (optional) - The alignment of the text. Possible values are left, right, and center. Default is left.
	brighter (optional) - Boolean. If true, the text is brighter and easier to see against a dark background.
	shadow (optional) - Boolean. If true, the text has a shadow. Defaults to false.
	card (optional) - Boolean. If true, this module will act as a card (has titlebar and background). The default is false.
	title (optional) - If card is true, this is the title of the card.
	align_card (optional) - Boolean. If true, and if card is false, this will cause this phrase to be aligned with cards
		below it. Use this with center or right alignment. Default is false.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$format = key_or_default($Module_Config, "format", "Now playing: %artist% - %title%.");
$card = key_or_default($Module_Config, "card", false);
$card_title = key_or_default($Module_Config, "title", "Audio");
$brighter = key_or_default($Module_Config, "brighter", false);
$alignment = key_or_default($Module_Config, "alignment", "left");
$align_card = key_or_default($Module_Config, "align_card", false);
$shadow = key_or_default($Module_Config, "shadow", false);

$title = key_or_default($Audio_File, "title", "-none-");
$album = key_or_default($Audio_File, "album", "-none-");
$artist = key_or_default($Audio_File, "artist", "-none-");

$content = str_replace("%title%", "<span class='audio-title'>" . htmlentities($title) . "</span>", $format);
$content = str_replace("%album%", "<span class='audio-album'>" . htmlentities($album) . "</span>", $content);
$content = str_replace("%artist%", "<span class='audio-artist'>" . htmlentities($artist) . "</span>", $content);

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
		<?php echo htmlentities($card_title); ?>
	</div>
	<?php } // Titlebar If ?>
	<div class="audio module content">
<?php  
} // Card If 
?>
	<div 
		class="
			<?php if($brighter){?>white<?php } ?> 
			<?php if(!$card) { ?>no-card<?php } ?> 
			<?php echo htmlentities($alignment); ?>
			<?php if($align_card && !$card) { ?>card_size<?php } ?>
			<?php if($shadow) { ?> shadowed <?php } ?>
			phrase label">
		<?php
			echo $content;
		?>
	</div>
<?php 
// Card If
if($card) 
{
?>
	</div>
</div>
<?php } // Card If ?>