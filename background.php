<?php 
// If this script was accessed in some other way than requiring it in index.php (such as visiting it in the browser),
// an error will be displayed.
if(!defined("IN_DGLOAD"))
{
	die("This file cannot be run from outside of DGLoad");
}

// Source array.
$sources = array();
// Sources that need to add stuff to the body. 
$bodySources = array();

// Solid color background source.
function source_color($options)
{
	$colors = array();
	if(array_key_exists("color", $options))
	{
		$colors = array( $options["color"] );
	}
	else if(array_key_exists("colors", $options))
	{
		$colors = $options["colors"];
	}
	else 
	{
		return;
	}
	
	$color = $colors[rand(0, count($colors) - 1)];
	echo "background-color: " . $color . ";";
}
$sources["color"] = "source_color";

// Image background source.
function source_image($options)
{
	// skip the rest of the CSS if we're doing a slideshow.
	if(key_or_default($options, "slideshow", false))
	{
		echo "background: none; overflow: hidden;";
		return;
	}

	$images = array();
	if(array_key_exists("url", $options))
	{
		$images = array($options["url"]);
	}
	elseif(array_key_exists("images", $options))
	{
		$images = $options["images"];
	}
	else
	{
		return;
	}
	
	$image = $images[rand(0, count($images) - 1)];
	
	echo "background-image: url(" . $image . ");\n"; 
	echo "background-repeat: " . key_or_default($options, "repeat", "no-repeat") . ";\n";
	echo "background-attachment: " . key_or_default($options, "attachment", "scroll") . ";\n";
	echo "background-position: " . key_or_default($options, "position", "left top") . ";\n";
	echo "background-size: " . key_or_default($options, "size", "cover") . ";\n"; 
}
$sources["image"] = "source_image";

function source_image_body($options)
{
	// no body if we're not doing a slideshow
	if(!key_or_default($options, "slideshow", false))
	{
		return;
	}

	$images = key_or_default($options, "images", array());
	$delay = key_or_default($options, "delay", 5);
	$fade = key_or_default($options, "fade", false);
	if(key_or_default($options, "shuffle", false))
	{
		shuffle($images);
	}
?>
	<div id="background_slideshow">
<?php
	foreach($images as $image)
	{
		echo "<div><img src='" . $image . "'></div>\n";
	}
?>
	</div>
	<script type="text/javascript">
	$("#background_slideshow").slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: <?php echo $delay * 1000; ?>,
		arrows: false,
		draggable: false,
		fade: <?php echo $fade ? 'true' : 'false'; ?>
	});
	</script>
<?php
}
$bodySources["image"] = "source_image_body";

// Generate noise background source.
function source_noise($options)
{
	$color = key_or_default($options, "color", "000000");
	$opacity = key_or_default($options, "opacity", 5);
	
	// Create the image.
	$image = imagecreatetruecolor(100, 100);
	
	// Fill the background image.
	$r = hexdec(substr($color, 0, 2));
	$g = hexdec(substr($color, 2, 2));
	$b = hexdec(substr($color, 4, 2));
	$bg_color = imagecolorallocate($image, $r, $g, $b);
	imagefilledrectangle($image, 0, 0, 100, 100, $bg_color);
	
	// Set alpha blending of the image.
	imagealphablending($image, true);
	// Convert 0-100 alpha to 127-0 alpha.
	$alpha = 127 - floor(($opacity / 100) * 127);
	
	for($i = 0; $i < 100; $i++)
	{
		for($j = 0; $j < 100; $j++)
		{
			// Generate a random BW value.
			$bw = mt_rand(0, 255);
			$bw_color = imagecolorallocatealpha($image, $bw, $bw, $bw, $alpha);
			// Draw pixel.
			imagesetpixel($image, $i, $j, $bw_color);
		}
	}
	
	// Start the output buffer so that we can convert it to a data URL.
	ob_start();
	// Output the image.
	imagepng($image);
	$data = ob_get_contents();
	// End the buffer. 
	ob_end_clean();
	// Create data URL.
	$image_data = base64_encode($data);
	$data_url = "data:image/png;base64," . $image_data;
	
	// Output the CSS. 
	echo "background-image: url(" . $data_url . ");";
}
$sources["noise"] = "source_noise";

