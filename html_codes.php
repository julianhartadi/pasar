<?php 
//Code for header and search bar
function headerAndSearchCode(){
	$defaulText = htmlentities($_GET['keywords']);
	
	echo '
		<header id="main_header">
			<div id="rightAline">
	';
	
	//topRightLinks Links will be here /menu kanan atas
	topRightLinks();
	
	echo "
			</div>
			<a href=\"index.php\"> <img src=\"images/mainLogo.png\"></a>
		</header>
			<div id=\"top_search\">
				<form name=\"input\" action=\"search.php\" method=\"get\">
					<input type=\"text\" id=\"keywords\" name=\"keywords\" size=\"100\" class=\"searchBox\" value=\"$defaulText\"> &nbsp;
					<select id=\"category\" name=\"category\" class=\"searchBox\" >
			
	";
	
	//include categories here
	createCategoryList();
	
	echo '
					</select>
					<input type="submit" value="Search" class="button">
				 </form>
			</div>
	';
}
//Top Right Links
function topRightLinks(){
	if( !isset ($_SESSION['user_id']) ) {
		echo '<a href="register.php">Register</a> | <a href="login.php">Log In</a>';
	}else{ /* Jika user login */
		$x = $_SESSION['user_id'];
		$result = mysql_query("SELECT * FROM messages WHERE receiver=$x AND status='unread' " ) or die(mysql_error());
		$num = mysql_num_rows($result);
		if($num==0){
			echo '<a href="messages_inbox.php">Messages</a> |';
		}else {
			echo "<span class=\"usernames\"> <a href=\"messages_inbox.php\">Messages($num)</a></span> | ";
		}
		echo '<a href="additem.php">Add Item</a> | <a href="account.php">My Account</a> | <a href="logout.php">Log Out</a> ';
	}
}

//Create Category <option>'s for search
function createCategoryList(){
	if( ctype_digit($_GET['category']) ){ 
		$x=$_GET['category'];
			}else{ 
				$x=999; 
			}
		echo "<option >Semua Kategori</option>";
		$i=0;
		while(1){
			if(numberToCategory($i) == "Kategori tidak ada"){
			break;
			}else{
				echo "<option value=\"$i\" ";
				if($i==$x)( echo ' SELECTED ' );
				echo " > ";
				echo numberToCategory($i);
				echo "</option>";
		}
		$i++;
	}
}

//Category Number Strings
function numberToCategory($n){
	switch($n){
		case 0:
			$cat = "Elektronik";
			break;
		case 1:
			$cat = "Handphone  Tablet";
			break;
		case 2:
			$cat = "Komputer & Laptop";
			break;
		case 4:
			$cat = "Kamera";
			break;
		case 5:
			$cat = "Peralatan Elektronik";
			break;
		case 6:
			$cat = "Fashion Pria";
			break;
		case 7:
			$cat = "Fashion Wanita";
			break;
		case 8:
			$cat = "Ibu & Anak";
			break;
		case 9:
			$cat = "Kesehatan & Kecantikan";
			break;
		case 10:
			$cat = "Hobi & Keterampilan";
			break;
		case 11:
			$cat = "Otomotif";
			break;
		case 12:
			$cat = "Lain-lain";
			break;
		default:
			$cat = "Kategori tidak ada";
	}
    return $cat;
}

//code for footer
function footerCode(){
    echo '
        <footer id="main_footer">
            <table>
                <tr>
                    <td><a href="http://myidbc.com">www.myidbc.com</a></td>
                    <td><a href="#">Social Media Links</a></td>
                    <td><a href="#">Channel youtube</a></td>
                </tr>
            </table>
        </footer>
    ';
}
?>