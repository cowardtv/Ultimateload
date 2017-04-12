<?php
/**
Name: Slideshow Module 
Description: 
	Displays a list of images in a slideshow, with configurable timing.
Options: 
	images - A list of images to display. 
	delay (optional) - This is the amount of time in seconds that images stay on the screen. Defaults to 5 seconds.
	fade (optional) - If true, images will fade instead of scroll. Defaults to false.
	title (optional) - The title of the module. This will only display if show_titlebar is true.
**/

// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

$title = key_or_default($Module_Config, "title", "Slideshow");
$delay = key_or_default($Module_Config, "delay", 5);
$fade = key_or_default($Module_Config, "fade", false);
$images = key_or_default($Module_Config, "images", []);

// Generate a unique ID for this slideshow. 
// This is used as the ID of the element so we can have different delays for each slideshow. 
$id = "slideshow_" . sha1(uniqid("", true) . mt_rand());


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
			<div class="slideshow" id="<?php echo $id; ?>">
				<?php 
				$whichVideos = array();
				$num = 0;
				// Slideshow Foreach
				foreach($images as $image)
				{
					$ext = pathinfo(parse_url($image, PHP_URL_PATH), PATHINFO_EXTENSION);
				?>
				<div>
					<?php 
					if($ext == "webm") 
					{ 
						$whichVideos[$num] = true;
					?>
					<video id="<?php echo $id . '-v-' . $num;?>" class="ui fluid image" src="<?php echo htmlentities($image); ?>" autoplay loop></video>
					<?php } else 
					{
						$whichVideos[$num] = false; 
					?>
					<img class="ui fluid image" src="<?php echo htmlentities($image); ?>">
					<?php } ?>
				</div>
				<?php 
					$num++;
				} //Slideshow Foreach
				?>
			</div>
		</div>
	
		<?php // Output slideshow JS ?>
		<script type="text/javascript">
		var <?php echo $id; ?>_videos = <?php echo json_encode($whichVideos); ?>;
		$("#<?php echo $id; ?>").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: <?php echo $delay * 1000; ?>,
			arrows: false,
			draggable: false,
			fade: <?php echo $fade ? 'true' : 'false'; ?>
		}).on("beforeChange", function(ev, slick, current, next) {
			if(<?php echo $id; ?>_videos[next])
			{
				$("#<?php echo $id; ?>-v-" + next)[0].play();
			}
		});

		if($("#<?php echo $id; ?>-v-0").length > 0)
		{
			$("#<?php echo $id; ?>-v-0")[0].play();
		}
		</script>
<?php
if($card)
{
?>
	</div>
</div>
<?php
} // Card If
?>