// Generate video background source.
function source_video($options)
{
	echo "background: none; overflow: hidden;";
}
$sources["video"] = "source_video";
// Generated video background element.
function source_video_body($options)
{
	$urls = array();
	if(array_key_exists("url", $options))
	{
		$urls = array( $options["url"] );
	}
	elseif(array_key_exists("urls", $options))
	{
		$urls = $options["urls"];
	}
	else
	{
		return;
	}
	
	$url = $urls[rand(0, count($urls) - 1)];
	
	// Output filter CSS.
	if(array_key_exists("filters", $options) && count($options["filters"]) > 0)
	{
		echo "<style type='text/css'> #background_video {";
		
		foreach($options["filters"] as $filter)
		{
			echo "filter: " . $filter . ";\n";
			echo "-webkit-filter: " . $filter . ";\n";
		}
		
		echo "} </style>";
	}
	
	// Check if it's a YouTube URL. 
	$matches = array();
	// If it matches, it is.
	if(preg_match("/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|(embed|v)\/))([^\?&\"'>]+)/", $url, $matches))
	{
		$id = $matches[5];
?>
	<div id="background_video"></div>
	<script type="text/javascript">
	<?php /* Load the YouTube IFrame API */ ?>
	var ytReadyCallbacks = ytReadyCallbacks || [];
	(function() {
		var player;
		function onYouTubeIframeAPIReady() 
		{
			player = new YT.Player('background_video', {
				height: '504',
				width: '896',
				playerVars: { 'autoplay': 1, 'controls': 0, 'modestbranding': 1, 'showinfo': 0 },
				videoId: '<?php echo htmlentities($id); ?>',
				events: {
					'onReady': onPlayerReady,
					'onStateChange': function(e){
						if (e.data === YT.PlayerState.ENDED) {
							player.playVideo(); 
						}
					}
				}
			});
		}
		
		function onPlayerReady(e)
		{
			player.setLoop(true);
			player.setSize(window.innerWidth, window.innerHeight);
			player.setVolume(0);
			player.playVideo();
		}
		
		$(window).on('resize', function() {
			player.setSize(window.innerWidth, window.innerHeight);
		});

		ytReadyCallbacks.push(onYouTubeIframeAPIReady);
	})();
	</script>
<?php
	}
	else 
	{
		// Output video HTML.
		echo "<video src='$url' autoplay loop muted preload id='background_video'></video>";
	}
}
$bodySources["video"] = "source_video_body";

// Generate triangles background CSS.
function source_triangles($options)
{
	echo "background: none; overflow: hidden;";
}
$sources["triangles"] = "source_triangles";
// Generate triangles background element.
function source_triangles_body($options)
{
	// Trianglify container.
	echo "<div id='background_triangles'></div>";
	
	$seed = key_or_default($options, "seed", null);
	$variance = key_or_default($options, "variance", 0.75);
	$cell_size = key_or_default($options, "cell_size", 75);
	$x_colors = key_or_default($options, "x_colors", "random");
	$y_colors = key_or_default($options, "y_colors", "match_x");
	$color_space = key_or_default($options, "color_space", "lab");
	$stroke_width = key_or_default($options, "stroke_width", 1.51);
	
	// Write Trianglify options.
?>
	<script type='text/javascript'>
	var currentWidth, currentHeight;
	function regenTriangles()
	{
		<?php /* Don't re-render the image if our current image is larger. */ ?>
		if(currentWidth >= window.innerWidth && currentHeight >= window.innerHeight)
		{
			return;
		}
		
		$('#background_triangles').empty();
		var pattern = Trianglify({
			width: window.innerWidth,
			height: window.innerHeight,
			variance: <?php echo $variance; ?>,
			cell_size: <?php echo $cell_size; ?>,
			x_colors: '<?php echo $x_colors; ?>',
			y_colors: '<?php echo $y_colors; ?>',
			color_space: '<?php echo $color_space; ?>',
			stroke_width: <?php echo $stroke_width; ?>,
			seed: <?php echo ($seed == null ? 'null' : "'" . $seed . "'"); ?>
		});
		currentWidth = window.innerWidth;
		currentHeight = window.innerHeight;
		$('#background_triangles').append(pattern.canvas());
	}
	$(window).resize(regenTriangles);
	regenTriangles();
	</script>
<?php
}
$bodySources["triangles"] = "source_triangles_body";

// Generate the background CSS.
function create_background_css($config)
{
	global $sources;
	
	// If no source was set, don't generate any CSS.
    if(!array_key_exists("source", $config))
    {
		return;
    }
	
    $source = $config["source"];
	$options = key_or_default($config, "options", array());
	
	// If the source doesn't exist, don't generate any CSS.
	if(!array_key_exists($source, $sources))
	{
		return;
	}
	
	// Call the source.
	$sources[$source]($options);
}

// Some sources need to put stuff in the body to work. This function does that.
function generate_background_body($config)
{
	global $bodySources;
	
	// If no source was set, don't output anything.
    if(!array_key_exists("source", $config))
    {
		return;
    }
	
    $source = $config["source"];
	$options = key_or_default($config, "options", array());
	
	// If the source doesn't exist, don't output anything.
	if(!array_key_exists($source, $bodySources))
	{
		return;
	}
	
	$bodySources[$source]($options);
}