<?php
global $IC;
global $action;
global $itemtype;

$sindex = $action[0];

$next = false;
$prev = false;

$item = $IC->getItem([
	"sindex" => $sindex, 
	"status" => 1,
	"historic" => true,
	"extend" => [
		"tags" => true, 
		"user" => true, 
		"mediae" => true, 
		"comments" => true, 
		"readstate" => true
	]
]);

if($item) {
	$this->pageTitle($item["name"]);
	$this->bodyClass($item["classname"] ? $item["classname"] : "services");
	$this->sharingMetaData($item);


	$next = $IC->getNext($item["item_id"], ["itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true]);
	$prev = $IC->getPrev($item["item_id"], ["itemtype" => $itemtype, "status" => 1, "order" => "position ASC", "extend" => true]);

	// set related pattern
	$related_pattern = ["itemtype" => $item["itemtype"], "tags" => $item["tags"], "exclude" => $item["id"]];
	$related_title = "Related services";

}
else {
	// itemtype pattern for missing item
	$related_pattern = ["itemtype" => $itemtype];
	$related_title = "Other services";

}

// add base pattern properties
$related_pattern["limit"] = 5;
$related_pattern["extend"] = ["tags" => true, "readstate" => true, "user" => true, "mediae" => true];

// get related items
$related_items = $IC->getRelatedItems($related_pattern);

?>

<div class="scene service i:scene">

<? if($item):
	$media = $IC->sliceMediae($item, "single_media"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?> service" itemscope itemtype="http://schema.org/Article"<?= HTML()->jsData(["readstate"]) ?>>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype]
			"default" => ["/services", "Services"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $item,
			"media" => $media,
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>

	</div>


<? 	if($next || $prev): ?>
	<div class="pagination i:pagination">
		<ul>
		<? if($prev): ?>
			<li class="previous">
				<!-- <h2>Previous</h2> -->
				<a href="/services/<?= $prev[0]["sindex"] ?>"><?= strip_tags($prev[0]["name"]) ?></a>
			</li>
		<? endif; ?>
		<? if($next): ?>
			<li class="next">
				<!-- <h2>Next</h2> -->
				<a href="/services/<?= $next[0]["sindex"] ?>"><?= strip_tags($next[0]["name"]) ?></a>
			</li>
		<? endif; ?>
		</ul>
	</div>
	<? endif; ?>

<? else: ?>

	<h1>Technology is limited</h1>
	<p>We could not find the specified service.</p>

<? endif; ?>



<? if($related_items): ?>
	<div class="related">
		<h2><?= $related_title ?> <a href="/services">(see all)</a></h2>

		<ul class="items services">
<?		foreach($related_items as $item): 
			$media = $IC->sliceMediae($item, "single_media"); ?>
			<li class="item service item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/NewsArticle"
				data-readstate="<?= $item["readstate"] ?>"
				>

				<h3 itemprop="headline"><a href="/services/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


				<?= HTML()->renderSnippet("snippets/info.php", [
					"item" => $item,
					"media" => $media,
				]) ?>

				<?/*= $HTML->articleInfo($item, "/services/".$item["sindex"], [
					"media" => $media
				])*/ ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
	<?	endforeach; ?>
		</ul>
	</div>
<? endif; ?>


</div>
