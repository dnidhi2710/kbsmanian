<?php
//echo "db connected";
class Dbclass
{
	private $error;
	public function test(){
		return "tested";
	}

	public function connect()
	{
		//mysql_connect('localhost','rootAdminCss','userCss!234@');
		//mysql_select_db('cssRecruitDb');
                /*mysql_connect('localhost','paperehe_papergo','GHKXiDMX;KG!');
		mysql_select_db('paperehe_enablegrowth');*/
		mysql_connect('localhost','root','root');
		mysql_select_db('kbsmanian');
	}
	
	public function getResults($query)
	{
		$conn = new mysqli('localhost','root', 'root','kbsmanian');
		//$output = array();
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_array($result)) 
			{	
				$output[] = $row;
			}
		}else{
			$conn->close();
			$output = null;
		}
		return $output;
	}

	public function getOneRow($query)
	{
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function query($query)
	{	
		$conn = new mysqli('localhost','root', 'root','kbsmanian');
		//$result = mysql_query($query);
		//echo $result;
		if($conn->query($query))
		{	
			$conn->close();
			return true;
		}
		else
		{	
			//$error = $conn->error;
			$this->$error = $conn->error;
			$conn->close();			
			return false;
		}
	}

	public function getError(){
		return $this->$error;
	}

	public function lastId()
	{
		return mysql_insert_id();
	}
	public function pagination($select_query,$count_query,$limit,$targetpage)
	{
		$output = array();
		$adjacents = 3;
		$total_pages = mysql_fetch_array(mysql_query($count_query));
		$total_pages = $total_pages['num'];
		
		/* Setup vars for query. */
		if(isset($_GET['page']))
		{
			$page = $_GET['page'];
		}
		else
		{
			$page = 0;
		}
		if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
		else
			$start = 0;								//if no page var is given, set start to 0
		
		/* Get data. */
		$sql = $select_query." LIMIT $start, $limit";
		$result = $this->getResults($sql);
		
		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;							//next page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"pagination\">";
			//previous button
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage&page=$prev\"><< previous</a>";
			else
				$pagination.= "<span class=\"disabled\"><< previous</span>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
					}
					$pagination.= "...";
					$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
					$pagination.= "...";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage&page=$next\">next >></a>";
			else
				$pagination.= "<span class=\"disabled\">next >></span>";
			$pagination.= "</div>\n";
		}
		$output[] = $result;
		$output[] = $pagination;
		return $output;
	}
}
//global $db;
//$db = new Dbclass;
//echo $db->test();
//$db->connect();
?>