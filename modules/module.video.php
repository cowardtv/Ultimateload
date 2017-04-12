<?php
/**
Name: Video Module 
Description: 
	Displays an HTML5 or YouTube video.
Options: 
	video - The URL of the video to display. This can be either the URL of an HTML5 video (WebM or MP4) or a YouTube video.
	videos - A list of URLs of videos. One will be randomly chosen from this list. This will be used over video if set.
	title (optional) - If card is enabled, this will be the title. The default is "Video"
	loop (optional) - If true, the video will loop. Defaults to false.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$title = key_or_default($Module_Config, "title", "Image");
$loop = key_or_default($Module_Config, "loop", false);

$videos = array();
if(array_key_exists("videos", $Module_Config))
{
	$videos = $Module_Config["videos"];
}
else 
{
	$videos = array( key_or_default($Module_Config, "video", "content/example.webm") );
}
$video = $videos[rand(0, count($videos) - 1)];

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
		<div class="<?php if(!$card) { ?>no_card<?php } ?>">
			<?php 
			// Check if it's a YouTube URL. 
			$matches = array();
			// YouTube If
			if(preg_match("/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|(embed|v)\/))([^\?&\"'>]+)/", $video, $matches))
			{
				$id = $matches[5];
			?>
				<iframe 
					class="ui fluid image" 
					type="text/html" 
					width="290" 
					height="163"
					frameborder="0"
					src="http://www.youtube.com/v/<?php echo $id; ?>?autoplay=1&loop=<?php echo $loop ? "1" : "0"; ?>&controls=0&modestbranding=1&showinfo=0&playlit=<?php echo $id; ?>"
				>
				</iframe>
			<?php } else { // YouTube If ?>
				<video 
					class="ui fluid image" 
					src="<?php echo $video; ?>" autoplay <?php echo $loop ? "loop" : ""; ?> preload></video>
			<?php } // YouTube If ?>
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