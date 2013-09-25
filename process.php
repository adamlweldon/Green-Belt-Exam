<?php  
	require_once("connection.php");
	session_start();

	if (isset($_POST['action']) && $_POST['action']=="add_applications") 
	{
		add_applications();
	} 
	else if (isset($_POST['action']) && $_POST['action']=="search_applications") 
	{
		search_applications();
	} 
	
	function add_applications() {
		if (!empty($_POST['application'])) {
			$query = "INSERT INTO applications (name, created_at, updated_at) VALUES ('{$_POST['application']}', NOW(), NOW())";
			mysql_query($query);
		}
		else
		{
			$_SESSION['error'] = "Application name cannot be left blank";
		}
		header("Location: index.php");
	}

	function search_applications() {
		$query = "SELECT id, name, DATE_FORMAT(created_at, '%M %d %Y') AS created_at FROM applications WHERE name LIKE '%{$_POST['search']}%'";
		$applications = fetch_all($query);

		$query = "SELECT applications.id as id, count(application_id) AS counts FROM shortcuts INNER JOIN applications ON applications.id = shortcuts.application_id GROUP BY applications.id";
		$shortcuts = fetch_all($query);

		$html='';

		foreach($applications as $application) 
		{
			$html.= "	<tr>
							<td>
								<form action='process.php' method='post'>
									<input class='link' type='submit' value='{$application['name']}'/>
									<input type='hidden' name='action' value='get_shortcut'/>
									<input type='hidden' name='id' value='{$application['id']}'/>
									<input type='hidden' name='name' value='{$application['name']}'/>
								</form>
							</td>";
			foreach($shortcuts as $shortcut) 
			{
				if($shortcut['id']==$application['id'])
				{
					$html.= "
							<td>{$shortcut['counts']}</td>";
				}
			}					
			$html.="		<td>{$application['created_at']}</td>
						</tr>";
		}

		$_SESSION['search'] = TRUE;
		$_SESSION['display'] = $html;
		header("Location:index.php");
	}

	if (isset($_POST['action']) && $_POST['action']=="back")
	{
		go_back();
	}
	else if (isset($_POST['action']) && $_POST['action']=="get_shortcut")
	{
		get_shortcut();
	}
	else if (isset($_POST['action']) && $_POST['action']=="add_shortcut")
	{
		add_shortcut();
	}
	else if (isset($_POST['action']) && $_POST['action']=="search_shortcut") 
	{
		search_shortcut();
	}

	function go_back() {
 		unset($_SESSION);
 		header("Location: index.php");
 	}

	function get_shortcut() {
		$_SESSION['id'] =  $_POST['id'];
		$_SESSION['name'] =  $_POST['name'];
		header("Location: shortcut.php?application_id={$_POST['id']}");
	}

	function add_shortcut() {
		if (!empty($_POST['shortcut'])) {
			$query = "INSERT INTO shortcuts (application_id, shortcut, description, created_at, updated_at) VALUES ('{$_SESSION['id']}', '{$_POST['shortcut']}','{$_POST['description']}', NOW(), NOW())";
			mysql_query($query);
		}
		else
		{
			$_SESSION['error'] = "Shortcut name cannot be left blank";
		}
		header("Location: shortcut.php?application_id={$_SESSION['id']}");
	}

	function search_shortcut() {
		$query = "SELECT * from shortcuts WHERE (shortcut LIKE '%{$_POST['search_shortcut']}%' OR description LIKE '%{$_POST['search_shortcut']}%') AND application_id = {$_SESSION['id']}";
		$shortcuts = fetch_all($query);

		$html='';

		foreach($shortcuts as $shortcut) 
		{
			$html.= "	<tr>
							<td>{$shortcut['shortcut']}</td>
							<td>{$shortcut['description']}</td>
							<td>{$shortcut['created_at']}</td>
						</tr>
			";
		}
		$_SESSION['short_search'] = TRUE;
		$_SESSION['short_display'] = $html;
		header("Location: shortcut.php?application_id={$_SESSION['id']}");
	}

	function display_applications()
 	{
 		$query = "SELECT id, name, DATE_FORMAT(created_at, '%M %d %Y') AS created_at FROM applications";
		$applications = fetch_all($query);

		$query = "SELECT applications.id AS id, count(application_id) AS counts FROM shortcuts INNER JOIN applications ON applications.id = shortcuts.application_id GROUP BY applications.id";
		$shortcuts = fetch_all($query);

		$html='';

		foreach($applications as $application) 
		{
			$html.= "	<tr>
							<td>
								<form action='process.php' method='post'>
									<input class='link' type='submit' value='{$application['name']}'/>
									<input type='hidden' name='action' value='get_shortcut'/>
									<input type='hidden' name='id' value='{$application['id']}'/>
									<input type='hidden' name='name' value='{$application['name']}'/>
								</form>
							</td>";
			foreach($shortcuts as $shortcut) 
			{
				if($shortcut['id']==$application['id'])
				{
					$html.= "
							<td>{$shortcut['counts']}</td>";
				}
			}					
			$html.="		<td>{$application['created_at']}</td>
						</tr>
			";
		}
		$_SESSION['display'] = $html;
 	}

 	function display_shortcuts() {
 		$query = "SELECT shortcut, description, DATE_FORMAT(created_at, '%M %d %Y') AS created_at FROM shortcuts WHERE application_id = {$_SESSION['id']}";
		$shortcuts = fetch_all($query);

		$html='';

		foreach($shortcuts as $shortcut) 
		{
			$html.= "	<tr>
							<td>{$shortcut['shortcut']}</td>
							<td>{$shortcut['description']}</td>
							<td>{$shortcut['created_at']}</td>
						</tr>
			";
		}
		$_SESSION['short_display'] = $html;
 	}
?>