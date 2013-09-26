<?php
define('EMPTY_CLASS', '__unset__');

function showList($items){
	$output	= '';
	foreach($items as $item){
		$output	.= showEntry($item);
	}
	return $output;
}

function showEntry($entry){
	// Manual unpack
	$title		= $entry['title'];
	$platforms	= $entry['platforms'];
	$notes		= $entry['notes'];
	$tags		= $entry['tags'];

	// Build HTML
	$classes	= array();
	$output	=	'<h3 class="title">'
					.'<a class="reference-link" target="_blank" href="http://www.google.com/search?q='.urlencode($title.' Game '.findBracketedWord(current($platforms), '[', ']', true)).'&btnI">'
						.render($title, true, true)
					.'</a>'
				.'</h3>';

	// Platforms
	if($platforms){
		foreach($platforms as $platform){
			$slug	= slugify(findBracketedWord($platform, '[', ']', true));
			$classes[]	= 'platform-'.$slug;
		}
		$output	.= ' <span class="platform">';
			if(isset($platformLink)){
				$output	.= '<a href="'.$platformLink.'">';
			}
			$output	.= render(implode('/', $platforms), true, true);
			if(isset($platformLink)){
				$output	.= '</a>';
			}
		$output	.= '</span>';
	} else {
		$classes[]	= 'platform-'.EMPTY_CLASS;
	}

	// Ignore tags

	if(isset($notes)){
		$output	.= preg_replace('~^<p>~', '<p class="notes">', render($notes));
	}

	$output	= '<li class="item'.($classes ? ' '.implode(' ', $classes) : '').'">'.$output.'</li>';
	return $output;
}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Replayed</title>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<meta name="robots" content="noindex, nofollow" />

	<link rel="stylesheet" href="style.css" />
</head>
<body>

<div role="main" data-count="<?=count($lists);?>">
<?php foreach($lists as $title => $list){ ?>
	<div class="items-group">
		<h2><?=$title;?></h2>
		<?=render($list['output']);?>
		<?=showList($list['items']);?>
	</div>
<?php }?>
</div>

<footer role="contentinfo">
	Powered by <a href="https://github.com/adamaveray/replayed">Replayed</a>
</footer>
</body>
</html>