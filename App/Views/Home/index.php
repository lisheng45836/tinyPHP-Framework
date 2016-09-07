<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<h1>Welcome <? echo htmlspecialchars($name); ?> !</h1>
	<p>Hello Home</p>

	<ul>
		<?php foreach ($colours as $value):?>
			<li> <? echo htmlspecialchars($value) ?></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>