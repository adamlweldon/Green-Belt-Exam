<?php 
	require_once("connection.php");
	require_once("process.php");
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shortcut Keys</title>
	    <link rel="stylesheet" href="css.css"/>
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			// $(document).ready(function(){
			// });
		</script>
	</head>
	<body>
		<div class="container">
			<form action="process.php" method="post">
				<button class="back_button" type="submit">Back</button>
				<input type="hidden" name="action" value="back"/>
			</form>
			<h1><?= $_SESSION['name'];?></h1>
			<div class="row">
				<div class="error">
<?php  
					if (isset($_SESSION['error'])) 
					{
						echo "<div class='error_warning'>
									{$_SESSION['error']}
								</div>";
						unset($_SESSION['error']);
					}
?>
				</div>
			</div>
			<div class="outer_area">
				<div class="inner_area">
					<form action="process.php" method="post">
						<label>Shortcut Key</label>
						<input class = "form_input1" type="text" name="shortcut"/><br/>
						<label>Description</label>
						<textarea class= "form_input2" name="description" rows="10"></textarea>
						<input type="hidden" name="action" value="add_shortcut">
						<div class="clear"></div>
						<button class="button" type="submit">Add Shortcut Key</button>
					</form>
				</div>
			</div>
			<div class="float_right">
				<div class="area">
					<form action="process.php" method="post">
						<input type="text" class="search_field" name="search_shortcut">
						<input type="hidden" name="action" value="search_shortcut">
						<button class="search_button">Search</button>
					</form>
				</div>
			</div>
			<div class="clear"></div>
			<div class="row">
				<table>
					<thead>
						<tr>
							<td class="key">Shortcut Key</td>
							<td class="key">Description</td>
							<td class="key">Created Date</td>
						</tr>
					</thead>
					<tbody>
<?php  
						if(isset($_SESSION['short_display']) && isset($_SESSION['short_search'])) 
						{
							echo $_SESSION['short_display'];
							unset($_SESSION['short_search']);
						}
						else
						{
							display_shortcuts();
							echo $_SESSION['short_display'];
						}
?>
					</tbody>
				</table>
			</div>	
		</div>
	</body>
</html>