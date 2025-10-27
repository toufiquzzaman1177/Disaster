<?php /* common header */ ?>
<?php if(!isset($PAGE_TITLE)) $PAGE_TITLE = "Disaster Relief Management"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($PAGE_TITLE) ?></title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <h1 class="brand">Disaster Relief Management</h1>
    <nav class="nav">
      <a href="index.php">Dashboard</a>
      <a href="disaster.php">Disaster</a>
      <a href="victim.php">Victim</a>
      <a href="relief_center.php">Relief Center</a>
      <a href="relief_item.php">Relief Item</a>
      <a href="distribution.php">Distribution</a>
    </nav>
  </div>
</header>
<main class="container">
