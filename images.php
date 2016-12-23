<?php include('header.php') ?>

<?php

function flickrPhotos($query){

	// API credentials
	$key = '087662980d5070d3a6ec836685fbfec7';

	// API call
	$list = json_decode(file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$key.'&text='.urlencode($query).'&sort=interestingness-desc&content_type=1&per_page=50&format=json&nojsoncallback=1'));

	return $list->photos->photo;

}

?>

<main class="images">

	<p>A picture is worth a thousand words. Now that we've got an idea of what you want to monetize, choose the photo that best resonates with your vision.</p>
	<?php
		// Prepare photo array
		$return = flickrPhotos($_GET['q']);

		// If the query returns less than 6 results, input 'random' as the query.
		if (count($return) < 6) $return = flickrPhotos('random');

		shuffle($return);
		$photos = array_slice($return,0,6);
	?>
	<ul>
		<?php foreach ($photos as $photo) { ?>
			<?php $photo_url = 'https://farm'.$photo->farm.'.staticflickr.com/'.$photo->server.'/'.$photo->id.'_'.$photo->secret; ?>
			<li>
				<!-- Each image is actually a form -->
				<form action="monetize.php" method="POST">
					<input type="hidden" name="photo_url" value="<?php echo $photo_url.'_z.jpg' ?>">
					<input type="image" src="<?php echo $photo_url.'_q.jpg' ?>" alt="Monetize This">
				</form>
			</li>
		<? } ?>
	</ul>

	<p>Don't see anything you like? <a href="?q=<?php echo urlencode($_GET['q']) ?>">Try a new set of photos</a>.</p>
	
</main>

<?php include('footer.php') ?>