<?php  
require_once("connection.php");
require_once('process.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Applications Page</title>
	    <link rel="stylesheet" href="css.css"/>
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			// $(document).ready(function(){
			// });
		</script>
	</head>
	<body>
		<div class="container">
			<div class="error_area">				
<?php  
				if (isset($_SESSION['error'])) 
				{
					echo "	<div class='error_warning'>
								{$_SESSION['error']}
							</div>";
					unset($_SESSION['error']);
				}
?>
			</div>
			<div class="outer_area">
				<div class="float">
					<form action="process.php" method="post">
						<label>Name: </label>
						<input type="text" class="search_field" name="application"/>
						<input type="hidden" name="action" value="add_applications">
						<button class="button" type="submit">Add Application</button>
					</form>
				</div>
			</div>
			<div class="float_right">
				<div class="search_area">
					<form action="process.php" method="post">
						<input type="text" class="search_field" name="search">
						<input type="hidden" name="action" value="search_applications">
						<button class="search_button">Search</button>
					</form>
				</div>
			</div>
			<div class="clear"></div>
			<table>
				<thead>
					<tr>
						<td class="key">Name</td>
						<td class="key">Number of Shortcut Keys</td>
						<td class="key">Created Date</td>
					</tr>
				</thead>
				<tbody>
<?php  
					if(isset($_SESSION['display']) && isset($_SESSION['search'])) 
					{
						echo $_SESSION['display'];
						unset($_SESSION['search']);
					}
					else
					{
						display_applications();
						echo $_SESSION['display'];
					}
?>
				</tbody>
			</table>
		</div>	
	</body>
</html>