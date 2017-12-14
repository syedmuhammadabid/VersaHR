<?php
	
	function slugify($text) {
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);
		if (empty($text)) {
		return 'n-a';
		}
		return $text;
	}

	$collection = [];
	$categories = scandir(__DIR__ . '/img/categories');
	foreach($categories as $category) {
		if($category == '.' || $category == '..') continue;
		$data = [];
		$data = ['category_name' => $category, 'category_slug' => slugify($category)];
		$data['projects'] = glob('img/categories/' . $category . '/*.png');
		$collection[] = $data;
	}

?>

<ul class="custom-category-links ">
<?php foreach($collection as $i => $category): ?>
	<li class="<?php echo $i == 0 ? 'active' : '' ?>">
        <a class="no-scroll" href="#<?php echo $category['category_slug'] ?>" data-toggle="tab" aria-expanded="false"><?php echo $category['category_name'] ?></a>
    </li>
<?php endforeach; ?>
</ul>


<div class="tab-content">
<?php foreach($collection as $h => $category): ?>
	
    <div class="tab-pane <?php echo $h == 0 ? 'active' : '' ?> main-projects" id="<?php echo $category['category_slug'] ?>">
    <?php foreach ($category['projects'] as $i => $project): ?>
    	<?php 
    		$basename = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($project));;
    	?>
    	<div class="col-sm-3">
            <div onclick="location.href='#';" class="projects <?php echo $i%2 == 0 ? 'web-project' : 'app-project' ?>">

                <div class="web-project-padding hover">
                    <p class="custom-box-hidden">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </p>

                    <img src="<?php echo $project ?>" alt="sample-work">


                </div>
                <div class="project-text">
                    <p class="bold"><?php echo $basename ?></p>
                    <p><?php echo $category['category_slug'] ?></p>
                </div>
            </div>
        </div>	
    <?php endforeach; ?>
    </div> 
<?php endforeach; ?>
</div>