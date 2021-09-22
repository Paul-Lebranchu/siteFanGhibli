<!DOCTYPE html>
 <html lang="fr">
  	<head>
  		<meta charset="UTF-8" />
  		<link rel="stylesheet" href="Style/ecriture.css"  />
      <title> <?php echo $this->title;?> </title>
    </head>

    <body>

     <?php echo $this->feedback; ?> 

	    <h1> <?php echo $this->title; ?> </h1>

      <?php echo $this->menu?>

      <?php echo $this->content; ?>

    </body>
  </html>
